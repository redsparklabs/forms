<?php

namespace App\Models\Traits;

trait DebugUserCreation
{
    protected static function bootDebugUserCreation()
    {
        static::saving(function ($model) {
            \Log::debug('User::saving - Model attributes:', $model->attributesToArray());
            \Log::debug('User::saving - Original attributes:', $model->getOriginal());
        });

        static::saved(function ($model) {
            \Log::debug('User::saved - Model saved:', [
                'id' => $model->id,
                'name' => $model->name,
                'email' => $model->email,
                'exists' => $model->exists,
                'wasRecentlyCreated' => $model->wasRecentlyCreated,
            ]);
        });

        static::creating(function ($model) {
            \Log::debug('User::creating - Model attributes:', $model->attributesToArray());
            \Log::debug('User::creating - Fillable:', $model->getFillable());
            \Log::debug('User::creating - Is name fillable?', ['is_fillable' => in_array('name', $model->getFillable())]);
        });
    }
}
