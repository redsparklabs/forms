<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Responses;
use Illuminate\Support\Str;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = ['start_date', 'estimated_launch_date'];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'start_date',
        'priority_level',
        'description',
        'minimum_success_criteria',
        'estimated_launch_date',
        'sponsor',
    ];

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
     * Get the events
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events()
    {
        return $this->belongsToMany(Event::class)->using(EventTeam::class)->withPivot('net_projected_value', 'investment');
    }

    /**
     * Get the default profile photo URL if no profile photo has been uploaded.
     *
     * @return string
     */
    public function getTeamImageAttribute()
    {
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the progress percentage.
     *
     * @param  Event $event
     * @return string|void
     */
    public function progressMetric(Event $event)
    {
        // Grab latest form
        $data = calculateSections($event, $this);

        if ($data) {
            return number_format($data['progressMetricTotal'], 1);
        }
    }

    /**
     * Get the latest event
     *
     * @return \App\Models\Event|null
     */
    public function latestEvent()
    {
        return $this->events()->latest('date')->first();
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
     * Get the latest form
     *
     * @return \App\Models\Form
     */
    public function latestform()
    {
        return $this->latestEvent()?->forms()->latest()->first();
    }

    /**
     * Get the progress metric total.
     *
     * @return void|string
     */
    public function getLatestProgressMetricAttribute()
    {
        if ($this->events->isNotEmpty()) {

            $data = calculateSections($this->latestEvent(), $this);

            if ($data) {
                return number_format($data['progressMetricTotal'], 1);
            }
        }
    }

    public function stage()
    {
        $metric = $this->latest_progress_metric;
        foreach(config('stages') as $stage) {
            if($metric >= $stage['start_scale'] && $metric <= $stage['end_scale']) {
                return (object) $stage;
            }
        }
    }
    /**
     * Get the pivot table name for the team and event relationship.
     *
     * @return string
     */
    public function latestpivot()
    {
        return $this->latestEvent()?->pivot;
    }
}
