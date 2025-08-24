<?php

namespace App\Orchid\Screens\Image;

use App\Models\Theme;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Toast;
use App\Orchid\Layouts\Image\ThemeListTable;

class ThemeListScreen extends Screen
{
    public function permission(): ?iterable
    {
        return [
            'platform.theme.manage'
        ];
    }

    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'themes' => Theme::query()
                ->get(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Темы слайдов';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            ThemeListTable::class,
        ];
    }

    public function changeCurrentTheme(Theme $theme)
    {
        Theme::query()
            ->where('id', '!=', $theme->id)
            ->update(['current' => false]);

        $theme->current = true;
        $theme->save();

        Toast::success('Текущая тема изменена.');
    }
}
