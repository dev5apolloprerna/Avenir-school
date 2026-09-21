<?php

namespace App\Models;

use App\Support\Uploads;
use Illuminate\Database\Eloquent\Model;

class NewsEvent extends Model
{
    protected $fillable = [
        'type', 'title', 'slug', 'description', 'image',
        'event_date', 'location', 'status',
    ];

    protected $casts = [
        'status' => 'boolean',
        'event_date' => 'date',
    ];

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeNews($query)
    {
        return $query->where('type', 'news');
    }

    public function scopeEvents($query)
    {
        return $query->where('type', 'event');
    }

    public function getImageUrlAttribute(): ?string
    {
        return Uploads::url($this->image);
    }
}
