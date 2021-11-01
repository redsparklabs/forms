<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;
use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;

class FormQuestion extends Pivot implements Sortable
{
    use SortableTrait;

    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    protected static function boot()
    {
        parent::boot();
        static::deleted(function (Sortable $model) {
            static::setNewOrder($model->buildSortQuery()->pluck($model->primaryKey)->toArray());
        });
    }
}
