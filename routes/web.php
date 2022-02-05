<?php

use App\Http\Livewire\Forms;
use App\Http\Livewire\Teams;
use App\Http\Livewire\Events;
use App\Http\Livewire\EventsShow;
use App\Http\Livewire\Portfolio;
use App\Http\Livewire\TeamsShow;
use App\Http\Livewire\Questions;
use App\Http\Livewire\FormBuilder;
use App\Http\Livewire\Results;


use App\Http\Controllers\Livewire\EventController;
use App\Http\Controllers\Livewire\OrganizationController;
use App\Http\Controllers\Livewire\CurrentOrganizationController;
use App\Http\Controllers\Livewire\OrganizationInvitationController;

use Laravel\Jetstream\Jetstream;
use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Http\Controllers\Livewire\UserProfileController;
use Laravel\Jetstream\Http\Controllers\Livewire\PrivacyPolicyController;
use Laravel\Jetstream\Http\Controllers\Livewire\TermsOfServiceController;
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

if (Jetstream::hasTermsAndPrivacyPolicyFeature()) {
    Route::get('/terms-of-service', [TermsOfServiceController::class, 'show'])->name('terms.show');
    Route::get('/privacy-policy', [PrivacyPolicyController::class, 'show'])->name('policy.show');
}

Route::get('form/{id}', FormBuilder::class)->name('form-builder');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/portfolio', Portfolio::class, )->name('portfolio');
    Route::get('/projects', Teams::class)->name('teams.index');
    Route::get('/projects/{team}', TeamsShow::class)->name('teams.show');
    Route::get('organizations/{organization}/forms', Forms::class)->name('forms');
    Route::get('organizations/{organization}/questions', Questions::class)->name('questions');
    Route::get('/growth-boards', Events::class, 'index')->name('events.index');
    Route::get('/growth-boards/{event}', EventsShow::class)->name('events.show');
    Route::get('/growth-boards/{event}/form/{form}/projects/{team}/results', Results::class)->name('events.results');

    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::get('/organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');
    Route::put('/current-organization', [CurrentOrganizationController::class, 'update'])->name('current-organization.update');

    Route::get('/organization-invitations/{invitation}', [OrganizationInvitationController::class, 'accept'])
        ->middleware(['signed'])
        ->name('organization-invitations.accept');


});
