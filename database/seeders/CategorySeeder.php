<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // categories for pets market such as food and toys
        $categories = [
            'food',
            'toys',
            'clothes',
            'accessories',
            'furniture',
            'other'
        ];
        foreach ($categories as $category) {
                    \App\Models\Category::factory()->create([
                        'name' => $category,
                        'image' => 'https://picsum.photos/200/300',
                    ]);
                }


    }
}
