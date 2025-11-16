<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 5 parent
        $parents = Category::factory()->count(5)->create();

        // 5 children
        $children = [];

        foreach ($parents as $parent) {
            $children[] = [
                'name' => fake()->word(),
                'parent_id' => $parent->id,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        Category::insert($children);
    }
}
