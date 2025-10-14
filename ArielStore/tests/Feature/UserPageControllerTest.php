<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class UserPageControllerTest extends TestCase
{
    use RefreshDatabase;

    /** Hiển thị áo (product_type_id=1), chỉ sản phẩm còn hàng và đang bán */
    public function test_show_shirt_lists_only_in_stock_and_selling()
    {
        // Arrange
        DB::table('product_types')->insert([
            ['id' => 1, 'type_name' => 'Áo'],
            ['id' => 2, 'type_name' => 'Quần'],
        ]);
        DB::table('products')->insert([
            ['id' => 101, 'name' => 'Áo A', 'import_price' => 100, 'price' => 200, 'material' => 'Cotton', 'sale' => 0, 'description' => null, 'quantity' => 5, 'size' => 'M', 'status' => 'Đang bán', 'category' => 'Áo', 'product_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 102, 'name' => 'Áo B', 'import_price' => 100, 'price' => 200, 'material' => 'Cotton', 'sale' => 0, 'description' => null, 'quantity' => 0, 'size' => 'M', 'status' => 'Đang bán', 'category' => 'Áo', 'product_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 103, 'name' => 'Quần C', 'import_price' => 100, 'price' => 200, 'material' => 'Jeans', 'sale' => 0, 'description' => null, 'quantity' => 10, 'size' => 'L', 'status' => 'Đang bán', 'category' => 'Quần', 'product_type_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 104, 'name' => 'Áo D', 'import_price' => 100, 'price' => 200, 'material' => 'Cotton', 'sale' => 0, 'description' => null, 'quantity' => 3, 'size' => 'S', 'status' => 'Ngừng bán', 'category' => 'Áo', 'product_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act
        $response = $this->get('/userpage/shirt');

        // Assert
        $response->assertStatus(200)
            ->assertViewIs('userpage.shirt')
            ->assertViewHas('products', function ($products) {
                return $products->count() === 1
                    && $products->first()->id === 101
                    && $products->first()->status === 'Đang bán'
                    && $products->first()->quantity > 0;
            });
    }

    /** Hiển thị tất cả: chỉ sản phẩm đang bán và còn hàng */
    public function test_show_all_lists_only_selling_and_in_stock()
    {
        // Arrange
        DB::table('product_types')->insert([
            ['id' => 1, 'type_name' => 'Áo'],
            ['id' => 2, 'type_name' => 'Quần'],
        ]);
        DB::table('products')->insert([
            ['id' => 201, 'name' => 'Áo A', 'import_price' => 100, 'price' => 200, 'material' => 'Cotton', 'sale' => 0, 'description' => null, 'quantity' => 5, 'size' => 'M', 'status' => 'Đang bán', 'category' => 'Áo', 'product_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 202, 'name' => 'Quần B', 'import_price' => 100, 'price' => 200, 'material' => 'Jeans', 'sale' => 0, 'description' => null, 'quantity' => 2, 'size' => 'L', 'status' => 'Đang bán', 'category' => 'Quần', 'product_type_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 203, 'name' => 'Áo C', 'import_price' => 100, 'price' => 200, 'material' => 'Cotton', 'sale' => 0, 'description' => null, 'quantity' => 0, 'size' => 'M', 'status' => 'Đang bán', 'category' => 'Áo', 'product_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act
        $response = $this->get('/userpage/all');

        // Assert
        $response->assertStatus(200)
            ->assertViewIs('userpage.all')
            ->assertViewHas('products', function ($products) {
                return $products->count() === 2
                    && $products->pluck('id')->sort()->values()->all() === [201, 202];
            });
    }

    /** Hiển thị sản phẩm chi tiết; 404 nếu không tồn tại */
    public function test_show_product_returns_404_when_not_found()
    {
        $response = $this->get('/userpage/product/999999');
        $response->assertStatus(404);
    }

    /** Thêm vào giỏ thành công và tính giá sau sale */
    public function test_add_to_cart_success_adds_item_with_discounted_price()
    {
        // Arrange
        DB::table('product_types')->insert([
            ['id' => 1, 'type_name' => 'Áo'],
        ]);
        DB::table('products')->insert([
            ['id' => 301, 'name' => 'Áo Sale', 'import_price' => 100, 'price' => 100000, 'material' => 'Cotton', 'sale' => 10, 'description' => null, 'quantity' => 10, 'size' => 'M', 'status' => 'Đang bán', 'category' => 'Áo', 'product_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act
        $response = $this->from('/userpage/product/301')
            ->post('/userpage/product/301/add-to-cart', ['quantity' => 2]);

        // Assert
        $response->assertRedirect('/userpage/product/301')
            ->assertSessionHas('success');

        $cart = session('cart');
        $this->assertArrayHasKey(301, $cart);
        $this->assertEquals(2, $cart[301]['quantity']);
        $this->assertEquals(90000, $cart[301]['price']); // 10% off
        $this->assertStringContainsString('images/d&g.jpg', $cart[301]['image']); // fallback image
    }

    /** Vượt quá tồn kho sẽ báo lỗi */
    public function test_add_to_cart_blocks_when_exceeding_stock()
    {
        DB::table('product_types')->insert([
            ['id' => 1, 'type_name' => 'Áo'],
        ]);
        DB::table('products')->insert([
            ['id' => 302, 'name' => 'Áo Ít Hàng', 'import_price' => 100, 'price' => 100000, 'material' => 'Cotton', 'sale' => 0, 'description' => null, 'quantity' => 3, 'size' => 'M', 'status' => 'Đang bán', 'category' => 'Áo', 'product_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Có sẵn 2 trong giỏ, thêm 2 nữa (vượt quá 3)
        session()->put('cart', [
            302 => ['name' => 'Áo Ít Hàng', 'price' => 100000, 'original_price' => 100000, 'image' => 'x', 'quantity' => 2, 'sale' => 0],
        ]);

        $response = $this->from('/userpage/product/302')
            ->post('/userpage/product/302/add-to-cart', ['quantity' => 2]);

        $response->assertRedirect('/userpage/product/302')
            ->assertSessionHas('error');
        $cart = session('cart');
        $this->assertEquals(2, $cart[302]['quantity']); // không thay đổi
    }

    /** View giỏ hàng tính đúng tổng */
    public function test_view_cart_computes_total_correctly()
    {
        session()->put('cart', [
            101 => ['name' => 'A', 'price' => 100000, 'original_price' => 100000, 'image' => 'x', 'quantity' => 2, 'sale' => 0],
            102 => ['name' => 'B', 'price' => 50000, 'original_price' => 50000, 'image' => 'y', 'quantity' => 3, 'sale' => 0],
        ]);

        $response = $this->get('/userpage/cart');
        $response->assertStatus(200)
            ->assertViewIs('userpage.cart')
            ->assertViewHas('total', 100000 * 2 + 50000 * 3);
    }

    /** Checkout hiển thị redirect khi giỏ trống */
    public function test_showcheckout_redirects_when_cart_empty()
    {
        session()->forget('cart');
        $response = $this->get('/userpage/checkout');
        $response->assertRedirect(route('userpage.cart'))
            ->assertSessionHas('error');
    }

    /** Checkout hiển thị view khi có giỏ */
    public function test_showcheckout_returns_view_with_total_when_cart_has_items()
    {
        session()->put('cart', [
            101 => ['name' => 'A', 'price' => 100000, 'original_price' => 100000, 'image' => 'x', 'quantity' => 2, 'sale' => 0],
            102 => ['name' => 'B', 'price' => 50000, 'original_price' => 50000, 'image' => 'y', 'quantity' => 3, 'sale' => 0],
        ]);
        $response = $this->get('/userpage/checkout');
        $response->assertStatus(200)
            ->assertViewIs('userpage.checkout')
            ->assertViewHas('total', 100000 * 2 + 50000 * 3);
    }

    /** Checkout thành công: tạo orders + order_details và xóa giỏ */
    public function test_checkout_success_creates_order_and_details_and_clears_cart()
    {
        // Arrange cart và dữ liệu sản phẩm tương ứng
        DB::table('product_types')->insert([
            ['id' => 1, 'type_name' => 'Áo'],
        ]);
        DB::table('products')->insert([
            ['id' => 701, 'name' => 'Áo 1', 'import_price' => 100, 'price' => 120000, 'material' => 'Cotton', 'sale' => 0, 'description' => null, 'quantity' => 10, 'size' => 'M', 'status' => 'Đang bán', 'category' => 'Áo', 'product_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 702, 'name' => 'Áo 2', 'import_price' => 100, 'price' => 80000, 'material' => 'Cotton', 'sale' => 0, 'description' => null, 'quantity' => 5, 'size' => 'L', 'status' => 'Đang bán', 'category' => 'Áo', 'product_type_id' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);
        session()->put('cart', [
            701 => ['name' => 'Áo 1', 'price' => 120000, 'original_price' => 120000, 'image' => 'x', 'quantity' => 1, 'sale' => 0],
            702 => ['name' => 'Áo 2', 'price' => 80000, 'original_price' => 80000, 'image' => 'y', 'quantity' => 2, 'sale' => 0],
        ]);

        // Act
        $response = $this->post('/userpage/checkout', [
            'name' => 'Khách Hàng',
            'phone' => '0900000000',
            'email' => 'customer@example.com',
            'address' => '123 Đường X',
            'payment_method' => 'COD',
            'note' => 'Giao nhanh',
        ]);

        // Assert
        $response->assertRedirect(route('userpage.order-success', ['orderId' => 1]));

        $this->assertDatabaseHas('orders', [
            'id' => 1,
            'customer_name' => 'Khách Hàng',
            'phone' => '0900000000',
            'email' => 'customer@example.com',
            'address' => '123 Đường X',
            'note' => 'Giao nhanh',
            'total_amount' => 120000 + 80000 * 2,
            'status' => 1,
        ]);

        $this->assertDatabaseHas('order_details', [
            'order_id' => 1,
            'product_name' => 'Áo 1',
            'price' => 120000,
        ]);
        $this->assertDatabaseHas('order_details', [
            'order_id' => 1,
            'product_name' => 'Áo 2',
            'price' => 80000,
        ]);

        $this->assertNull(session('cart')); // đã clear giỏ
    }

    /** Checkout lỗi khi thiếu dữ liệu bắt buộc */
    public function test_checkout_validation_errors_when_missing_required_fields()
    {
        session()->put('cart', [
            701 => ['name' => 'Áo 1', 'price' => 120000, 'original_price' => 120000, 'image' => 'x', 'quantity' => 1, 'sale' => 0],
        ]);

        $response = $this->from('/userpage/checkout')
            ->post('/userpage/checkout', [
                // thiếu name
                'phone' => '0900000000',
                'email' => 'invalid-email', // cũng sai định dạng
                'address' => '',
                'payment_method' => '',
                'note' => 'Ghi chú',
            ]);

        $response->assertRedirect('/userpage/checkout');
        $response->assertSessionHasErrors(['name', 'email', 'address', 'payment_method']);
        $this->assertDatabaseCount('orders', 0);
        $this->assertNotNull(session('cart')); // vẫn giữ giỏ
    }

    /** Tìm kiếm ShowProduct theo tên */
    public function test_search_returns_matching_products()
    {
        DB::table('show_products')->insert([
            ['id' => 1, 'name' => 'Áo thun', 'price' => 100000, 'original_price' => 120000, 'sizes' => json_encode(['S','M']), 'quantity' => 10, 'image' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'name' => 'Quần jean', 'price' => 200000, 'original_price' => 250000, 'sizes' => json_encode(['L']), 'quantity' => 5, 'image' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $response = $this->get('/userpage/search?query=Áo');
        $response->assertStatus(200)
            ->assertViewIs('userpage.search_results')
            ->assertViewHas('products', function ($products) {
                return $products->count() === 1 && $products->first()->name === 'Áo thun';
            })
            ->assertViewHas('query', 'Áo');
    }

    /** Trang thông báo thành công */
    public function test_order_success_view_receives_order_id()
    {
        $response = $this->get('/userpage/order-success/12345');
        $response->assertStatus(200)
            ->assertViewIs('userpage.order_success')
            ->assertViewHas('orderId', 12345);
    }
}