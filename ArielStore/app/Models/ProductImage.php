<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = ['product_id','original_name', 'filename', 'filesize', 'filetype'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
