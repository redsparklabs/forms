<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use App\Traits\HasOrganizations;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Traits\DebugUserCreation;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use HasOrganizations;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use DebugUserCreation;
    
    /**
     * Set the user's name.
     *
     * @param  string  $value
     * @return void
     */
    public function setNameAttribute($value)
    {
        \Log::debug('Setting name attribute', [
            'old_name' => $this->attributes['name'] ?? null,
            'new_name' => $value,
            'caller' => debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS, 2)[1] ?? null
        ]);
        
        $this->attributes['name'] = $value;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * The teams that belong to the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teams()
    {
        return $this->belongsToMany(Team::class, 'team_user')
            ->using(TeamMember::class)
            ->withPivot(['role', 'status', 'email', 'invitation_token', 'invitation_sent_at'])
            ->withTimestamps();
    }

    /**
     * Get all teams where the user has the given role.
     *
     * @param  string  $role
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function teamsWithRole(string $role)
    {
        return $this->teams()->wherePivot('role', $role);
    }

    /**
     * Get all teams where the user is an owner.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function ownedTeams()
    {
        return $this->teamsWithRole(TeamMember::ROLE_OWNER);
    }

    /**
     * Get all teams where the user is a lead.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function leadTeams()
    {
        return $this->teamsWithRole(TeamMember::ROLE_LEAD);
    }

    /**
     * Get all teams where the user is a member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function memberTeams()
    {
        return $this->teamsWithRole(TeamMember::ROLE_MEMBER);
    }

    /**
     * Get all active team memberships.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function activeTeams()
    {
        return $this->teams()->wherePivot('status', TeamMember::STATUS_ACTIVE);
    }

    /**
     * Get all pending team invitations.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pendingTeamInvitations()
    {
        return $this->teams()->wherePivot('status', TeamMember::STATUS_INVITED);
    }

    /**
     * Check if the user is a member of the given team.
     *
     * @param  \App\Models\Team  $team
     * @return bool
     */
    public function isMemberOf(Team $team): bool
    {
        return $this->teams()->where('teams.id', $team->id)->exists();
    }

    /**
     * Check if the user has the given role on the team.
     *
     * @param  \App\Models\Team  $team
     * @param  string  $role
     * @return bool
     */
    public function hasTeamRole(Team $team, string $role): bool
    {
        return $this->teams()
            ->where('teams.id', $team->id)
            ->wherePivot('role', $role)
            ->exists();
    }

    /**
     * Check if the user can manage the given team.
     *
     * @param  \App\Models\Team  $team
     * @return bool
     */
    public function canManageTeam(Team $team): bool
    {
        // Organization admins can manage any team in their organization
        if ($this->hasOrganizationRole($team->organization, 'admin')) {
            return true;
        }
        
        // Team owners and leads can manage their team
        return $this->hasTeamRole($team, TeamMember::ROLE_OWNER) || 
               $this->hasTeamRole($team, TeamMember::ROLE_LEAD);
    }
}
