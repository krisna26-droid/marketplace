<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Vendor;
use App\Models\Customer;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // 10 vendor
        $vendors = User::factory()->count(10)->create(['role' => 'vendor', 'is_vendor' => true, 'vendor_status' => 'approved']);
        Vendor::insert(
            $vendors->map(fn($v) => [
                'user_id' => $v->id,
                'created_at' => now(),
                'updated_at' => now()
            ])->toArray()
        );

        // 100 customer
        $customers = User::factory()->count(100)->create(['role' => 'customer']);
        Customer::insert(
            $customers->map(fn($c) => [
                'user_id' => $c->id,
                'address' => fake()->address(),
                'phone' => fake()->phoneNumber(),
                'city' => fake()->city(),
                'province' => fake()->state(),
                'postal_code' => fake()->postcode(),
                'created_at' => now(),
                'updated_at' => now(),
            ])->toArray()
        );
    }
}
