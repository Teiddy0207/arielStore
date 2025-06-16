<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'import_price',
        'price',
        'material',
        'sale',
        'description',
        'quantity',
        'size',
        'status',
        'category',
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }
}
