<?php

namespace App\Orchid\Layouts\Catalog;

use App\Models\Content\FileToEntity;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\TD;


class TyrePhotosLayout extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tyre.marketplacePhotoEntities';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('photo', 'Фото')->render(function (FileToEntity $entity) {
                if (isset($entity->file->absolute_path)) {
                    return view('components.fancyboximage', [
                        'src' => $entity->absolute_path,
                        'width' => 300,
                    ]);
                }
                return "";
            })
                ->width(200),
        ];
    }
}
