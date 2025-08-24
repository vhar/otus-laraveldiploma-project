<?php

namespace App\Orchid\Layouts\Image;

use App\Models\Theme;
use Orchid\Screen\TD;
use Orchid\Screen\Fields\Radio;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;

class ThemeListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'themes';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('', 'Название')->render(function (Theme $theme) {
                return (new $theme->theme)->get()->name;
            }),
            TD::make('', 'Кол-во слайдов')->render(function (Theme $theme) {
                /** @var \App\Services\Interfaces\Theme\Theme $slideTheme */
                $slideTheme = (new $theme->theme)->get();

                return count($slideTheme->slides);
            })
                ->width('160px'),
            TD::make('', 'Превью')->render(function (Theme $theme) {
                /** @var \App\Services\Interfaces\Theme\Theme $slideTheme */
                $slideTheme = (new $theme->theme)->get();

                $src = base64_encode(file_get_contents($slideTheme->thumbnail));
                $mime = mime_content_type($slideTheme->thumbnail);

                $thumb = "data:{$mime};base64,{$src}";

                return view('components.fancyboximage', [
                    'src' => $thumb,
                    'width' => 120,
                ]);
            })
                ->width('160px'),
            TD::make('', 'Текущая')->render(function (Theme $theme) {
                if ($theme->current) {
                    return Radio::make('')
                        ->placeholder('Текущая')
                        ->checked();
                } else {
                    return Button::make('Сделать текущей')
                        ->method('changeCurrentTheme', ['theme' => $theme->id])
                        ->icon('bs.check-circle');
                }
            })
                ->width('200px'),
        ];
    }
}
