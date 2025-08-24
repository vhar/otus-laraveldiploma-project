<?php

namespace Database\Factories\Catalog\Tyres;

use Illuminate\Support\Str;
use App\Models\Catalog\Tyres\Tyre;
use App\Models\Catalog\Tyres\TyreBrand;
use App\Models\Catalog\Tyres\TyreModel;
use App\Models\Marketplaces\Ozon\TyreOnOzon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog\Tyres\Tyre>
 */
class TyreFactory extends Factory
{
    public function configure(): static
    {
        return $this->afterCreating(function (Tyre $tyre) {
            TyreOnOzon::factory()->create([
                'tyre_id' => $tyre->id,
                'article' => $tyre->article
            ]);
        });
    }

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        list($width, $height, $diameter) = explode(" ", fake()->randomElement(config()->get('tyres.popular_sizes')));

        return [
            'model_id' => TyreModel::factory(),
            'article' => fake()->unique()->word(),
            'diameter' => $diameter,
            'width' => $width,
            'height' => $height,
            'season' => fake()->randomElement(['Летние', 'Зимние']),
            'load_index' => fake()->randomKey(config()->get('tyres.load_indexes')),
            'speed_index' => fake()->randomKey(config()->get('tyres.speed_indexes')),
            'is_extra_load' => fake()->boolean(),
            'is_run_flat' => fake()->boolean(),
            'is_stud' => false,
            'is_active' => true,
            'title' => function (array $attributes) {
                return sprintf(
                    "%s шины %s %s %s/%s R%s",
                    $attributes['season'],
                    TyreModel::whereId($attributes['model_id'])->first()->tyreBrand->title,
                    TyreModel::whereId($attributes['model_id'])->first()->title,
                    $attributes['width'],
                    $attributes['height'],
                    $attributes['diameter']
                );
            },
            'slug' => function (array $attributes) {
                return Str::slug($attributes['title']);
            }
        ];
    }
}
