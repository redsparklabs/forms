<?php

namespace App\Http\Livewire;

use App\Http\Livewire\BaseComponent;
use App\Models\Form;
use App\Actions\CreateFormSubmission;
use Illuminate\Support\Str;
use Livewire\Component;

class FormResults extends Component
{
    public $form;

    public $responses;

    public $questions;

    public $feedback_questions;

    public function mount($form)
    {
        $this->form = Form::find($form);

        $customQuestion = $this->form->questions->map(function($item) {
            return [
                'question' => $item['question'],
                'description' => $item['description'],
                'color' => '',
                'section' => 'custom'
            ];
        })->toArray();

        $this->questions = array_merge(
            config('questions.business-model'),
            config('questions.qualitative-intuitive-scoring'),
            $customQuestion,

        );

        $this->feedback_questions = config('questions.qualitative-intuitive-scoring-feedback');
    }

    public function render()
    {
        return view('livewire.forms-results');
    }
}
