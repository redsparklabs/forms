<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Jetstream\Http\Livewire\UpdateTeamNameForm;
use Livewire\Livewire;
use Tests\TestCase;

class UpdateOrganizationNameTest extends TestCase
{
    use RefreshDatabase;

    public function test_team_names_can_be_updated()
    {
        $this->actingAs($user = User::factory()->withPersonalOrganization()->create());

        Livewire::test(UpdateTeamNameForm::class, ['team' => $user->currentOrganization])
                    ->set(['state' => ['name' => 'Test Team']])
                    ->call('updateTeamName');

        $this->assertCount(1, $user->fresh()->ownedOrganizations);
        $this->assertEquals('Test Team', $user->currentOrganization->fresh()->name);
    }
}
