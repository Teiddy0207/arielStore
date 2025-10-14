<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Arrange-Act-Assert: getOrder trả về danh sách theo status và search.
     */
    public function test_get_order_filters_by_status_and_search()
    {
        // Arrange: tạo dữ liệu statuses và orders
        DB::table('statuses')->insert([
            ['id' => 1, 'description' => 'Chờ xử lý', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'description' => 'Hoàn thành', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('orders')->insert([
            ['id' => 1001, 'customer_name' => 'A', 'total_amount' => 100000, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 1002, 'customer_name' => 'B', 'total_amount' => 150000, 'status' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2003, 'customer_name' => 'C', 'total_amount' => 200000, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->getJson('/api/get-orders?status=Chờ xử lý&search=2003');

        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'id' => 2003,
                'customer_name' => 'C',
                'total_amount' => 200000,
                'status' => 'Chờ xử lý',
            ]);
    }

    /**
     * Lọc theo mã đơn hàng duy nhất bằng tham số search.
     */
    public function test_get_order_filters_by_order_id_only()
    {
        // Arrange
        DB::table('statuses')->insert([
            ['id' => 1, 'description' => 'Chờ xử lý', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'description' => 'Hoàn thành', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('orders')->insert([
            ['id' => 5001, 'customer_name' => 'X', 'total_amount' => 180000, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 5002, 'customer_name' => 'Y', 'total_amount' => 220000, 'status' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->getJson('/api/get-orders?search=5001');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonFragment([
                'id' => 5001,
                'customer_name' => 'X',
                'total_amount' => 180000,
                'status' => 'Chờ xử lý',
            ]);
    }

    /**
     * Lọc theo trạng thái duy nhất.
     */
    public function test_get_order_filters_by_status_only()
    {
        // Arrange
        DB::table('statuses')->insert([
            ['id' => 1, 'description' => 'Chờ xử lý', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'description' => 'Hoàn thành', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('orders')->insert([
            ['id' => 7001, 'customer_name' => 'P', 'total_amount' => 100000, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7002, 'customer_name' => 'Q', 'total_amount' => 200000, 'status' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7003, 'customer_name' => 'R', 'total_amount' => 300000, 'status' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->getJson('/api/get-orders?status=Hoàn thành');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(['id' => 7002, 'status' => 'Hoàn thành'])
            ->assertJsonFragment(['id' => 7003, 'status' => 'Hoàn thành']);
    }

    /**
     * Không truyền filter sẽ trả về tất cả đơn hàng.
     */
    public function test_get_order_returns_all_when_no_filters()
    {
        // Arrange
        DB::table('statuses')->insert([
            ['id' => 1, 'description' => 'Chờ xử lý', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'description' => 'Hoàn thành', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('orders')->insert([
            ['id' => 8001, 'customer_name' => 'M', 'total_amount' => 120000, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8002, 'customer_name' => 'N', 'total_amount' => 220000, 'status' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->getJson('/api/get-orders');

        // Assert
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(['id' => 8001, 'status' => 'Chờ xử lý'])
            ->assertJsonFragment(['id' => 8002, 'status' => 'Hoàn thành']);
    }

    /**
     * search rỗng sẽ không áp dụng bộ lọc search.
     */
    public function test_get_order_handles_empty_search()
    {
        // Arrange
        DB::table('statuses')->insert([
            ['id' => 1, 'description' => 'Chờ xử lý', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'description' => 'Hoàn thành', 'created_at' => now(), 'updated_at' => now()],
        ]);

        DB::table('orders')->insert([
            ['id' => 8101, 'customer_name' => 'M1', 'total_amount' => 120000, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8102, 'customer_name' => 'N1', 'total_amount' => 220000, 'status' => 2, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act: truyền search rỗng
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->getJson('/api/get-orders?search=');

        // Assert: vẫn trả về tất cả vì search rỗng bị bỏ qua
        $response->assertStatus(200)
            ->assertJsonCount(2)
            ->assertJsonFragment(['id' => 8101])
            ->assertJsonFragment(['id' => 8102]);
    }

    /**
     * Trạng thái không tồn tại trả về rỗng.
     */
    public function test_get_order_handles_nonexistent_status()
    {
        // Arrange
        DB::table('statuses')->insert([
            ['id' => 1, 'description' => 'Chờ xử lý', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('orders')->insert([
            ['id' => 8201, 'customer_name' => 'Z', 'total_amount' => 120000, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->getJson('/api/get-orders?status=Không tồn tại');

        // Assert
        $response->assertStatus(200)
            ->assertExactJson([]);
    }
 
    public function test_update_status_updates_order()
    {
        // Arrange
        DB::table('statuses')->insert([
            ['id' => 1, 'description' => 'Chờ xử lý', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'description' => 'Đã hủy', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('orders')->insert([
            ['id' => 3001, 'customer_name' => 'D', 'total_amount' => 120000, 'status' => 1, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/update-status', [
                'order_id' => 3001,
                'status' => 3,
            ]);

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công!',
            ]);
        $this->assertDatabaseHas('orders', [
            'id' => 3001,
            'status' => 3,
        ]);
    }

    /**
     * Cập nhật trạng thái với order không tồn tại vẫn trả về success
     * và không làm thay đổi dữ liệu.
     */
    public function test_update_status_no_order_still_returns_success_and_no_change()
    {
        // Arrange: không có orders
        DB::table('statuses')->insert([
            ['id' => 1, 'description' => 'Chờ xử lý', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'description' => 'Đã hủy', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/update-status', [
                'order_id' => 9999,
                'status' => 3,
            ]);

        // Assert: Controller hiện tại luôn trả về success
        $response->assertStatus(200)
            ->assertJson([
                'success' => true,
                'message' => 'Cập nhật trạng thái thành công!',
            ]);

        // Database không có bản ghi tương ứng
        $this->assertDatabaseMissing('orders', [
            'id' => 9999,
            'status' => 3,
        ]);
    }


    /**
     * Arrange-Act-Assert: getOrderDetail trả về chi tiết đơn hàng kèm items.
     */
    public function test_get_order_detail_returns_order_and_details()
    {
        // Arrange
        DB::table('statuses')->insert([
            ['id' => 1, 'description' => 'Chờ xử lý', 'created_at' => now(), 'updated_at' => now()],
        ]);
        DB::table('orders')->insert([
            [
                'id' => 4001,
                'customer_name' => 'E',
                'phone' => '0900000000',
                'email' => 'e@example.com',
                'address' => '123 Đường X',
                'note' => 'Gọi trước khi giao',
                'total_amount' => 250000,
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('order_details')->insert([
            ['order_id' => 4001, 'product_name' => 'Áo thun', 'price' => 150000],
            ['order_id' => 4001, 'product_name' => 'Quần jean', 'price' => 100000],
        ]);

        // Act
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->getJson('/api/order-detail/4001');

        // Assert
        $response->assertStatus(200)
            ->assertJsonFragment([
                'id' => 4001,
                'customer_name' => 'E',
                'total_amount' => 250000,
                'address' => '123 Đường X',
                'note' => 'Gọi trước khi giao',
                'phone' => '0900000000',
                'status' => 'Chờ xử lý',
            ])
            ->assertJsonCount(2, 'details');
    }

    /**
     * Khi không có đơn hàng, API trả về order=null và details=[]
     */
    public function test_get_order_detail_returns_empty_when_not_found()
    {
        // Arrange: đảm bảo có bảng
        DB::table('statuses')->insert([
            ['id' => 1, 'description' => 'Chờ xử lý', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Act
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->getJson('/api/order-detail/123456');

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'order' => null,
                'details' => [],
            ]);
    }
}