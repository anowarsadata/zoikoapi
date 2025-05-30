<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $fillable = ['user_id'];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
}
