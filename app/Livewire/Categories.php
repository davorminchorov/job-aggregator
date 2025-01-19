<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class Categories extends Component
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
        $categories = Category::query()
            ->withCount('jobPositions')
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%');
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

        return view('livewire.categories', [
            'categories' => $categories->paginate(12),
        ]);
    }
}
