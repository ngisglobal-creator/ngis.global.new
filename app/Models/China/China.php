<?php

namespace App\Models\China;

use App\Models\User;

/**
 * نموذج الصين - يمثل المستخدمين من نوع الصين
 */
class China extends User
{
    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope('china', function ($query) {
            $query->where('type', 'china');
        });
    }

    public static function createChina(array $attributes): static
    {
        $attributes['type'] = 'china';
        return static::create($attributes);
    }
}
