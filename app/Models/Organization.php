<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Events\OrganizationCreated;
use App\Events\OrganizationDeleted;
use App\Events\OrganizationUpdated;
use App\Models\Event;
use App\Models\Form;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'personal_organization' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'personal_organization',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => OrganizationCreated::class,
        'updated' => OrganizationUpdated::class,
        'deleted' => OrganizationDeleted::class,
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function teams()
    {
        return $this->hasMany(Team::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function forms()
    {
        return $this->hasMany(Form::class)->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class)->latest();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    /**
     * Get the owner of the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get all of the team's users including its owner.
     *
     * @return \Illuminate\Support\Collection
     */
    public function allUsers()
    {
        return $this->users->merge([$this->owner]);
    }

    /**
     * Get all of the users that belong to the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, Membership::class)
            ->withPivot('role')
            ->withTimestamps()
            ->as('membership');
    }


    /**
     * Determine if the given user belongs to the team.
     *
     * @param  \App\Models\User  $user
     * @return bool
     */
    public function hasUser($user)
    {
        return $this->users->contains($user) || $user->ownsOrganization($this);
    }

    /**
     * Determine if the given email address belongs to a user on the team.
     *
     * @param  string  $email
     * @return bool
     */
    public function hasUserWithEmail(string $email)
    {
        return $this->allUsers()->contains(function ($user) use ($email) {
            return $user->email === $email;
        });
    }

    /**
     * Determine if the given user has the given permission on the team.
     *
     * @param  \App\Models\User  $user
     * @param  string  $permission
     * @return bool
     */
    public function userHasPermission($user, $permission)
    {
        return $user->hasOrganizationPermission($this, $permission);
    }

    /**
     * Get all of the pending user invitations for the team.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function organizationInvitations()
    {
        return $this->hasMany(OrganizationInvitation::class);
    }

    /**
     * Remove the given user from the team.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function removeUser($user)
    {
        if ($user->current_organization_id === $this->id) {
            $user->forceFill([
                'current_organization_id' => null,
            ])->save();
        }

        $this->users()->detach($user);
    }

    /**
     * Purge all of the organization's resources.
     *
     * @return void
     */
    public function purge()
    {
        $this->owner()->where('current_organization_id', $this->id)
            ->update(['current_organization_id' => null]);

        $this->users()->where('current_organization_id', $this->id)
            ->update(['current_organization_id' => null]);

        $this->users()->detach();

        $this->delete();
    }
}
