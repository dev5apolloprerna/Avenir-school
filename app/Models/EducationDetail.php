<?php

namespace App\Models;

use App\Support\Uploads;
use Illuminate\Database\Eloquent\Model;

class EducationDetail extends Model
{
    protected $fillable = ['image', 'title', 'subtitle', 'description', 'sort_order', 'status'];

    protected $casts = ['status' => 'boolean', 'sort_order' => 'integer'];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function getImageUrlAttribute(): ?string
    {
        return Uploads::url($this->image);
    }
}
