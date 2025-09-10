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
        'note',
        'phone',
        'quantity',
        'status',
    ];

    // Mỗi chi tiết đơn hàng thuộc về 1 đơn hàng
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    // Mỗi chi tiết đơn hàng có 1 trạng thái
    public function status()
    {
        return $this->belongsTo(Status::class, 'status');
    }
}
