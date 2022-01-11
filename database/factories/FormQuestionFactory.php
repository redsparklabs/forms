<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FormQuestion;

class FormQuestionFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = FormQuestion::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'id' => $this->faker->randomNumber(),
            'form_id' => $this->faker->randomNumber(),
            'question_id' => $this->faker->randomNumber(),
            'order' => $this->faker->randomNumber(),
        ];
    }
}
