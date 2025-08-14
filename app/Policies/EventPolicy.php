<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EventPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any events.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        // Organization admins can view all events in their organization
        if ($user->allOrganizations()->count() > 0) {
            return true;
        }
        
        // Project-scoped team members can view events for their teams
        return true; // We'll filter in the component based on team membership
    }

    /**
     * Determine whether the user can view the event.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public function view(User $user, Event $event)
    {
        // Organization admins can view any event in their organization
        if ($user->hasOrganizationRole($event->organization, 'admin')) {
            return true;
        }
        
        // Team members can view events for their teams
        return $event->teams()->whereHas('members', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        })->exists();
    }

    /**
     * Determine whether the user can create events.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        // Only organization admins can create events
        return $user->allOrganizations()->count() > 0;
    }

    /**
     * Determine whether the user can update the event.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public function update(User $user, Event $event)
    {
        // Organization admins can update any event in their organization
        if ($user->hasOrganizationRole($event->organization, 'admin')) {
            return true;
        }
        
        // Team leads can update events for their teams
        return $event->teams()->whereHas('members', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('role', \App\Models\TeamMember::ROLE_LEAD);
        })->exists();
    }

    /**
     * Determine whether the user can delete the event.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Event  $event
     * @return mixed
     */
    public function delete(User $user, Event $event)
    {
        // Organization admins can delete any event in their organization
        if ($user->hasOrganizationRole($event->organization, 'admin')) {
            return true;
        }
        
        // Team leads can delete events for their teams
        return $event->teams()->whereHas('members', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                  ->where('role', \App\Models\TeamMember::ROLE_LEAD);
        })->exists();
    }
}
