<?php

use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';

    /**
     * Handle an incoming registration request.
     */
    public function register(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'string', 'confirmed', Rules\Password::defaults()],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        event(new Registered($user = User::create($validated)));

        // Assign the member role to the new user
        $user->assignRole('member');

        Auth::login($user);

        $this->redirect(route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-slate-900 dark:text-white">Create an account</h2>
        <p class="mt-2 text-sm text-slate-600 dark:text-slate-400">Join JobNexus to find your next opportunity</p>
    </div>

    <form wire:submit="register" class="space-y-6">
        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" class="text-sm font-medium text-slate-700 dark:text-slate-300" />
            <x-text-input wire:model="name" id="name" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-violet-500 focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-slate-400" type="text" name="name" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-sm font-medium text-slate-700 dark:text-slate-300" />
            <x-text-input wire:model="email" id="email" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-violet-500 focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-slate-400" type="email" name="email" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-sm font-medium text-slate-700 dark:text-slate-300" />
            <x-text-input wire:model="password" id="password" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-violet-500 focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-slate-400" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-sm font-medium text-slate-700 dark:text-slate-300" />
            <x-text-input wire:model="password_confirmation" id="password_confirmation" class="mt-1 block w-full rounded-lg border-slate-300 shadow-sm focus:border-violet-500 focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-700 dark:text-white dark:placeholder-slate-400" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-primary-button class="w-full justify-center bg-violet-600 hover:bg-violet-500 focus:ring-violet-500">
                {{ __('Sign up') }}
            </x-primary-button>
        </div>

        <p class="text-center text-sm text-slate-600 dark:text-slate-400">
            {{ __('Already have an account?') }}
            <a href="{{ route('login') }}" class="font-medium text-violet-600 hover:text-violet-500 dark:text-violet-400 dark:hover:text-violet-300" wire:navigate>
                {{ __('Sign in') }}
            </a>
        </p>
    </form>
</div>
