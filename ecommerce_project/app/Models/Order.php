<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    // Menentukan tabel yang digunakan (opsional, jika nama tabel mengikuti konvensi Laravel)
    protected $table = 'orders';

    // Menentukan kolom yang dapat diisi secara massal (mass assignment)
    protected $fillable = [
        'user_id',
        'full_name',
        'phone', 
        'shipping_address',
        'total_price',
        'status',
        'courier',
        'tracking_number',
        'shipped_at',
        'delivered_at',
    ];

    // Relasi ke tabel 'users'
    public function user()
    {
        return $this->belongsTo(User::class, 'order_id'); // Relasi Order ke User (satu user memiliki banyak order)
    }

    // Relasi ke tabel 'order_items' (satu order memiliki banyak order item)
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'order_id'); // Satu Order bisa memiliki banyak OrderItem
    }

    // public function payment()
    // {
    //     return $this->hasOne(Payments::class);
    // }

    public function payment()
    {
        return $this->hasOne(Payments::class, 'order_id');
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Cari nomor pesanan terakhir untuk hari ini
            $lastOrder = self::whereDate('created_at', now()->toDateString())
                ->orderBy('id', 'desc')
                ->first();

            // Tentukan urutan nomor pesanan
            $sequence = $lastOrder ? ((int) substr($lastOrder->order_number, -4)) + 1 : 1;

            // Format: ORD-YYYYMMDD-XXXX
            $model->order_number = 'RNZ/' . now()->format('Ymd') . '/' . str_pad($sequence, 4, '0', STR_PAD_LEFT);
        });
    }

}
