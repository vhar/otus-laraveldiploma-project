<?php

namespace App\Orchid\Screens\Catalog;

use App\Models\Theme;
use Illuminate\Bus\Batch;
use Orchid\Screen\Screen;
use Illuminate\Http\Request;
use App\Jobs\HandleTyreImagesJob;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use App\Models\Catalog\Tyres\Tyre;
use Illuminate\Support\Facades\Bus;
use App\Jobs\UploadTyreImagesToOzonJob;
use App\Events\TyreImagesJobFinihedEvent;
use App\Orchid\Layouts\Catalog\TyreListTable;
use App\Orchid\Layouts\Catalog\TyreSelection;
use App\Events\UploadTyreImagesToOzonJobFinihedEvent;

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

            $jobs = [];

            foreach ($tyres as $tyre) {
                $jobs[] = new HandleTyreImagesJob(new $theme->theme, $tyre->id);
            }

            if (count($jobs)) {
                $batch = Bus::batch($jobs)
                    ->finally(function (Batch $batch) {
                        TyreImagesJobFinihedEvent::dispatch($batch->id);
                    })->dispatch();
            }

            Toast::success('Товары отправлены на обработку в задание ' . $batch->id);
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

        $jobs = [];

        foreach ($tyres as $tyre) {
            $jobs[] = new UploadTyreImagesToOzonJob($tyre->id);
        }

        if (count($jobs)) {
            $batch = Bus::batch($jobs)
                ->finally(function (Batch $batch) {
                    UploadTyreImagesToOzonJobFinihedEvent::dispatch($batch->id);
                })->dispatch();
        }

        Toast::success('Картинки товаро отправлены на загрузку в задание ' . $batch->id);
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
