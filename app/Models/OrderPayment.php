<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderPayment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'status',
        'notes',
        'payment_date',
    ];

    protected $dates = ['payment_date'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
