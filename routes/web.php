<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Jetstream;
use App\Http\Livewire\FormManager;
use App\Http\Livewire\FormBuilder;
use App\Http\Livewire\QuestionManager;
use App\Http\Livewire\Teams\TeamShow;
use App\Http\Livewire\Teams\TeamManager;
use App\Http\Livewire\PortfolioController;

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

Route::get('form/{eventid}', FormBuilder::class)->name('form-builder');

Route::group(['middleware' => ['auth', 'verified']], function () {
    Route::get('/portfolio', PortfolioController::class, )->name('portfolio');
    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');

    Route::get('/growth-boards', [EventController::class, 'index'])->name('events.index');
    Route::get('/growth-boards/create', [EventController::class, 'create'])->name('events.create');
    Route::get('/growth-boards/{event}', [EventController::class, 'show'])->name('events.show');
    Route::get('/growth-boards/{event}/form/{form}/projects/{team}/results', [EventController::class, 'results'])->name('events.results');


    Route::get('/projects', TeamManager::class)->name('teams.index');
    Route::get('/projects/{team}', TeamShow::class)->name('teams.show');

    Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::get('/organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');
    Route::put('/current-organization', [CurrentOrganizationController::class, 'update'])->name('current-organization.update');

    Route::get('/organization-invitations/{invitation}', [OrganizationInvitationController::class, 'accept'])
        ->middleware(['signed'])
        ->name('organization-invitations.accept');

    Route::get('organizations/{organization}/forms', FormManager::class)->name('form-manager');
    Route::get('organizations/{organization}/questions', QuestionManager::class)->name('question-manager');
});
