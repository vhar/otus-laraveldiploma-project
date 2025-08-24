<?php

namespace App\Orchid\Filters\Marketplaces\Ozon;

use Illuminate\Database\Eloquent\Builder;
use Orchid\Filters\Filter;
use Orchid\Screen\Field;
use Orchid\Screen\Fields\DateRange;
use Carbon\Carbon;

class OzonPictureUploadedAtRangeFilter extends Filter
{
    /**
     * The displayable name of the filter.
     *
     * @return string
     */
    public function name(): string
    {
        return 'Картинки загружены';
    }

    /**
     * The array of matched parameters.
     *
     * @return array|null
     */
    public function parameters(): ?array
    {
        return ['uploaded'];
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
                ->where('picture_upload_at', '>', date("Y-m-d", strtotime($this->request->get('uploaded')['start'] ?? '1970-01-01')))
                ->where('picture_upload_at', '<', date("Y-m-d", strtotime($this->request->get('uploaded')['end'] ?? Carbon::now()) + 86400));
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
            DateRange::make('uploaded')
                ->title($this->name())
                ->format('Y-m-d')
                ->empty()
                ->value([
                    'start' => $this->request->get('uploaded')['start'] ?? null,
                    'end'   => $this->request->get('uploaded')['end'] ?? null
                ])
        ];
    }
}
