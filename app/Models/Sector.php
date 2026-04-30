<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sector extends Model
{
    /** @use HasFactory<\Database\Factories\SectorFactory> */
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'name_zh',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_sectors');
    }
}
