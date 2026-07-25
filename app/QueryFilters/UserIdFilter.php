<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class UserIdFilter extends QueryFilter
{
    public function __construct(
        protected ?int $userId,
    ) {}

    protected function shouldApply(): bool
    {
        return filled($this->userId);
    }

    protected function apply(Builder $query): void
    {
        $query->where('user_id', $this->userId);
    }
}
