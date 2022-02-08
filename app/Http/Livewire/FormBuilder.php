<?php

namespace App\Http\Livewire;

use App\Models\Form;
use App\Models\Event;
use Illuminate\Support\Str;
use App\Actions\CreateFormSubmission;
use App\Http\Livewire\BaseComponent;

class FormBuilder extends BaseComponent
{
    /**
     * @var string
     */
    public $componentName = 'FormBuilder';

    /**
     * @var string
     */
    public $event;

    /**
     * @var \App\Models\Form
     */
    public $form;

    /**
     * @var array
     */
    public $slugQuestions;

    /**
     * @var array
     */
    public $customQuestions;

    /**
     * @var array
     */
    public $create_form = [
        'email' => '',
        'team' => '',
    ];

    /**
     * Mount the component
     *
     * @param  string $id
     * @return void
     */
    public function mount($id)
    {
        if(!is_numeric($id)) {
            $this->event = Event::whereSlug($id)->firstOrFail();
            $this->form = $this->event->forms()->first();
        } else {
            $this->form = Form::find($id);
        }

        $this->slugQuestions = array_map(function ($item) {
            return Str::slug($item);
        }, array_merge(
            array_column(config('questions.business-model'), 'question'),
            array_column(config('questions.qualitative-intuitive-scoring'), 'question'),
        ));

        $this->customQuestions = array_map(function ($item) {
            return Str::slug($item);
        }, array_merge(
            $this->form->questions->pluck('question')->toArray(),
        ));
    }

    /**
     * Create a new form submission
     *
     * @return void
     */
    public function create()
    {
        CreateFormSubmission::run(
            $this->event,
            $this->form,
            $this->create_form,
            $this->slugQuestions,
            $this->customQuestions,
        );

        $this->emit('created');
    }

    /**
     * @return void
     */
    public function createAction()
    {
    }

    /**
     * @return void
     */
    public function confirmUpdateAction()
    {
    }

    /**
     * @return void
     */
    public function updateAction()
    {
    }

    /**
     * @return void
     */
    public function destroyAction()
    {
    }

    /**
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.form-builder')->layout('layouts.form', ['header' => $this->form->name]);
    }
}
