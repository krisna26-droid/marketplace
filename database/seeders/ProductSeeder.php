<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\User;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = User::where('role','vendor')->pluck('id')->toArray();
        $categories = Category::pluck('id')->toArray();

        $totalProducts = 500;
        $batchSize = 50; // insert tiap 50 produk
        $products = [];

        $this->command->info("Starting seeding $totalProducts products...");

        for ($i = 1; $i <= $totalProducts; $i++) {
            // Gunakan URL gambar langsung untuk cepat
            $filename = "https://picsum.photos/600/600?random=" . uniqid();

            $products[] = [
                'vendor_id' => fake()->randomElement($vendors),
                'category_id' => fake()->randomElement($categories),
                'name' => fake()->words(3, true),
                'description' => fake()->sentence(),
                'price' => fake()->numberBetween(20000, 2000000),
                'stock' => fake()->numberBetween(5, 50),
                'image' => $filename,
                'created_at' => now(),
                'updated_at' => now(),
            ];

            // Insert batch
            if ($i % $batchSize === 0) {
                Product::insert($products);
                $products = [];
                $this->command->info("Inserted $i / $totalProducts products...");
            }
        }

        // Insert sisa produk jika ada
        if (!empty($products)) {
            Product::insert($products);
            $this->command->info("Inserted remaining products.");
        }

        $this->command->info("Seeding completed!");
    }
}
