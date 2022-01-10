<?php

namespace Database\Factories;

use App\Models\Responses;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Laravel\Jetstream\Features;

class ResponsesFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Responses::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'event_id' => rand(25,35),
            'form_id' => rand(1,10),
            "team_id" => rand(1,10),
            'response' => [
                "email" => $this->faker->safeEmail(),
                'questions' => [
                    'custom' => [
                        "specific-questions-any-specific-areas-you-would-like-to-see-more-information-or-specific-questions-you-have-for-this-team" => "How do i milk a goat",
                        "overall-feedback-your-general-thoughts-impressions-and-feedback-for-the-team" => "My feedback",
                    ],
                    "team-gameplan" => rand(1, 2),
                    "team-performance" => rand(1, 2),
                    "costs" => rand(1, 3),
                    "revenue" => rand(1, 2),
                    "key-metrics" => rand(1, 3),
                    "competitive-advantage" => rand(1, 2),
                    "channels" => rand(1, 3),
                    "solution" => rand(1, 4),
                    "value-proposition" => rand(1, 2),
                    "customer-need" => rand(1, 3),
                    "opportunity-segments" => rand(1, 2),
                ]
            ],
        ];
    }
}
