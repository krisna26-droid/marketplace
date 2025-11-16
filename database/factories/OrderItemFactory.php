<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'order_id' => null,
            'product_id' => null,
            'quantity' => $this->faker->numberBetween(1, 3),
            'price' => null,
        ];
    }
}
