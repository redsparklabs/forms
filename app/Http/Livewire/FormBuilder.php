<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use App\Models\Form;
use App\Actions\CreateFormSubmission;
use Illuminate\Support\Str;

class FormBuilder extends BaseComponent
{
    /**
     * @var string
     */
    public $componentName = 'FormBuilder';

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
     * @param  string $form
     * @return void
     */
    public function mount($form)
    {

        $this->form = Form::find($form)->first();

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
            $this->form,
            $this->create_form,
            $this->slugQuestions,
            $this->customQuestions,
        );

        $this->emit('created');
    }

    public function createAction()
    {
    }

    public function confirmUpdateAction()
    {
    }

    public function updateAction()
    {
    }

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
