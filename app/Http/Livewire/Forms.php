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
use Livewire\WithPagination;

class Forms extends BaseComponent
{
    use WithPagination;
    /**
     * @var array
     */
    protected $listeners = [
        'refresh' => 'render',
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
     * @var string
     */
    public $sortByField = 'name';

    /**
     * @var string
     */
    public $keyword = null;

    /**
     * @var string
     */
    public $sortDirection = 'asc';

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
     * Update the search keyword.
     *
     * @return void
     */

    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Sort the collection by the given field.
     *
     * @param  string $field
     *
     * @return void
     */
    public function sortBy(string $field)
    {
        $this->sortByField = $field;

        $this->sortDirection = ($this->sortDirection == 'desc') ? 'asc' : 'desc';

        $this->emit('refresh');
    }

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

        $this->assignedQuestions = collect($form->questions()->pluck('question_id')->map(fn($id) => (int) $id)->toArray());

        // Assigned, ordered by pivot.order
        $assigned = $form->questions()->orderBy('form_question.order')->get();

        // Unassigned for this form
        $unassigned = $this->organization->questions()
            ->whereNotIn('id', $this->assignedQuestions)
            ->orderBy('question') // secondary stable order
            ->get();

        // Final list: assigned first (in order), then unassigned
        $this->allQuestions = $assigned->concat($unassigned);
        //$this->allQuestions = $this->organization->questions()->get()->merge($form->questions()->get())->sortBy('pivot.order');

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
            $form->questions()->sync($this->assignedQuestions->toArray());
        } else {
            $form->questions()->detach();
        }

        $this->assignedQuestions = collect($form->questions()->pluck('question_id')->map(fn($id) => (int) $id)->toArray());

        $assigned = $form->questions()->orderBy('form_question.order')->get();
        $unassigned = $this->organization->questions()
            ->whereNotIn('id', $this->assignedQuestions)
            ->orderBy('question')
            ->get();

        $this->allQuestions = $assigned->concat($unassigned);

        //$this->allQuestions = $this->organization->questions()->get()->merge($form->questions()->get())->sortBy('pivot.order');
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

        $assigned = $form->questions()->orderBy('form_question.order')->get();
        $unassigned = $this->organization->questions()
            ->whereNotIn('id', $assigned->pluck('id'))
            ->orderBy('question')
            ->get();
        
        $this->allQuestions = $assigned->concat($unassigned);
        
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

        $assigned = $form->questions()->orderBy('form_question.order')->get();
        $unassigned = $this->organization->questions()
            ->whereNotIn('id', $assigned->pluck('id'))
            ->orderBy('question')
            ->get();
        
        $this->allQuestions = $assigned->concat($unassigned);
        
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
        $forms = $this->organization
            ->forms()
            ->search($this->keyword)
            ->orderBy($this->sortByField, $this->sortDirection)
            ->paginate(25);

        return view('forms.index', compact('forms'));
    }
}
