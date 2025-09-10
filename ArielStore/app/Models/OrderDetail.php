<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $table = 'order_details'; // rõ ràng tên bảng

    protected $fillable = [
        'order_id',
        'product_name',
    ];

    // Mỗi chi tiết đơn hàng thuộc về 1 đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
