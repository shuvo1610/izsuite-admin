<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class PriorityFilter extends QueryFilter
{
    public function __construct(
        protected ?string $priority,
    ) {}

    protected function shouldApply(): bool
    {
        return filled($this->priority);
    }

    protected function apply(Builder $query): void
    {
        $query->where('priority', $this->priority);
    }
}
