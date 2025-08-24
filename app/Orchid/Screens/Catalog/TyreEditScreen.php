<?php

namespace App\Orchid\Screens\Catalog;

use App\Models\Theme;
use Orchid\Screen\Screen;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Fields\Label;
use App\Orchid\Fields\ListField;
use App\Jobs\HandleTyreImagesJob;
use Orchid\Screen\Actions\Button;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Toast;
use App\Models\Catalog\Tyres\Tyre;
use Orchid\Support\Facades\Layout;
use App\Jobs\UploadTyreImagesToOzonJob;
use App\Orchid\Layouts\Catalog\TyrePhotosLayout;

class TyreEditScreen extends Screen
{
    private ?Tyre $tyre = null;

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
    public function query(Tyre $tyre): iterable
    {
        $this->tyre = $tyre;

        return [
            'tyre' => $this->tyre,
        ];
    }

    /**
     * Display header name.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return $this->tyre->title . " (Артикул: " . $this->tyre->article . ")";
    }

    /**
     * Button commands.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сгенерировать')
                ->method('recreate', ['tyre' => $this->tyre->id])
                ->icon('bs.arrow-clockwise'),
            Button::make('На Озон')
                ->method('upload', ['tyre' => $this->tyre->id])
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
            Layout::columns([
                Layout::rows([
                    Link::make('Товар на Озон')
                        ->href('https://www.ozon.ru/search/?from_global=true&text=' . $this->tyre->onOzon->sku)
                        ->target('_blank'),
                    ListField::make('missing')
                        ->title('Недостающие данные')
                        ->list($this->tyre->missing_data),
                    Label::make('created')
                        ->title('Картинки созданы')
                        ->value((empty($this->tyre->marketplacePhotoEntities[0])) ? '' : $this->tyre->marketplacePhotoEntities[0]->created_at->format('d.m.Y')),
                    Label::make('uploaded')
                        ->title('Картинки загружены на Озон')
                        ->value($this->tyre->onOzon?->picture_upload_at?->format("d.m.Y в H:i:s") ?? 'Не загружались'),
                    Label::make('tyre.article')
                        ->title('Артикул'),
                    Label::make('tyre.tyreBrand.title')
                        ->title('Бренд'),
                    Label::make('tyre.tyreModel.title')
                        ->title('Модель'),
                    Label::make('tyre.season')
                        ->title('Сезон'),
                    Label::make('stud')
                        ->title('Шипованная')
                        ->value($this->tyre->is_stud ? "Да" : "Нет"),
                    Label::make('is_extra_load')
                        ->title('XL')
                        ->value($this->tyre->is_extra_load ? "Да" : "Нет"),
                    Label::make('tyre.width')
                        ->title('Ширина'),
                    Label::make('tyre.height')
                        ->title('Высота профиля'),
                    Label::make('tyre.diameter')
                        ->title('Диаметр'),
                    Label::make('tyre.load_index')
                        ->title('Индекс нагрузки'),
                    Label::make('tyre.speed_index')
                        ->title('Индекс скорости'),
                    Label::make('is_run_flat')
                        ->title('RunFlat')
                        ->value($this->tyre->is_run_flat ? "Да" : "Нет")
                ]),
                TyrePhotosLayout::class,
            ]),
        ];
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
