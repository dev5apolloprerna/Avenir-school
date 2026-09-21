<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;
use App\Models\PhotoGallery;
use App\Traits\ImageUploadTrait;
use Illuminate\Http\Request;

/**
 * Multiple image upload for one album (the "Add images" action button).
 */
class GalleryImageController extends Controller
{
    use ImageUploadTrait;

    public function index(PhotoGallery $photoGallery)
    {
        $images = $photoGallery->images()->latest()->paginate(24);

        return view('admin.photo-galleries.images', compact('photoGallery', 'images'));
    }

    public function store(Request $request, PhotoGallery $photoGallery)
    {
        $request->validate([
            'images'   => 'required|array|max:20',
            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:4096',
        ], [
            'images.required'  => 'Please choose at least one image.',
            'images.max'       => 'You can upload up to 20 images at a time.',
            'images.*.image'   => 'Each file must be an image.',
            'images.*.mimes'   => 'Images must be jpg, jpeg, png or webp.',
            'images.*.max'     => 'Each image must be 4 MB or smaller.',
            'images.*.uploaded' => 'One of the images failed to upload. It may be larger than the server upload limit.',
        ]);

        foreach ($request->file('images') as $file) {
            $photoGallery->images()->create([
                'image' => $this->uploadImage($file, 'gallery/' . $photoGallery->id),
            ]);
        }

        $count = count($request->file('images'));

        return back()->with('success', $count . ' ' . ($count === 1 ? 'image' : 'images') . ' uploaded.');
    }

    public function destroy(GalleryImage $galleryImage)
    {
        $this->deleteImage($galleryImage->image);
        $galleryImage->delete();

        return back()->with('success', 'Image deleted.');
    }
}
