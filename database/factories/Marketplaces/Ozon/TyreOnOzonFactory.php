<?php

namespace Database\Factories\Marketplaces\Ozon;

use App\Models\Catalog\Tyres\Tyre;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Marketplaces\Ozon\TyreOnOzon>
 */
class TyreOnOzonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'tyre_id' => Tyre::factory(),
            'ozon_product_id' => fake()->randomNumber(9),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'sku' => (string)fake()->randomNumber(9),
            'article' => function (array $attributes) {
                return Tyre::whereId($attributes['tyre_id'])->first()->article;
            }
        ];
    }
}
