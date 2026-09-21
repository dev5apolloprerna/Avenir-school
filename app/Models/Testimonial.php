<?php

namespace App\Models;

use App\Support\Uploads;
use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = ['name', 'designation', 'message', 'photo', 'status'];

    protected $casts = ['status' => 'boolean'];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return Uploads::url($this->photo);
    }
}
