<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name',
        'product_name',
        'total_amount',
        'status',
        'created_at'
        // Thêm các cột khác nếu cần
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function details()
{
    return $this->hasOne(OrderDetail::class, 'order_id');
}
}
