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
    public function handle(Form $form, array $attributes, array $slugQuestions, array $customQuestions)
    {
        $this->slugQuestions = $slugQuestions;

        $this->customQuestions = $customQuestions;


        $this->fill($attributes)->validateAttributes();

        $form->responses()->create([
            'response' => $attributes
        ]);

        $form->save();
    }

    /**
     * @return array
     */
    public function rules(): array
    {
        $data = array_merge(array_map(function ($item) {
            return ['questions.' . $item => ['required']];
        }, $this->slugQuestions));

        $data = array_merge(...$data);

        $data1 = array_merge(array_map(function ($item) {
            return ['questions.custom.' . $item => ['required']];
        }, $this->customQuestions));

        $data1 = array_merge(...$data1);

        $data = array_merge($data, $data1, [
            'email' => ['required', 'email'],
            'team' => ['required'],
        ]);

        return $data;
    }

    /**
     * @return array
     */
    public function getValidationMessages(): array
    {
        $arr = [
            'team.required' => 'Please choose a team.',
        ];

        foreach ($this->slugQuestions as $item) {
            $arr['questions.' . $item . '.required'] = 'Please answer the question.';
        }
        foreach ($this->customQuestions as $item) {
            $arr['questions.custom.' . $item . '.required'] = 'Please answer the question.';
        }

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
