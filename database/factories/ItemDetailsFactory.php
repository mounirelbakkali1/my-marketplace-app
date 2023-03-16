<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\ItemDetails;
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
            'color' => $this->faker->colorName,
            'size' => $this->faker->randomDigitNotZero().','.$this->faker->randomDigitNotZero(),
            'stock' => $this->faker->randomDigitNotZero(),
            'description' => $this->faker->text
        ];
    }

    public function configure()
    {

        return $this->afterCreating(function (ItemDetails $itemDetails) {
            $itemDetails->images()->save(
                Image::factory()->make()
            );
        });
    }
}
