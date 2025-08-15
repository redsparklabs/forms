<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\Form;
use App\Models\Event;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;
use Livewire\Component;
use Illuminate\Validation\Validator;

class CreateFormSubmission
{
    use AsObject, WithAttributes;

    /**
     * @var array
     */
    public $slugQuestions;

    /**
     * @var array
     */
    public $customQuestions;

    /**
     * Handle the action
     *
     * @param  Form  $form
     * @param  array $attributes
     * @param  array $slugQuestions
     * @param  array $customQuestions
     * @return void
     */
    public function handle(Event $event, Form $form, array $attributes, array $slugQuestions, array $customQuestions)
    {
        $this->slugQuestions = $slugQuestions;

        $this->customQuestions = $customQuestions;

        $this->fill($attributes)->validateAttributes();

        $response = $form->responses()->create([
            'response' => $attributes
        ]);
        $response->event()->associate($event);
        $response->form()->associate($form);
        $response->team()->associate(Arr::get($attributes, 'team'));

        $response->save();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = [];

        // Business model sliders: 0..5 allowed
        foreach (config('questions.business-model') as $q) {
            $slug = \Illuminate\Support\Str::slug($q['question']);
            $rules['questions.' . $slug] = ['required', 'integer', 'between:0,5'];
        }

        // Qualitative intuitive scoring sliders: 1..5
        foreach (config('questions.qualitative-intuitive-scoring') as $q) {
            $slug = \Illuminate\Support\Str::slug($q['question']);
            $rules['questions.' . $slug] = ['required', 'integer', 'between:1,5'];
        }

        // Optional: custom text questions are free text, not required by design
        // foreach ($this->customQuestions as $slug) {
        //     $rules['questions.custom.' . $slug] = ['nullable', 'string'];
        // }

        $rules['email'] = ['required', 'email'];
        $rules['team'] = ['required'];

        return $rules;
    }

    /**
     * @return array
     */
    public function getValidationMessages(): array
    {
        $arr = [
            'team.required' => 'Please choose a project.',
        ];

        foreach ($this->slugQuestions as $item) {
            $arr['questions.' . $item . '.required'] = 'Please answer the question.';
        }
        // foreach ($this->customQuestions as $item) {
        //     $arr['questions.custom.' . $item . '.required'] = 'Please answer the question.';
        // }

        return $arr;
    }

    /**
     * @return string
     */
    public function getValidationErrorBag(): string
    {
        return 'addFormSubmission';
    }
}
