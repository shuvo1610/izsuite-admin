<?php

namespace App\QueryFilters;

use Illuminate\Database\Eloquent\Builder;

class SearchFilter extends QueryFilter
{
    /**
     * @param  string|null  $search  The search term
     * @param  array  $columns  Columns to search in (e.g. ['name', 'email'])
     * @param  array  $relations  Relations to search in (e.g. ['user' => ['name', 'email']])
     */
    public function __construct(
        protected ?string $search,
        protected array $columns = [],
        protected array $relations = [],
    ) {}

    protected function shouldApply(): bool
    {
        return filled($this->search);
    }

    protected function apply(Builder $query): void
    {
        $search = $this->search;

        $query->where(function (Builder $q) use ($search) {
            foreach ($this->columns as $column) {
                $q->orWhere($column, 'like', "%{$search}%");
            }

            foreach ($this->relations as $relation => $columns) {
                $q->orWhereHas($relation, function (Builder $sub) use ($search, $columns) {
                    $sub->where(function (Builder $inner) use ($search, $columns) {
                        foreach ($columns as $col) {
                            $inner->orWhere($col, 'like', "%{$search}%");
                        }
                    });
                });
            }
        });
    }
}
