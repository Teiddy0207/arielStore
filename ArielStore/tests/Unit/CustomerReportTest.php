<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class CustomerReportTest extends TestCase
{
    /**
     * Test tính toán top khách hàng mua hàng
     */
    public function test_calculate_top_customers()
    {
        $orders = [
            ['customer_id' => 1, 'customer_name' => 'Nguyễn Văn A', 'total_amount' => 5000000],
            ['customer_id' => 2, 'customer_name' => 'Trần Thị B', 'total_amount' => 3000000],
            ['customer_id' => 1, 'customer_name' => 'Nguyễn Văn A', 'total_amount' => 2000000],
            ['customer_id' => 3, 'customer_name' => 'Lê Văn C', 'total_amount' => 4000000],
        ];
        
        $result = $this->calculateTopCustomers($orders, 3);
        
        $this->assertCount(3, $result);
        $this->assertEquals('Nguyễn Văn A', $result[0]['customer_name']);
        $this->assertEquals(7000000, $result[0]['total_amount']);
        $this->assertEquals(2, $result[0]['order_count']);
    }

    /**
     * Test tính toán tỷ lệ khách hàng nam/nữ
     */
    public function test_calculate_gender_ratio()
    {
        $customers = [
            ['gender' => 'Nam', 'total_amount' => 10000000],
            ['gender' => 'Nữ', 'total_amount' => 8000000],
            ['gender' => 'Nam', 'total_amount' => 5000000],
            ['gender' => 'Nữ', 'total_amount' => 3000000],
        ];
        
        $result = $this->calculateGenderRatio($customers);
        
        $this->assertEquals(15000000, $result['male_total']);
        $this->assertEquals(11000000, $result['female_total']);
        $this->assertEquals(57.69, round($result['male_percentage'], 2));
        $this->assertEquals(42.31, round($result['female_percentage'], 2));
    }

    /**
     * Test tính toán tỷ lệ mua lại
     */
    public function test_calculate_repurchase_ratio()
    {
        $customers = [
            ['customer_id' => 1, 'order_count' => 3],
            ['customer_id' => 2, 'order_count' => 1],
            ['customer_id' => 3, 'order_count' => 5],
            ['customer_id' => 4, 'order_count' => 1],
            ['customer_id' => 5, 'order_count' => 2],
        ];
        
        $result = $this->calculateRepurchaseRatio($customers);
        
        $this->assertEquals(5, $result['total_customers']);
        $this->assertEquals(3, $result['repurchase_customers']);
        $this->assertEquals(60, $result['repurchase_percentage']);
    }

    /**
     * Test tính toán với dữ liệu rỗng
     */
    public function test_calculate_with_empty_data()
    {
        $topCustomers = $this->calculateTopCustomers([], 5);
        $genderRatio = $this->calculateGenderRatio([]);
        $repurchaseRatio = $this->calculateRepurchaseRatio([]);
        
        $this->assertEmpty($topCustomers);
        $this->assertEquals(0, $genderRatio['male_total']);
        $this->assertEquals(0, $repurchaseRatio['repurchase_percentage']);
    }

    /**
     * Test tính toán với giới tính không hợp lệ
     */
    public function test_calculate_gender_ratio_invalid_gender()
    {
        $customers = [
            ['gender' => 'Nam', 'total_amount' => 1000000],
            ['gender' => 'Khác', 'total_amount' => 500000],
            ['gender' => '', 'total_amount' => 200000],
        ];
        
        $result = $this->calculateGenderRatio($customers);
        
        $this->assertEquals(1000000, $result['male_total']);
        $this->assertEquals(0, $result['female_total']);
        $this->assertEquals(100, $result['male_percentage']);
    }

    /**
     * Helper method tính top khách hàng
     */
    private function calculateTopCustomers($orders, $limit)
    {
        $customerTotals = [];
        
        foreach ($orders as $order) {
            $customerId = $order['customer_id'];
            if (!isset($customerTotals[$customerId])) {
                $customerTotals[$customerId] = [
                    'customer_id' => $customerId,
                    'customer_name' => $order['customer_name'],
                    'total_amount' => 0,
                    'order_count' => 0
                ];
            }
            $customerTotals[$customerId]['total_amount'] += $order['total_amount'];
            $customerTotals[$customerId]['order_count']++;
        }
        
        usort($customerTotals, function($a, $b) {
            return $b['total_amount'] <=> $a['total_amount'];
        });
        
        return array_slice($customerTotals, 0, $limit);
    }

    /**
     * Helper method tính tỷ lệ giới tính
     */
    private function calculateGenderRatio($customers)
    {
        $maleTotal = 0;
        $femaleTotal = 0;
        
        foreach ($customers as $customer) {
            if ($customer['gender'] === 'Nam') {
                $maleTotal += $customer['total_amount'];
            } elseif ($customer['gender'] === 'Nữ') {
                $femaleTotal += $customer['total_amount'];
            }
        }
        
        $total = $maleTotal + $femaleTotal;
        $malePercentage = $total > 0 ? ($maleTotal / $total) * 100 : 0;
        $femalePercentage = $total > 0 ? ($femaleTotal / $total) * 100 : 0;
        
        return [
            'male_total' => $maleTotal,
            'female_total' => $femaleTotal,
            'male_percentage' => $malePercentage,
            'female_percentage' => $femalePercentage
        ];
    }

    /**
     * Helper method tính tỷ lệ mua lại
     */
    private function calculateRepurchaseRatio($customers)
    {
        $totalCustomers = count($customers);
        $repurchaseCustomers = 0;
        
        foreach ($customers as $customer) {
            if ($customer['order_count'] > 1) {
                $repurchaseCustomers++;
            }
        }
        
        $repurchasePercentage = $totalCustomers > 0 ? ($repurchaseCustomers / $totalCustomers) * 100 : 0;
        
        return [
            'total_customers' => $totalCustomers,
            'repurchase_customers' => $repurchaseCustomers,
            'repurchase_percentage' => $repurchasePercentage
        ];
    }
}

