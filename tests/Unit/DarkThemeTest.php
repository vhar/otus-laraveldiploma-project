<?php

namespace Tests\Unit;

use Tests\TestCase;
use UnexpectedValueException;
use App\Services\Interfaces\Theme\Theme;
use Intervention\Image\Interfaces\ImageInterface;
use App\Services\Repositories\Common\PreparedTyre;
use App\Services\UseCases\Commands\Tyres\Images\Themes\Dark\DarkTheme;

class DarkThemeTest extends TestCase
{
    protected Theme $theme;
    protected PreparedTyre $tyre;
    protected PreparedTyre $tyreWOImages;
    protected PreparedTyre $tyreWORating;

    public function setUp(): void
    {
        parent::setUp();

        $this->theme = (new DarkTheme())->get();

        $this->tyre = new PreparedTyre(
            tyreId: 0,
            article: '358787',
            name: 'Шина летняя CONTINENTAL SportContact 6 285/30 R20 99Y XL',
            brandName: 'Continental',
            brandSlug: 'continental',
            brandLogo: base_path('tests/resources/tyre_brands/continental.webp'),
            modelName: 'SportContact 6',
            modelSlug: 'sportcontact-6',
            season: 'летние',
            size: '285 30 R20',
            sizeWithOptions: '185 30 R20 XL',
            tredPattern: 'Ненаправленный асимметричный дизайн протектора',
            loadIndex: '99 до 775 кг',
            speedIndex: 'Y до 300 км/ч',
            rating: [
                "Сухая дорога" => "90",
                "Мокрая дорога" => "90",
                "Устойчивость" => "90",
                "Комфорт" => "80",
                "Бесшумность" => "80",
                "Торможение" => "90",
                "Оценка" => "90",
                "Аквапланирование" => "90",
                "Скорость" => "90",
                "Износоустойчивость" => "80",
                "Качество" => "90",
                "Цена/качество" => "80",
            ],
            images: [
                base_path('tests/resources/tyre_models/continental/sport-contact-6-1.webp'),
                base_path('tests/resources/tyre_models/continental/sport-contact-6-2.webp'),
                base_path('tests/resources/tyre_models/continental/sport-contact-6-3.webp'),
            ],
            originCountry: 'RUS',
            slug: 'continental-sportcontact-6-letnie-285-30-r20-358787',
        );

        $this->tyreWOImages = new PreparedTyre(
            tyreId: 0,
            article: '358787',
            name: 'Шина летняя CONTINENTAL SportContact 6 285/30 R20 99Y XL',
            brandName: 'Continental',
            brandSlug: 'continental',
            brandLogo: base_path('tests/resources/tyre_brands/continental.webp'),
            modelName: 'SportContact 6',
            modelSlug: 'sportcontact-6',
            season: 'летние',
            size: '285 30 R20',
            sizeWithOptions: '185 30 R20 XL',
            tredPattern: 'Ненаправленный асимметричный дизайн протектора',
            loadIndex: '99 до 775 кг',
            speedIndex: 'Y до 300 км/ч',
            rating: [
                "Сухая дорога" => "90",
                "Мокрая дорога" => "90",
                "Устойчивость" => "90",
                "Комфорт" => "80",
                "Бесшумность" => "80",
                "Торможение" => "90",
                "Оценка" => "90",
                "Аквапланирование" => "90",
                "Скорость" => "90",
                "Износоустойчивость" => "80",
                "Качество" => "90",
                "Цена/качество" => "80",
            ],
            images: [],
            originCountry: 'RUS',
            slug: 'continental-sportcontact-6-letnie-285-30-r20-358787',
        );

        $this->tyreWORating = new PreparedTyre(
            tyreId: 0,
            article: '358787',
            name: 'Шина летняя CONTINENTAL SportContact 6 285/30 R20 99Y XL',
            brandName: 'Continental',
            brandSlug: 'continental',
            brandLogo: base_path('tests/resources/tyre_brands/continental.webp'),
            modelName: 'SportContact 6',
            modelSlug: 'sportcontact-6',
            season: 'летние',
            size: '285 30 R20',
            sizeWithOptions: '185 30 R20 XL',
            tredPattern: 'Ненаправленный асимметричный дизайн протектора',
            loadIndex: '99 до 775 кг',
            speedIndex: 'Y до 300 км/ч',
            rating: [],
            images: [
                base_path('tests/resources/tyre_models/continental/sport-contact-6-1.webp'),
                base_path('tests/resources/tyre_models/continental/sport-contact-6-2.webp'),
                base_path('tests/resources/tyre_models/continental/sport-contact-6-3.webp'),
            ],
            originCountry: 'RUS',
            slug: 'continental-sportcontact-6-letnie-285-30-r20-358787',
        );
    }

    public function test_first_slide_handler_success(): void
    {
        $slide = $this->theme->slides[0];
        $image = $slide->handler->handle($slide, $this->tyre);

        $this->assertTrue($image instanceof ImageInterface);
    }

    public function test_first_slide_handler_exception(): void
    {
        $slide = $this->theme->slides[0];

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Нет картинок с прозрачным фоном для модели');

        $slide->handler->handle($slide, $this->tyreWOImages);
    }

    public function test_second_slide_handler_success(): void
    {
        $slide = $this->theme->slides[1];
        $image = $slide->handler->handle($slide, $this->tyre);

        $this->assertTrue($image instanceof ImageInterface);
    }

    public function test_second_slide_handler_exception(): void
    {
        $slide = $this->theme->slides[1];

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Нет картинки с прозрачным фоном для второго слайда');

        $slide->handler->handle($slide, $this->tyreWOImages);
    }

    public function test_third_slide_handler_success(): void
    {
        $slide = $this->theme->slides[2];
        $image = $slide->handler->handle($slide, $this->tyre);

        $this->assertTrue($image instanceof ImageInterface);
    }

    public function test_third_slide_handler_exception(): void
    {
        $slide = $this->theme->slides[2];

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Нет картинки с прозрачным фоном для третьего слайда');

        $slide->handler->handle($slide, $this->tyreWOImages);
    }

    public function test_fourth_slide_handler_success(): void
    {
        $slide = $this->theme->slides[3];
        $image = $slide->handler->handle($slide, $this->tyre);

        $this->assertTrue($image instanceof ImageInterface);
    }

    public function test_fourth_slide_handler_exception(): void
    {
        $slide = $this->theme->slides[3];

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Отсутствует рейтинг для модели шины');

        $slide->handler->handle($slide, $this->tyreWORating);
    }

    public function test_fifth_slide_handler_success(): void
    {
        $slide = $this->theme->slides[4];
        $image = $slide->handler->handle($slide, $this->tyre);

        $this->assertTrue($image instanceof ImageInterface);
    }

    public function test_fifth_slide_handler_exception(): void
    {
        $slide = $this->theme->slides[4];

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Отсутствует рейтинг для модели шины');

        $slide->handler->handle($slide, $this->tyreWORating);
    }

    public function test_sixth_slide_handler_success(): void
    {
        $slide = $this->theme->slides[5];
        $image = $slide->handler->handle($slide, $this->tyre);

        $this->assertTrue($image instanceof ImageInterface);
    }

    public function test_sixth_slide_handler_exception(): void
    {
        $slide = $this->theme->slides[5];

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Отсутствует рейтинг для модели шины');

        $slide->handler->handle($slide, $this->tyreWORating);
    }

    public function test_sixth_slide_handler_image_exception(): void
    {
        $slide = $this->theme->slides[5];

        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('Нет картинки с прозрачным фоном для шестого слайда');

        $slide->handler->handle($slide, $this->tyreWOImages);
    }
}
