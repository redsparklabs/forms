<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Team;
use App\Models\Event;
use App\Models\Form;
use App\Models\Question;
use App\Models\Organization;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $faker = Faker::create();

        // Organization::factory()
        //     ->count(5)
        //     ->hasTeams(10)
        //     ->hasEvents(10)
        //     ->hasForms(10)
        //     ->hasQuestions(4)
        //     ->create();
        // \App\Models\Organization::factory(5)->create()->each(function ($org) {
        //     $org->events()->saveMany(\App\Models\Event::factory())->make();
        // });
        // \App\Models\Event::factory(20)->create();
        // \App\Models\Form::factory(5)->create();
        // // \App\Models\FormQuestion::factory(5)->create();
        // \App\Models\Team::factory(5)->create();
        // \App\Models\Organization::factory(5)->create();
        \App\Models\Responses::factory(10000)->create();

        // $limit = 100;
        // for ($i = 0; $i < $limit; $i++) {
        //     $ids = $faker->randomElements(Event::pluck('id'), rand(1,5));
        //     Team::inRandomOrder()->first()->events()->attach($ids, ['investment' => $faker->randomFloat(2), 'net_projected_value' => $faker->randomFloat(2)]);
        // }
        // for ($i = 0; $i < $limit; $i++) {
        //     $ids = $faker->randomElements(Form::pluck('id'), rand(1,5));
        //     Event::inRandomOrder()->first()->forms()->attach($ids);
        // }
        // for ($i = 0; $i < $limit; $i++) {
        //     $ids = $faker->randomElements(Form::pluck('id'), rand(1,5));
        //     Question::inRandomOrder()->first()->forms()->attach($ids, ['order' => $i]);
        // }
    }
}
