<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use App\Models\Form;
use App\Actions\CreateFormSubmission;
use Illuminate\Support\Str;

class FormBuilder extends BaseComponent
{
    public $componentName = 'FormBuilder';

    public $form;

    public $slugQuestions;

    public $create_form = [
        'email' => '',
        'club' => '',
    ];

    public function mount($form)
    {
        $this->form = Form::whereSlug($form)->first();

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

    public function render()
    {
        return view('livewire.form-builder')->layout('layouts.form', ['header' => $this->form->name]);
    }
}
