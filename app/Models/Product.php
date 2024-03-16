<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price_uk',
        'price_usa',
        'category_id',
        'product_type_id',
        'discount_type_id',
        'short_description',
        'discount',
        'featured',
    ];
}
