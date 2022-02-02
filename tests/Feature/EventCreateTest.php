<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Team;
use App\Models\Form;
use App\Models\Organization;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Http\Livewire\UpdatePasswordForm;
use Livewire\Livewire;
use Tests\TestCase;
use App\Http\Livewire\Events\EventCreate;

class EventCreateTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated()
    {
        // $this->actingAs($user = User::factory()->withPersonalOrganization()->create());

        // Livewire::test(EventCreate::class, ['organization' => $user->currentOrganization->id])
        //         ->set('createForm', [
        //             'name' => 'myform',
        //             'teams' => [Team::factory()->create()],
        //             'forms' => [Form::factory()->create([
        //                 'organization_id' => $user->currentOrganization->id,
        //             ])],
        //         ])
        //         ->call('createAction');

                // dd($user->currentOrganization()->events);
        // $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }


}
