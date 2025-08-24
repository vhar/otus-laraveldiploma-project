<?php

namespace App\Services\UseCases\Commands\Marketplaces\Ozon;

use App\Services\Repositories\TyreRepository;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use App\Services\UseCases\Queries\Tyres\Images\ImagesFetcher;
use App\Services\UseCases\Commands\Marketplaces\Ozon\OzonPictureUploadException;

class UploadTyreImageHandler
{
    /**
     * Загрузка изображений товра на Озон
     * @param int $tyreId
     * @return UploadResult
     * @throws OzonPictureUploadException
     */
    public function handle(int $tyreId): UploadResult
    {
        $images = (new ImagesFetcher())->fetch($tyreId);

        $headers = [
            'Content-Type' => 'application/json',
            'Client-Id' => Config::get('marketplaces.ozon.clientId'),
            'Api-Key' => Config::get('marketplaces.ozon.apiKey'),
        ];

        $repository = new TyreRepository();

        $ozonProductId = $repository->getOzonProductId($tyreId);

        if ($ozonProductId) {
            $payload = [
                "product_id" => $ozonProductId,
                "images" => $images,
            ];
        }

        $response = Http::withHeaders($headers)
            ->acceptJson()
            ->post('https://api-seller.ozon.ru/v1/product/pictures/import', $payload);

        if ($response->getStatusCode() === 200) {
            $jsonResult =  $response->json('result');
            $pictures = array_map(fn($picture) => new UploadPicture(
                $picture['is_360'],
                $picture['is_color'],
                $picture['is_primary'],
                $picture['product_id'],
                $picture['state'],
                $picture['url']
            ), $jsonResult['pictures']);

            $repository->updateUploadOnOzon($ozonProductId);

            return new UploadResult($pictures);
        } else {
            $errors = array_map(fn($detail) => new UploadErrorDetail(
                $detail['typeUrl'],
                $detail['value']
            ), $response->json('details'));

            $exception = new OzonPictureUploadException($response->json('message'), $response->json('code'));
            $exception->setDetails($errors);

            throw $exception;
        }
    }
}
