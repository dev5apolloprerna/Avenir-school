<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhotoGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

/**
 * An album = title + ONE cover image.
 * More photos are added later with "Add images" (see GalleryImageController).
 */
class PhotoGalleryController extends Controller
{
    use ImageUploadTrait;

    public function index()
    {
        $galleries = PhotoGallery::withCount('images')->latest()->paginate(10);

        return view('admin.photo-galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.photo-galleries.form');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'cover_image' => 'required|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        $data['cover_image'] = $this->uploadImage($request->file('cover_image'), 'gallery/covers');
        $data['status'] = $request->boolean('status');

        PhotoGallery::create($data);

        return redirect()->route('admin.photo-galleries.index')->with('success', 'Album created. Use "Add images" to upload more photos.');
    }

    public function edit(PhotoGallery $photoGallery)
    {
        return view('admin.photo-galleries.form', ['gallery' => $photoGallery]);
    }

    public function update(Request $request, PhotoGallery $photoGallery)
    {
        $data = $request->validate([
            'title'       => 'required|string|max:150',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
        ]);

        if ($request->hasFile('cover_image')) {
            $this->deleteImage($photoGallery->cover_image);
            $data['cover_image'] = $this->uploadImage($request->file('cover_image'), 'gallery/covers');
        }
        $data['status'] = $request->boolean('status');

        $photoGallery->update($data);

        return redirect()->route('admin.photo-galleries.index')->with('success', 'Album updated.');
    }

    public function destroy(PhotoGallery $photoGallery)
    {
        // delete files from disk; DB rows in gallery_images are removed by cascadeOnDelete
        foreach ($photoGallery->images as $image) {
            $this->deleteImage($image->image);
        }
        $this->deleteImage($photoGallery->cover_image);

        $photoGallery->delete();

        return redirect()->route('admin.photo-galleries.index')->with('success', 'Album deleted.');
    }
}
