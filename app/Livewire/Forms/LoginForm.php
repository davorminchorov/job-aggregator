<?php

namespace App\Livewire\Forms;

use App\Enums\RoleName;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\ValidationException;
use Livewire\Attributes\Validate;
use Livewire\Form;

class LoginForm extends Form
{
    #[Validate('required|string|email')]
    public string $email = '';

    #[Validate('required|string')]
    public string $password = '';

    #[Validate('boolean')]
    public bool $remember = false;

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        if (! Auth::attempt($this->only(['email', 'password']), $this->remember)) {
            RateLimiter::hit($this->throttleKey());

            throw ValidationException::withMessages([
                'form.email' => trans('auth.failed'),
            ]);
        }

        // Check if the user is trying to access the admin panel
        if (Request::is('admin*') && ! Auth::user()->hasRole(RoleName::ADMIN->value)) {
            Auth::logout();

            Session::invalidate();
            Session::regenerateToken();

            throw ValidationException::withMessages([
                'form.email' => 'You do not have permission to access the admin panel.',
            ]);
        }

        // Check if the user is trying to access the main app
        if (! Request::is('admin*') && ! Auth::user()->hasRole(RoleName::MEMBER->value)) {
            Auth::logout();

            Session::invalidate();
            Session::regenerateToken();

            throw ValidationException::withMessages([
                'form.email' => 'You do not have permission to access this area.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        Session::regenerate();
    }

    /**
     * Ensure the authentication request is not rate limited.
     */
    protected function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout(request()));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'form.email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the authentication rate limiting throttle key.
     */
    protected function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->email) . '|' . request()->ip());
    }
}
