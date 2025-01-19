<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class ForgotPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function test_forgot_password_screen_can_be_rendered(): void
    {
        $response = $this->get('/forgot-password');

        $response->assertStatus(200);
        $response->assertSee('Forgot your password?');
        $response->assertSee('No problem. Just let us know your email address and we will email you a password reset link.');
    }

    public function test_reset_password_link_can_be_requested(): void
    {
        Notification::fake();

        $user = User::factory()->create();

        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        Notification::assertSentTo($user, ResetPassword::class);
        $response->assertSessionHas('status');
    }

    public function test_reset_password_link_is_not_sent_to_invalid_email(): void
    {
        Notification::fake();

        $response = $this->post('/forgot-password', [
            'email' => 'invalid@example.com',
        ]);

        Notification::assertNothingSent();
        $response->assertSessionHasErrors(['email']);
    }

    public function test_reset_password_link_requires_valid_email_format(): void
    {
        $response = $this->post('/forgot-password', [
            'email' => 'not-an-email',
        ]);

        $response->assertSessionHasErrors(['email']);
    }

    public function test_throttle_password_reset_requests(): void
    {
        $user = User::factory()->create();

        // Make multiple requests
        for ($i = 0; $i < 5; $i++) {
            $this->post('/forgot-password', [
                'email' => $user->email,
            ]);
        }

        // The next request should be throttled
        $response = $this->post('/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertStringContainsString(
            'Please wait before retrying.',
            collect($response->exception->errors()['email'])->first()
        );
    }
}
