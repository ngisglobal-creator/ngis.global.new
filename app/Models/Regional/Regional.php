<?php

namespace App\Models\Regional;

use App\Models\User;

/**
 * نموذج مكتب الاقليم - يمثل المستخدمين من نوع regional_office
 */
class Regional extends User
{
    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope('regional', function ($query) {
            $query->where('type', 'regional_office');
        });
    }

    public static function createRegional(array $attributes): static
    {
        $attributes['type'] = 'regional_office';
        return static::create($attributes);
    }
}
