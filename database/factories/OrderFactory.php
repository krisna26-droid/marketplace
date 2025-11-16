<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    public function definition(): array
    {
        return [
            'customer_id' => null,
            'total_price' => 0,
            'status' => 'completed',
            'payment_status' => 'paid',
            'payment_method' => 'transfer',
            'shipping_address' => $this->faker->address(),
        ];
    }
}
