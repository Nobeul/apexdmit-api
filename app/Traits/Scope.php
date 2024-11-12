<?php

namespace App\Traits;

trait Scope
{
     /**
     * Scope a query to search a column with LIKE.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $column
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWhereLike($query, $column, $value)
    {
        return $query->where($column, 'like', "%{$value}%");
    }
}
