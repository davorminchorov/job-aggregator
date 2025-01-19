<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class Edit extends Component
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

    public function render()
    {
        return view('livewire.profile.edit')
            ->layout('layouts.app');
    }
}
