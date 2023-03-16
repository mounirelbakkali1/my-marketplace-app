<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CollectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $collections = [
            'cat',
            'dog',
            'bird',
            'other'
        ];
        foreach ($collections as $collection) {
            \App\Models\Collection::factory()->create([
                'name' => $collection,
                'image' => 'https://picsum.photos/200/300',
            ]);
        }
    }
}
