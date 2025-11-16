<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;

class OrderSeeder extends Seeder
{
    public function run(): void
    {
        $customers = User::where('role','customer')->pluck('id')->toArray();
        $productList = Product::get()->keyBy('id'); // untuk update stok cepat

        $totalOrders = 500;
        $orders = [];
        $batchSize = 50;

        $this->command->info("Starting seeding $totalOrders orders...");

        // 1. Generate Orders & OrderItems
        $allItems = [];
        foreach (range(1, $totalOrders) as $index) {

            $customerId = fake()->randomElement($customers);

            $itemCount = rand(1, 5);
            $totalPrice = 0;
            $orderItems = [];

            for ($i = 0; $i < $itemCount; $i++) {
                $product = $productList->random();

                if ($product->stock <= 0) continue;
                $product->stock -= 1;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'quantity' => 1,
                    'price' => $product->price,
                ];

                $totalPrice += $product->price;
            }

            $orders[] = [
                'customer_id' => $customerId,
                'total_price' => $totalPrice,
                'status' => 'completed',
                'payment_status' => 'paid',
                'payment_method' => 'transfer',
                'shipping_address' => fake()->address(),
                'created_at' => now(),
                'updated_at' => now(),
            ];

            $allItems[] = $orderItems;

            // Progress info
            if ($index % $batchSize === 0) {
                $this->command->info("Prepared $index / $totalOrders orders...");
            }
        }

        // 2. Insert Orders batch
        Order::insert($orders);
        $orderIDs = Order::latest()->take($totalOrders)->pluck('id')->toArray();

        $this->command->info("Orders inserted, preparing order items...");

        // 3. Prepare OrderItems with order_id
        $itemsToInsert = [];
        foreach ($orderIDs as $idx => $orderId) {
            foreach ($allItems[$idx] as $item) {
                $itemsToInsert[] = [
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
        }

        // 4. Insert OrderItems in batch
        foreach (array_chunk($itemsToInsert, $batchSize) as $chunk) {
            OrderItem::insert($chunk);
            $this->command->info("Inserted batch of order items...");
        }

        // 5. Update stok produk di batch
        foreach ($productList as $product) {
            $product->save();
        }

        $this->command->info("Order seeding completed!");
    }
}
