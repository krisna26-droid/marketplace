<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Admin
        // User::updateOrCreate(
        //     ['email' => 'admin@example.com'],
        //     [
        //         'name' => 'Admin Utama',
        //         'password' => Hash::make('password'),
        //         'role' => 'admin',
        //     ]
        // );

        // // Vendor
        // User::updateOrCreate(
        //     ['email' => 'vendor@example.com'],
        //     [
        //         'name' => 'Vendor Pertama',
        //         'password' => Hash::make('password'),
        //         'role' => 'vendor',
        //     ]
        // );

        // // Customer contoh
        // User::updateOrCreate(
        //     ['email' => 'customer@example.com'],
        //     [
        //         'name' => 'Customer Contoh',
        //         'password' => Hash::make('password'),
        //         'role' => 'customer',
        //     ]
        // );
    }
}
