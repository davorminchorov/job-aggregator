<?php

namespace App\Livewire;

use App\Models\Company;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CompanyDetails extends Component
{
    use WithPagination;

    public Company $company;

    #[Url]
    public string $search = '';

    #[Url]
    public string $sortBy = 'latest';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        $positions = $this->company->jobPositions()
            ->with(['category', 'company'])
            ->when($this->search, function ($query) {
                $query->where('title', 'like', '%' . $this->search . '%')
                    ->orWhere('description', 'like', '%' . $this->search . '%')
                    ->orWhere('location', 'like', '%' . $this->search . '%')
                    ->orWhere('type', 'like', '%' . $this->search . '%');
            })
            ->when($this->sortBy === 'title', function ($query) {
                $query->orderBy('title');
            })
            ->when($this->sortBy === 'salary_high', function ($query) {
                $query->orderByDesc('salary_max');
            })
            ->when($this->sortBy === 'salary_low', function ($query) {
                $query->orderBy('salary_min');
            })
            ->when($this->sortBy === 'latest', function ($query) {
                $query->latest();
            });

        return view('livewire.company-details', [
            'positions' => $positions->paginate(10),
        ]);
    }
}
