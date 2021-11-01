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

    public $createForm = [
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
            $this->form->questions->pluck('question')->toArray(),
            array_column(config('questions.qualitative-intuitive-scoring'), 'question'),
            array_column(config('questions.qualitative-intuitive-scoring-feedback'), 'question')
        ));
    }

    public function create()
    {
        CreateFormSubmission::run(
            $this->form,
            $this->createForm,
            $this->slugQuestions
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
