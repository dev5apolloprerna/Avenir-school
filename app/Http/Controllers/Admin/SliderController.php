<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

class SliderController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $sliders = Slider::orderBy('sort_order')->latest()->paginate(10);

        return view('admin.sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.sliders.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate($this->rules());
        $data['status'] = $request->boolean('status');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($data['type'] === 'image') {
            $data['image'] = $this->uploadImage($request->file('image'), 'sliders');
            $data['video_url'] = null;
        } else {
            $data['image'] = null;
        }

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider added.');
    }

    public function edit(Slider $slider)
    {
        return view('admin.sliders.form', compact('slider'));
    }

    public function update(Request $request, Slider $slider)
    {
        $data = $request->validate($this->rules(true));
        $data['status'] = $request->boolean('status');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        if ($data['type'] === 'image') {
            if ($request->hasFile('image')) {
                $this->deleteImage($slider->image);
                $data['image'] = $this->uploadImage($request->file('image'), 'sliders');
            } elseif (! $slider->image) {
                // switched from video -> image but forgot to choose a file
                return back()
                    ->withErrors(['image' => 'Please choose an image for this slider.'])
                    ->withInput();
            }
            $data['video_url'] = null;
        } else {
            // switched to video: remove the old image file
            $this->deleteImage($slider->image);
            $data['image'] = null;
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slider updated.');
    }

    public function destroy(Slider $slider)
    {
        $this->deleteImage($slider->image);
        $slider->delete();

        return redirect()->route('admin.sliders.index')->with('success', 'Slider deleted.');
    }

    private function rules(bool $isUpdate = false): array
    {
        return [
            'title'      => 'nullable|string|max:150',
            'type'       => 'required|in:image,video',
            'image'      => $isUpdate
                ? ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096']
                : ['required_if:type,image', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'video_url'  => 'required_if:type,video|nullable|url|max:500',
            'sort_order' => 'nullable|integer|min:0',
        ];
    }
}
