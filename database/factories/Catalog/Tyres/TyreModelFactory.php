<?php

namespace Database\Factories\Catalog\Tyres;

use Illuminate\Support\Str;
use App\Models\Content\File;
use App\Models\Content\FileToEntity;
use App\Models\Catalog\Tyres\TyreBrand;
use App\Models\Catalog\Tyres\TyreModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog\Tyres\TyreModel>
 */
class TyreModelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tread_patterns = [
            "Симметричный,Ненаправленный",
            "Симметричный,Направленный",
            "Асимметричный,Ненаправленный",
            "Асимметричный,Направленный"
        ];

        return [
            'brand_id' => TyreBrand::factory(),
            'title' => fake()->words(2, true),
            'slug' => function (array $attributes) {
                return Str::slug($attributes['title']);
            },
            'tread_pattern' => fake()->randomElement($tread_patterns)
        ];
    }
}
