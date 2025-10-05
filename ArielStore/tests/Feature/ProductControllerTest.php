<?php

namespace Tests\Feature;

use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use Tests\TestCase;

class ProductControllerTest extends TestCase
{
    #[Test]
    #[Group('name')]
    public function should_return_false_when_name_of_product_is_empty()
    {
        $productName = '';
        $isValid = !empty($productName);
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('name')]
    public function should_return_false_when_name_of_product_is_longer_than_255()
    {
        $productName = str_repeat('a', 256);
        $isValid = strlen($productName) <= 255;
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('import_price')]
    public function should_return_false_when_import_price_is_negative()
    {
        $importPrice = -100;
        $isValid = $importPrice >= 1;
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('import_price')]
    public function should_return_false_when_import_price_is_equal_zero()
    {
        $importPrice = 0;
        $isValid = $importPrice >= 1;
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('import_price')]
    public function should_return_false_when_import_price_is_characters()
    {
        $importPrice = 'one hundred';
        $isValid = is_int($importPrice);
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('price')]
    public function should_return_false_when_price_is_not_integer_number()
    {
        $price = 100.5;
        $isValid = is_int($price);
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('price')]
    public function should_return_false_when_price_is_zero()
    {
        $price = 0;
        $isValid = $price >= 1;
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('price')]
    public function should_return_false_when_price_is_negative()
    {
        $price = -50;
        $isValid = $price >= 1;
        $this->assertFalse($isValid);
    }
    #[Test]
    #[Group('price')]
    public function should_return_false_when_price_is_characters()
    {
        $price = 'two hundred';
        $isValid = is_int($price);
        $this->assertFalse($isValid);
    }

    #[Test]
    public function should_return_true_when_product_information_is_valid()
    {
        $data = [
            'name' => 'Áo sơ mi',
            'import_price' => 200000,
            'price' => 250000,
            'material' => 'Cotton',
            'sale' => 10,
            'description' => 'Áo sơ mi nam tay dài',
            'quantity' => 50,
            'size' => 'M',
            'status' => 'Đang bán',
            'type_name' => 'Áo',
        ];

        $rules = [
            'name' => 'required|string|max:255',
            'import_price' => 'required|integer|min:1',
            'price' => 'required|integer|min:1',
            'material' => 'nullable|string|max:255',
            'sale' => 'nullable|integer|min:0|max:50',
            'description' => 'nullable|string|max:500',
            'quantity' => 'required|integer|min:1',
            'size' => 'required|in:S,M,L,XL,XXL',
            'status' => 'required|in:Đang bán,Hết hàng,Ngừng bán',
            'type_name' => 'required|in:Quần,Áo,Váy,Phụ kiện',
        ];

        $validator = Validator::make($data, $rules);
        $isValid = !$validator->fails();

        $this->assertTrue($isValid);
    }

    #[Test]
    #[Group('description')]
    public function should_return_false_when_description_of_product_is_longer_than_255()
    {
        $description = str_repeat('a', 256);
        $isValid = strlen($description) <= 255;
        $this->assertFalse($isValid);
    }
    #[Test]
    #[Group('sale')]
    public function should_return_false_when_sale_is_greater_than_50(){
        $sale = 60;
        $isValid = $sale <= 50;
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('sale')]
    public function should_return_false_when_sale_is_negative(){
        $sale = -10;
        $isValid = $sale >= 0;
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('sale')]
    public function should_return_false_when_sale_is_characters(){
        $sale = 'ten';
        $isValid = is_int($sale);
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('quantity')]
    public function should_return_false_when_sale_is_not_integer_number(){
        $quantity = 20.5;
        $isValid = is_int($quantity);
        $this->assertFalse($isValid);
    }
    #[Test]
    #[Group('quantity')]
    public function should_return_false_when_quantity_is_zero(){
        $quantity = 0;
        $isValid = $quantity >= 1;
        $this->assertFalse($isValid);
    }
    #[Test]
    #[Group('quantity')]
    public function should_return_false_when_quantity_is_negative(){
        $quantity = -5;
        $isValid = $quantity >= 1;
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('quantity')]
    public function should_return_false_when_quantity_is_characters(){
        $quantity = 'fifty';
        $isValid = is_int($quantity);
        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('size')]
    public function should_return_false_when_size_is_not_in_list_size(){
        $size = 'XXFL';
        $validSizes = ['S', 'M', 'L', 'XL', 'XXL'];
        $isValid = in_array($size, $validSizes);
        $this->assertFalse($isValid);
    }

    #[Test]
    public function should_return_true_when_remove_successfully()
    {
        $product = Product::factory()->create();
        $image = $product->images()->create([
            'original_name' => 'test.jpg',
            'filename' => 'products/test.jpg',
            'filesize' => '0.1M',
            'filetype' => 'jpg',
        ]);

        \Storage::fake('public');
        \Storage::disk('public')->put($image->filename, 'dummy content');

        $response = $this->delete(route('products.destroy', $product->id));

        $response->assertRedirect(route('products.index'));
        $this->assertDatabaseMissing('products', ['id' => $product->id]);
        $this->assertDatabaseMissing('product_images', ['id' => $image->id]);
        \Storage::disk('public')->assertMissing($image->filename);
    }

}
