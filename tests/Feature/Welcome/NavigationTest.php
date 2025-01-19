<?php

namespace Tests\Feature\Welcome;

use App\Livewire\Welcome\Navigation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class NavigationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('navigation')]
    public function rendersCorrectly(): void
    {
        Livewire::test(Navigation::class)
            ->assertViewIs('livewire.welcome.navigation');
    }

    #[Test]
    #[Group('navigation')]
    public function logsOutUserAndRedirects(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Navigation::class)
            ->call('logout')
            ->assertRedirect('/');

        $this->assertGuest();
    }

    #[Test]
    #[Group('navigation')]
    public function invalidatesSessionOnLogout(): void
    {
        $user = User::factory()->create();

        $component = Livewire::actingAs($user)
            ->test(Navigation::class);

        $token = session()->token();

        $component->call('logout');

        $this->assertNotEquals($token, session()->token());
        $this->assertSessionMissing('_token');
    }
}
