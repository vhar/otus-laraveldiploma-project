<?php

namespace App\Orchid\Filters\Catalog;

use Orchid\Screen\Field;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Select;
use Illuminate\Database\Eloquent\Builder;

class TyreHasPhotoFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Наличие фото';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['has_photo'];
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
        return match ($this->request->get('has_photo')) {
            "1" => $builder->has('marketplacePhotoEntities', '>', 0),
            "2" => $builder->has('marketplacePhotoEntities', 0),
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
            Select::make('has_photo')
                ->options([
                    1 => 'С фото',
                    2 => 'Без фото',
                ])
                ->empty()
                ->value((!is_null($this->request->get('has_photo'))) ? intval($this->request->get('has_photo')) : null)
                ->title($this->name())
        ];
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->name() . ': ' . (
            match ($this->request->get('has_photo')) {
                "1" => "С фото",
                "2" => "Без фото",
            });
    }
}
