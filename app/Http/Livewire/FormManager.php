<?php

namespace App\Http\Livewire;

use App\Actions\CreateForm;
use App\Actions\DestroyForm;
use App\Actions\UpdateForm;
use App\Models\Organization;
use App\Models\Form;
use App\Models\FormQuestion;
use App\Http\Livewire\BaseComponent;
use Illuminate\Support\Facades\Auth;

class FormManager extends BaseComponent
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
     * @var \App\Models\Organization
     */
    public $organization;

    /**
     * @var string
     */
    public $componentName = 'Form';

    /**
     * @var \App\Models\User|null
     */
    public $user;

    /**
     * @var array
     */
    public $createForm = [
        'name' => '',
        'description' => '',
    ];

    /**
     * @var array
     */
    public $updateForm = [
        'name' => '',
        'description' => '',
    ];

    /**
     * @var array
     */
    public $rules = [
        'createForm.name' => 'required',
        'createForm.description' => 'required',
    ];

    /**
     * @var array
     */
    protected $messages = [
        'createForm.name.required' => 'Please enter a name.',
        'createForm.description.required' => 'Please enter a description.',
    ];

    /**
     * @var null|\Illuminate\Support\Collection|null
     */
    public $assignedQuestions = null;

    /**
     * @var null|\Illuminate\Support\Collection|null
     */
    public $allQuestions = null;

    /**
     * @param  Organization $organization
     * @return void
     */
    public function mount(Organization $organization)
    {
        $this->user = Auth::user();
        $this->organization = $organization;
        $this->assignedQuestions = collect();
        $this->allQuestions = collect();
    }

    /**
     * @return void
     */
    public function createAction()
    {
        $this->validate();

        $form = CreateForm::run(
            $this->user,
            $this->organization,
            $this->createForm
        );

        $this->confirmingCreating = false;

        $this->confirmUpdate($form->id);
    }


    /**
     * @return void
     */
    public function confirmUpdateAction()
    {
        $form = $this->organization->forms()->findOrFail($this->idBeingUpdated);

        $this->assignedQuestions = collect($form->questions()->pluck('question_id')->toArray());

        $this->allQuestions = $this->organization->questions()->get()->merge($form->questions()->get())->sortBy('pivot.order');

        $this->updateForm = [
            'name' => $form->name,
            'description' => $form->description,
        ];
    }


    /**
     * @return void
     */
    public function updateAction()
    {
        $form = $this->organization->forms()->findOrFail($this->idBeingUpdated);

        UpdateForm::run(
            $this->user,
            $this->organization,
            $form,
            $this->updateForm
        );

        if ($this->assignedQuestions) {
            $form->questions()->sync($this->assignedQuestions->toArray());
        } else {
            $form->questions()->detach();
        }
    }

    /**
     * @return void
     */
    public function destroyAction()
    {
        DestroyForm::run(
            $this->user,
            $this->organization,
            Form::findOrFail($this->idBeingDestroyed)
        );
    }

    /**
     * @param  integer $questionId
     * @return void
     */
    public function syncQuestion(int $questionId)
    {
        if (!$this->assignedQuestions?->contains($questionId)) {
            $this->assignedQuestions?->push($questionId);
        } else {
            $this->assignedQuestions = collect($this->assignedQuestions->reject(fn ($value, $key) => $value == $questionId)->toArray());
        }

        $form = Form::findOrFail($this->idBeingUpdated);

        if ($this->assignedQuestions) {
            $form->questions()->sync($this->assignedQuestions);
        } else {
            $form->questions()->detach();
        }

        $this->assignedQuestions = collect($form->questions()->pluck('question_id')->toArray());

        $this->allQuestions = $this->organization->questions()->get()->merge($form->questions()->get())->sortBy('pivot.order');

        $this->organization = $this->organization->fresh();
    }

    /**
     * @param  integer $formId
     * @param  integer $questionId
     * @return void
     */
    public function moveQuestionUp(int $formId, int $questionId)
    {

        $form = Form::findOrFail($formId);

        FormQuestion::whereFormId($formId)->whereQuestionId($questionId)->first()?->moveOrderUp();

        $this->allQuestions = $this->organization->questions()->get()->merge($form->questions()->get())->sortBy('pivot.order');

        $this->notification()->success(
            'Question Moved',
            'Your question was successfully moved.'
        );
    }

    /**
     * @param  integer $formId
     * @param  integer $questionId
     * @return void
     */
    public function moveQuestionDown(int $formId, int $questionId)
    {
        $form = Form::findOrFail($formId);

        FormQuestion::whereFormId($formId)->whereQuestionId($questionId)->first()?->moveOrderDown();

        $this->allQuestions = $this->organization->questions()->get()->merge($form->questions()->get())->sortBy('pivot.order');

        $this->notification()->success(
            'Question Moved',
            'Your question was successfully moved.'
        );
    }

    /**
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.forms-manager');
    }
}
