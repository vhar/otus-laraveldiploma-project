<?php

namespace App\Orchid\Filters\Catalog;

use Orchid\Screen\Field;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Select;
use Illuminate\Database\Eloquent\Builder;

class TyreModelHasPhotoFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Наличие фото для слайдов';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['has_model_photo'];
    }

    /**
     * Apply to a given Eloquent query builder.
     *
     * @param Builder $builder
     *
     * @return Builder
     */
    public function run(Builder $builder): Builder
    {
        return match ($this->request->get('has_model_photo')) {
            "1" => $builder->has('modelPhotoEntities', '>',  0),
            "2" => $builder->has('modelPhotoEntities', 0),
            "3" => $builder->has('modelPhotoEntities', '>', 2),
            "4" => $builder->has('modelPhotoEntities', '<', 3),
        };
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Select::make('has_model_photo')
                ->options([
                    1 => 'С фото',
                    2 => 'Без фото',
                    3 => 'С комплектом фото',
                    4 => 'Без комплекта фото',
                ])
                ->empty()
                ->value((!is_null($this->request->get('has_model_photo'))) ? intval($this->request->get('has_model_photo')) : null)
                ->title($this->name())
        ];
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->name() . ': ' . (
            match ($this->request->get('has_model_photo')) {
                "1" => "С фото",
                "2" => "Без фото",
                "3" => 'С комплектом фото',
                "4" => 'Без комплекта фото',
            });
    }
}
