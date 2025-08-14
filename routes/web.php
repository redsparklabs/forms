<?php

use App\Http\Livewire\Forms;
use App\Http\Livewire\Teams;
use App\Http\Livewire\Events;
use App\Http\Livewire\EventsShow;
use App\Http\Livewire\Dashboard;
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
use App\Http\Controllers\TeamInvitationController;
use App\Http\Controllers\HomeController;
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

// Team Invitation Acceptance Route (public, no auth required)
Route::get('/teams/{team}/invitations/{token}', [TeamInvitationController::class, 'accept'])
    ->name('team-invitations.accept');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('/dashboard', Dashboard::class, )->name('dashboard');
    Route::get('/portfolio', Teams::class)->name('teams.index');
    Route::get('/projects/{team}', TeamsShow::class)->name('teams.show');
    Route::get('organizations/{organization}/forms', Forms::class)->name('forms');
    Route::get('organizations/{organization}/questions', Questions::class)->name('questions');
    Route::get('/assessments', Events::class, 'index')->name('events.index');
    Route::get('/assessments/{event}', EventsShow::class)->name('events.show');
    Route::get('/assessments/{event}/projects/{team}/results', Results::class)->name('events.results');

    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');
    Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::get('/organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');
    Route::put('/current-organization', [CurrentOrganizationController::class, 'update'])->name('current-organization.update');

    Route::get('/organization-invitations/{invitation}', [OrganizationInvitationController::class, 'accept'])
        ->middleware(['signed'])
        ->name('organization-invitations.accept');

    // Team Invitation Management Routes (auth required)
    Route::prefix('teams/{team}')->group(function () {
        Route::post('/invite', [TeamInvitationController::class, 'invite'])
            ->name('team-invitations.invite');
            
        Route::post('/invitations/{invitation}/resend', [TeamInvitationController::class, 'resend'])
            ->name('team-invitations.resend');
            
        Route::delete('/invitations/{invitation}', [TeamInvitationController::class, 'revoke'])
            ->name('team-invitations.revoke');
    });
});
