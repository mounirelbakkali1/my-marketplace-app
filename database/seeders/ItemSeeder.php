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
        Item::factory()->count(5)->create();
    }
}
