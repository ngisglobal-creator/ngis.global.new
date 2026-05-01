<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserNews extends Model
{
    protected $table = 'user_news';

    protected $fillable = [
        'user_id',
        'type',
        'title_ar',
        'title_en',
        'content_ar',
        'content_en',
        'images',
        'video',
    ];

    protected $casts = [
        'images' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
