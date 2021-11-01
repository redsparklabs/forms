<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Form;
use App\Models\Question;

class Responses extends Model
{
    use HasFactory;

    protected $fillable = [
        'response', 'form_id',
    ];

    protected $casts = [
        'response' => 'array'
    ];

    public function form()
    {
        return $this->belongsTo(Form::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public function getEmailAttribute()
    {
        return $this->response['email'];
    }

    public function getTeamAttribute()
    {
        return $this->response['club'];
    }

    public function getQuestionsAttribute()
    {
        return $this->response['questions'];
    }

    public function getResponseCollectionAttribute()
    {
        return collect($this->response['questions']);
    }
}
