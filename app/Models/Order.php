<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'currency_id',
        'billing_address_id',
        'shipping_address_id',
        'payment_method',
        'subtotal',
        'total',
        'subtotal',
        'remarks',
        'status',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function currencies()
    {
        return $this->belongsToMany(Currency::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
