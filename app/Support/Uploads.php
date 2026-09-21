<?php

namespace App\Support;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * One place that knows where uploads live.
 * Reads config/uploads.php (which reads UPLOAD_PATH / UPLOAD_URL from .env).
 */
class Uploads
{
    /** Disk pointing at UPLOAD_PATH (live) or storage/app/public (local). */
    public static function disk(): Filesystem
    {
        return Storage::build([
            'driver'     => 'local',
            'root'       => config('uploads.path') ?: storage_path('app/public'),
            'visibility' => 'public',
            'throw'      => true,   // show a clear error if the folder is not writable
        ]);
    }

    /** Save an uploaded file in $folder and return its short path, e.g. "sliders/abc.jpg". */
    public static function store(UploadedFile $file, string $folder): string
    {
        return self::disk()->putFile($folder, $file);
    }

    public static function delete(?string $path): void
    {
        if ($path && self::disk()->exists($path)) {
            self::disk()->delete($path);
        }
    }

    /** Public web address of a stored file. */
    public static function url(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        $path = ltrim($path, '/');
        $base = config('uploads.url');

        return $base
            ? rtrim($base, '/') . '/' . $path      // live: UPLOAD_URL
            : asset('storage/' . $path);           // local: public/storage symlink
    }
}
