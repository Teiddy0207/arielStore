<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use Illuminate\Support\Facades\DB;

class InventoryReportTest extends TestCase
{
    /**
     * Test tính toán tỷ lệ nhập vào và bán ra
     */
    public function test_calculate_inventory_ratio()
    {
        $importData = [
            ['product_id' => 1, 'quantity' => 100, 'date' => '2023-01-01'],
            ['product_id' => 2, 'quantity' => 50, 'date' => '2023-01-01'],
        ];
        
        $salesData = [
            ['product_id' => 1, 'quantity' => 80, 'date' => '2023-01-01'],
            ['product_id' => 2, 'quantity' => 30, 'date' => '2023-01-01'],
        ];
        
        $result = $this->calculateInventoryRatio($importData, $salesData);
        
        $this->assertEquals(150, $result['total_import']);
        $this->assertEquals(110, $result['total_sales']);
        $this->assertEquals(73.33, round($result['sales_ratio'], 2));
    }

    /**
     * Test tính toán tỷ lệ với dữ liệu rỗng
     */
    public function test_calculate_inventory_ratio_empty_data()
    {
        $result = $this->calculateInventoryRatio([], []);
        
        $this->assertEquals(0, $result['total_import']);
        $this->assertEquals(0, $result['total_sales']);
        $this->assertEquals(0, $result['sales_ratio']);
    }

    /**
     * Test tính toán tỷ lệ với số lượng âm
     */
    public function test_calculate_inventory_ratio_negative_quantities()
    {
        $importData = [
            ['product_id' => 1, 'quantity' => -10, 'date' => '2023-01-01'],
        ];
        
        $salesData = [
            ['product_id' => 1, 'quantity' => 5, 'date' => '2023-01-01'],
        ];
        
        $result = $this->calculateInventoryRatio($importData, $salesData);
        
        $this->assertEquals(0, $result['total_import']); // Số âm được xử lý thành 0
        $this->assertEquals(5, $result['total_sales']);
    }

    /**
     * Test tính toán tỷ lệ với chia cho 0
     */
    public function test_calculate_inventory_ratio_division_by_zero()
    {
        $importData = [];
        $salesData = [
            ['product_id' => 1, 'quantity' => 10, 'date' => '2023-01-01'],
        ];
        
        $result = $this->calculateInventoryRatio($importData, $salesData);
        
        $this->assertEquals(0, $result['total_import']);
        $this->assertEquals(10, $result['total_sales']);
        $this->assertEquals(0, $result['sales_ratio']); // Không chia cho 0
    }

    /**
     * Test tính toán tỷ lệ với dữ liệu lớn
     */
    public function test_calculate_inventory_ratio_large_data()
    {
        $importData = [];
        $salesData = [];
        
        for ($i = 1; $i <= 1000; $i++) {
            $importData[] = ['product_id' => $i, 'quantity' => 100, 'date' => '2023-01-01'];
            $salesData[] = ['product_id' => $i, 'quantity' => 75, 'date' => '2023-01-01'];
        }
        
        $result = $this->calculateInventoryRatio($importData, $salesData);
        
        $this->assertEquals(100000, $result['total_import']);
        $this->assertEquals(75000, $result['total_sales']);
        $this->assertEquals(75, $result['sales_ratio']);
    }

    /**
     * Helper method để tính toán tỷ lệ kho hàng
     */
    private function calculateInventoryRatio($importData, $salesData)
    {
        $totalImport = 0;
        $totalSales = 0;
        
        foreach ($importData as $item) {
            $quantity = max(0, $item['quantity']); // Xử lý số âm
            $totalImport += $quantity;
        }
        
        foreach ($salesData as $item) {
            $totalSales += $item['quantity'];
        }
        
        $salesRatio = $totalImport > 0 ? ($totalSales / $totalImport) * 100 : 0;
        
        return [
            'total_import' => $totalImport,
            'total_sales' => $totalSales,
            'sales_ratio' => $salesRatio
        ];
    }
}
