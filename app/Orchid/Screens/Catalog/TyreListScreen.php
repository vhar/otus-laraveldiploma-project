<?php

namespace App\Orchid\Screens\Catalog;

use App\Models\Theme;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Jobs\HandleTyreImagesJob;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use App\Jobs\UploadTyreImagesToOzonJob;
use App\Models\Catalog\Tyres\Tyre;
use App\Orchid\Layouts\Catalog\TyreListTable;
use App\Orchid\Layouts\Catalog\TyreSelection;

class TyreListScreen extends Screen
{
    public function permission(): ?iterable
    {
        return [
            'platform.tyres.manage'
        ];
    }

    /**
     * Query data.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'tyres' => Tyre::query()
                ->has('tyreModel')
                ->has('onOzon')
                ->with('tyreModel')
                ->with('tyreModel.photoEntities')
                ->with('tyreModel.rating')
                ->with('onOzon')
                ->with('marketplacePhotoEntities')
                ->filtersApplySelection(TyreSelection::class)
                ->paginate(50)
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Каталог шин';
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сгенерировать отмеченные')
                ->method('recreateChecked')
                ->icon('bs.arrow-clockwise'),
            Button::make('На Озон')
                ->method('uploadChecked')
                ->icon('bs.upload'),
        ];
    }

    /**
     * Views.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            TyreSelection::class,
            TyreListTable::class
        ];
    }

    public function recreateChecked(Request $request)
    {
        if (!$theme = Theme::query()->where('current', true)->first()) {
            Alert::error('Не выбрана текущая тема');
        } else {
            $tyreIds = array_keys(
                array_filter(
                    $request->get('tyre')
                )
            );

            $tyres = Tyre::query()
                ->whereIn('id', $tyreIds)
                ->get();

            foreach ($tyres as $tyre) {
                HandleTyreImagesJob::dispatch(new $theme->theme, $tyre->id);
            }

            Toast::success('Товары отправлены на обработку');
        }
    }

    public function uploadChecked(Request $request)
    {
        $tyreIds = array_keys(
            array_filter(
                $request->get('tyre')
            )
        );

        $tyres = Tyre::query()
            ->whereIn('id', $tyreIds)
            ->get();

        foreach ($tyres as $tyre) {
            //
        }

        Toast::success('Фото товаров отправлены на загрузку');
    }

    public function recreate(Tyre $tyre)
    {
        if (!$theme = Theme::query()->where('current', true)->first()) {
            Alert::error('Не выбрана текущая тема');
        } else {
            HandleTyreImagesJob::dispatch(new $theme->theme, $tyre->id);

            Toast::success('Товар отправлен на обработку');
        }
    }

    public function upload(Tyre $tyre)
    {
        UploadTyreImagesToOzonJob::dispatch($tyre->id);

        Toast::success('Фото товара отправлены на загрузку');
    }
}
