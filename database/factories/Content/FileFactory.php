<?php

namespace Database\Factories\Content;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\Content\File;
use App\Models\Content\FileToEntity;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Content\File>
 */
class FileFactory extends Factory
{
    /**
     * Configure the factory to handle version_id appropriately.
     *
     * @return $this
     */
    public function configure()
    {
        return $this->afterMaking(function (File $file) {
            if (!isset($file->local_path) || $file->local_path === null) {
                $filePath = resource_path('images/example/tyres/001.webp');

                Storage::disk($file->storage)->put('tyres/' . $file->file_name, file_get_contents($filePath));

                $file->local_path = 'tyres/' . $file->file_name;
                $file->absolute_path =  Storage::disk($file->storage)->url($file->local_path);
            }
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
            'file_name' => Str::uuid() . '.webp',
            'storage' => 'public',
            'local_path' => null,
            'absolute_path' => function (array $attributes) {
                return !empty($attributes['local_path']) ? Storage::disk($attributes['storage'])->url($attributes['local_path']) : null;
            },
            'is_active' => true,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now()
        ];
    }
}
