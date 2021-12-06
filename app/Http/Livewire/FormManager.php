<?php

namespace App\Http\Livewire;

use App\Actions\CreateForm;
use App\Actions\DestroyForm;
use App\Actions\UpdateForm;
use App\Models\Team;
use App\Models\Form;
use App\Models\FormQuestion;
use App\Http\Livewire\BaseComponent;

class FormManager extends BaseComponent
{
    public $team;

    public $componentName = 'Form';

    public $create_form = [
        'name' => '',
        'events' => '',
        'description' => '',
        'clubs' => []
    ];

    public $update_form = [
        'name' => '',
        'events' => '',
        'description' => '',
        'clubs' => []
    ];

    public $rules = [
        'create_form.name' => 'required',
        'create_form.events' => 'required',
        'create_form.description' => 'required',
        'create_form.clubs' => 'required'
    ];

    protected $messages = [
        'create_form.name.required' => 'Please enter a form name.',
        'create_form.events.required' => 'Please enter a form event.',
        'create_form.description.required' => 'Please enter a form description.',
        'create_form.clubs.required' => 'Please choose at least one team.'
    ];

    public $assignedQuestions = null;

    public $allQuestions = null;

    public function mount(Team $team)
    {
        $this->team = $team;
        $this->assignedQuestions = collect();
        $this->allQuestions = collect();
    }

    public function createAction()
    {

        $this->validate();

        $form = CreateForm::run(
            $this->user,
            $this->team,
            $this->create_form
        );

        $this->confirmUpdate($form->id);
    }

    public function confirmUpdateAction()
    {
        $form = $this->team->forms()->findOrFail($this->idBeingUpdated);

        $this->assignedQuestions = collect($form->questions()->pluck('question_id')->toArray());

        $this->allQuestions = $this->team->questions()->get()->merge($form->questions()->get())->sortBy('pivot.order');

        $this->updateForm = [
            'name' => $form->name,
            'events' => $form->tag_string,
            'description' => $form->description,
            'clubs' => $form->clubs->pluck('id')->mapWithKeys(fn ($item) => [$item => $item])
        ];
    }

    public function updateAction()
    {
        $form = $this->team->forms()->findOrFail($this->idBeingUpdated);

        UpdateForm::run(
            $this->user,
            $this->team,
            $form,
            $this->updateForm
        );

        $form->questions()->sync($this->assignedQuestions);
    }

    public function destroyAction()
    {
        DestroyForm::run(
            $this->user,
            $this->team,
            Form::findOrFail($this->idBeingDestroyed)
        );
    }

    public function syncQuestion(int $questionId)
    {
        if (!$this->assignedQuestions->contains($questionId)) {
            $this->assignedQuestions->push($questionId);
        } else {
            $this->assignedQuestions = collect($this->assignedQuestions->reject(fn ($value, $key) => $value == $questionId)->toArray());
        }

        $form = Form::findOrFail($this->idBeingUpdated);

        $form->questions()->sync($this->assignedQuestions);

        $this->assignedQuestions = collect($form->questions()->pluck('question_id')->toArray());

        $this->allQuestions = $this->team->questions()->get()->merge($form->questions()->get())->sortBy('pivot.order');

        $this->team = $this->team->fresh();
    }

    public function moveQuestionUp(int $formId, int $questionId)
    {

        $form = Form::find($formId);

        $question = FormQuestion::whereFormId($formId)->whereQuestionId($questionId)->first();

        $question->moveOrderUp();

        $this->allQuestions = $this->team->questions()->get()->merge($form->questions()->get())->sortBy('pivot.order');

        $this->notification()->success(
            'Question Moved',
            'Your question was successfully moved.'
        );
    }

    public function moveQuestionDown(int $formId, int $questionId)
    {

        $form = Form::find($formId);

        $question = FormQuestion::whereFormId($formId)->whereQuestionId($questionId)->first();

        $question->moveOrderDown();

        $this->allQuestions = $this->team->questions()->get()->merge($form->questions()->get())->sortBy('pivot.order');

        $this->notification()->success(
            'Question Moved',
            'Your question was successfully moved.'
        );
    }

    public function render()
    {
        return view('livewire.forms-manager');
    }
}
