<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'user_id',
        'sector_id',
        'branch_id',
        'category_id',
        'name',
        'sku',
        'price',
        'currency_code',
        'min_order_quantity',
        'description',
        'piece_weight',
        'product_piece_count',
        'carton_length',
        'carton_width',
        'carton_height',
        'unit_cbm',
        'total_cbm',
        'total_weight',
        'cap_20ft',
        'cap_40ft',
        'cap_40hq',
        'cap_45ft',
        'spec_20ft_open_top',
        'spec_40ft_open_top',
        'spec_20ft_flat_rack',
        'spec_40ft_flat_rack',
        'spec_20ft_platform',
        'spec_40ft_platform',
        'spec_40ft_reefer',
        'spec_roro',
        'logistics_details',
    ];

    protected $casts = [
        'logistics_details' => 'array',
        'spec_roro' => 'boolean',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function sector() { return $this->belongsTo(Sector::class); }
    public function branch() { return $this->belongsTo(Branch::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function images() { return $this->hasMany(VehicleImage::class); }
}
