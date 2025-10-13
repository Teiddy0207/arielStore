<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
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
        'product_type_id',
        'original_name',
        'filename',
        'filesize',
        'filetype',
    ];

    public static function create(array $validated): Product
    {
        $product = new self($validated);
        $product->save();
        return $product;
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function productType()
    {
        return $this->belongsTo(ProductType::class);
    }


}
