<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use App\Actions\CreateQuestion;
use App\Actions\DestroyQuestion;
use App\Actions\UpdateQuestion;
use App\Models\Question;
use App\Models\Team;

class QuestionManager extends BaseComponent
{

    public $componentName = 'Question';

    public $team;

    public $createForm = [
        'question' => '',
        'description' => ''
    ];

    public $updateForm = [
        'question' => '',
        'description' => ''
    ];

    public function mount(Team $team)
    {
        $this->team = $team;
    }

    public function createAction()
    {
        CreateQuestion::run(
            $this->user,
            $this->team,
            $this->createForm,
        );
    }

    public function confirmUpdateAction()
    {
        $question = $this->team->questions()->findOrFail($this->idBeingUpdated);

        $this->updateForm = [
            'question' => $question->question,
            'description' => $question->description
        ];
    }

    public function updateAction()
    {
        UpdateQuestion::run(
            $this->user,
            $this->team,
            $this->team->questions()->findOrFail($this->idBeingUpdated),
            $this->updateForm
        );
    }

    public function destroyAction()
    {
        DestroyQuestion::run(
            $this->user,
            $this->team,
            $this->team->questions()->findOrFail($this->idBeingUpdated)
        );
    }

    public function render()
    {
        return view('livewire.questions-manager');
    }
}
