<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'order_code', 'user_id', 'customer_name', 'customer_email', 
        'customer_phone', 'customer_address', 'total_amount', 
        'shipping_fee', 'discount_amount', 'final_amount', 
        'payment_method', 'payment_status', 'status', 'note'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}