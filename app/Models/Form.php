<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Question;
use App\Models\Event;
use App\Models\Organization;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class Form extends Model
{
    use HasFactory;

    /**
     * Filleable attributes
     *
     * @var string[]
     */
    protected $fillable = [
        'name',
        'description'
    ];


    /**
     * Questions
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function questions()
    {
        return $this->belongsToMany(Question::class)->withPivot('order')->withTimestamps()->using(FormQuestion::class);
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
     * Organizations
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function organizations()
    {
        return $this->belongsToMany(Organization::class)->withTimestamps();
    }

    /**
     * Events
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function events()
    {
        return $this->hasMany(Event::class)->withTimestamps();
    }
}
