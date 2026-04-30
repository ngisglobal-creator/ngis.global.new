<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomSourcingOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'category_type',
        'description',
        'reference_link',
        'images',
        'spec_file',
        'quantity',
        'unit',
        'target_price',
        'packaging',
        'origin',
        'certs',
        'other_certs',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'images' => 'array',
        'packaging' => 'array',
        'certs' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending'    => 'warning',
            'processing' => 'info',
            'matched'    => 'primary',
            'shipped'    => 'success',
            'completed'  => 'success',
            'cancelled'  => 'danger',
            default      => 'default',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'pending'    => 'قيد المراجعة',
            'processing' => 'جاري البحث الميداني',
            'matched'    => 'تمت المطابقة',
            'shipped'    => 'تم الشحن',
            'completed'  => 'مكتمل',
            'cancelled'  => 'ملغي',
            default      => $this->status,
        };
    }

    public function matchedProducts()
    {
        return $this->hasMany(Product::class, 'custom_order_id');
    }
}
