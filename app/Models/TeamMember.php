<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeamMember extends Pivot
{
    // Role constants
    public const ROLE_OWNER = 'owner';
    public const ROLE_LEAD = 'lead';
    public const ROLE_MEMBER = 'member';

    // Status constants
    public const STATUS_INVITED = 'invited';
    public const STATUS_ACTIVE = 'active';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'team_user';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'team_id',
        'user_id',
        'email',
        'role',
        'status',
        'invitation_token',
        'invitation_sent_at'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'invitation_sent_at' => 'datetime',
    ];

    /**
     * Get the user that owns the team member.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
