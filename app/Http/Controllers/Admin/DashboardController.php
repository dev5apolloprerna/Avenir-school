<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\GalleryImage;
use App\Models\NewsEvent;
use App\Models\PhotoGallery;
use App\Models\Slider;
use App\Models\Testimonial;
use App\Models\VideoGallery;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'sliders'      => Slider::count(),
            'albums'       => PhotoGallery::count(),
            'photos'       => GalleryImage::count(),
            'videos'       => VideoGallery::count(),
            'faqs'         => Faq::count(),
            'testimonials' => Testimonial::count(),
            'news'         => NewsEvent::news()->count(),
            'events'       => NewsEvent::events()->count(),
        ];

        $latest = NewsEvent::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latest'));
    }
}
