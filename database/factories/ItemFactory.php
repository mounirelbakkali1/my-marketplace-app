<?php

namespace Database\Factories;

use App\Enums\ItemStatus;
use App\Models\Category;
use App\Models\Collection;
use App\Models\ItemDetails;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'price' => $this->faker->randomFloat(2, 0, 1000),
            'primary_image' => $this->faker->image('public/storage/items/images', 640, 480, null, false),
            'category_id' => Category::factory(),
            'collection_id' => Collection::factory(),
            'seller_id' => Seller::factory(),
            'itemDetails'=> ItemDetails::factory(),
        ];
    }
}
