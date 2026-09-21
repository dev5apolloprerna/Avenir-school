<?php

use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\GalleryImageController;
use App\Http\Controllers\Admin\NewsEventController;
use App\Http\Controllers\Admin\PhotoGalleryController;
use App\Http\Controllers\Admin\PrincipalMessageController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\VideoGalleryController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('admin.dashboard'));

/*
|--------------------------------------------------------------------------
| Admin login  (the route MUST be named "login" so Laravel can send
| logged-out visitors here automatically)
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');

/*
|--------------------------------------------------------------------------
| Admin panel (login required)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile + change password
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

    // Sliders (image or video URL)
    Route::resource('sliders', SliderController::class)->except('show');

    // Principal message (single record)
    Route::get('principal-message', [PrincipalMessageController::class, 'edit'])->name('principal.edit');
    Route::put('principal-message', [PrincipalMessageController::class, 'update'])->name('principal.update');

    // Photo gallery (album) + multiple image upload
    Route::resource('photo-galleries', PhotoGalleryController::class)->except('show');
    Route::get('photo-galleries/{photoGallery}/images', [GalleryImageController::class, 'index'])->name('photo-galleries.images.index');
    Route::post('photo-galleries/{photoGallery}/images', [GalleryImageController::class, 'store'])->name('photo-galleries.images.store');
    Route::delete('gallery-images/{galleryImage}', [GalleryImageController::class, 'destroy'])->name('gallery-images.destroy');

    // Video gallery, FAQ, testimonials, news & events
    Route::resource('video-galleries', VideoGalleryController::class)->except('show');
    Route::resource('faqs', FaqController::class)->except('show');
    Route::resource('testimonials', TestimonialController::class)->except('show');
    Route::resource('news-events', NewsEventController::class)->except('show');
});
