<?php

namespace Database\Factories;

use App\Models\AdditionalProfilSettings;
use App\Models\Address;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AdditionalProfilSettings>
 */
class AdditionalProfilSettingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'coverImage' => $this->faker->imageUrl(),
            'websiteUrl' => 'www.google.com',
            'phone' => '+49 123 456 789',
            'intro' => $this->faker->sentence,
            'address_id' => Address::factory()->create()->id,
        ];
    }

  /*  public function configure()
    {
        return $this->afterCreating(function (AdditionalProfilSettings $additionalProfilSettings) {
            $additionalProfilSettings->address()->save(
                Address::factory()->make()
            );
        });
    }*/
}
