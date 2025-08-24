<?php

namespace App\Orchid\Layouts\Catalog;

use Orchid\Screen\TD;
use Illuminate\Support\Str;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\CheckBox;
use App\Models\Catalog\Tyres\Tyre;

class TyreListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'tyres';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('', CheckBox::make('all-tyres')->id('select-all-tyres'))
                ->render(
                    function (Tyre $tyre) {
                        return CheckBox::make("tyre[$tyre->id]")
                            ->sendTrueOrFalse();
                    }
                ),
            TD::make('article', 'Артикул')
                ->width('100px'),
            TD::make('title', 'Название')
                ->render(
                    function (Tyre $tyre) {
                        $link = Link::make(Str::limit($tyre->title, 64))
                            ->route('platform.tyre.edit', ['tyre' => $tyre->id])
                            ->target('_blank');

                        if ($tyre->onOzon->sku) {
                            $ozon = Link::make('Товар на Озон')
                                ->href('https://www.ozon.ru/search/?from_global=true&text=' . $tyre->onOzon->sku)
                                ->target('_blank');
                        }

                        return view("components.tyre-row-data", [
                            'link' => $link,
                            'model' => $tyre->tyreModel,
                        ]);
                    }
                ),
            TD::make('', 'Маркетплэйсы')
                ->render(
                    function (Tyre $tyre) {
                        if ($tyre->onOzon->sku) {
                            return Link::make('Товар на Озон')
                                ->href('https://www.ozon.ru/search/?from_global=true&text=' . $tyre->onOzon->sku)
                                ->target('_blank');
                        }
                        return "";
                    }
                ),
            TD::make('brand_id', 'Бренд')
                ->render(
                    function (Tyre $tyre) {
                        return $tyre->tyreBrand->title;
                    }
                )
                ->width('200px'),
            TD::make('image', 'Картинка')
                ->render(function (Tyre $tyre) {
                    if (!empty($tyre->marketplacePhotoEntities[0])) {
                        return view('components.fancyboximage', [
                            'src' => $tyre->marketplacePhotoEntities[0]->absolute_path,
                            'width' => 120,
                            'created' => $tyre->marketplacePhotoEntities[0]->created_at->format('d.m.Y') ?? null,
                            'uploadedToOzon' => $tyre->onOzon->picture_upload_at?->format('d.m.Y') ?? null,
                        ]);
                    }

                    return "";
                })
                ->width('160px'),
            TD::make('', '')
                ->render(
                    function (Tyre $tyre) {
                        return Button::make('')
                            ->method('recreate', ['tyre' => $tyre->id])
                            ->icon('bs.arrow-clockwise');
                    }
                ),
            TD::make('', '')
                ->render(
                    function (Tyre $tyre) {
                        $btn = Button::make('')
                            ->method('upload', ['tyre' => $tyre->id])
                            ->icon('bs.upload');
                        if (!$tyre->marketplacePhotoEntities->count()) {
                            $btn->disabled();
                        }

                        return $btn;
                    }
                ),
        ];
    }
}
