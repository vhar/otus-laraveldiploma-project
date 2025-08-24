<?php

namespace App\Services\UseCases\Commands\Marketplaces\Ozon;

/**
 * Ошибка загрузки изображений товара
 * @see https://docs.ozon.ru/api/seller/?abt_att=1&origin_referer=yandex.ru#operation/ProductAPI_ProductImportPictures
 */
final readonly class UploadErrorDetail
{
    public function __construct(
        public string $typeUrl,
        public string $value
    ) {}
}
