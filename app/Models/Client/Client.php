<?php

namespace App\Models\Client;

use App\Models\User;

/**
 * نموذج العميل - يمثل المستخدمين من نوع عميل
 */
class Client extends User
{
    protected $table = 'users';

    /**
     * تصفية المستخدمين من نوع عميل فقط
     */
    protected static function booted(): void
    {
        static::addGlobalScope('client', function ($query) {
            $query->where('type', 'client');
        });
    }

    /**
     * إنشاء عميل جديد مع تعيين النوع تلقائياً
     */
    public static function createClient(array $attributes): static
    {
        $attributes['type'] = 'client';
        return static::create($attributes);
    }
}
