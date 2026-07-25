<?php

namespace App\QueryFilters;

use Closure;
use Illuminate\Database\Eloquent\Builder;

abstract class QueryFilter
{
    /**
     * Handle the pipeline stage.
     */
    public function handle(Builder $query, Closure $next): Builder
    {
        if (! $this->shouldApply()) {
            return $next($query);
        }

        $this->apply($query);

        return $next($query);
    }

    /**
     * Determine if the filter should be applied.
     */
    abstract protected function shouldApply(): bool;

    /**
     * Apply the filter to the query.
     */
    abstract protected function apply(Builder $query): void;
}
