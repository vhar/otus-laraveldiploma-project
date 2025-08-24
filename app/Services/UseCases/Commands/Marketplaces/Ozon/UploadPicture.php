<?php

namespace App\Services\UseCases\Commands\Marketplaces\Ozon;

/**
 * Данные изображения для загрузки
 * @see https://docs.ozon.ru/api/seller/?abt_att=1&origin_referer=yandex.ru#operation/ProductAPI_ProductImportPictures
 */
final readonly class UploadPicture
{
    public function __construct(
        public bool $is_360,
        public bool $is_color,
        public bool $is_primry,
        public int $product_id,
        public string $state,
        public string $url

    ) {}
}
