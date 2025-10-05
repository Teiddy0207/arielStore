<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Employee;

class StatisticViewRoutesTest extends TestCase
{
    use RefreshDatabase;

    protected $user;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Arrange - Tạo user/employee để test authentication
        $this->user = Employee::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_active' => true
        ]);
    }

    /**
     * Test truy cập route báo cáo bán hàng chính
     * 
     * @test
     */
    public function it_can_access_main_sales_report_route()
    {
        // Arrange - Đăng nhập user
        $this->actingAs($this->user);

        // Act - Truy cập route
        $response = $this->get(route('statistic.sales'));

        // Assert - Kiểm tra response
        $response->assertStatus(200);
        $response->assertViewIs('statistic.sales.days');
        $response->assertSee('Báo cáo thống kê', false);
    }

    /**
     * Test truy cập route báo cáo bán hàng theo ngày
     * 
     * @test
     */
    public function it_can_access_daily_sales_report_route()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act
        $response = $this->get(route('statistic.sales.days'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('statistic.sales.days');
        $response->assertSee('Báo cáo thống kê', false);
        $response->assertSee('Số đơn hàng', false);
        $response->assertSee('Doanh thu', false);
    }

    /**
     * Test truy cập route báo cáo bán hàng theo tháng
     * 
     * @test
     */
    public function it_can_access_monthly_sales_report_route()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act
        $response = $this->get(route('statistic.sales.months'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('statistic.sales.months');
        $response->assertSee('Báo cáo thống kê', false);
        $response->assertSee('Doanh thu từng tháng', false);
    }

    /**
     * Test truy cập route báo cáo bán hàng theo năm
     * 
     * @test
     */
    public function it_can_access_yearly_sales_report_route()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act
        $response = $this->get(route('statistic.sales.years'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('statistic.sales.years');
        $response->assertSee('Báo cáo thống kê', false);
    }

    /**
     * Test truy cập route báo cáo kho hàng theo tháng
     * 
     * @test
     */
    public function it_can_access_monthly_inventory_report_route()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act
        $response = $this->get(route('statistic.inventory.months'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('statistic.inventory.months');
        $response->assertSee('Báo cáo thống kê', false);
        $response->assertSee('Đơn hàng gần đây', false);
    }

    /**
     * Test truy cập route báo cáo kho hàng theo năm
     * 
     * @test
     */
    public function it_can_access_yearly_inventory_report_route()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act
        $response = $this->get(route('statistic.inventory.years'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('statistic.inventory.years');
        $response->assertSee('Báo cáo thống kê', false);
        $response->assertSee('Xuất báo cáo', false);
    }

    /**
     * Test truy cập route báo cáo khách hàng
     * 
     * @test
     */
    public function it_can_access_customer_report_route()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act
        $response = $this->get(route('statistic.customer'));

        // Assert
        $response->assertStatus(200);
        $response->assertViewIs('statistic.customer');
        $response->assertSee('Báo cáo thống kê', false);
    }

    /**
     * Test tất cả view routes có chứa các element UI cơ bản
     * 
     * @test
     */
    public function it_ensures_all_statistic_views_contain_basic_ui_elements()
    {
        // Arrange
        $this->actingAs($this->user);
        
        $routes = [
            'statistic.sales.days',
            'statistic.sales.months', 
            'statistic.sales.years',
            'statistic.inventory.months',
            'statistic.inventory.years',
            'statistic.customer'
        ];

        foreach ($routes as $routeName) {
            // Act
            $response = $this->get(route($routeName));

            // Assert - Kiểm tra các element UI chung
            $response->assertStatus(200);
            $response->assertSee('Báo cáo thống kê', false);
            $response->assertSee('Tìm kiếm', false);
            
            // Kiểm tra có CSS và JS cơ bản
            $response->assertSee('Font Awesome', false);
            $response->assertSee('Inter', false);
        }
    }

    /**
     * Test middleware authentication cho các route
     * 
     * @test
     */
    public function it_requires_authentication_for_statistic_routes()
    {
        // Arrange - Không đăng nhập

        $protectedRoutes = [
            'statistic.sales',
            'statistic.sales.days',
            'statistic.sales.months', 
            'statistic.sales.years',
            'statistic.inventory.months',
            'statistic.inventory.years',
            'statistic.customer'
        ];

        foreach ($protectedRoutes as $routeName) {
            // Act - Truy cập route khi chưa đăng nhập
            $response = $this->get(route($routeName));

            // Assert - Redirect đến login
            $response->assertRedirect('/login');
        }
    }

    /**
     * Test view có đúng layout
     * 
     * @test
     */
    public function it_uses_correct_layout_for_statistic_views()
    {
        // Arrange
        $this->actingAs($this->user, 'employee');

        // Act
        $response = $this->get(route('statistic.sales.days'));

        // Assert - Kiểm tra extend layout chính
        $response->assertSee('@extends(\'layouts.app\')');
        $response->assertSee('layouts.app');
    }

    /**
     * Test responsive design elements trong view
     * 
     * @test
     */
    public function it_contains_responsive_design_elements()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act  
        $response = $this->get(route('statistic.sales.days'));

        // Assert - Kiểm tra có các class CSS responsive
        $response->assertSee('summary-cards', false);
        $response->assertSee('main-content', false);
        $response->assertSee('charts-section', false);
        $response->assertSee('table-section', false);
    }

    /**
     * Test chart JavaScript libraries được load
     * 
     * @test
     */
    public function it_loads_required_javascript_libraries()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act
        $response = $this->get(route('statistic.sales.days'));

        // Assert - Kiểm tra Chart.js được load
        $response->assertSee('chart.js', false);
        $response->assertSee('Chart(', false);
    }

    /**
     * Test export modal functionality
     * 
     * @test
     */
    public function it_contains_export_modal_functionality()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act
        $response = $this->get(route('statistic.inventory.months'));

        // Assert - Kiểm tra modal export
        $response->assertSee('reportModal', false);
        $response->assertSee('Xuất báo cáo', false);
        $response->assertSee('openReportModal', false);
        $response->assertSee('closeReportModal');
    }

    /**
     * Test dropdown time filter functionality
     * 
     * @test
     */
    public function it_contains_time_filter_dropdown()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act
        $response = $this->get(route('statistic.sales.months'));

        // Assert - Kiểm tra dropdown thời gian
        $response->assertSee('dropdownToggle', false);
        $response->assertSee('dropdownMenu', false);
        $response->assertSee('Thời gian', false);
    }

    /**
     * Test navigation links between different report types
     * 
     * @test
     */
    public function it_contains_navigation_links_between_reports()
    {
        // Arrange
        $this->actingAs($this->user);

        // Act
        $response = $this->get(route('statistic.sales.months'));

        // Assert - Kiểm tra navigation links
        $response->assertSee(route('statistic.sales.days'), false);
        $response->assertSee(route('statistic.sales.months'), false);
        $response->assertSee(route('statistic.sales.years'), false);
        $response->assertSee('Theo ngày', false);
        $response->assertSee('Theo tháng', false);
        $response->assertSee('Theo năm', false);
    }
}