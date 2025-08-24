<?php

namespace App\Services\Repositories;

use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use App\Models\Catalog\Tyres\Tyre;
use App\Models\Marketplaces\Ozon\TyreOnOzon;
use App\Models\Catalog\Tyres\TyreModelRating;
use App\Services\Repositories\Common\PreparedTyre;
use App\Services\Repositories\Common\ModelNotFoundException;

class TyreRepository
{
    /**
     * Получить данные шины для создания картинок
     * @param int $tyreId
     * @throws ModelNotFoundException
     * @return PreparedTyre
     */
    public function getPreparedTyre(int $tyreId): PreparedTyre
    {
        $tyre = Tyre::whereId($tyreId)
            ->with('tyreModel')
            ->first();

        if (!$tyre) {
            throw new ModelNotFoundException('Шина с id ' . $tyreId . ' не найдена');
        }

        $images = array_map(
            fn($image) => $image->absolute_path,
            $tyre->tyreModel->photos()
        );

        $index = explode("/", $tyre->load_index);

        $loadIndex  = config()->get('tyres.load_indexes')[$index[0]];
        $speedIndex = config()->get('tyres.speed_indexes')[$tyre->speed_index];

        $tredPattern = '';

        if ($tyre->tyreModel->tread_pattern) {
            $lower = Str::lower($tyre->tyreModel->tread_pattern);
            $words = explode(',', $lower);
            $text = $words[1] . ' ' . $words[0] . ' дизайн протектора';
            $tredPattern = Str::ucfirst($text);
        }

        $size = sprintf("%s %s R%s", $tyre->width, $tyre->height, $tyre->diameter);

        $sizeWithOptions = $size;

        if ($tyre->is_extra_load) {
            $sizeWithOptions .= ' XL';
        }

        if ($tyre->is_run_flat) {
            $sizeWithOptions .= ' RunFlat';
        }

        $slug = sprintf(
            "%s-%s-%s-%s-%sr%s-%s",
            Str::slug(title: $tyre->tyreBrand->title, language: 'ru'),
            Str::slug(title: $tyre->tyreModel->title, language: 'ru'),
            Str::slug(title: $tyre->season, language: 'ru'),
            $tyre->width,
            $tyre->height,
            $tyre->diameter,
            Str::slug(title: $tyre->article, language: 'ru'),
        );

        $rating = TyreModelRating::query()
            ->where('model_id', $tyre->model_id)
            ->pluck('rating')
            ->first();

        return new PreparedTyre(
            tyreId: $tyre->id,
            article: $tyre->article,
            name: $tyre->title,
            brandName: $tyre->tyreBrand->title,
            brandSlug: $tyre->tyreBrand->slug,
            brandLogo: $tyre->tyreBrand->logo()->absolute_path,
            modelName: $tyre->tyreModel->title,
            modelSlug: $tyre->tyreModel->slug,
            season: Str::lower($tyre->season),
            size: $size,
            sizeWithOptions: $sizeWithOptions,
            tredPattern: $tredPattern,
            loadIndex: $loadIndex,
            speedIndex: $speedIndex,
            rating: $rating ?? [],
            images: $images,
            originCountry: $tyre->tyreBrand->origin_country ?? '',
            slug: $slug
        );
    }

    /**
     * Обновить время загрузки картинок товара на Озон
     * @param int $ozonProductId
     * @return int
     */
    public function updateUploadOnOzon(int $ozonProductId): int
    {
        return TyreOnOzon::query()
            ->where('ozon_product_id', $ozonProductId)
            ->update([
                'picture_upload_at' => Carbon::now()
            ]);
    }

    /**
     * Получить id продукта на Озон по id шины
     * @param int $tyreId
     * @throws ModelNotFoundException
     * @return int|null
     */
    public function getOzonProductId(int $tyreId): int
    {
        $tyre = Tyre::whereId($tyreId)
            ->with('onOzon')
            ->first();

        if (!$tyre) {
            throw new ModelNotFoundException('Шина с id ' . $tyreId . ' не найдена');
        }

        return $tyre->onOzon->ozon_product_id;
    }
}
