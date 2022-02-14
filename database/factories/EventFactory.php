<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Event;

class EventFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Event::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'slug' => $this->faker->slug,
            'name' => $this->faker->name,
            'date' => $this->faker->dateTime()->format('d-m-Y'),
            'organization_id' =>  \App\Models\Organization::factory(),
        ];
    }
}
