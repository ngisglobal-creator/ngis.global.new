<?php

namespace App\Models\Company;

use App\Models\User;

/**
 * نموذج الشركة - يمثل المستخدمين من نوع شركة
 */
class Company extends User
{
    protected $table = 'users';

    protected static function booted(): void
    {
        static::addGlobalScope('company', function ($query) {
            $query->where('type', 'company');
        });
    }

    public static function createCompany(array $attributes): static
    {
        $attributes['type'] = 'company';
        return static::create($attributes);
    }
}
