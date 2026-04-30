<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Package extends Model
{
    use HasFactory;

    protected $fillable = [
        'type',
        'title_ar',
        'title_en',
        'title_zh',
        'description_ar',
        'description_en',
        'description_zh',
        'image',
    ];

    /**
     * Get image URL
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? Storage::url($this->image) : asset('dist/img/boxed-bg.jpg');
    }

    /**
     * Get translated title
     */
    public function getTitleAttribute()
    {
        $locale = app()->getLocale();
        $field = "title_{$locale}";
        return $this->{$field} ?? $this->title_en;
    }

    /**
     * Get translated description
     */
    public function getDescriptionAttribute()
    {
        $locale = app()->getLocale();
        $field = "description_{$locale}";
        return $this->{$field} ?? $this->description_en;
    }
}
