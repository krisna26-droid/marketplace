<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition(): array
    {
        return [
            'vendor_id' => null,
            'category_id' => null,
            'name' => $this->faker->words(3, true),
            'description' => $this->faker->sentence(),
            'price' => $this->faker->numberBetween(10000, 2000000),
            'stock' => $this->faker->numberBetween(0, 100),
            'image' => null,
        ];
    }
}
