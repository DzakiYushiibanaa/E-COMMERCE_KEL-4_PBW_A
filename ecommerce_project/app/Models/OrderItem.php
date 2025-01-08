<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan
    protected $table = 'order_items';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    // Relasi ke tabel 'orders'
    public function order()
    {
        return $this->belongsTo(Order::class , 'order_id'); // Setiap OrderItem milik satu Order
    }

    // Relasi ke tabel 'products'
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id'); // Setiap OrderItem terkait dengan satu Produk
    }
}
