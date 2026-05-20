<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'food_id',
        'quantity',
        'price',
    ];

    // each item belongs to an order
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    // each item belongs to a food
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}