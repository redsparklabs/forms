<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;

class TeamFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Team::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'start_date' => $this->faker->dateTime()->format('d-m-Y'),
            'priority_level' => rand(1,10),
            'description' => $this->faker->text,
            'minimum_success_criteria' => $this->faker->text,
            'estimated_launch_date' => $this->faker->dateTime()->format('d-m-Y'),
            'sponsor' => $this->faker->text,
            'organization_id' => \App\Models\Organization::factory(),
        ];
    }
}
