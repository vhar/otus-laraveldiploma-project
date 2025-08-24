<?php

namespace App\Orchid\Filters\Marketplaces\Ozon;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateRange;
use Carbon\Carbon;

class OzonCreatedAtRangeFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Добавлен(а)';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['created'];
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
        return $builder->whereHas('onOzon', function (Builder $query) {
            $query
                ->where('created_at', '>', date("Y-m-d", strtotime($this->request->get('created')['start'] ?? '1970-01-01')))
                ->where('created_at', '<', date("Y-m-d", strtotime($this->request->get('created')['end'] ?? Carbon::now()) + 86400));
        });
    }

    /**
     * Get the display fields.
     *
     * @return Field[]
     */
    public function display(): array
    {
        return [
            DateRange::make('created')
                ->title($this->name())
                ->format('Y-m-d')
                ->empty()
                ->value([
                    'start' => $this->request->get('created')['start'] ?? null,
                    'end'   => $this->request->get('created')['end'] ?? null
                ])
        ];
    }
}
