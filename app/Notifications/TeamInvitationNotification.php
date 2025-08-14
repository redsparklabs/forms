<?php

namespace App\Notifications;

use App\Models\Team;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;
use Illuminate\Support\Str;

class TeamInvitationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    /**
     * The team instance.
     *
     * @var \App\Models\Team
     */
    public $team;

    /**
     * The invitation token.
     *
     * @var string
     */
    public $token;

    /**
     * Create a new notification instance.
     *
     * @param  \App\Models\Team  $team
     * @param  string  $token
     * @return void
     */
    public function __construct(Team $team, string $token)
    {
        $this->team = $team;
        $this->token = $token;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $appName = config('app.name');
        $acceptUrl = route('team-invitations.accept', ['team' => $this->team->id, 'token' => $this->token]);
        $teamName = e($this->team->name);
        $inviterName = $this->team->owner?->name ?? 'A team member';
        
        return (new MailMessage)
            ->subject("You've been invited to join {$teamName}")
            ->greeting("Hello!")
            ->line("You have been invited by {$inviterName} to join the team **{$teamName}** on {$appName}.")
            ->line('This invitation will expire in 7 days.')
            ->action('Accept Invitation', $acceptUrl)
            ->line('If you did not expect to receive an invitation to this team, you may discard this email.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            'team_id' => $this->team->id,
            'team_name' => $this->team->name,
            'token' => $this->token,
        ];
    }
}
