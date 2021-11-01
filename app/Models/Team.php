<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Events\CreateTeam;
use App\Events\DeleteTeam;
use Laravel\Jetstream\Events\TeamCreated;
use Laravel\Jetstream\Events\TeamDeleted;
use Laravel\Jetstream\Events\TeamUpdated;
use Laravel\Jetstream\Team as JetstreamTeam;
use App\Models\Club;
use App\Models\Form;

class Team extends JetstreamTeam
{
    use HasFactory;

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'personal_team' => 'boolean',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'personal_team',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' =>  CreateTeam::class,
        'updated' => TeamUpdated::class,
        'deleted' => DeleteTeam::class,
    ];

    public function clubs()
    {
        return $this->hasMany(Club::class);
    }

    public function forms()
    {
        return $this->hasMany(Form::class)->latest();
    }

    public function questions()
    {
        return $this->hasMany(Question::class);
    }
}
