<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShowProduct extends Model
{
    protected $fillable = [
        'name', 
        'price', 
        'original_price', 
        'sizes', 
        'quantity'
    ];
}
