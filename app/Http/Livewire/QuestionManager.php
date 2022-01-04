<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use App\Actions\CreateQuestion;
use App\Actions\DestroyQuestion;
use App\Actions\UpdateQuestion;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;

class QuestionManager extends BaseComponent
{
    /**
     * @var array
     */
    protected $listeners = [
        'updated' => 'render',
        'created' => 'render',
        'destroyed' => 'render',
    ];

    /**
     * @var string
     */
    public $componentName = 'Question';

    /**
     * @var \App\Models\Organization
     */
    public $organization;

    /**
     *
     * @var \App\Models\User|null
     */
    public $user;

    /**
     * @var array
     */
    public $createForm = [
        'question' => '',
        'description' => ''
    ];

    /**
     * @var array
     */
    public $updateForm = [
        'question' => '',
        'description' => ''
    ];

    /**
     * @param  Organization $organization
     * @return void
     */
    public function mount(Organization $organization)
    {
        $this->user = Auth::user();
        $this->organization = $organization;
    }

    /**
     * @return void
     */
    public function createAction()
    {
        CreateQuestion::run(
            $this->user,
            $this->organization,
            $this->createForm,
        );
    }

    /**
     * @return void
     */
    public function confirmUpdateAction()
    {

        $question = $this->organization->questions()->findOrFail($this->idBeingUpdated);

        $this->updateForm = [
            'question' => $question->question,
            'description' => $question->description
        ];
    }

    /**
     * @return void
     */
    public function updateAction()
    {
        UpdateQuestion::run(
            $this->user,
            $this->organization,
            $this->organization->questions()->findOrFail($this->idBeingUpdated),
            $this->updateForm
        );
    }

    /**
     * @return void
     */
    public function destroyAction()
    {
        DestroyQuestion::run(
            $this->user,
            $this->organization,
            $this->organization->questions()->findOrFail($this->idBeingDestroyed)
        );
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.questions-manager');
    }
}
