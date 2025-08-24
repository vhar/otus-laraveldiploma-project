<?php

namespace Database\Factories\Content;

use App\Models\Content\File;
use App\Models\Catalog\Tyres\Tyre;
use App\Models\ValueObject\EntityType;
use App\Models\ValueObject\FileToEntityLinkType;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content\FileToEntity>
 */
class FileToEntityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_id' => File::factory(),
            'entity_type' => EntityType::TYRE_MODEL->value,
            'entity_id' => Tyre::factory(),
            'sort' => 100,
            'link_type' => FileToEntityLinkType::TRANSPARENT_PHOTO,
        ];
    }
}
