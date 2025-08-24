<?php

namespace App\Orchid\Layouts\Catalog;

use Orchid\Filters\Filter;
use App\Orchid\Filters\TitleFilter;
use Orchid\Screen\Layouts\Selection;
use App\Orchid\Filters\Catalog\ArticleFilter;
use App\Orchid\Filters\Catalog\TyreBrandFilter;
use App\Orchid\Filters\Catalog\TyreHasPhotoFilter;
use App\Orchid\Filters\Catalog\TyreModelHasPhotoFilter;
use App\Orchid\Filters\Marketplaces\Ozon\OzonCreatedAtRangeFilter;
use App\Orchid\Filters\Marketplaces\Ozon\OzonPictureUploadedAtRangeFilter;

class TyreSelection extends Selection
{
    /**
     * @return Filter[]
     */
    public function filters(): iterable
    {
        return [
            ArticleFilter::class,
            TitleFilter::class,
            TyreBrandFilter::class,
            TyreModelHasPhotoFilter::class,
            TyreHasPhotoFilter::class,
            OzonCreatedAtRangeFilter::class,
            OzonPictureUploadedAtRangeFilter::class
        ];
    }
}
