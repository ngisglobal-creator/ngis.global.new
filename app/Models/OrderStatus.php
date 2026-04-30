<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'name_zh',
        'image',
    ];
}
