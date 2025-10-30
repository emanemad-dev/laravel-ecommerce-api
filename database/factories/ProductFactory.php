<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'title' => [
                'en' => $this->faker->words(3, true),
                'ar' => 'منتج ' . $this->faker->numberBetween(1, 10000),
            ],
            'description' => [
                'en' => $this->faker->sentence(10),
                'ar' => 'وصف المنتج رقم ' . $this->faker->numberBetween(1, 10000),
            ],
            'price' => $this->faker->randomFloat(2, 10, 1000),
            'quantity' => $this->faker->numberBetween(1, 200),
        ];
    }
}
