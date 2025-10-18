<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

class StatisticCalculationTest extends TestCase
{
    // ----------- Helper functions for sales calculation -----------
    private function calculateDailySales(array $orders): array
    {
        $result = [];
        foreach ($orders as $order) {
            $date = date('Y-m-d', strtotime($order['created_at']));
            if (!isset($result[$date])) {
                $result[$date] = 0;
            }
            $result[$date] += $order['total_amount'];
        }
        
        $formatted = [];
        foreach ($result as $date => $total) {
            $formatted[] = [
                'date' => $date,
                'total_sales' => $total
            ];
        }
        
        return $formatted;
    }

    private function calculateMonthlySales(array $orders): array
    {
        $result = [];
        foreach ($orders as $order) {
            $month = date('Y-m', strtotime($order['created_at']));
            if (!isset($result[$month])) {
                $result[$month] = 0;
            }
            $result[$month] += $order['total_amount'];
        }
        
        $formatted = [];
        foreach ($result as $month => $total) {
            $formatted[] = [
                'month' => $month,
                'total_sales' => $total
            ];
        }
        
        return $formatted;
    }

    private function calculateYearlySales(array $orders): array
    {
        $result = [];
        foreach ($orders as $order) {
            $year = date('Y', strtotime($order['created_at']));
            if (!isset($result[$year])) {
                $result[$year] = 0;
            }
            $result[$year] += $order['total_amount'];
        }
        
        $formatted = [];
        foreach ($result as $year => $total) {
            $formatted[] = [
                'year' => $year,
                'total_sales' => $total
            ];
        }
        
        return $formatted;
    }

    private function calculateProductTypeRatio(array $orderDetails): array
    {
        $typeCounts = [];
        $total = 0;
        
        foreach ($orderDetails as $detail) {
            $typeId = $detail['product_type_id'];
            $typeName = $detail['type_name'];
            $items = $detail['items'];
            
            if (!isset($typeCounts[$typeId])) {
                $typeCounts[$typeId] = [
                    'type_id' => $typeId,
                    'type_name' => $typeName,
                    'items' => 0
                ];
            }
            $typeCounts[$typeId]['items'] += $items;
            $total += $items;
        }
        
        $total = max(1, $total); // Avoid division by zero
        
        $result = [];
        foreach ($typeCounts as $type) {
            $result[] = [
                'type_id' => (int) $type['type_id'],
                'type_name' => $type['type_name'],
                'items' => (int) $type['items'],
                'ratio' => round($type['items'] / $total, 4),
                'percent' => round($type['items'] * 100 / $total)
            ];
        }
        
        return $result;
    }

    // ----------- Test cases for Daily Sales -----------
    #[Test]
    #[Group('daily_sales')]
    public function test_daily_sales_single_order()
    {
        $orders = [
            ['total_amount' => 100000, 'created_at' => '2024-01-15 10:30:00']
        ];
        
        $result = $this->calculateDailySales($orders);
        
        $this->assertCount(1, $result);
        $this->assertEquals('2024-01-15', $result[0]['date']);
        $this->assertEquals(100000, $result[0]['total_sales']);
    }

    #[Test]
    #[Group('daily_sales')]
    public function test_daily_sales_multiple_orders_same_day()
    {
        $orders = [
            ['total_amount' => 100000, 'created_at' => '2024-01-15 10:30:00'],
            ['total_amount' => 200000, 'created_at' => '2024-01-15 14:20:00'],
            ['total_amount' => 50000, 'created_at' => '2024-01-15 18:45:00']
        ];
        
        $result = $this->calculateDailySales($orders);
        
        $this->assertCount(1, $result);
        $this->assertEquals('2024-01-15', $result[0]['date']);
        $this->assertEquals(350000, $result[0]['total_sales']);
    }

