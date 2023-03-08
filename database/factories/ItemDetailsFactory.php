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
            'size' => $this->faker->randomDigitNotZero().','.$this->faker->randomDigitNotZero(),
            'stock' => $this->faker->randomDigitNotZero(),
            'description' => $this->faker->text
        ];
    }
}
