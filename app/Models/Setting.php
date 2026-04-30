<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value'];

    /**
     * Get a setting value by key.
     */
    public static function get($key, $default = null)
    {
        $setting = static::where('key', $key)->first();
        return $setting ? $setting->value : $default;
    }

    /**
     * Set a setting value.
     */
    public static function set($key, $value)
    {
        return static::updateOrCreate(['key' => $key], ['value' => $value]);
    }

    /**
     * Get logo URL helper
     */
    public static function logoUrl()
    {
        $logo = static::get('site_logo');
        if (!$logo) return asset('dist/img/default-logo.png');
        
        // If it looks like a relative path in public storage, resolve it properly
        // First, check if it's already an absolute URL from another domain
        if (str_starts_with($logo, 'http') && !str_contains($logo, config('app.url'))) {
            return $logo;
        }

        // Clean up: if it's an absolute URL from THIS or a PREVIOUS environment, extract relative path
        $cleanPath = preg_replace('/^https?:\/\/[^\/]+\/storage\//', '', $logo);

        return \Illuminate\Support\Facades\Storage::disk('public')->url($cleanPath);
    }
}
