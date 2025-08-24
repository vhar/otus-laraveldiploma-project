<?php

namespace App\Orchid\Filters\Catalog;

use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Select;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Catalog\Tyres\TyreBrand;

class TyreBrandFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Бренд';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['brand'];
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
        return $builder->where('brand_id', $this->request->get('brand'));
    }

    public function display(): array
    {
        return [
            Select::make('brand')
                ->fromModel(TyreBrand::class, 'title', 'id')->orderBy('title', 'asc')
                ->empty()
                ->value(!is_null($this->request->get('brand')) ? intval($this->request->get('brand')) : null)
                ->title($this->name())
        ];
    }

    /**
     * @return string
     */
    public function value(): string
    {
        return $this->name() . ': ' . TyreBrand::where('id', $this->request->get('brand'))->first()->title;
    }
}
