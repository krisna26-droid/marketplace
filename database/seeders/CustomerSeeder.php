<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'Customer Contoh',
            'email' => 'customer@example.com',
            'password' => Hash::make('password'),
            'role' => 'customer',
        ]);
        $user->customer()->create([
            'address' => 'Jl. Contoh',
            'phone' => '08123456789',
            'city' => 'Contoh',
            'province' => 'Contoh',
            'postal_code' => '12345',
        ]);

    }
}
