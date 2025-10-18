<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;

class ReportExportTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test export báo cáo bán hàng PDF
     */
    public function test_export_sales_report_pdf()
    {
        // Tạo dữ liệu test
        DB::table('orders')->insert([
            ['id' => 1, 'customer_name' => 'Nguyễn Văn A', 'total_amount' => 1000000, 'status' => 4, 'created_at' => '2023-01-01 10:00:00'],
            ['id' => 2, 'customer_name' => 'Trần Thị B', 'total_amount' => 2000000, 'status' => 4, 'created_at' => '2023-01-02 11:00:00'],
        ]);

        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/export-sales-report', [
                'format' => 'pdf',
                'start_date' => '2023-01-01',
                'end_date' => '2023-01-31'
            ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/pdf');
    }

    /**
     * Test export báo cáo bán hàng Excel
     */
    public function test_export_sales_report_excel()
    {
        DB::table('orders')->insert([
            ['id' => 1, 'customer_name' => 'Nguyễn Văn A', 'total_amount' => 1000000, 'status' => 4, 'created_at' => '2023-01-01 10:00:00'],
        ]);

        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/export-sales-report', [
                'format' => 'excel',
                'start_date' => '2023-01-01',
                'end_date' => '2023-01-31'
            ]);

        $response->assertStatus(200);
        $response->assertHeader('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    }

    /**
     * Test export báo cáo khách hàng
     */
    public function test_export_customer_report()
    {
        DB::table('orders')->insert([
            ['id' => 1, 'customer_name' => 'Nguyễn Văn A', 'total_amount' => 1000000, 'status' => 4, 'created_at' => '2023-01-01 10:00:00'],
            ['id' => 2, 'customer_name' => 'Nguyễn Văn A', 'total_amount' => 2000000, 'status' => 4, 'created_at' => '2023-01-02 11:00:00'],
        ]);

        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/export-customer-report', [
                'format' => 'pdf',
                'start_date' => '2023-01-01',
                'end_date' => '2023-01-31'
            ]);

        $response->assertStatus(200);
    }

    /**
     * Test export báo cáo kho hàng
     */
    public function test_export_inventory_report()
    {
        DB::table('products')->insert([
            ['id' => 1, 'name' => 'Áo thun', 'price' => 200000, 'import_price' => 150000, 'quantity' => 100, 'created_at' => '2023-01-01 10:00:00'],
            ['id' => 2, 'name' => 'Quần jean', 'price' => 500000, 'import_price' => 350000, 'quantity' => 50, 'created_at' => '2023-01-01 10:00:00'],
        ]);

        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/export-inventory-report', [
                'format' => 'excel',
                'month' => '2023-01',
                'year' => '2023'
            ]);

        $response->assertStatus(200);
    }

    /**
     * Test export với định dạng không hợp lệ
     */
    public function test_export_invalid_format()
    {
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/export-sales-report', [
                'format' => 'invalid',
                'start_date' => '2023-01-01',
                'end_date' => '2023-01-31'
            ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Invalid export format']);
    }

    /**
     * Test export với dữ liệu rỗng
     */
    public function test_export_empty_data()
    {
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/export-sales-report', [
                'format' => 'pdf',
                'start_date' => '2023-01-01',
                'end_date' => '2023-01-31'
            ]);

        $response->assertStatus(200);
        $response->assertJson(['message' => 'No data to export']);
    }

    /**
     * Test export với ngày không hợp lệ
     */
    public function test_export_invalid_date_range()
    {
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/export-sales-report', [
                'format' => 'pdf',
                'start_date' => '2023-01-31',
                'end_date' => '2023-01-01' // Ngày kết thúc trước ngày bắt đầu
            ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Invalid date range']);
    }

    /**
     * Test export không có quyền truy cập
     */
    public function test_export_without_permission()
    {
        $response = $this->postJson('/api/export-sales-report', [
            'format' => 'pdf',
            'start_date' => '2023-01-01',
            'end_date' => '2023-01-31'
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test export với dữ liệu lớn
     */
    public function test_export_large_data()
    {
        // Tạo 1000 đơn hàng
        $orders = [];
        for ($i = 1; $i <= 1000; $i++) {
            $orders[] = [
                'id' => $i,
                'customer_name' => "Khách hàng {$i}",
                'total_amount' => rand(100000, 5000000),
                'status' => 4,
                'created_at' => '2023-01-01 10:00:00'
            ];
        }
        
        DB::table('orders')->insert($orders);

        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/export-sales-report', [
                'format' => 'excel',
                'start_date' => '2023-01-01',
                'end_date' => '2023-01-31'
            ]);

        $response->assertStatus(200);
    }

    /**
     * Test export với tham số thiếu
     */
    public function test_export_missing_parameters()
    {
        $response = $this->withoutMiddleware(\App\Http\Middleware\CheckEmployeeAuth::class)
            ->postJson('/api/export-sales-report', [
                'format' => 'pdf'
                // Thiếu start_date và end_date
            ]);

        $response->assertStatus(400);
        $response->assertJson(['error' => 'Missing required parameters']);
    }
}
