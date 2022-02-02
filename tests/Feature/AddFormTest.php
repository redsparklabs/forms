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
use App\Http\Livewire\FormManager;

class AddFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_form_can_be_created()
    {
        $this->actingAs($user = User::factory()->withPersonalOrganization()->create());

        Livewire::test(FormManager::class, ['organization' => $user->currentOrganization->id])
                ->set('createForm', [
                    'name' => 'myform',
                    'description' => 'my form description',
                ])
                ->call('createAction');

                $this->assertSame(2, $user->currentOrganization->forms->count());
        // $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }


}
