<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Companies extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public string $sortBy = 'name';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $companies = Company::query()
            ->withCount('jobPositions')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%')
                    ->orWhere('industry', 'like', '%' . $this->search . '%');
            })
            ->when($this->sortBy === 'name', function ($query) {
                $query->orderBy('name');
            })
            ->when($this->sortBy === 'positions_count', function ($query) {
                $query->orderByDesc('job_positions_count');
            })
            ->when($this->sortBy === 'latest', function ($query) {
                $query->latest();
            });

        return view('livewire.companies', [
            'companies' => $companies->paginate(12),
        ]);
    }
}
