<?php

use Illuminate\Support\Facades\Route;
use Laravel\Jetstream\Jetstream;
use App\Http\Livewire\FormManager;
use App\Http\Livewire\FormBuilder;
use App\Http\Livewire\FormResults;
use App\Http\Livewire\QuestionManager;
use App\Http\Livewire\ClubManager;

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

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('form/{form}', FormBuilder::class)->name('form-builder');


Route::group(['middleware' => ['auth', 'verified']], function () {
    // User & Profile...
    Route::get('/user/profile', [UserProfileController::class, 'show'])->name('profile.show');

    Route::get('/organizations/create', [OrganizationController::class, 'create'])->name('organizations.create');
    Route::get('/organizations/{organization}', [OrganizationController::class, 'show'])->name('organizations.show');
    Route::put('/current-organization', [CurrentOrganizationController::class, 'update'])->name('current-organization.update');

    Route::get('/organization-invitations/{invitation}', [OrganizationInvitationController::class, 'accept'])
                ->middleware(['signed'])
                ->name('organization-invitations.accept');

    Route::get('organizations/{organization}/forms', FormManager::class)->name('form-manager');
    Route::get('organizations/{organization}/forms/{form}/results', FormResults::class)->name('form-results');
    Route::get('organizations/{organization}/questions', QuestionManager::class)->name('question-manager');
});
