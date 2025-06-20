<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ShowProduct;

class ShowProductSeeder extends Seeder
{
    public function run(): void
    {
        ShowProduct::create([
            'name' => 'Váy Hoa Vintage',
            'price' => 450000,
            'original_price' => 600000,
            'sizes' => json_encode(['S', 'M', 'L', 'XL']),
            'quantity' => 1,
            'image' => 'images/vayhela.png',
        ]);

        ShowProduct::create([
            'name' => 'Quần Skinny Jeans',
            'price' => 680000,
            'original_price' => null,
            'sizes' => json_encode(['S', 'M', 'L', 'XL']),
            'quantity' => 1,
            'image' => 'images/skinnyjeans.png',
        ]);

        ShowProduct::create([
            'name' => 'Áo Thun Basic',
            'price' => 360000,
            'original_price' => 500000,
            'sizes' => json_encode(['S', 'M', 'L', 'XL']),
            'quantity' => 1,
            'image' => 'images/lv.jpg',
        ]);

        ShowProduct::create([
            'name' => 'Áo Sơ Mi Trắng',
            'price' => 3200000,
            'original_price' => null,
            'sizes' => json_encode(['S', 'M', 'L', 'XL']),
            'quantity' => 1,
            'image' => 'images/d&g.jpg',
        ]);

        ShowProduct::create([
            'name' => 'Balenciaga Glasses',
            'price' => 180000,
            'original_price' => 250000,
            'sizes' => json_encode(['S', 'M', 'L', 'XL']),
            'quantity' => 1,
            'image' => 'images/glasses.png',
        ]);

        ShowProduct::create([
            'name' => 'Nike Air Jordan Low 1',
            'price' => 3600000,
            'original_price' => 4000000,
            'sizes' => json_encode(['S', 'M', 'L', 'XL']),
            'quantity' => 1,
            'image' => 'images/shoes.png',
        ]);

        ShowProduct::create([
            'name' => 'Vivienne Westwood Bracelet 08g',
            'price' => 4400000,
            'original_price' => null,
            'sizes' => json_encode(['S', 'M', 'L', 'XL']),
            'quantity' => 1,
            'image' => 'images/bracelet.png',
        ]);

        ShowProduct::create([
            'name' => '13 de Marzo Bag 04',
            'price' => 3500000,
            'original_price' => 4000000,
            'sizes' => json_encode(['S', 'M', 'L', 'XL']),
            'quantity' => 1,
            'image' => 'images/bag.png',
        ]);

        ShowProduct::create([
            'name' => 'Bucket Burberry Hat 01',
            'price' => 6500000,
            'original_price' => null,
            'sizes' => json_encode(['S', 'M', 'L', 'XL']),
            'quantity' => 1,
            'image' => 'images/hat.png',
        ]);
    }
}
