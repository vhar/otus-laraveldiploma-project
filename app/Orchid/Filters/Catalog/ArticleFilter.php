<?php

namespace App\Orchid\Filters\Catalog;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Fields\Input;

class ArticleFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Артикул';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['article'];
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
        return $builder->whereRaw('LOWER(article) LIKE ?', ['%' . trim(strtolower($this->request->get('article'))) . '%']);
    }

    public function display(): array
    {
        return [
            Input::make('article')
                ->type('text')
                ->value(!is_null($this->request->get('art')) ? $this->request->get('article'): null)
                ->title($this->name())
        ];
    }
}
