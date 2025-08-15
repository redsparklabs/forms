<?php

namespace App\Http\Livewire;

use App\Models\Form;
use App\Models\Event;
use Illuminate\Support\Str;
use App\Actions\CreateFormSubmission;
use Livewire\Component;

class FormBuilder extends Component
{

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
        'team' => null,
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

        // Ensure default values exist for all sliders so validation sees the fields as present
        // Business model sliders allow 0..5
        foreach (config('questions.business-model') as $q) {
            $slug = Str::slug($q['question']);
            data_set($this->create_form, "questions.$slug", 0, overwrite: false);
        }

        // Qualitative intuitive scoring sliders are 1..5
        foreach (config('questions.qualitative-intuitive-scoring') as $q) {
            $slug = Str::slug($q['question']);
            data_set($this->create_form, "questions.$slug", 1, overwrite: false);
        }
    }


    /**
     * Create a new form submission
     *
     * @return void
     */
    public function create()
    {
        if($this->event->teams->count() == 1) {
            $this->create_form['team'] = $this->event->teams->first()->id;
        }

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
     * Render the component
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        $header = $this->event ? $this->event->name : $this->form->name;
        return view('livewire.form-builder')->layout('layouts.form', ['header' => $header]);
    }
}
