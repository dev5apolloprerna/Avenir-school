# School website – Admin panel (Laravel)

Admin panel for a school website. Works with Laravel 10, 11 and 12 (PHP 8.1+).

## What is included

| Module | What you can do |
|---|---|
| Admin login | Email + password login, logout, "keep me signed in" |
| Profile & password | Edit name, email, phone, profile photo. Change password (needs current password) |
| Sliders | Each slider is an **image upload** or a **video URL**. Order + show/hide |
| Principal's message | Name, designation, message, photo (one record, edited in one form) |
| Photo gallery | Album = title + one cover image. **"Add images"** button in the action column opens a page to **upload multiple images** and delete single images |
| Video gallery | Title + video URL (YouTube thumbnail shown automatically) |
| FAQ | Question, answer, order, show/hide |
| Testimonials | Name, designation, message, optional photo |
| News & events | One list with a News / Event type. Events also have a date and location |

## Setup (5 minutes)

1. Create a fresh Laravel project:
   ```bash
   composer create-project laravel/laravel school
   cd school
   ```
2. Copy everything from this zip into the `school` folder. **Say yes when asked to overwrite**:
   `app/Models/User.php`, `app/Providers/AppServiceProvider.php`, `database/seeders/DatabaseSeeder.php`, `routes/web.php`.
3. Open `.env` and set your database (MySQL example):
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=school
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Create an empty database called `school` first (phpMyAdmin or `CREATE DATABASE school;`).
4. Run:
   ```bash
   php artisan migrate --seed
   php artisan storage:link
   php artisan serve
   ```
5. Open http://127.0.0.1:8000/admin/login

**Login:** `admin@school.com` / `Admin@123`  (change it on the Profile & password page after first login)

> `php artisan storage:link` is required. Uploaded images are saved in `storage/app/public` and this command makes them visible in the browser.

## Uploading many images

PHP has its own limits. If big uploads fail, raise these in `php.ini` and restart the server:
```
upload_max_filesize = 8M
post_max_size = 64M
max_file_uploads = 30
```
The app allows up to 20 images per upload, 4 MB each.

## Folder map

```
app/Http/Controllers/Admin/   AuthController, DashboardController, ProfileController,
                              SliderController, PrincipalMessageController,
                              PhotoGalleryController, GalleryImageController,
                              VideoGalleryController, FaqController,
                              TestimonialController, NewsEventController
app/Models/                   User, Slider, PrincipalMessage, PhotoGallery, GalleryImage,
                              VideoGallery, Faq, Testimonial, NewsEvent
app/Traits/                   ImageUploadTrait (save/delete files), HasVideoUrl (YouTube/Vimeo helpers)
database/migrations/          9 migrations (users columns + 8 new tables)
database/seeders/             AdminSeeder (creates the admin user)
resources/views/layouts/      admin.blade.php (sidebar layout)
resources/views/admin/        one folder per module (index + form)
routes/web.php                all routes
```

## Database tables

`users` (+ `phone`, `photo`) · `sliders` · `principal_messages` · `photo_galleries` ·
`gallery_images` (FK → photo_galleries, cascade delete) · `video_galleries` · `faqs` ·
`testimonials` · `news_events`

## Using the data on your public website

Every model has an `active()` scope and image URL helpers, for example:

```php
$sliders      = Slider::active()->get();            // $slider->image_url, $slider->embed_url
$principal    = PrincipalMessage::first();          // $principal->photo_url
$albums       = PhotoGallery::active()->with('images')->get();  // $album->cover_url, $img->image_url
$videos       = VideoGallery::active()->latest()->get();        // $video->embed_url
$faqs         = Faq::active()->get();
$testimonials = Testimonial::active()->latest()->get();
$news         = NewsEvent::active()->news()->latest()->get();
$events       = NewsEvent::active()->events()->orderBy('event_date')->get();
```

## Notes for your teacher / viewers

- Only admins exist (no public registration). Add more admins with `php artisan tinker`
  or by copying `AdminSeeder`.
- Deleting an album also deletes its image files and database rows.
- Message / description fields are plain text. When you show them on the website use
  `{!! nl2br(e($text)) !!}` to keep line breaks safely.
# Avenir-school
