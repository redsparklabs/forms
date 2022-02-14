<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Organization;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {


        Organization::factory()
            ->count(5)
            ->hasTeams(4)
            ->hasEvents(4)
            ->hasForms(4)
            ->hasQuestions(4)
            ->create();
        // \App\Models\Organization::factory(5)->create()->each(function ($org) {
        //     $org->events()->saveMany(App\Models\Event::factory())->make());
        // });
        // \App\Models\Event::factory(5)->create();
        // \App\Models\Form::factory(5)->create();
        // \App\Models\FormQuestion::factory(5)->create();
        // \App\Models\Team::factory(5)->create();
        // \App\Models\Organization::factory(5)->create();
        // \App\Models\Responses::factory(5000)->create();
    }
}
