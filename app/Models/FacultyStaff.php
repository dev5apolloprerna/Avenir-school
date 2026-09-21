<?php

namespace App\Models;

use App\Support\Uploads;
use Illuminate\Database\Eloquent\Model;

class FacultyStaff extends Model
{
    protected $table = 'faculty_staff';

    protected $fillable = [
        'image',
        'name',
        'designation',
        'short_description',
        'detailed_description',
        'qualification',
        'email',
        'phone',
        'sort_order',
        'status',
    ];

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
