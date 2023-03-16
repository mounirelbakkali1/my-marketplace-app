<?php

namespace Database\Factories;

use App\Enums\ItemStatus;
use App\Models\Category;
use App\Models\Collection;
use App\Models\Item;
use App\Models\ItemDetails;
use App\Models\Seller;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use function rand;

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
            'primary_image' => $this->faker->imageUrl(),
            'category_id' => Category::all()->random()->id,
           'collection_id' => Collection::all()->random()->id,
            'seller_id' => Seller::all()->random()->id,
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (Item $item) {
            $item->itemDetails()->save(
                ItemDetails::factory()->make()
            );
            for ($i = 0; $i < 3; $i++) {
                $item->ratings()->create([
                    'rating' => rand(1, 5),
                    'comment' => $this->faker->sentence(),
                    'user_id' => User::all()->random()->id,
                ]);
            }
        });
    }
}
