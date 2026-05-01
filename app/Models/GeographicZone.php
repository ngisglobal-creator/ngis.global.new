<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GeographicZone extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'name_zh',
        'image',
    ];

    public function countries()
    {
        return $this->belongsToMany(Country::class, 'geographic_zone_country');
    }
}
