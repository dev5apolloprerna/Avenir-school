<?php

namespace App\Models;

use App\Traits\HasVideoUrl;
use Illuminate\Database\Eloquent\Model;

class VideoGallery extends Model
{
    use HasVideoUrl;

    protected $fillable = ['title', 'video_url', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
