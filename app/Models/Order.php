<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'rider_id',
        'status',
        'total_price',
    ];
public function rider()
{
    return $this->belongsTo(User::class, 'rider_id');
}

public function user()
{
    return $this->belongsTo(User::class);
}

public function items()
{
    return $this->hasMany(OrderItem::class);
}

public function reviews()
{
    return $this->hasMany(Review::class);
}

protected static function boot()
{
    parent::boot();

    static::updating(function ($order) {

        // 🚫 LOCK DELIVERED ORDERS
        if ($order->getOriginal('status') === 'delivered') {
            throw new \Exception("Delivered orders cannot be modified.");
        }

        // 🚫 LOCK CANCELLED ORDERS
        if ($order->getOriginal('status') === 'cancelled') {
            throw new \Exception("Cancelled orders cannot be modified.");
        }
    });
}
}