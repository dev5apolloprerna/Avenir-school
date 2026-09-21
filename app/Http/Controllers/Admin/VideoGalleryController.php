<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\VideoGallery;
use Illuminate\Http\Request;

class VideoGalleryController extends Controller
{
    public function index()
    {
        $videos = VideoGallery::latest()->paginate(10);

        return view('admin.video-galleries.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.video-galleries.form');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        VideoGallery::create($data);

        return redirect()->route('admin.video-galleries.index')->with('success', 'Video added.');
    }

    public function edit(VideoGallery $videoGallery)
    {
        return view('admin.video-galleries.form', ['video' => $videoGallery]);
    }

    public function update(Request $request, VideoGallery $videoGallery)
    {
        $videoGallery->update($this->validated($request));

        return redirect()->route('admin.video-galleries.index')->with('success', 'Video updated.');
    }

    public function destroy(VideoGallery $videoGallery)
    {
        $videoGallery->delete();

        return redirect()->route('admin.video-galleries.index')->with('success', 'Video deleted.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'title'     => 'required|string|max:150',
            'video_url' => 'required|url|max:500',
        ]);
        $data['status'] = $request->boolean('status');

        return $data;
    }
}
