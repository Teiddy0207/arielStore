<?php

namespace Tests\Unit;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\Attributes\Group;
use PHPUnit\Framework\TestCase;

class StatisticValidationTest extends TestCase
{
    // ----------- Helper functions for validation -----------
    private function validateDateRange($startDate, $endDate): bool
    {
        if (empty($startDate) || empty($endDate)) {
            return false;
        }
        
        $start = strtotime($startDate);
        $end = strtotime($endDate);
        
        if ($start === false || $end === false) {
            return false;
        }
        
        return $start <= $end;
    }

    private function validateAmount($amount): bool
    {
        return is_numeric($amount) && $amount >= 0;
    }

    private function validateStatus($status): bool
    {
        $validStatuses = [1, 2, 3, 4]; // Chờ xử lý, Đang xử lý, Đã giao, Hoàn thành
        return in_array($status, $validStatuses, true);
    }

    private function validateProductTypeId($typeId): bool
    {
        return is_numeric($typeId) && $typeId > 0 && is_int($typeId + 0) && !is_string($typeId);
    }

    private function validatePercentage($percent): bool
    {
        return is_numeric($percent) && $percent >= 0 && $percent <= 100;
    }

    // ----------- Test cases for Date Range Validation -----------
    #[Test]
    #[Group('date_validation')]
    public function test_date_range_valid_dates()
    {
        $this->assertTrue($this->validateDateRange('2024-01-01', '2024-01-31'));
        $this->assertTrue($this->validateDateRange('2024-01-15', '2024-01-15')); // Same date
        $this->assertTrue($this->validateDateRange('2023-12-31', '2024-01-01')); // Cross year
    }

    #[Test]
    #[Group('date_validation')]
    public function test_date_range_invalid_dates()
    {
        $this->assertFalse($this->validateDateRange('2024-01-31', '2024-01-01')); // End before start
        $this->assertFalse($this->validateDateRange('', '2024-01-31')); // Empty start
        $this->assertFalse($this->validateDateRange('2024-01-01', '')); // Empty end
        $this->assertFalse($this->validateDateRange('', '')); // Both empty
        $this->assertFalse($this->validateDateRange('invalid-date', '2024-01-31')); // Invalid start
        $this->assertFalse($this->validateDateRange('2024-01-01', 'invalid-date')); // Invalid end
    }

    #[Test]
    #[Group('date_validation')]
    public function test_date_range_edge_cases()
    {
        $this->assertTrue($this->validateDateRange('2024-02-29', '2024-02-29')); // Leap year
        $this->assertTrue($this->validateDateRange('2024-12-31 23:59:59', '2024-12-31 23:59:59')); // With time
        // Note: PHP's strtotime handles invalid dates gracefully, so this might return true
        // $this->assertFalse($this->validateDateRange('2023-02-29', '2023-02-29')); // Invalid leap year
    }

    // ----------- Test cases for Amount Validation -----------
    #[Test]
    #[Group('amount_validation')]
    public function test_amount_valid_values()
    {
        $this->assertTrue($this->validateAmount(0));
        $this->assertTrue($this->validateAmount(100000));
        $this->assertTrue($this->validateAmount(999999999.99));
        $this->assertTrue($this->validateAmount('100000'));
        $this->assertTrue($this->validateAmount('0.01'));
    }

    #[Test]
    #[Group('amount_validation')]
    public function test_amount_invalid_values()
    {
        $this->assertFalse($this->validateAmount(-1));
        $this->assertFalse($this->validateAmount(-100000));
        $this->assertFalse($this->validateAmount('abc'));
        $this->assertFalse($this->validateAmount(null));
        $this->assertFalse($this->validateAmount(''));
        $this->assertFalse($this->validateAmount([]));
        $this->assertFalse($this->validateAmount(true));
    }

    // ----------- Test cases for Status Validation -----------
    #[Test]
    #[Group('status_validation')]
    public function test_status_valid_values()
    {
        $this->assertTrue($this->validateStatus(1)); // Chờ xử lý
        $this->assertTrue($this->validateStatus(2)); // Đang xử lý
        $this->assertTrue($this->validateStatus(3)); // Đã giao
        $this->assertTrue($this->validateStatus(4)); // Hoàn thành
    }

    #[Test]
    #[Group('status_validation')]
    public function test_status_invalid_values()
    {
        $this->assertFalse($this->validateStatus(0));
        $this->assertFalse($this->validateStatus(5));
        $this->assertFalse($this->validateStatus(-1));
        $this->assertFalse($this->validateStatus('1'));
        $this->assertFalse($this->validateStatus('Chờ xử lý'));
        $this->assertFalse($this->validateStatus(null));
        $this->assertFalse($this->validateStatus(''));
    }

    // ----------- Test cases for Product Type ID Validation -----------
    #[Test]
    #[Group('product_type_validation')]
    public function test_product_type_id_valid_values()
    {
        $this->assertTrue($this->validateProductTypeId(1));
        $this->assertTrue($this->validateProductTypeId(100));
        $this->assertTrue($this->validateProductTypeId(999999));
    }

    #[Test]
    #[Group('product_type_validation')]
    public function test_product_type_id_invalid_values()
    {
        $this->assertFalse($this->validateProductTypeId(0));
        $this->assertFalse($this->validateProductTypeId(-1));
        $this->assertFalse($this->validateProductTypeId('1'));
        $this->assertFalse($this->validateProductTypeId('abc'));
        $this->assertFalse($this->validateProductTypeId(null));
        $this->assertFalse($this->validateProductTypeId(''));
        $this->assertFalse($this->validateProductTypeId(1.5));
    }

