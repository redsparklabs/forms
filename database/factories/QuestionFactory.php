<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Question;

class QuestionFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Question::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'question' => $this->faker->word,
            'description' => $this->faker->text,
            'color' => $this->faker->text,
            'section' => $this->faker->text,
            'hidden' => $this->faker->boolean,
            'organization_id' => $this->faker->randomNumber(),
        ];
    }
}
