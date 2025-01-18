<?php

namespace App\Livewire;

use App\Models\JobPosition;
use Livewire\Component;
use Illuminate\View\View;

class JobPositionDetails extends Component
{
    public JobPosition $position;

    public function mount(JobPosition $position): void
    {
        $this->position = $position->load(['company', 'category']);
    }

    public function render(): View
    {
        return view('livewire.job-position-details');
    }

    public function apply(): void
    {
        if (! auth()->check()) {
            $this->redirect(route('login'));
            return;
        }

        $application = $this->position->applications()->create([
            'user_id' => auth()->id(),
            'status' => 'pending',
        ]);

        $this->dispatch('position-applied', positionId: $this->position->id);

        session()->flash('success', 'Your application has been submitted successfully!');
    }
}
