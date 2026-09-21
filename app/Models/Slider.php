<?php

namespace App\Models;

use App\Support\Uploads;
use App\Traits\HasVideoUrl;
use Illuminate\Database\Eloquent\Model;

class Slider extends Model
{
    use HasVideoUrl;

    protected $fillable = ['title', 'type', 'image', 'video_url', 'sort_order', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('status', true)->orderBy('sort_order');
    }

    public function getImageUrlAttribute(): ?string
    {
        return Uploads::url($this->image);
    }
}
