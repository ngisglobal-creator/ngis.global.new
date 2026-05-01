<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'sector_id',
        'branch_id',
        'category_id',
        'name',
        'sku',
        'description',
        'price',
        'min_order_quantity',
        'currency_code',
        'custom_info',
        'product_catalog',
        'piece_weight',
        'product_piece_count',
        'carton_length',
        'carton_height',
        'carton_width',
        'carton_volume_cbm',
        'total_weight',
        'total_cbm',
        'cbm_1_capacity',
        'container_20ft_capacity',
        'container_40ft_capacity',
        'container_40hq_capacity',
        'container_45ft_capacity',
        'vehicle_group',
        'logistics_details',
        'custom_order_id',
    ];

    protected $casts = [
        'logistics_details' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sector()
    {
        return $this->belongsTo(Sector::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function customOrder()
    {
        return $this->belongsTo(CustomSourcingOrder::class, 'custom_order_id');
    }
}
