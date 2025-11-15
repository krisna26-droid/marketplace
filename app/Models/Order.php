<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'total_price',
        'status',
        'payment_status',
        'payment_method',
        'shipping_address',
    ];

    protected static function booted()
    {
        static::updated(function ($order) {
            if($order->isDirty('payment_status') && $order->payment_status == 'paid') {
                cache()->forget('admin_total_revenue');
            }
        });
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
