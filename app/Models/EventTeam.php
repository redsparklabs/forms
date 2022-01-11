<?php

namespace App\Models;

use App\Models\Team;
use Illuminate\Support\Str;
use App\Models\Organization;
use Illuminate\Support\Facades\Crypt;

use Illuminate\Database\Eloquent\Relations\Pivot;


class EventTeam extends Pivot
{

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $fillable = [

    ];
}
