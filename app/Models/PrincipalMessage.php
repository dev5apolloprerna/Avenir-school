<?php

namespace App\Models;

use App\Support\Uploads;
use Illuminate\Database\Eloquent\Model;

class PrincipalMessage extends Model
{
    protected $fillable = ['name', 'designation', 'message', 'photo'];

    public function getPhotoUrlAttribute(): ?string
    {
        return Uploads::url($this->photo);
    }
}
