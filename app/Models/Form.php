<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Team;
use App\Models\Organization;
use Spatie\Tags\HasTags;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class Form extends Model
{
    use HasFactory, HasTags;

    /**
     * Route Key
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Filleable attributes
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'description'
    ];

    /**
     * Boot the model
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        static::created(function ($model) {
            $slug = Str::of(Crypt::encrypt(implode(',', [$model->name, $model->created_at, $model->id])))->limit(40, '');
            $model->slug = $slug;
            $model->save();
        });
    }

    /**
     * Questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('order')->withTimestamps()->using(FormQuestion::class);
    }

    /**
     * Responses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses()
    {
        return $this->hasMany(Responses::class);
    }

    /**
     * Organizations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class)->withTimestamps();
    }

    /**
     * Teams
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }

    /**
     * Get Tags
     *
     * @return string
     */
    public function getTagStringAttribute()
    {
        return $this->tags->pluck('name')->implode(',', 'name');
    }
}
