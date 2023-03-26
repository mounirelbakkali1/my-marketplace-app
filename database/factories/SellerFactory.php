<?php

namespace Database\Factories;

use App\Models\AdditionalProfilSettings;
use App\Models\Address;
use App\Models\Seller;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function now;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Seller>
 */
class SellerFactory extends Factory
{

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('azer1234'),
            'remember_token' => Str::random(10),
            'image' => $this->faker->imageUrl(),
        ];
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
