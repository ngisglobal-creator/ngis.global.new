<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Verification extends Model
{
    use HasFactory;

    protected $fillable = ['image', 'type', 'description_ar', 'description_en', 'description_zh'];

    public function getImageUrlAttribute()
    {
        return $this->image ? \Illuminate\Support\Facades\Storage::url($this->image) : null;
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_verification');
    }
}
