<?php

namespace App\Models;

use App\Models\Event;
use App\Models\Question;
use Illuminate\Support\Str;
use App\Models\Organization;
use App\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Form extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Searchable;

    /**
     * The attributes that are dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

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
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class)->withTimestamps();
    }


    /**
     * Feedback questions
     *
     * @return array
     */

    public function allQuestions()
    {
        $customQuestion = $this->questions->map(function ($item) {
            return [
                'question' => $item['question'],
                'description' => $item['description'],
                'color' => '',
                'section' => 'custom'
            ];
        })->toArray();

        $questions = array_merge(config('questions.business-model'), config('questions.qualitative-intuitive-scoring'), $customQuestion);

        $questions = collect($questions)->reject(fn ($item) => $item['section'] == 'custom');

        return $questions;
    }

    /**
     * Feedback questions
     *
     * @return array
     */
    public function feedbackQuestions()
    {
        return config('questions.qualitative-intuitive-scoring-feedback');
    }
}
