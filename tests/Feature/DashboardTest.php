<?php

namespace Tests\Feature;

use App\Livewire\Dashboard;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class DashboardTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    #[Group('dashboard')]
    public function unauthenticatedUserCannotAccessDashboard(): void
    {
        $this->get(route('dashboard'))
            ->assertRedirect(route('login'));
    }

    #[Test]
    #[Group('dashboard')]
    public function authenticatedUserCanAccessDashboard(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->get(route('dashboard'))
            ->assertOk();
    }

    #[Test]
    #[Group('dashboard')]
    public function dashboardShowsAuthenticatedUserInformation(): void
    {
        $user = User::factory()->create();

        Livewire::actingAs($user)
            ->test(Dashboard::class)
            ->assertViewHas('user', $user);
    }
}
