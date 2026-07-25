<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class ActionFilter extends QueryFilter
{
    public function __construct(
        protected ?string $action,
    ) {}

    protected function shouldApply(): bool
    {
        return filled($this->action);
    }

    protected function apply(Builder $query): void
    {
        $query->where('action', $this->action);
    }
}
