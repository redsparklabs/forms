<?php

namespace App\Models;

use App\Models\Team;
use App\Models\Responses;
use App\Models\EventTeam;
use Illuminate\Support\Str;
use App\Traits\Searchable;
use App\Models\Organization;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Event extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = ['date'];
    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [];

    protected $with = ['responses', 'forms'];
    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'slug',
        'date',
        'department'
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
     * Get the latest form
     *
     * @return \App\Models\Form|null
     */
    public function latestForm()
    {
        return $this->forms->sortBy('created_at')->first();
    }


    /**
     * Grab the current stage
     *
     * @return object|null
     */
    public function stage($metric)
    {
        foreach(config('stages') as $stage) {
            if($metric >= $stage['start_scale'] && $metric <= $stage['end_scale']) {
                return (object) $stage;
            }
        }
    }

    /**
     * Get the progress metric total.
     *
     * @param  Team $team
     * @return void|string
     */
    public function progressMetric(Team $team)
    {
        $data = calculateSections($this, $team);

        if($data) {
            return number_format($data['progressMetricTotal'], 1);
        }
    }

    /**
     * Get the owner of the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class)->using(EventTeam::class)->withPivot('net_projected_value', 'investment');
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
}
