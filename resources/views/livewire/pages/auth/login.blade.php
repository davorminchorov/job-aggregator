<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Welcome back!</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Please sign in to your account</p>
    </div>

    <form wire:submit="login" class="space-y-6">
        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-slate-700 dark:text-slate-300" />
            <x-text-input wire:model="form.email" id="email" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-violet-500 focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-slate-400" type="email" name="email" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('form.email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-slate-700 dark:text-slate-300" />
            <x-text-input wire:model="form.password" id="password" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-violet-500 focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-slate-400" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('form.password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="flex items-center justify-between">
            <label for="remember" class="inline-flex items-center">
                <input wire:model="form.remember" id="remember" type="checkbox" class="rounded border-slate-300 text-violet-600 shadow-sm focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-700 dark:ring-offset-slate-800" name="remember">
                <span class="ms-2 text-sm text-slate-600 dark:text-slate-400">{{ __('Remember me') }}</span>
            </label>

            @if (Route::has('password.request'))
                <a class="text-sm text-violet-600 hover:text-violet-500 dark:text-violet-400 dark:hover:text-violet-300" href="{{ route('password.request') }}" wire:navigate>
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <div>
            <x-primary-button class="w-full justify-center bg-violet-600 hover:bg-violet-500 focus:ring-violet-500">
                {{ __('Sign in') }}
            </x-primary-button>
        </div>

        <p class="text-center text-sm text-slate-600 dark:text-slate-400">
            {{ __("Don't have an account?") }}
            <a href="{{ route('register') }}" class="font-medium text-violet-600 hover:text-violet-500 dark:text-violet-400 dark:hover:text-violet-300" wire:navigate>
                {{ __('Sign up') }}
            </a>
        </p>
    </form>
</div>
