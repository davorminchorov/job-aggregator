<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\JobPosition;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class JobPositions extends Component
{
    use WithPagination;

    #[Url]
    public string $search = '';

    #[Url]
    public ?string $category = null;

    #[Url]
    public string $sortBy = 'latest';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedCategory()
    {
        $this->resetPage();
    }

    public function toggleBookmark(JobPosition $jobPosition): void
    {
        if (! Auth::check()) {
            $this->redirectRoute('login');

            return;
        }

        $user = Auth::user();

        if ($jobPosition->isBookmarkedByUser($user)) {
            $user->bookmarks()->detach($jobPosition);
            $this->dispatch('job-position-unbookmarked');
        } else {
            $user->bookmarks()->attach($jobPosition);
            $this->dispatch('job-position-bookmarked');
        }
    }

    public function render()
    {
        $positions = JobPosition::query()
            ->with(['company', 'category'])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('title', 'like', '%' . $this->search . '%')
                        ->orWhere('description', 'like', '%' . $this->search . '%')
                        ->orWhereHas('company', function ($query) {
                            $query->where('name', 'like', '%' . $this->search . '%');
                        });
                });
            })
            ->when($this->category, function ($query) {
                $query->whereHas('category', function ($query) {
                    $query->where('slug', $this->category);
                });
            })
            ->when($this->sortBy === 'latest', function ($query) {
                $query->latest();
            })
            ->when($this->sortBy === 'salary_high', function ($query) {
                $query->orderByDesc('salary_max');
            })
            ->when($this->sortBy === 'salary_low', function ($query) {
                $query->orderBy('salary_min');
            });

        return view('livewire.job-positions', [
            'positions' => $positions->paginate(10),
            'categories' => Category::all(),
        ]);
    }
}
