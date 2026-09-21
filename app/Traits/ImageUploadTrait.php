<?php

namespace App\Traits;

use App\Support\Uploads;
use Illuminate\Http\UploadedFile;

/**
 * Used by controllers to save / delete images.
 * Where the files really go (local storage folder or the live
 * public_html folder) is decided by UPLOAD_PATH in .env - see config/uploads.php
 */
trait ImageUploadTrait
{
    protected function uploadImage(UploadedFile $file, string $folder): string
    {
        return Uploads::store($file, $folder);
    }

    protected function deleteImage(?string $path): void
    {
        Uploads::delete($path);
    }
}
