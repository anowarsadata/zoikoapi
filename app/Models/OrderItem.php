<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];
    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(\App\Models\Product::class);
    }

}
