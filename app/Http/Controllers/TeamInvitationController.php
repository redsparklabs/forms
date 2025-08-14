<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamMember;
use App\Models\User;
use App\Notifications\TeamInvitationNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class TeamInvitationController extends Controller
{
    /**
     * Accept a team invitation.
     *
     * @param  \App\Models\Team  $team
     * @param  string  $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function accept(Team $team, string $token)
    {
        // Find the invitation by token
        $invitation = TeamMember::where('invitation_token', $token)
            ->where('invitation_sent_at', '>=', now()->subDays(7))
            ->firstOrFail();

        $team = $invitation->team;
        
        // If user is not authenticated, redirect to register with the invitation token
        if (!auth()->check()) {
            return redirect()->route('register', ['invitation' => $token]);
        }

        $user = auth()->user();
        
        // If the invitation email doesn't match the authenticated user's email
        if (strtolower($invitation->email) !== strtolower($user->email)) {
            return redirect()->route('dashboard')
                ->with('error', 'The invitation was sent to a different email address.');
        }

        // Update the invitation to mark it as accepted
        $invitation->update([
            'user_id' => $user->id,
            'status' => TeamMember::STATUS_ACTIVE,
            'invitation_token' => null,
            'invitation_sent_at' => null,
        ]);

        return redirect()->route('teams.show', $team)
            ->with('status', 'You have successfully joined the team.');
    }

    /**
     * Resend an invitation email.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @param  int  $invitationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function resend(Request $request, Team $team, int $invitationId)
    {
        $this->authorize('manageMembers', $team);
        
        $invitation = $team->members()->findOrFail($invitationId);
        
        if ($invitation->status !== TeamMember::STATUS_INVITED) {
            throw ValidationException::withMessages([
                'invitation' => 'This invitation has already been accepted.'
            ]);
        }

        $this->sendInvitation($team, $invitation->email, $invitation->role);
        
        return back()->with('status', 'Invitation has been resent.');
    }

    /**
     * Revoke an invitation.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @param  int  $invitationId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function revoke(Request $request, Team $team, int $invitationId)
    {
        $this->authorize('manageMembers', $team);
        
        $invitation = $team->members()->findOrFail($invitationId);
        
        // Only allow revoking pending invitations
        if ($invitation->status === TeamMember::STATUS_INVITED) {
            $invitation->delete();
            return back()->with('status', 'Invitation has been revoked.');
        }
        
        return back()->with('error', 'Cannot revoke an accepted invitation.');
    }

    /**
     * Send an invitation to join the team.
     *
     * @param  \App\Models\Team  $team
     * @param  string  $email
     * @param  string  $role
     * @return \App\Models\TeamMember
     */
    protected function sendInvitation(Team $team, string $email, string $role = TeamMember::ROLE_MEMBER)
    {
        $invitation = TeamMember::firstOrNew([
            'team_id' => $team->id,
            'email' => $email,
        ]);

        // If this is a new invitation or the previous one has expired
        if (!$invitation->exists || $invitation->isExpired()) {
            $invitation->invitation_token = Str::random(32);
            $invitation->invitation_sent_at = now();
        }

        $invitation->role = $role;
        $invitation->status = TeamMember::STATUS_INVITED;
        $invitation->save();

        // Send notification to the email address
        $user = User::where('email', $email)->first();
        
        if ($user) {
            $user->notify(new TeamInvitationNotification($team, $invitation->invitation_token));
        } else {
            // For non-users, we'd typically send an email with a registration link
            // For now, we'll just log it
            \Log::info("Invitation sent to non-user: {$email}");
        }

        return $invitation;
    }

    /**
     * Invite a new member to the team.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Team  $team
     * @return \Illuminate\Http\RedirectResponse
     */
    public function invite(Request $request, Team $team)
    {
        $this->authorize('inviteMembers', $team);
        
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'role' => ['required', Rule::in([
                TeamMember::ROLE_MEMBER,
                TeamMember::ROLE_LEAD,
                TeamMember::ROLE_OWNER,
            ])],
        ]);

        // Check if the user is already a member
        $existingMember = $team->members()
            ->where('email', $validated['email'])
            ->orWhereHas('user', function ($query) use ($validated) {
                $query->where('email', $validated['email']);
            })
            ->first();

        if ($existingMember) {
            if ($existingMember->status === TeamMember::STATUS_ACTIVE) {
                throw ValidationException::withMessages([
                    'email' => 'This user is already a member of the team.'
                ]);
            }

            // Resend invitation if it's pending
            $this->resend($request, $team, $existingMember->id);
            return back()->with('status', 'Invitation has been resent.');
        }

        $this->sendInvitation($team, $validated['email'], $validated['role']);
        
        return back()->with('status', 'Invitation has been sent.');
    }
}
