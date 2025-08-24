<?php

use Illuminate\Support\Facades\Route;
use App\Models\Catalog\Tyres\Tyre;
use App\Services\UseCases\Commands\Marketplaces\Ozon\UploadTyreImageHandler;
use App\Services\UseCases\Commands\Marketplaces\Ozon\OzonPictureUploadException;

Route::get('/', function () {
    return redirect(route('platform.main'));
});

Route::get('/throw', function () {
    try {
        throw new OzonPictureUploadException('ssss');
    } catch (OzonPictureUploadException $exception) {
        return $exception->getMessage() . PHP_EOL;
    } catch (Exception $exception) {
        return ($exception instanceof OzonPictureUploadException) . PHP_EOL;
    }
});