    #[Test]
    #[Group('daily_sales')]
    public function test_daily_sales_multiple_days()
    {
        $orders = [
            ['total_amount' => 100000, 'created_at' => '2024-01-15 10:30:00'],
            ['total_amount' => 200000, 'created_at' => '2024-01-16 14:20:00'],
            ['total_amount' => 50000, 'created_at' => '2024-01-17 18:45:00']
        ];
        
        $result = $this->calculateDailySales($orders);
        
        $this->assertCount(3, $result);
        $this->assertEquals(100000, $result[0]['total_sales']);
        $this->assertEquals(200000, $result[1]['total_sales']);
        $this->assertEquals(50000, $result[2]['total_sales']);
    }

    #[Test]
    #[Group('daily_sales')]
    public function test_daily_sales_empty_orders()
    {
        $orders = [];
        
        $result = $this->calculateDailySales($orders);
        
        $this->assertCount(0, $result);
    }

    // ----------- Test cases for Monthly Sales -----------
    #[Test]
    #[Group('monthly_sales')]
    public function test_monthly_sales_single_month()
    {
        $orders = [
            ['total_amount' => 100000, 'created_at' => '2024-01-15 10:30:00'],
            ['total_amount' => 200000, 'created_at' => '2024-01-20 14:20:00']
        ];
        
        $result = $this->calculateMonthlySales($orders);
        
        $this->assertCount(1, $result);
        $this->assertEquals('2024-01', $result[0]['month']);
        $this->assertEquals(300000, $result[0]['total_sales']);
    }

    #[Test]
    #[Group('monthly_sales')]
    public function test_monthly_sales_multiple_months()
    {
        $orders = [
            ['total_amount' => 100000, 'created_at' => '2024-01-15 10:30:00'],
            ['total_amount' => 200000, 'created_at' => '2024-02-20 14:20:00'],
            ['total_amount' => 150000, 'created_at' => '2024-03-10 18:45:00']
        ];
        
        $result = $this->calculateMonthlySales($orders);
        
        $this->assertCount(3, $result);
        $this->assertEquals(100000, $result[0]['total_sales']);
        $this->assertEquals(200000, $result[1]['total_sales']);
        $this->assertEquals(150000, $result[2]['total_sales']);
    }

    // ----------- Test cases for Yearly Sales -----------
    #[Test]
    #[Group('yearly_sales')]
    public function test_yearly_sales_single_year()
    {
        $orders = [
            ['total_amount' => 100000, 'created_at' => '2024-01-15 10:30:00'],
            ['total_amount' => 200000, 'created_at' => '2024-06-20 14:20:00'],
            ['total_amount' => 150000, 'created_at' => '2024-12-10 18:45:00']
        ];
        
        $result = $this->calculateYearlySales($orders);
        
        $this->assertCount(1, $result);
        $this->assertEquals('2024', $result[0]['year']);
        $this->assertEquals(450000, $result[0]['total_sales']);
    }

    #[Test]
    #[Group('yearly_sales')]
    public function test_yearly_sales_multiple_years()
    {
        $orders = [
            ['total_amount' => 100000, 'created_at' => '2023-01-15 10:30:00'],
            ['total_amount' => 200000, 'created_at' => '2024-06-20 14:20:00'],
            ['total_amount' => 150000, 'created_at' => '2024-12-10 18:45:00']
        ];
        
        $result = $this->calculateYearlySales($orders);
        
        $this->assertCount(2, $result);
        $this->assertEquals(100000, $result[0]['total_sales']);
        $this->assertEquals(350000, $result[1]['total_sales']);
    }

    // ----------- Test cases for Product Type Ratio -----------
    #[Test]
    #[Group('product_ratio')]
    public function test_product_type_ratio_single_type()
    {
        $orderDetails = [
            ['product_type_id' => 1, 'type_name' => 'Áo', 'items' => 10]
        ];
        
        $result = $this->calculateProductTypeRatio($orderDetails);
        
        $this->assertCount(1, $result);
        $this->assertEquals(1, $result[0]['type_id']);
        $this->assertEquals('Áo', $result[0]['type_name']);
        $this->assertEquals(10, $result[0]['items']);
        $this->assertEquals(1.0, $result[0]['ratio']);
        $this->assertEquals(100, $result[0]['percent']);
    }

