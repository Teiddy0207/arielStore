<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->words(3, true),
            'import_price' => $this->faker->numberBetween(50000, 500000),
            'price' => $this->faker->numberBetween(100000, 800000),
            'material' => $this->faker->randomElement(['Cotton', 'Polyester', 'Silk', 'Wool', 'Linen']),
            'sale' => $this->faker->numberBetween(0, 50),
            'description' => $this->faker->sentence(),
            'quantity' => $this->faker->numberBetween(1, 100),
            'size' => $this->faker->randomElement(['S', 'M', 'L', 'XL', 'XXL']),
            'status' => $this->faker->randomElement(['Đang bán', 'Hết hàng', 'Ngừng bán']),
            'product_type_id' => \App\Models\ProductType::factory(),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
