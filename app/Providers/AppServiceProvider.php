<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\ClubManager;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Jetstream::ignoreRoutes();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blade::component('jetstream::components.textarea', 'jet-textarea');
        Blade::component('jetstream::components.switchable-organization', 'jet-switchable-organization');
    }
}
