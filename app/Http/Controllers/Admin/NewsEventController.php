<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsEvent;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsEventController extends Controller
{
    use ImageUploadTrait;

    public function index(Request $request)
    {
        $type = $request->query('type');

        $items = NewsEvent::when(
                in_array($type, ['news', 'event'], true),
                fn ($q) => $q->where('type', $type)
            )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.news-events.index', compact('items', 'type'));
    }

    public function create()
    {
        return view('admin.news-events.form');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $this->uniqueSlug($data['title']);

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'), 'news-events');
        }

        NewsEvent::create($data);

        return redirect()->route('admin.news-events.index')->with('success', ucfirst($data['type']) . ' added.');
    }

    public function edit(NewsEvent $newsEvent)
    {
        return view('admin.news-events.form', ['item' => $newsEvent]);
    }

    public function update(Request $request, NewsEvent $newsEvent)
    {
        $data = $this->validated($request);

        if ($data['title'] !== $newsEvent->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $newsEvent->id);
        }

        if ($request->hasFile('image')) {
            $this->deleteImage($newsEvent->image);
            $data['image'] = $this->uploadImage($request->file('image'), 'news-events');
        }

        $newsEvent->update($data);

        return redirect()->route('admin.news-events.index')->with('success', ucfirst($data['type']) . ' updated.');
    }

    public function destroy(NewsEvent $newsEvent)
    {
        $this->deleteImage($newsEvent->image);
        $newsEvent->delete();

        return redirect()->route('admin.news-events.index')->with('success', 'Item deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'type'        => 'required|in:news,event',
            'title'       => 'required|string|max:200',
            'description' => 'required|string',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'event_date'  => 'required_if:type,event|nullable|date',
            'location'    => 'nullable|string|max:200',
        ]);

        $data['status'] = $request->boolean('status');

        // date / place only make sense for events
        if ($data['type'] === 'news') {
            $data['event_date'] = null;
            $data['location'] = null;
        }

        return $data;
    }

    /**
     * Str::slug() returns '' for titles written in Gujarati / Hindi etc.,
     * so fall back to a random slug in that case.
     */
    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'item-' . Str::lower(Str::random(6));
        $slug = $base;
        $i = 1;

        while (NewsEvent::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }
}
