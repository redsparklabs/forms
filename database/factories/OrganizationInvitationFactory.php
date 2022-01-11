<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\OrganizationInvitation;

class OrganizationInvitationFactory extends Factory
{
    /**
    * The name of the factory's corresponding model.
    *
    * @var  string
    */
    protected $model = OrganizationInvitation::class;

    /**
    * Define the model's default state.
    *
    * @return  array
    */
    public function definition(): array
    {
        return [
            'organization_id' => \App\Models\Organization::factory(),
            'email' => $this->faker->safeEmail,
            'role' => $this->faker->word,
        ];
    }
}