    #[Test]
    #[Group('product_ratio')]
    public function test_product_type_ratio_multiple_types()
    {
        $orderDetails = [
            ['product_type_id' => 1, 'type_name' => 'Áo', 'items' => 30],
            ['product_type_id' => 2, 'type_name' => 'Quần', 'items' => 20],
            ['product_type_id' => 3, 'type_name' => 'Phụ kiện', 'items' => 10]
        ];
        
        $result = $this->calculateProductTypeRatio($orderDetails);
        
        $this->assertCount(3, $result);
        
        // Áo: 30/60 = 50%
        $this->assertEquals(1, $result[0]['type_id']);
        $this->assertEquals(30, $result[0]['items']);
        $this->assertEquals(0.5, $result[0]['ratio']);
        $this->assertEquals(50, $result[0]['percent']);
        
        // Quần: 20/60 = 33.33%
        $this->assertEquals(2, $result[1]['type_id']);
        $this->assertEquals(20, $result[1]['items']);
        $this->assertEquals(0.3333, $result[1]['ratio']);
        $this->assertEquals(33, $result[1]['percent']);
        
        // Phụ kiện: 10/60 = 16.67%
        $this->assertEquals(3, $result[2]['type_id']);
        $this->assertEquals(10, $result[2]['items']);
        $this->assertEquals(0.1667, $result[2]['ratio']);
        $this->assertEquals(17, $result[2]['percent']);
    }

    #[Test]
    #[Group('product_ratio')]
    public function test_product_type_ratio_empty_details()
    {
        $orderDetails = [];
        
        $result = $this->calculateProductTypeRatio($orderDetails);
        
        $this->assertCount(0, $result);
    }

    #[Test]
    #[Group('product_ratio')]
    public function test_product_type_ratio_zero_items()
    {
        $orderDetails = [
            ['product_type_id' => 1, 'type_name' => 'Áo', 'items' => 0]
        ];
        
        $result = $this->calculateProductTypeRatio($orderDetails);
        
        $this->assertCount(1, $result);
        $this->assertEquals(0, $result[0]['items']);
        $this->assertEquals(0.0, $result[0]['ratio']);
        $this->assertEquals(0, $result[0]['percent']);
    }

    // ----------- Test case for all valid calculations -----------
    #[Test]
    #[Group('all')]
    public function test_all_calculations_with_complex_data()
    {
        $orders = [
            ['total_amount' => 100000, 'created_at' => '2024-01-15 10:30:00'],
            ['total_amount' => 200000, 'created_at' => '2024-01-15 14:20:00'],
            ['total_amount' => 150000, 'created_at' => '2024-02-20 18:45:00'],
            ['total_amount' => 300000, 'created_at' => '2024-03-10 12:00:00']
        ];

        $orderDetails = [
            ['product_type_id' => 1, 'type_name' => 'Áo', 'items' => 25],
            ['product_type_id' => 2, 'type_name' => 'Quần', 'items' => 15],
            ['product_type_id' => 3, 'type_name' => 'Phụ kiện', 'items' => 10]
        ];

        // Test daily sales
        $dailyResult = $this->calculateDailySales($orders);
        $this->assertCount(3, $dailyResult);
        $this->assertEquals(300000, $dailyResult[0]['total_sales']); // Jan 15

        // Test monthly sales
        $monthlyResult = $this->calculateMonthlySales($orders);
        $this->assertCount(3, $monthlyResult);
        $this->assertEquals(300000, $monthlyResult[0]['total_sales']); // Jan

        // Test yearly sales
        $yearlyResult = $this->calculateYearlySales($orders);
        $this->assertCount(1, $yearlyResult);
        $this->assertEquals(750000, $yearlyResult[0]['total_sales']); // 2024

        // Test product ratio
        $ratioResult = $this->calculateProductTypeRatio($orderDetails);
        $this->assertCount(3, $ratioResult);
        $this->assertEquals(25, $ratioResult[0]['items']); // Áo: 25 items
    }
}
