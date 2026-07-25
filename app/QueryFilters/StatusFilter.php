<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class StatusFilter extends QueryFilter
{
    public function __construct(
        protected ?string $status,
    ) {}

    protected function shouldApply(): bool
    {
        return filled($this->status);
    }

    protected function apply(Builder $query): void
    {
        $query->where('status', $this->status);
    }
}
