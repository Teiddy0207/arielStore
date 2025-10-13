<?php

namespace Tests\Feature;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

class ProductControllerTest extends TestCase
{
    // ----------- Helper functions for validation -----------
    private function validateName($name): bool
    {
        return !empty($name) && is_string($name) && strlen($name) <= 255;
    }

    private function validateImportPrice($importPrice): bool
    {
        return isset($importPrice) && is_numeric($importPrice) && $importPrice >= 1;
    }

    private function validatePrice($price): bool
    {
        return isset($price) && is_numeric($price) && $price >= 1;
    }

    private function validateMaterial($material): bool
    {
        return empty($material) || strlen($material) <= 255;
    }

    private function validateSale($sale): bool
    {
        return !isset($sale) || (is_numeric($sale) && $sale >= 0 && $sale <= 50);
    }

    private function validateDescription($description): bool
    {
        return empty($description) || strlen($description) <= 500;
    }

    private function validateQuantity($quantity): bool
    {
        return isset($quantity) && is_numeric($quantity) && $quantity >= 1;
    }

    private function validateSize($size): bool
    {
        $validSizes = ['S', 'M', 'L', 'XL', 'XXL'];
        return !empty($size) && in_array($size, $validSizes, true);
    }

    private function validateStatus($status): bool
    {
        $validStatus = ['Đang bán', 'Hết hàng', 'Ngừng bán'];
        return !empty($status) && in_array($status, $validStatus, true);
    }

    // ----------- Test cases for Name -----------
    #[Test]
    #[Group('name')]
    public function test_name_is_empty_should_be_invalid()
    {
        $this->assertFalse($this->validateName(''));
    }

    #[Test]
    #[Group('name')]
    public function test_name_too_long_should_be_invalid()
    {
        $this->assertFalse($this->validateName(str_repeat('a', 256)));
    }

    #[Test]
    #[Group('name')]
    public function test_name_is_not_string_should_be_invalid()
    {
        $this->assertFalse($this->validateName(12345));
    }

    // ----------- Test cases for Import Price -----------
    #[Test]
    #[Group('import_price')]
    public function test_import_price_missing_should_be_invalid()
    {
        $this->assertFalse($this->validateImportPrice(null));
    }

    #[Test]
    #[Group('import_price')]
    public function test_import_price_is_not_numeric_should_be_invalid()
    {
        $this->assertFalse($this->validateImportPrice('abc'));
    }

    #[Test]
    #[Group('import_price')]
    public function test_import_price_less_than_1_should_be_invalid()
    {
        $this->assertFalse($this->validateImportPrice(0));
    }

    // ----------- Test cases for Price -----------
    #[Test]
    #[Group('price')]
    public function test_price_missing_should_be_invalid()
    {
        $this->assertFalse($this->validatePrice(null));
    }

    #[Test]
    #[Group('price')]
    public function test_price_is_not_numeric_should_be_invalid()
    {
        $this->assertFalse($this->validatePrice('abc'));
    }

    #[Test]
    #[Group('price')]
    public function test_price_less_than_1_should_be_invalid()
    {
        $this->assertFalse($this->validatePrice(0));
    }

    // ----------- Test cases for Material -----------
    #[Test]
    #[Group('material')]
    public function test_material_too_long_should_be_invalid()
    {
        $this->assertFalse($this->validateMaterial(str_repeat('b', 256)));
    }

    // ----------- Test cases for Sale -----------
    #[Test]
    #[Group('sale')]
    public function test_sale_negative_should_be_invalid()
    {
        $this->assertFalse($this->validateSale(-1));
    }

    #[Test]
    #[Group('sale')]
    public function test_sale_greater_than_50_should_be_invalid()
    {
        $this->assertFalse($this->validateSale(60));
    }

    #[Test]
    #[Group('sale')]
    public function test_sale_zero_should_be_valid()
    {
        $this->assertTrue($this->validateSale(0));
    }

    #[Test]
    #[Group('sale')]
    public function test_sale_50_should_be_valid()
    {
        $this->assertTrue($this->validateSale(50));
    }

    // ----------- Test cases for Description -----------
    #[Test]
    #[Group('description')]
    public function test_description_too_long_should_be_invalid()
    {
        $this->assertFalse($this->validateDescription(str_repeat('c', 501)));
    }

    // ----------- Test cases for Quantity -----------
    #[Test]
    #[Group('quantity')]
    public function test_quantity_missing_should_be_invalid()
    {
        $this->assertFalse($this->validateQuantity(null));
    }

    #[Test]
    #[Group('quantity')]
    public function test_quantity_is_not_numeric_should_be_invalid()
    {
        $this->assertFalse($this->validateQuantity('abc'));
    }

    #[Test]
    #[Group('quantity')]
    public function test_quantity_less_than_1_should_be_invalid()
    {
        $this->assertFalse($this->validateQuantity(0));
    }

    // ----------- Test cases for Size -----------
    #[Test]
    #[Group('size')]
    public function test_size_invalid_should_be_invalid()
    {
        $this->assertFalse($this->validateSize('XS'));
    }

    #[Test]
    #[Group('size')]
    public function test_size_valid_should_be_valid()
    {
        $this->assertTrue($this->validateSize('L'));
    }

    #[Test]
    #[Group('size')]
    public function test_size_missing_should_be_invalid()
    {
        $this->assertFalse($this->validateSize(''));
    }

    // ----------- Test cases for Status -----------
    #[Test]
    #[Group('status')]
    public function test_status_invalid_should_be_invalid()
    {
        $this->assertFalse($this->validateStatus('Tạm ngưng'));
    }

    #[Test]
    #[Group('status')]
    public function test_status_valid_should_be_valid()
    {
        $this->assertTrue($this->validateStatus('Đang bán'));
    }

    #[Test]
    #[Group('status')]
    public function test_status_missing_should_be_invalid()
    {
        $this->assertFalse($this->validateStatus(''));
    }

    // ----------- Test case for all valid fields -----------
    #[Test]
    #[Group('all')]
    public function test_all_fields_valid_should_be_valid()
    {
        $data = [
            'name' => 'Áo thun',
            'import_price' => 100,
            'price' => 200,
            'material' => 'Cotton',
            'sale' => 10,
            'description' => 'Sản phẩm tốt',
            'quantity' => 5,
            'size' => 'M',
            'status' => 'Đang bán'
        ];

        $isValid =
            $this->validateName($data['name']) &&
            $this->validateImportPrice($data['import_price']) &&
            $this->validatePrice($data['price']) &&
            $this->validateMaterial($data['material']) &&
            $this->validateSale($data['sale']) &&
            $this->validateDescription($data['description']) &&
            $this->validateQuantity($data['quantity']) &&
            $this->validateSize($data['size']) &&
            $this->validateStatus($data['status']);

        $this->assertTrue($isValid);
    }
}
