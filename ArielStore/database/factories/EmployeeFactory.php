<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => bcrypt('password'),
            'birthday' => $this->faker->date(),
            'address' => $this->faker->address(),
            'role' => $this->faker->randomElement(['Quản lý', 'Nhân viên', 'Thu ngân']),
            'is_active' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
