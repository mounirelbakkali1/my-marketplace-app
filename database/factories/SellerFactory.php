<?php

namespace Database\Factories;

use App\Models\AdditionalProfilSettings;
use App\Models\Address;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends UserFactory
{

    public function definition(): array
    {
        return parent::definition();

    }
    public function forUser(): static
    {
        return $this->state(function (array $attributes) {
            return [
                'role' => Seller::TYPE,
            ];
        });
    }
    public function configure()
    {
        return $this->afterCreating(function (Seller $seller) {
            $seller->AdditionalInfo()->save(
                AdditionalProfilSettings::factory()->make()
            );
            $seller->assignRole('seller');
        });
    }
}
