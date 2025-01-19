<?php

namespace Tests\Feature\Actions;

use App\Livewire\Actions\Logout;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('auth')]
    public function logsOutUser(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->assertAuthenticated();

        (new Logout)();

        $this->assertGuest();
    }

    #[Test]
    #[Group('auth')]
    public function invalidatesSession(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $this->session(['key' => 'value']);
        $this->assertSessionHas('key', 'value');

        (new Logout)();

        $this->assertSessionMissing('key');
    }

    #[Test]
    #[Group('auth')]
    public function regeneratesToken(): void
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $token = session()->token();

        (new Logout)();

        $this->assertNotEquals($token, session()->token());
    }
}
