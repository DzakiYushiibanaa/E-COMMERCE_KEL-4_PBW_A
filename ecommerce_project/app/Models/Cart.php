<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id']; // Hanya user_id yang ada di tabel carts

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id'); // Mengacu ke field product_id yang ada di tabel cart_items
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id'); // Mengacu ke user_id yang ada di tabel carts
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class); // Menghubungkan Cart dengan CartItem
    }
}
