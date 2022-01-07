<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Team;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class Event extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug'
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
     * Get the owner of the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }


    /**
     * Get the owner of the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function forms()
    {
        return $this->belongsToMany(Form::class);
    }

        /**
     * Get the owner of the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class);
    }
}
