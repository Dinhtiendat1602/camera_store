<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    protected $fillable = [
        'order_id', 'user_id', 'shipping_full_name', 'shipping_email',
        'shipping_phone', 'shipping_address', 'shipping_city', 
        'shipping_district', 'shipping_ward', 'payment_method',
        'payment_status', 'transaction_id', 'bank_code', 
        'card_last_digits', 'shipping_fee', 'discount_amount', 
        'total_amount', 'checkout_date', 'payment_date'
    ];

    protected $dates = ['checkout_date', 'payment_date'];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}