<?php

namespace App\Services\UseCases\Commands\Marketplaces\Ozon;

/**
 * Результат загрузки изображений товара
 * @see https://docs.ozon.ru/api/seller/?abt_att=1&origin_referer=yandex.ru#operation/ProductAPI_ProductImportPictures
 */
final readonly class UploadResult
{
    /**
     * Summary of __construct
     * @param UploadPicture[] $pictures
     */
    public function __construct(
        public array $pictures,
    ) {}
}
