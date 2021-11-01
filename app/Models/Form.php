<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Team;
use App\Models\Club;
use App\Models\Organization;
use Spatie\Tags\HasTags;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class Form extends Model
{
    use HasFactory, HasTags;

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $slug = Str::of(Crypt::encrypt(implode(',', [$model->name, $model->created_at, $model->id])))->limit(40, '');
            $model->slug = $slug;
            $model->save();
        });
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('order')->withTimestamps()->using(FormQuestion::class);
    }

    public function responses()
    {
        return $this->hasMany(Responses::class);
    }

    public function organizations()
    {
        return $this->belongsToMany(Organization::class)->withTimestamps();
    }

    public function clubs()
    {
        return $this->belongsToMany(Club::class);
    }

    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    public function getTagStringAttribute()
    {
        return $this->tags->pluck('name')->implode(',', 'name');
    }
}
