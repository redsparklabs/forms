<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\CreateTeamForm;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTeamTest extends TestCase
{
    use RefreshDatabase;

    public function test_teams_can_be_created()
    {
        $this->actingAs($user = User::factory()->withPersonalOrganization()->create());

        Livewire::test(CreateTeamForm::class)
                    ->set(['state' => ['name' => 'Test Organization']])
                    ->call('createTeam');

        $this->assertCount(2, $user->fresh()->ownedOrganizations);
        $this->assertEquals('Test Organization', $user->fresh()->ownedOrganizations()->latest('id')->first()->name);
    }
}
