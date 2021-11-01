<?php

namespace App\Actions;

use Illuminate\Support\Facades\Gate;
use App\Models\Form;
use Illuminate\Support\Arr;
use Lorisleiva\Actions\Concerns\AsObject;
use Lorisleiva\Actions\Concerns\WithAttributes;
use Livewire\Component;
use Illuminate\Validation\Validator;

class CreateFormSubmission
{
    use AsObject, WithAttributes;

    public $slugQuestions;

    public function handle(Form $form, array $attributes, array $slugQuestions)
    {

        $this->slugQuestions = $slugQuestions;

        if ( ! $attributes['club']) {
            $attributes['club'] = $form->clubs->first()->name;
        }

        $this->fill($attributes)->validateAttributes();

        $form->responses()->create([
            'response' => $attributes
        ]);
    }

    public function rules(): array
    {
        $data = array_merge(array_map(function($item) {
            return ['questions.'.$item => ['required']];
        }, $this->slugQuestions));

        $data = array_merge(...$data);

        $data = array_merge($data, [
            'email' => ['required', 'email'],
            'club' => ['required'],
        ]);

        return $data;

    }

    public function getValidationMessages(): array
    {
        return [
            'club.required' => 'Please choose a team.',
        ];
    }

    public function getValidationErrorBag(): string
    {
        return 'addFormSubmission';
    }
}
