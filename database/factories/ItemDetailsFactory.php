<?php

namespace Database\Factories;

use App\Enums\ItemCondition;
use App\Models\Item;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ItemDetails>
 */
class ItemDetailsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'item_id' => Item::factory(),
            'color' => $this->faker->colorName,
            'size' => $this->faker->randomFloat(2, 0, 1000),
            'stock' => $this->faker->randomDigitNotZero(),
            'description' => $this->faker->text,
            'condition' => $this->faker->randomKey(ItemCondition::getValues()),

        ];
    }
}
