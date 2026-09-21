<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PhotoGallery extends Model
{
    protected $fillable = ['title', 'cover_image', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function images(): HasMany
    {
        return $this->hasMany(GalleryImage::class);
    }

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getCoverUrlAttribute(): ?string
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : null;
    }
}
