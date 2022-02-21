<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Laravel\Jetstream\Jetstream;
use Illuminate\Support\ServiceProvider;
use Livewire\Livewire;
use App\Http\Livewire\ClubManager;
use Illuminate\Database\Eloquent\Model;

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
        // Model::preventLazyLoading();

        // if ($this->app->environment('local')) {
        //     Model::handleLazyLoadingViolationUsing(function ($model, $relation) {
        //         $class = get_class($model);

        //         ray("Attempted to lazy load [{$relation}] on model [{$class}].");
        //     });

        //     $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
        // }
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
