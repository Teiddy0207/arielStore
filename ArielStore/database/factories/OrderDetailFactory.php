<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\ProductType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OrderDetail>
 */
class OrderDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $quantity = $this->faker->numberBetween(1, 5);
        $price = $this->faker->numberBetween(100000, 800000);
        
        return [
            'order_id' => Order::factory(),
            'product_name' => $this->faker->words(3, true),
            'quantity' => $quantity,
            'price' => $price,
            'total_price' => $quantity * $price,
            'product_type_id' => ProductType::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Set specific order for this detail.
     */
    public function forOrder($orderId)
    {
        return $this->state(fn (array $attributes) => [
            'order_id' => $orderId,
        ]);
    }

    /**
     * Set specific product type for this detail.
     */
    public function forProductType($productTypeId)
    {
        return $this->state(fn (array $attributes) => [
            'product_type_id' => $productTypeId,
        ]);
    }
}