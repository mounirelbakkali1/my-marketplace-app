<?php

namespace Database\Seeders;

use App\Enums\ItemCondition;
use App\Models\Item;
use App\Models\ItemDetails;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use function rand;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = Item::factory()->count(5)->create();
        foreach ($items as $item){
            for ($i = 0; $i < 3; $i++) {
                $item->ratings()->create([
                    'rating' => rand(1, 5),
                    'user_id' => rand(1, 5),
                ]);
            }
            ItemDetails::factory()->create([
                'item_id' => $item->id,
            ]);
        }
    }
}
