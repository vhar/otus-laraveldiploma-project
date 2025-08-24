<?php

namespace Database\Factories\Catalog\Tyres;

use Illuminate\Support\Str;
use App\Models\Content\File;
use App\Models\Content\FileToEntity;
use App\Models\Catalog\Tyres\TyreBrand;
use App\Models\ValueObject\EntityType;
use App\Models\ValueObject\FileToEntityLinkType;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Catalog\Tyres\TyreBrand>
 */
class TyreBrandFactory extends Factory
{
    public function configure(): static
    {
        return $this->afterCreating(function (TyreBrand $brand) {

            $brandLogo = resource_path('images/example/trademarks/kama-ru.webp');

            $fileName = Str::uuid() . '.webp';
            Storage::disk('public')->put('trademarks/' . $fileName, file_get_contents($brandLogo));

            $file = File::factory()->create([
                'file_name' => $fileName,
                'storage' => 'public',
                'local_path' => 'trademarks/' . $fileName,
            ]);

            FileToEntity::factory()->create([
                'file_id' => $file->id,
                'entity_id' => $brand->id,
                'entity_type' => EntityType::TYRE_BRAND,
                'link_type' => FileToEntityLinkType::PHOTO
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
        return [
            'title' => fake()->unique()->word(),
            'slug' => function (array $attributes) {
                return Str::slug($attributes['title']);
            },
            'origin_country' => fake()->randomElement(['IDN', 'MKO', 'POL', 'RUS']),
        ];
    }
}
