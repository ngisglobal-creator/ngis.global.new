<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_ar',
        'name_en',
        'name_zh',
        'flag_code',
    ];

    public function geographicZones()
    {
        return $this->belongsToMany(GeographicZone::class, 'geographic_zone_country');
    }
}
