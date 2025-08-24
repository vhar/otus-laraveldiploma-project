<?php

namespace App\Orchid\Filters;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\Input;

class TitleFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Название';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['title'];
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
        return $builder->whereRaw('LOWER(title) LIKE ?', ['%' . trim(mb_strtolower($this->request->get('title'))) . '%']);
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): array
    {
        return [
            Input::make('title')
                ->empty()
                ->value(!is_null($this->request->get('title')) ? $this->request->get('title') : null)
                ->title($this->name())
        ];
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->name() . ' содержит: ' . $this->request->get('title');
    }
}
