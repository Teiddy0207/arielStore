<?php

namespace Tests\Unit;

use App\Http\Controllers\UserPageController;
use Tests\TestCase;

class UserPageDiscountTest extends TestCase
{
    private function callCalculateDiscount(bool $existingCustomer, float $subtotal): array
    {
        $controller = new UserPageController();
        $method = new \ReflectionMethod(UserPageController::class, 'calculateDiscount');
        $method->setAccessible(true);
        return $method->invoke($controller, $existingCustomer, $subtotal);
    }

    /** Khách mới, dưới 3 triệu: giảm 5% */
    public function test_new_customer_under_threshold_gets_5_percent()
    {
        $result = $this->callCalculateDiscount(false, 2000000);
        $this->assertEquals(5, $result['discount_percent']);
        $this->assertEquals(100000, $result['discount_amount']);
        $this->assertFalse($result['near_threshold']);
        $this->assertNull($result['message']);
    }

    /** Khách cũ, dưới 3 triệu: không giảm */
    public function test_existing_customer_under_threshold_gets_0_percent()
    {
        $result = $this->callCalculateDiscount(true, 2000000);
        $this->assertEquals(0, $result['discount_percent']);
        $this->assertEquals(0, $result['discount_amount']);
        $this->assertFalse($result['near_threshold']);
        $this->assertNull($result['message']);
    }

    /** Khách mới, trên hoặc bằng 3 triệu: giảm 15% */
    public function test_new_customer_at_or_above_threshold_gets_15_percent()
    {
        $result = $this->callCalculateDiscount(false, 3000000);
        $this->assertEquals(15, $result['discount_percent']);
        $this->assertEquals(450000, $result['discount_amount']);
        $this->assertFalse($result['near_threshold']);
        $this->assertNull($result['message']);
    }

    /** Khách cũ, trên hoặc bằng 3 triệu: giảm 10% */
    public function test_existing_customer_at_or_above_threshold_gets_10_percent()
    {
        $result = $this->callCalculateDiscount(true, 3000000);
        $this->assertEquals(10, $result['discount_percent']);
        $this->assertEquals(300000, $result['discount_amount']);
        $this->assertFalse($result['near_threshold']);
        $this->assertNull($result['message']);
    }

    /** Dưới ngưỡng nhưng gần 3 triệu: hiển thị thông báo gần đạt */
    public function test_near_threshold_message_shows_when_within_200k_below()
    {
        // Khách mới, 2.85 triệu: vẫn 5% và có thông báo gần đạt
        $resultNew = $this->callCalculateDiscount(false, 2850000);
        $this->assertEquals(5, $resultNew['discount_percent']);
        $this->assertEquals(142500, $resultNew['discount_amount']);
        $this->assertTrue($resultNew['near_threshold']);
        $this->assertEquals('Đơn hàng của bạn gần đạt 3.000.000 VND, sẽ được giảm giá 10% khi đạt mốc.', $resultNew['message']);

        // Khách cũ, 2.82 triệu: 0% và có thông báo gần đạt
        $resultOld = $this->callCalculateDiscount(true, 2820000);
        $this->assertEquals(0, $resultOld['discount_percent']);
        $this->assertEquals(0, $resultOld['discount_amount']);
        $this->assertTrue($resultOld['near_threshold']);
        $this->assertEquals('Đơn hàng của bạn gần đạt 3.000.000 VND, sẽ được giảm giá 10% khi đạt mốc.', $resultOld['message']);
    }
}