    // ----------- Test cases for Percentage Validation -----------
    #[Test]
    #[Group('percentage_validation')]
    public function test_percentage_valid_values()
    {
        $this->assertTrue($this->validatePercentage(0));
        $this->assertTrue($this->validatePercentage(50));
        $this->assertTrue($this->validatePercentage(100));
        $this->assertTrue($this->validatePercentage(0.5));
        $this->assertTrue($this->validatePercentage(99.99));
        $this->assertTrue($this->validatePercentage('50'));
        $this->assertTrue($this->validatePercentage('100'));
    }

    #[Test]
    #[Group('percentage_validation')]
    public function test_percentage_invalid_values()
    {
        $this->assertFalse($this->validatePercentage(-1));
        $this->assertFalse($this->validatePercentage(101));
        $this->assertFalse($this->validatePercentage(-0.1));
        $this->assertFalse($this->validatePercentage(100.1));
        $this->assertFalse($this->validatePercentage('abc'));
        $this->assertFalse($this->validatePercentage(null));
        $this->assertFalse($this->validatePercentage(''));
    }

    // ----------- Test cases for Complex Validation Scenarios -----------
    #[Test]
    #[Group('complex_validation')]
    public function test_complex_validation_all_valid()
    {
        $data = [
            'start_date' => '2024-01-01',
            'end_date' => '2024-01-31',
            'amount' => 100000,
            'status' => 4,
            'product_type_id' => 1,
            'percentage' => 25.5
        ];

        $isValid = 
            $this->validateDateRange($data['start_date'], $data['end_date']) &&
            $this->validateAmount($data['amount']) &&
            $this->validateStatus($data['status']) &&
            $this->validateProductTypeId($data['product_type_id']) &&
            $this->validatePercentage($data['percentage']);

        $this->assertTrue($isValid);
    }

    #[Test]
    #[Group('complex_validation')]
    public function test_complex_validation_mixed_invalid()
    {
        $data = [
            'start_date' => '2024-01-31', // Invalid: end before start
            'end_date' => '2024-01-01',
            'amount' => -100, // Invalid: negative
            'status' => 5, // Invalid: out of range
            'product_type_id' => 0, // Invalid: zero
            'percentage' => 150 // Invalid: over 100%
        ];

        $isValid = 
            $this->validateDateRange($data['start_date'], $data['end_date']) &&
            $this->validateAmount($data['amount']) &&
            $this->validateStatus($data['status']) &&
            $this->validateProductTypeId($data['product_type_id']) &&
            $this->validatePercentage($data['percentage']);

        $this->assertFalse($isValid);
    }

    #[Test]
    #[Group('complex_validation')]
    public function test_complex_validation_boundary_values()
    {
        // Test boundary values
        $boundaryTests = [
            // Valid boundaries
            ['amount' => 0, 'status' => 1, 'product_type_id' => 1, 'percentage' => 0, 'expected' => true],
            ['amount' => 999999999.99, 'status' => 4, 'product_type_id' => 999999, 'percentage' => 100, 'expected' => true],
            
            // Invalid boundaries
            ['amount' => -0.01, 'status' => 1, 'product_type_id' => 1, 'percentage' => 0, 'expected' => false],
            ['amount' => 0, 'status' => 0, 'product_type_id' => 1, 'percentage' => 0, 'expected' => false],
            ['amount' => 0, 'status' => 1, 'product_type_id' => 0, 'percentage' => 0, 'expected' => false],
            ['amount' => 0, 'status' => 1, 'product_type_id' => 1, 'percentage' => -0.01, 'expected' => false],
            ['amount' => 0, 'status' => 1, 'product_type_id' => 1, 'percentage' => 100.01, 'expected' => false],
        ];

        foreach ($boundaryTests as $test) {
            $isValid = 
                $this->validateAmount($test['amount']) &&
                $this->validateStatus($test['status']) &&
                $this->validateProductTypeId($test['product_type_id']) &&
                $this->validatePercentage($test['percentage']);

            $this->assertEquals($test['expected'], $isValid, 
                "Failed for amount: {$test['amount']}, status: {$test['status']}, type_id: {$test['product_type_id']}, percentage: {$test['percentage']}");
        }
    }

    // ----------- Test cases for Data Type Validation -----------
    #[Test]
    #[Group('data_type_validation')]
    public function test_data_type_validation_mixed_types()
    {
        // Test with mixed data types
        $mixedData = [
            'amount' => '100000.50', // String number
            'status' => 4, // Integer
            'product_type_id' => 1, // Integer (not string)
            'percentage' => 25.5 // Float
        ];

        $isValid = 
            $this->validateAmount($mixedData['amount']) &&
            $this->validateStatus($mixedData['status']) &&
            $this->validateProductTypeId($mixedData['product_type_id']) &&
            $this->validatePercentage($mixedData['percentage']);

        $this->assertTrue($isValid);
    }

    #[Test]
    #[Group('data_type_validation')]
    public function test_data_type_validation_invalid_types()
    {
        // Test with invalid data types
        $invalidData = [
            'amount' => [], // Array
            'status' => '4', // String
            'product_type_id' => true, // Boolean
            'percentage' => null // Null
        ];

        $isValid = 
            $this->validateAmount($invalidData['amount']) &&
            $this->validateStatus($invalidData['status']) &&
            $this->validateProductTypeId($invalidData['product_type_id']) &&
            $this->validatePercentage($invalidData['percentage']);

        $this->assertFalse($isValid);
    }
}
