<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_reset_password_screen_can_be_rendered(): void
    {
        $user = User::factory()->create();

        $token = Password::createToken($user);

        $response = $this->get('/reset-password/' . $token . '?email=' . $user->email);

        $response->assertStatus(200);
        $response->assertSee('Reset your password');
        $response->assertSee('Enter your new password below to reset your account password.');
    }

    public function test_password_can_be_reset_with_valid_token(): void
    {
        Event::fake();

        $user = User::factory()->create();

        $token = Password::createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        Event::assertDispatched(PasswordReset::class);

        $this->assertTrue(Hash::check('new-password', $user->fresh()->password));
        $response->assertSessionHas('status');
        $response->assertRedirect('/login');
    }

    public function test_password_cannot_be_reset_with_invalid_token(): void
    {
        $user = User::factory()->create();

        $response = $this->post('/reset-password', [
            'token' => 'invalid-token',
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertFalse(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_password_cannot_be_reset_without_email(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => '',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertFalse(Hash::check('new-password', $user->fresh()->password));
    }

    public function test_password_must_be_confirmed(): void
    {
        $user = User::factory()->create();
        $token = Password::createToken($user);

        $response = $this->post('/reset-password', [
            'token' => $token,
            'email' => $user->email,
            'password' => 'new-password',
            'password_confirmation' => 'different-password',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertFalse(Hash::check('new-password', $user->fresh()->password));
    }
}
