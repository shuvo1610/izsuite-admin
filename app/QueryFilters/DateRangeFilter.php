<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class DateRangeFilter extends QueryFilter
{
    public function __construct(
        protected ?string $from,
        protected ?string $to,
        protected string $column = 'created_at',
    ) {}

    protected function shouldApply(): bool
    {
        return filled($this->from) || filled($this->to);
    }

    protected function apply(Builder $query): void
    {
        if (filled($this->from)) {
            $query->whereDate($this->column, '>=', $this->from);
        }

        if (filled($this->to)) {
            $query->whereDate($this->column, '<=', $this->to);
        }
    }
}
