<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function OrderItems()
    {
        return $this->HasMany(OrderItem::class);
    }
    public function ShippingInfo()
    {
        return $this->hasOne(ShippingInfo::class);
    }


    protected $casts = [
        'OrderStatus' => OrderStatus::class,
    ];

    protected $fillable = [
        'user_id',
        'total_price'
    ];
}
