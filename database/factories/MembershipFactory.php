<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Membership;
use App\Models\Role;

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
            'organization_id' => \App\Models\Organization::factory(),
            'user_id' => \App\Models\User::factory(),
            'role' => $this->faker->word,
        ];
    }
}
