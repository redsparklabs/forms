<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Jetstream;
use App\Http\Livewire\FormManager;
use App\Http\Livewire\FormBuilder;
use App\Http\Livewire\FormResults;
use App\Http\Livewire\QuestionManager;
use App\Http\Livewire\ClubManager;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect(route('login'));
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::group(['middleware' => config('jetstream.middleware', ['web'])], function () {

    Route::get('form/{form}', FormBuilder::class)->name('form-builder');

    Route::group(['middleware' => ['auth', 'verified']], function () {
        if (Jetstream::hasTeamFeatures()) {
            Route::get('organizations/{team}/forms', FormManager::class)->name('form-manager');
            Route::get('organizations/{team}/forms/{form}/results', FormResults::class)->name('form-results');
            Route::get('organizations/{team}/questions', QuestionManager::class)->name('question-manager');
        }
    });
});
