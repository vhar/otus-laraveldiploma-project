<?php

namespace App\Services\UseCases\Commands\Tyres\Images\Themes\Dark;

use App\Services\Interfaces\Theme\Chart;
use App\Services\Interfaces\Theme\Fonts;
use App\Services\Interfaces\Theme\Slide;
use App\Services\Interfaces\Theme\Theme;
use App\Services\Interfaces\Theme\Season;
use App\Services\Interfaces\Theme\ChartRate;
use App\Services\Interfaces\ThemeInterface;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\FifthHandler;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\FirstHandler;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\SixthHandler;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\ThirdHandler;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\FourthHandler;
use App\Services\UseCases\Commands\Tyres\Images\Handlers\SecondHandler;

class DarkTheme implements ThemeInterface
{
    public function get(): Theme
    {
        $chart = new Chart(
            color: '21A3FF',
            rates: [
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/0.png')),
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/1.png')),
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/2.png')),
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/3.png')),
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/4.png')),
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/5.png')),
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/6.png')),
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/7.png')),
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/8.png')),
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/9.png')),
                new ChartRate(app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Chart/10.png')),
            ]
        );

        $season = new Season(
            winter: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Season/winter.png'),
            summer: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Season/summer.png'),
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
                background: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Backgrounds/1.png'),
                fonts: $fonts,
                color: 'FFFFFF',
                chart: $chart,
                season: $season,
                countryFlagPath: resource_path('images/icons/countries'),
            ),
            new Slide(
                handler: new SecondHandler,
                background: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Backgrounds/2.png'),
                fonts: $fonts,
                color: 'FFFFFF',
                chart: $chart,
                season: $season,
                countryFlagPath: resource_path('images/icons/countries'),
            ),
            new Slide(
                handler: new ThirdHandler,
                background: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Backgrounds/3.png'),
                fonts: $fonts,
                color: 'FFFFFF',
                chart: $chart,
                season: $season,
                countryFlagPath: resource_path('images/icons/countries'),
            ),
            new Slide(
                handler: new FourthHandler,
                background: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Backgrounds/4.png'),
                fonts: $fonts,
                color: 'FFFFFF',
                chart: $chart,
                season: $season,
                countryFlagPath: resource_path('images/icons/countries'),
            ),
            new Slide(
                handler: new FifthHandler,
                background: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Backgrounds/5.png'),
                fonts: $fonts,
                color: 'FFFFFF',
                chart: $chart,
                season: $season,
                countryFlagPath: resource_path('images/icons/countries'),
            ),
            new Slide(
                handler: new SixthHandler,
                background: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/Backgrounds/6.png'),
                fonts: $fonts,
                color: 'FFFFFF',
                chart: $chart,
                season: $season,
                countryFlagPath: resource_path('images/icons/countries'),
            ),
        ];

        return new Theme(
            name: 'Темная тема',
            thumbnail: app_path('Services/UseCases/Commands/Tyres/Images/Themes/Dark/thumbnail.png'),
            slides: $slides,
        );
    }
}
