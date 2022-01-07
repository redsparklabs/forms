<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Form;
use App\Models\Team;
use App\Models\Event;
use App\Models\Question;
use Illuminate\Support\Arr;

class Responses extends Model
{
    use HasFactory;

    /**
     * @var string[]
     */
    protected $fillable = [
        'response', 'form_id',
    ];

    /**
     * @var string[]
     */
    protected $casts = [
        'response' => 'array'
    ];


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function team()
    {
        return $this->belongsTo(Team::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function form()
    {
        return $this->belongsTo(Form::class);
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function event()
    {
        return $this->belongsTo(Event::class);
    }
    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|null
     */
    public function getEmailAttribute()
    {
        if($this->response) {
            return Arr::get($this->response, 'email');
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|null
     */
    public function getQuestionsAttribute()
    {
        if($this->response) {
            return Arr::get($this->response, 'questions');
        }
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getResponseCollectionAttribute()
    {
        return collect($this->questions);
    }
}
