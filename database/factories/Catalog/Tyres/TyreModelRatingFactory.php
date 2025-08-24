<?php

namespace Database\Factories\Catalog\Tyres;

use App\Models\Catalog\Tyres\TyreModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog\Tyres\TyreModelRating>
 */
class TyreModelRatingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'model_id' => TyreModel::factory(),
            'rating' => [
                'Сухая дорога' => (fake()->randomDigit() + 1) * 10,
                'Мокрая дорога' => (fake()->randomDigit() + 1) * 10,
                'Комфорт' => (fake()->randomDigit() + 1) * 10,
                'Устойчивость' => (fake()->randomDigit() + 1) * 10,
                'Бесшумность' => (fake()->randomDigit() + 1) * 10,
                'Торможение' => (fake()->randomDigit() + 1) * 10,
                'Аквапланирование' => (fake()->randomDigit() + 1) * 10,
                'Скорость' => (fake()->randomDigit() + 1) * 10,
                'Износоустойчивость' => (fake()->randomDigit() + 1) * 10,
                'Качество' => (fake()->randomDigit() + 1) * 10,
                'Цена/качество' => (fake()->randomDigit() + 1) * 10,
            ]
        ];
    }
}
