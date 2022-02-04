<?php

namespace App\Traits;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

trait Searchable
{
    /**
     * Search the model.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param array $columns
     * @param array $relativeTables
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch(Builder $query, $keyword, $columns = [], $relativeTables = [])
    {
        if (empty($columns)) {
            $columns = Arr::except(Schema::getColumnListing($this->getTable()), $this->guarded);
        }

        $query->when($keyword, function ($query) use ($keyword, $columns, $relativeTables) {
            
            $query->where(function ($query) use ($keyword, $columns, $relativeTables) {
                foreach ($columns as $key => $column) {
                    $clause = $key == 0 ? 'where' : 'orWhere';
                    $query->$clause($column, 'LIKE', "%$keyword%");

                    if (!empty($relativeTables)) {
                        $this->filterByRelationship($query, $keyword, $relativeTables);
                    }
                }
            });
        });

        return $query;
    }

    /**
     * Filter the query by a relationship.
     *
     * @param object $query
     * @param string $keyword
     * @param object $relativeTables
     * @return void
     */
    private function filterByRelationship($query, $keyword, $relativeTables)
    {
        foreach ($relativeTables as $relationship => $relativeColumns) {
            $query->orWhereHas($relationship, function ($relationQuery) use (
                $keyword,
                $relativeColumns
            ) {
                foreach ($relativeColumns as $key => $column) {
                    $clause = $key == 0 ? 'where' : 'orWhere';
                    $relationQuery->$clause($column, 'LIKE', "%$keyword%");
                }
            });
        }

        return $query;
    }
}
