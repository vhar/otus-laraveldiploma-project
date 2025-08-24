<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Themes\Winter;

use App\Services\Interfaces\Theme\Fonts;
use App\Services\Interfaces\Theme\Slide;
use App\Services\Interfaces\Theme\Theme;
use App\Services\Interfaces\Theme\Season;
use App\Services\Interfaces\ThemeInterface;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\FirstHandler;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\ThirdHandler;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\SecondHandler;

class WinterTheme implements ThemeInterface
{
    public function get(): Theme
    {
        $season = new Season(
            winter: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Winter/Season/winter.png'),
            summer: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Winter/Season/summer.png'),
        );

        $fonts = new Fonts(
            light: resource_path('fonts/Manrope-Light.ttf'),
            regular: resource_path('fonts/Manrope-Regular.ttf'),
            medium: resource_path('fonts/Manrope-Medium.ttf'),
            bold: resource_path('fonts/Manrope-Bold.ttf'),
        );

        $slides = [
            new Slide(
                handler: new FirstHandler,
                background: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Winter/Backgrounds/1.png'),
                fonts: $fonts,
                color: '#18191B',
                chart: null,
                season: $season,
                countryFlagPath: resource_path('images/icons/countries'),
            ),
            new Slide(
                handler: new SecondHandler,
                background: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Winter/Backgrounds/2.png'),
                fonts: $fonts,
                color: '18191B',
                chart: null,
                season: $season,
                countryFlagPath: resource_path('images/icons/countries'),
            ),
            new Slide(
                handler: new ThirdHandler,
                background: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Winter/Backgrounds/2.png'),
                fonts: $fonts,
                color: '18191B',
                chart: null,
                season: $season,
                countryFlagPath: resource_path('images/icons/countries'),
            ),
        ];

        return new Theme(
            name: 'Зимняя тема',
            thumbnail: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Winter/thumbnail.png'),
            slides: $slides,
        );
    }
}
