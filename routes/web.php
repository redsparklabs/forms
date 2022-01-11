<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Jetstream;
use App\Http\Livewire\FormManager;
use App\Http\Livewire\FormBuilder;
use App\Http\Livewire\QuestionManager;


use App\Http\Controllers\Livewire\TeamController;
use App\Http\Controllers\Livewire\EventController;
use App\Http\Controllers\Livewire\CurrentOrganizationController;
use App\Http\Controllers\Livewire\OrganizationController;
use App\Http\Controllers\Livewire\OrganizationInvitationController;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/portfolio', function () {
    return view('portfolio');
})->name('portfolio');

Route::get('form/{eventid}', FormBuilder::class)->name('form-builder');


Route::group(['middleware' => ['auth', 'verified']], function () {
    // User & Profile...
    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');

    Route::get('/events', [EventController::class, 'index'])->name('events.index');
    Route::get('/events/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/events/{event}/form/{form}/team/{team}/results', [EventController::class, 'results'])->name('events.team.results');
    Route::get('/events/{event}/form/{form}/results', [EventController::class, 'results'])->name('events.results');


    Route::get('/teams', [TeamController::class, 'index'])->name('teams.index');
    Route::get('/teams/create', [TeamController::class, 'create'])->name('teams.create');
    Route::get('/teams/{team}', [TeamController::class, 'show'])->name('teams.show');

    Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::get('/organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');
    Route::put('/current-organization', [CurrentOrganizationController::class, 'update'])->name('current-organization.update');

    Route::get('/organization-invitations/{invitation}', [OrganizationInvitationController::class, 'accept'])
                ->middleware(['signed'])
                ->name('organization-invitations.accept');

    Route::get('organizations/{organization}/forms', FormManager::class)->name('form-manager');
    Route::get('organizations/{organization}/questions', QuestionManager::class)->name('question-manager');
});
