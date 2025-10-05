<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'customer_name' => $this->faker->name(),
            'customer_phone' => $this->faker->phoneNumber(),
            'customer_email' => $this->faker->safeEmail(),
            'customer_address' => $this->faker->address(),
            'total_amount' => $this->faker->numberBetween(100000, 2000000),
            'payment_method' => $this->faker->randomElement(['Tiền mặt', 'Chuyển khoản', 'Thẻ tín dụng']),
            'status' => $this->faker->randomElement([1, 2, 3, 4, 5]), // 1: Chờ xử lý, 2: Đang xử lý, 3: Đang giao, 4: Hoàn thành, 5: Hủy
            'notes' => $this->faker->optional()->sentence(),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the order is completed.
     */
    public function completed()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 4,
        ]);
    }

    /**
     * Indicate that the order is cancelled.
     */
    public function cancelled()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 5,
        ]);
    }

    /**
     * Indicate that the order is processing.
     */
    public function processing()
    {
        return $this->state(fn (array $attributes) => [
            'status' => 2,
        ]);
    }
}