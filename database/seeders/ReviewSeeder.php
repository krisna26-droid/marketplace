<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OrderItem;
use App\Models\Review;

class ReviewSeeder extends Seeder
{
    public function run(): void
    {
        $totalReviews = 1000;
        $batchSize = 200;

        // Eager load order untuk menghindari N+1 query
        $items = OrderItem::with('order')->inRandomOrder()->take($totalReviews)->get();

        $reviews = [];
        $count = 0;

        foreach ($items as $item) {
            $reviews[] = [
                'order_id' => $item->order_id,
                'order_item_id' => $item->id,
                'product_id' => $item->product_id,
                'customer_id' => $item->order->customer_id,
                'rating' => rand(1, 5),
                'comment' => fake()->sentence(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $count++;

            // Batch insert & progres info
            if ($count % $batchSize === 0) {
                Review::insert($reviews);
                $reviews = [];
                $this->command->info("Inserted $count / $totalReviews reviews...");
            }
        }

        // Insert sisa
        if (!empty($reviews)) {
            Review::insert($reviews);
            $this->command->info("Inserted remaining reviews.");
        }

        $this->command->info("Review seeding completed!");
    }
}
