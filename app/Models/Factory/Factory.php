<?php

namespace App\Models\Factory;

use App\Models\User;

/**
 * نموذج المصنع - يمثل المستخدمين من نوع مصنع
 */
class Factory extends User
{
    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope('factory', function ($query) {
            $query->where('type', 'factory');
        });
    }

    public static function createFactory(array $attributes): static
    {
        $attributes['type'] = 'factory';
        return static::create($attributes);
    }
}
