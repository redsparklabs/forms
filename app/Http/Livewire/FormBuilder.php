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
        return view('livewire.form-builder')->layout('layouts.form', ['header' => $this->form->name]);
    }
}
