<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrincipalMessage extends Model
{
    protected $fillable = ['name', 'designation', 'message', 'photo'];

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? asset('storage/' . $this->photo) : null;
    }
}
