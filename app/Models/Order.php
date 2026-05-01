<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'product_id',
        'quantity',
        'shipping_unit_type',
        'notes',
        'status',
        'assigned_to_regional',
        'contract_file',
        'invoice_file',
        'paid_amount',
        'payment_status',
        'forward_to_china',
        'rejection_reason',
        'cartons_count',
        'total_weight',
        'total_cbm',
        'total_cost',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function payments()
    {
        return $this->hasMany(OrderPayment::class)->latest();
    }
}
