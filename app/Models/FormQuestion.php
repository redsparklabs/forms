<?php

namespace App\Models;

use Spatie\EloquentSortable\Sortable;
use Spatie\EloquentSortable\SortableTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\Pivot;

class FormQuestion extends Pivot implements Sortable
{
    use SortableTrait;
    use SoftDeletes;

    protected $table = 'form_question';
    protected $primaryKey = 'id';
    public $incrementing = true;

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $sortable = [
        'order_column_name' => 'order',
        'sort_when_creating' => true,
    ];

    /**
     * Boot the model
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();
        static::deleted(function (Sortable $model) {
            static::setNewOrder($model->buildSortQuery()->pluck($model->primaryKey)->toArray());
        });
    }
    
    // Ensure sorting is scoped per form
    public function buildSortQuery()
    {
        return static::query()->where('form_id', $this->form_id)->orderBy($this->sortable['order_column_name']);
    }
}
