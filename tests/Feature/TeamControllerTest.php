<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Laravel\Jetstream\Http\Livewire\UpdatePasswordForm;
use Livewire\Livewire;
use Tests\TestCase;

class TeamControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_password_can_be_updated()
    {
        $this->actingAs($user = User::factory()->create());

        $response = $this->post('/portfolio', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
    }

}
