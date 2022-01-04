<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use App\Actions\CreateQuestion;
use App\Actions\DestroyQuestion;
use App\Actions\UpdateQuestion;
use App\Models\Organization;

class QuestionManager extends BaseComponent
{
    protected $listeners = [
        'updated' => 'render',
        'created' => 'render',
        'destroyed' => 'render',
    ];

    public $componentName = 'Question';

    public $organization;

    public $createForm = [
        'question' => '',
        'description' => ''
    ];

    public $updateForm = [
        'question' => '',
        'description' => ''
    ];

    public function mount(Organization $organization)
    {
        $this->organization = $organization;
    }

    public function createAction()
    {
        CreateQuestion::run(
            $this->user,
            $this->organization,
            $this->createForm,
        );
    }

    public function confirmUpdateAction()
    {

        $question = $this->organization->questions()->findOrFail($this->idBeingUpdated);

        $this->updateForm = [
            'question' => $question->question,
            'description' => $question->description
        ];
    }

    public function updateAction()
    {
        UpdateQuestion::run(
            $this->user,
            $this->organization,
            $this->organization->questions()->findOrFail($this->idBeingUpdated),
            $this->updateForm
        );
    }

    public function destroyAction()
    {
        DestroyQuestion::run(
            $this->user,
            $this->organization,
            $this->organization->questions()->findOrFail($this->idBeingDestroyed)
        );
    }

    public function render()
    {
        return view('livewire.questions-manager');
    }
}
