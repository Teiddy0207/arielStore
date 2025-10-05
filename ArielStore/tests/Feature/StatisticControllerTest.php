<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\ProductType;
use App\Models\User;
use Carbon\Carbon;

class StatisticControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();
        
        // Seed cơ bản nếu cần
        $this->seed();
    }

    /**
     * Test thống kê doanh số theo ngày
     * 
     * @test
     */
    public function it_can_get_daily_sales_statistics()
    {
        // Arrange - Chuẩn bị dữ liệu
        $user = User::factory()->create();
        $today = Carbon::today();
        $yesterday = Carbon::yesterday();
        
        // Tạo đơn hàng với status = 4 (hoàn thành)
        Order::factory()->create([
            'total_amount' => 100000,
            'status' => 4,
            'created_at' => $today
        ]);
        
        Order::factory()->create([
            'total_amount' => 200000,
            'status' => 4,
            'created_at' => $yesterday
        ]);
        
        // Tạo đơn hàng với status khác (không tính vào thống kê)
        Order::factory()->create([
            'total_amount' => 50000,
            'status' => 1,
            'created_at' => $today
        ]);

        // Act - Thực hiện action
        $response = $this->getJson('/api/statistic/sales/days');

        // Assert - Kiểm tra kết quả
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'date',
                'total_sales'
            ]
        ]);
        
        $data = $response->json();
        
        // Kiểm tra có đúng 2 ngày trong kết quả
        $this->assertCount(2, $data);
        
        // Kiểm tra tổng tiền theo từng ngày
        $todayRecord = collect($data)->firstWhere('date', $today->format('Y-m-d'));
        $yesterdayRecord = collect($data)->firstWhere('date', $yesterday->format('Y-m-d'));
        
        $this->assertEquals(100000, $todayRecord['total_sales']);
        $this->assertEquals(200000, $yesterdayRecord['total_sales']);
    }

    /**
     * Test thống kê doanh số theo tháng
     * 
     * @test
     */
    public function it_can_get_monthly_sales_statistics()
    {
        // Arrange
        $currentMonth = Carbon::now()->startOfMonth();
        $lastMonth = Carbon::now()->subMonth()->startOfMonth();
        
        Order::factory()->create([
            'total_amount' => 150000,
            'status' => 4,
            'created_at' => $currentMonth
        ]);
        
        Order::factory()->create([
            'total_amount' => 250000,
            'status' => 4,
            'created_at' => $lastMonth
        ]);

        // Act
        $response = $this->getJson('/api/statistic/sales/months');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'month',
                'total_sales'
            ]
        ]);
        
        $data = $response->json();
        $this->assertCount(2, $data);
        
        // Kiểm tra format tháng Y-m
        $currentMonthRecord = collect($data)->firstWhere('month', $currentMonth->format('Y-m'));
        $lastMonthRecord = collect($data)->firstWhere('month', $lastMonth->format('Y-m'));
        
        $this->assertEquals(150000, $currentMonthRecord['total_sales']);
        $this->assertEquals(250000, $lastMonthRecord['total_sales']);
    }

    /**
     * Test thống kê doanh số theo năm
     * 
     * @test
     */
    public function it_can_get_yearly_sales_statistics()
    {
        // Arrange
        $currentYear = Carbon::now()->year;
        $lastYear = $currentYear - 1;
        
        Order::factory()->create([
            'total_amount' => 500000,
            'status' => 4,
            'created_at' => Carbon::create($currentYear, 1, 1)
        ]);
        
        Order::factory()->create([
            'total_amount' => 750000,
            'status' => 4,
            'created_at' => Carbon::create($lastYear, 1, 1)
        ]);

        // Act
        $response = $this->getJson('/api/statistic/sales/years');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'year',
                'total_sales'
            ]
        ]);
        
        $data = $response->json();
        $this->assertCount(2, $data);
        
        $currentYearRecord = collect($data)->firstWhere('year', $currentYear);
        $lastYearRecord = collect($data)->firstWhere('year', $lastYear);
        
        $this->assertEquals(500000, $currentYearRecord['total_sales']);
        $this->assertEquals(750000, $lastYearRecord['total_sales']);
    }

    /**
     * Test thống kê biểu đồ sản phẩm theo ngày
     * 
     * @test
     */
    public function it_can_get_daily_product_chart_statistics()
    {
        // Arrange
        $productType1 = ProductType::factory()->create(['description' => 'Áo thun']);
        $productType2 = ProductType::factory()->create(['description' => 'Quần jean']);
        
        $order1 = Order::factory()->create(['status' => 4]);
        $order2 = Order::factory()->create(['status' => 4]);
        
        // Tạo order details
        OrderDetail::factory()->create([
            'order_id' => $order1->id,
            'product_type_id' => $productType1->id
        ]);
        
        OrderDetail::factory()->create([
            'order_id' => $order1->id,
            'product_type_id' => $productType1->id
        ]);
        
        OrderDetail::factory()->create([
            'order_id' => $order2->id,
            'product_type_id' => $productType2->id
        ]);

        // Act
        $response = $this->getJson('/api/statistic/sales/days/chart');

        // Assert
        $response->assertStatus(200);
        $response->assertJsonStructure([
            '*' => [
                'type_id',
                'type_name',
                'items',
                'ratio',
                'percent'
            ]
        ]);
        
        $data = $response->json();
        
        // Kiểm tra có đúng 2 loại sản phẩm
        $this->assertCount(2, $data);
        
        // Kiểm tra số lượng items
        $aothunRecord = collect($data)->firstWhere('type_name', 'Áo thun');
        $quanjeanRecord = collect($data)->firstWhere('type_name', 'Quần jean');
        
        $this->assertEquals(2, $aothunRecord['items']);
        $this->assertEquals(1, $quanjeanRecord['items']);
        
        // Kiểm tra tỷ lệ phần trăm
        $this->assertEquals(67, $aothunRecord['percent']); // 2/3 * 100 = 67%
        $this->assertEquals(33, $quanjeanRecord['percent']); // 1/3 * 100 = 33%
    }

    /**
     * Test các view routes của báo cáo thống kê
     * 
     * @test
     */
    public function it_can_access_statistic_view_routes()
    {
        // Arrange - Đăng nhập user (nếu cần authentication)
        $user = User::factory()->create();
        $this->actingAs($user);

        // Act & Assert - Test từng route view
        $routes = [
            '/statistic/sales',
            '/statistic/sales/days', 
            '/statistic/sales/months',
            '/statistic/sales/years',
            '/statistic/inventory/months',
            '/statistic/inventory/years',
            '/statistic/customer'
        ];
        
        foreach ($routes as $route) {
            $response = $this->get($route);
            $response->assertStatus(200);
            $response->assertViewIs($this->getExpectedViewName($route));
        }
    }

    /**
     * Test trường hợp không có dữ liệu
     * 
     * @test
     */
    public function it_returns_empty_array_when_no_sales_data_exists()
    {
        // Arrange - Không tạo dữ liệu gì

        // Act
        $response = $this->getJson('/api/statistic/sales/days');

        // Assert
        $response->assertStatus(200);
        $response->assertJson([]);
    }

    /**
     * Test chỉ tính đơn hàng có status = 4 (hoàn thành)
     * 
     * @test
     */
    public function it_only_counts_completed_orders_in_statistics()
    {
        // Arrange
        $today = Carbon::today();
        
        // Tạo đơn hàng với các status khác nhau
        Order::factory()->create(['total_amount' => 100000, 'status' => 1, 'created_at' => $today]); // Chờ xử lý
        Order::factory()->create(['total_amount' => 200000, 'status' => 2, 'created_at' => $today]); // Đang xử lý
        Order::factory()->create(['total_amount' => 300000, 'status' => 3, 'created_at' => $today]); // Đang giao
        Order::factory()->create(['total_amount' => 400000, 'status' => 4, 'created_at' => $today]); // Hoàn thành
        Order::factory()->create(['total_amount' => 500000, 'status' => 5, 'created_at' => $today]); // Hủy

        // Act
        $response = $this->getJson('/api/statistic/sales/days');

        // Assert
        $response->assertStatus(200);
        $data = $response->json();
        
        $this->assertCount(1, $data);
        $this->assertEquals(400000, $data[0]['total_sales']); // Chỉ tính đơn status = 4
    }

    /**
     * Helper method để lấy tên view dự kiến
     */
    private function getExpectedViewName($route)
    {
        $viewMap = [
            '/statistic/sales' => 'statistic.sales.days',
            '/statistic/sales/days' => 'statistic.sales.days',
            '/statistic/sales/months' => 'statistic.sales.months', 
            '/statistic/sales/years' => 'statistic.sales.years',
            '/statistic/inventory/months' => 'statistic.inventory.months',
            '/statistic/inventory/years' => 'statistic.inventory.years',
            '/statistic/customer' => 'statistic.customer'
        ];
        
        return $viewMap[$route];
    }
}