<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Form;

class FormFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Form::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'description' => $this->faker->text,
            'organization_id' => $this->faker->randomNumber(),
        ];
    }
}
