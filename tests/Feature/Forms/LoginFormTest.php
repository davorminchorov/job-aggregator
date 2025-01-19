<?php

namespace Tests\Feature\Forms;

use App\Enums\RoleName;
use App\Livewire\Forms\LoginForm;
use App\Models\User;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\ValidationException;
use Livewire\Livewire;
use Tests\TestCase;

class LoginFormTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Route::get('/admin/test', fn () => 'admin')->middleware('web');
        Route::get('/member/test', fn () => 'member')->middleware('web');
    }

    #[Test]
    #[Group('auth')]
    public function validatesRequiredFields(): void
    {
        Livewire::test(LoginForm::class)
            ->call('authenticate')
            ->assertHasErrors(['email' => 'required', 'password' => 'required']);
    }

    #[Test]
    #[Group('auth')]
    public function validatesEmailFormat(): void
    {
        Livewire::test(LoginForm::class)
            ->set('email', 'invalid-email')
            ->call('authenticate')
            ->assertHasErrors(['email' => 'email']);
    }

    #[Test]
    #[Group('auth')]
    public function authenticatesUser(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RoleName::MEMBER->value);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate');

        $this->assertAuthenticated();
    }

    #[Test]
    #[Group('auth')]
    public function preventsAdminAccessForMembers(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RoleName::MEMBER->value);

        $this->get('/admin/test');

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate');

        $this->assertGuest();
    }

    #[Test]
    #[Group('auth')]
    public function preventsMemberAccessForAdmins(): void
    {
        $this->withoutExceptionHandling();
        $this->expectException(ValidationException::class);

        $user = User::factory()->create([
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RoleName::ADMIN->value);

        $this->get('/member/test');

        Livewire::test(LoginForm::class)
            ->set('email', 'admin@example.com')
            ->set('password', 'password')
            ->call('authenticate');

        $this->assertGuest();
    }

    #[Test]
    #[Group('auth')]
    public function handlesRateLimiting(): void
    {
        Event::fake([Lockout::class]);

        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        for ($i = 0; $i < 6; $i++) {
            try {
                Livewire::test(LoginForm::class)
                    ->set('email', 'test@example.com')
                    ->set('password', 'wrong-password')
                    ->call('authenticate');
            } catch (ValidationException $e) {
                continue;
            }
        }

        Event::assertDispatched(Lockout::class);
        $this->assertTrue(RateLimiter::tooManyAttempts($user->email . '|127.0.0.1', 5));
    }

    #[Test]
    #[Group('auth')]
    public function remembersUser(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RoleName::MEMBER->value);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->set('remember', true)
            ->call('authenticate');

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->remember_token);
    }

    #[Test]
    #[Group('auth')]
    public function clearsRateLimitAfterSuccessfulLogin(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RoleName::MEMBER->value);

        RateLimiter::hit($user->email . '|127.0.0.1');

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate');

        $this->assertFalse(RateLimiter::tooManyAttempts($user->email . '|127.0.0.1', 5));
    }

    #[Test]
    #[Group('auth')]
    public function handlesInactiveUser(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'is_active' => false,
        ]);

        $user->assignRole(RoleName::MEMBER->value);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate')
            ->assertHasErrors(['form.email' => 'Your account is inactive.']);

        $this->assertGuest();
    }

    #[Test]
    #[Group('auth')]
    public function handlesTemporarilyBannedUser(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'banned_until' => now()->addDay(),
        ]);

        $user->assignRole(RoleName::MEMBER->value);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate')
            ->assertHasErrors(['form.email' => 'Your account is temporarily suspended.']);

        $this->assertGuest();
    }

    #[Test]
    #[Group('auth')]
    public function handlesPasswordResetRequired(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'password_change_required' => true,
        ]);

        $user->assignRole(RoleName::MEMBER->value);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate')
            ->assertRedirect(route('password.change'));
    }

    #[Test]
    #[Group('auth')]
    public function handlesLoginFromSuspiciousLocation(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'last_login_ip' => '1.2.3.4',
        ]);

        $user->assignRole(RoleName::MEMBER->value);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate');

        $this->assertDatabaseHas('security_logs', [
            'user_id' => $user->id,
            'action' => 'login',
            'ip_address' => request()->ip(),
        ]);
    }

    #[Test]
    #[Group('auth')]
    public function handlesSimultaneousLogins(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        $user->assignRole(RoleName::MEMBER->value);

        // First login
        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate');

        // Second login should invalidate first session
        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate');

        $this->assertCount(1, $user->sessions()->get());
    }

    #[Test]
    #[Group('auth')]
    public function handlesLoginAttemptWithoutRole(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate')
            ->assertHasErrors(['form.email' => 'You do not have permission to access this area.']);

        $this->assertGuest();
    }

    #[Test]
    #[Group('auth')]
    public function handlesLoginWithExpiredPassword(): void
    {
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'password_changed_at' => now()->subDays(91), // Assuming 90 days password expiry
        ]);

        $user->assignRole(RoleName::MEMBER->value);

        Livewire::test(LoginForm::class)
            ->set('email', 'test@example.com')
            ->set('password', 'password')
            ->call('authenticate')
            ->assertRedirect(route('password.expired'));
    }
}
