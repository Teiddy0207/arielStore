<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductType>
 */
class ProductTypeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type_name' => $this->faker->randomElement(['Quần', 'Áo', 'Váy', 'Phụ kiện']),
            'description' => $this->faker->randomElement([
                'Áo thun', 'Áo sơ mi', 'Áo khoác', 'Áo polo',
                'Quần jean', 'Quần kaki', 'Quần short', 'Quần tây',
                'Váy maxi', 'Váy ngắn', 'Váy công sở',
                'Túi xách', 'Giày dép', 'Phụ kiện thời trang'
            ]),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    /**
     * Indicate that the product type is for clothing.
     */
    public function clothing()
    {
        return $this->state(fn (array $attributes) => [
            'type_name' => $this->faker->randomElement(['Quần', 'Áo', 'Váy']),
            'description' => $this->faker->randomElement([
                'Áo thun', 'Áo sơ mi', 'Áo khoác',
                'Quần jean', 'Quần kaki', 'Váy maxi'
            ]),
        ]);
    }

    /**
     * Indicate that the product type is for accessories.
     */
    public function accessory()
    {
        return $this->state(fn (array $attributes) => [
            'type_name' => 'Phụ kiện',
            'description' => $this->faker->randomElement([
                'Túi xách', 'Giày dép', 'Mũ nón', 'Khăn quàng'
            ]),
        ]);
    }
}