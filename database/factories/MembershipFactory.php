<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Membership;

class MembershipFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = Membership::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'organization_id' => $this->faker->randomNumber(),
            'user_id' => $this->faker->randomNumber(),
            'role' => $this->faker->word,
        ];
    }
}
