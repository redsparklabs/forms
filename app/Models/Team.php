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

protected $with = ['events'];
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
     * Responses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function responses()
    {
        return $this->hasMany(Responses::class);
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
     * Get the latest event
     *
     * @return \App\Models\Event|null
     */
    public function latestEvent()
    {
        return $this->events->sortByDesc('date')->reject(function($event) {
            return $event->progressMetric($this) == 0;
        })->first();
    }

    /**
     * Get all team members.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members()
    {
        return $this->belongsToMany(User::class, 'team_user', 'team_id', 'user_id')
            ->using(TeamMember::class)
            ->withPivot(['role', 'status', 'email', 'invitation_token', 'invitation_sent_at'])
            ->withTimestamps();
    }

    /**
     * Get all active team members.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activeMembers()
    {
        return $this->members()->wherePivot('status', TeamMember::STATUS_ACTIVE);
    }

    /**
     * Get all pending team member invitations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pendingInvitations()
    {
        return $this->members()->wherePivot('status', TeamMember::STATUS_INVITED);
    }

    /**
     * Get the owner of the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function owner()
    {
        return $this->members()
            ->wherePivot('role', TeamMember::ROLE_OWNER);
    }

    /**
     * Get the owner user of the team.
     *
     * @return \App\Models\User|null
     */
    public function getOwnerAttribute()
    {
        return $this->owner()->first();
    }

    /**
     * Get all team leads.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function leads()
    {
        return $this->members()
            ->wherePivot('role', TeamMember::ROLE_LEAD);
    }

    /**
     * Check if the given user is a member of this team.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function hasMember(User $user)
    {
        return $this->members()->where('user_id', $user->id)->exists();
    }

    /**
     * Check if the given user is the owner of this team.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function isOwnedBy(User $user)
    {
        return $this->members()
            ->where('user_id', $user->id)
            ->wherePivot('role', TeamMember::ROLE_OWNER)
            ->exists();
    }
}
