<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use App\Models\Content\File;
use Illuminate\Database\Seeder;
use App\Models\Catalog\Tyres\Tyre;
use App\Models\Content\FileToEntity;
use App\Models\Catalog\Tyres\TyreModel;
use Illuminate\Support\Facades\Storage;
use App\Models\Catalog\Tyres\TyreModelRating;

class TyreSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        /**
         * Массив картинок для модели
         */
        $files = [
            resource_path('images/example/tyres/001.webp'),
            resource_path('images/example/tyres/002.webp'),
            resource_path('images/example/tyres/003.webp'),
        ];


        /**
         * Модель без рейтинга и картинок
         */
        $model = TyreModel::factory()->create();

        Tyre::factory()->create(['model_id' => $model->id]);


        /**
         * Модель с рейтингом без картинок
         */
        Tyre::factory()
            ->for(
                TyreModel::factory()
                    ->has(TyreModelRating::factory(), 'rating')
            )->create();


        /**
         * Модель без рейтинга с одной картинкой
         */
        $model = TyreModel::factory()->create();

        $fileName = Str::uuid() . '.webp';
        Storage::disk('public')->put('tyres/' . $fileName, file_get_contents($files[0]));

        $file = File::factory()->create([
            'file_name' => $fileName,
            'local_path' => 'tyres/' . $fileName,
        ]);

        FileToEntity::factory()->create([
            'file_id' => $file->id,
            'entity_id' => $model->id,
            'sort' => 100
        ]);

        Tyre::factory()->create(['model_id' => $model->id]);


        /**
         * Модель без рейтинга с набором картинок
         */
        $model = TyreModel::factory()->create();

        $sort = 100;

        foreach ($files as $file) {
            $fileName = Str::uuid() . '.webp';
            Storage::disk('public')->put('tyres/' . $fileName, file_get_contents($file));

            $file = File::factory()->create([
                'file_name' => $fileName,
                'local_path' => 'tyres/' . $fileName,
            ]);

            FileToEntity::factory()->create([
                'file_id' => $file->id,
                'entity_id' => $model->id,
                'sort' => $sort
            ]);

            $sort += 100;
        }

        Tyre::factory()->create(['model_id' => $model->id]);


        /**
         * Модель с рейтингом и набором картинок
         */
        $model = TyreModel::factory()
            ->has(TyreModelRating::factory(), 'rating')
            ->create();

        $sort = 100;

        foreach ($files as $file) {
            $fileName = Str::uuid() . '.webp';
            Storage::disk('public')->put('tyres/' . $fileName, file_get_contents($file));

            $file = File::factory()->create([
                'file_name' => $fileName,
                'local_path' => 'tyres/' . $fileName,
            ]);

            FileToEntity::factory()->create([
                'file_id' => $file->id,
                'entity_id' => $model->id,
                'sort' => $sort
            ]);

            $sort += 100;
        }

        Tyre::factory()->create(['model_id' => $model->id]);
    }
}
