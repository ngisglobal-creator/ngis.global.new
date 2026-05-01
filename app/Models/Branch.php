<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Branch extends Model
{
    use HasFactory;

    protected $fillable = ['sector_id', 'name_ar', 'name_en', 'name_zh'];

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }
}
