<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;
use Livewire\WithFileUploads;

new #[Layout('layouts.app')] class extends Component
{
    use WithFileUploads;

    public string $name = '';
    public string $email = '';
    public string $phone = '';
    public string $location = '';
    public string $bio = '';
    public $profile_picture;
    public $resume;
    public string $current_role = '';
    public string $experience = '';
    public string $skills = '';
    public string $education = '';

    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;

        if ($profile = $user->profile) {
            $this->phone = $profile->phone ?? '';
            $this->location = $profile->location ?? '';
            $this->bio = $profile->bio ?? '';
            $this->current_role = $profile->current_role ?? '';
            $this->experience = $profile->experience ?? '';
            $this->skills = is_array($profile->skills) ? implode(', ', $profile->skills) : '';
            $this->education = $profile->education ?? '';
        }
    }

    public function updateProfile(): void
    {
        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email,' . Auth::id()],
            'phone' => ['nullable', 'string', 'max:20'],
            'location' => ['nullable', 'string', 'max:255'],
            'bio' => ['nullable', 'string', 'max:1000'],
            'profile_picture' => ['nullable', 'image', 'max:1024'],
            'resume' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:2048'],
            'current_role' => ['nullable', 'string', 'max:255'],
            'experience' => ['nullable', 'string', 'max:1000'],
            'skills' => ['nullable', 'string', 'max:500'],
            'education' => ['nullable', 'string', 'max:1000'],
        ]);

        $user = Auth::user();
        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
        ]);

        // Get or create profile
        $profile = $user->profile ?? $user->profile()->create();

        // Handle file uploads
        if ($this->profile_picture) {
            $path = $this->profile_picture->store('profile-pictures', 'public');
            $profile->profile_picture = $path;
        }

        if ($this->resume) {
            $path = $this->resume->store('resumes', 'public');
            $profile->resume = $path;
        }

        // Convert skills string to array
        $skills = array_map('trim', explode(',', $validated['skills']));

        // Update profile
        $profile->update([
            'phone' => $validated['phone'],
            'location' => $validated['location'],
            'bio' => $validated['bio'],
            'current_role' => $validated['current_role'],
            'experience' => $validated['experience'],
            'skills' => $skills,
            'education' => $validated['education'],
        ]);

        $this->dispatch('profile-updated');
    }
}; ?>

<div>
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
        <div class="p-4 sm:p-8 bg-white dark:bg-slate-800 shadow sm:rounded-lg">
            <div class="max-w-xl">
                <header>
                    <h2 class="text-lg font-medium text-slate-900 dark:text-slate-100">
                        {{ __('Profile Information') }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                        {{ __("Update your account's profile information and email address.") }}
                    </p>
                </header>

                <form wire:submit="updateProfile" class="mt-6 space-y-6">
                    <!-- Basic Information -->
                    <div>
                        <x-input-label for="name" :value="__('Name')" />
                        <x-text-input wire:model="name" id="name" name="name" type="text" class="mt-1 block w-full" required autofocus autocomplete="name" />
                        <x-input-error class="mt-2" :messages="$errors->get('name')" />
                    </div>

                    <div>
                        <x-input-label for="email" :value="__('Email')" />
                        <x-text-input wire:model="email" id="email" name="email" type="email" class="mt-1 block w-full" required autocomplete="username" />
                        <x-input-error class="mt-2" :messages="$errors->get('email')" />
                    </div>

                    <div>
                        <x-input-label for="phone" :value="__('Phone')" />
                        <x-text-input wire:model="phone" id="phone" name="phone" type="tel" class="mt-1 block w-full" autocomplete="tel" />
                        <x-input-error class="mt-2" :messages="$errors->get('phone')" />
                    </div>

                    <div>
                        <x-input-label for="location" :value="__('Location')" />
                        <x-text-input wire:model="location" id="location" name="location" type="text" class="mt-1 block w-full" placeholder="City, Country" />
                        <x-input-error class="mt-2" :messages="$errors->get('location')" />
                    </div>

                    <div>
                        <x-input-label for="bio" :value="__('Bio')" />
                        <x-textarea wire:model="bio" id="bio" name="bio" class="mt-1 block w-full" rows="4" placeholder="Tell us about yourself..." />
                        <x-input-error class="mt-2" :messages="$errors->get('bio')" />
                    </div>

                    <!-- Profile Picture -->
                    <div>
                        <x-input-label for="profile_picture" :value="__('Profile Picture')" />
                        <input wire:model="profile_picture" type="file" id="profile_picture" name="profile_picture" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 dark:file:bg-violet-900/50 dark:file:text-violet-400" accept="image/*" />
                        <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
                    </div>

                    <!-- Resume -->
                    <div>
                        <x-input-label for="resume" :value="__('Resume')" />
                        <input wire:model="resume" type="file" id="resume" name="resume" class="mt-1 block w-full text-sm text-slate-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-violet-50 file:text-violet-700 hover:file:bg-violet-100 dark:file:bg-violet-900/50 dark:file:text-violet-400" accept=".pdf,.doc,.docx" />
                        <x-input-error class="mt-2" :messages="$errors->get('resume')" />
                    </div>

                    <!-- Professional Information -->
                    <div>
                        <x-input-label for="current_role" :value="__('Current Role')" />
                        <x-text-input wire:model="current_role" id="current_role" name="current_role" type="text" class="mt-1 block w-full" placeholder="e.g. Senior Software Engineer" />
                        <x-input-error class="mt-2" :messages="$errors->get('current_role')" />
                    </div>

                    <div>
                        <x-input-label for="experience" :value="__('Work Experience')" />
                        <x-textarea wire:model="experience" id="experience" name="experience" class="mt-1 block w-full" rows="4" placeholder="Describe your work experience..." />
                        <x-input-error class="mt-2" :messages="$errors->get('experience')" />
                    </div>

                    <div>
                        <x-input-label for="skills" :value="__('Skills')" />
                        <x-textarea wire:model="skills" id="skills" name="skills" class="mt-1 block w-full" rows="3" placeholder="Enter your skills, separated by commas..." />
                        <x-input-error class="mt-2" :messages="$errors->get('skills')" />
                    </div>

                    <div>
                        <x-input-label for="education" :value="__('Education')" />
                        <x-textarea wire:model="education" id="education" name="education" class="mt-1 block w-full" rows="3" placeholder="List your educational background..." />
                        <x-input-error class="mt-2" :messages="$errors->get('education')" />
                    </div>

                    <div class="flex items-center gap-4">
                        <x-primary-button>{{ __('Save') }}</x-primary-button>

                        <x-action-message class="me-3" on="profile-updated">
                            {{ __('Saved.') }}
                        </x-action-message>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
