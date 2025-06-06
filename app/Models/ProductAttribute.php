<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'name', 'value', 'unit'];
    public function products() {
        return $this->belongsTo(Product::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
