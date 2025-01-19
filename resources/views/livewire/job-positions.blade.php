<div class="min-h-screen bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 sm:text-3xl sm:truncate">
                    Job Positions
                </h2>
                <p class="mt-1 text-sm text-gray-500">
                    Find your next career opportunity from our curated list of positions
                </p>
            </div>
        </div>

        <!-- Search and Filters -->
        <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
            <div class="space-y-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search Positions</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input
                            wire:model.live="search"
                            type="text"
                            name="search"
                            id="search"
                            class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 pr-4 py-3 sm:text-sm border-gray-300 rounded-md"
                            placeholder="Search by position title, company, or keywords..."
                        >
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Category Filter -->
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700">Category</label>
                        <select
                            wire:model.live="category"
                            id="category"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                        >
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->slug }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Sort -->
                    <div>
                        <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                        <select
                            wire:model.live="sortBy"
                            id="sort"
                            class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md"
                        >
                            <option value="latest">Latest</option>
                            <option value="salary_high">Highest Salary</option>
                            <option value="salary_low">Lowest Salary</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Position Listings -->
        <div class="mt-8 grid gap-6">
            @forelse($positions as $position)
                <div wire:key="{{ $position->id }}" class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <div class="flex items-start">
                                    @php
                                        $initials = collect(explode(' ', $position->company->name))->map(function($word) {
                                            return strtoupper(substr($word, 0, 1));
                                        })->take(2)->join('');
                                    @endphp
                                    <div class="flex-shrink-0">
                                        @if($position->company->logo)
                                            <img src="{{ $position->company->logo }}" alt="{{ $position->company->name }}" class="h-12 w-12 rounded-lg object-cover">
                                        @else
                                            <div class="h-12 w-12 rounded-lg bg-indigo-100 flex items-center justify-center text-lg font-bold text-indigo-600">
                                                {{ $initials }}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-8 flex-1">
                                        <h3 class="text-lg font-semibold text-gray-900">
                                            <a href="{{ route('positions.show', $position) }}" class="hover:text-indigo-600">{{ $position->title }}</a>
                                        </h3>
                                        <div class="mt-1 flex items-center text-sm text-gray-600">
                                            <span>{{ $position->company->name }}</span>
                                            @if($position->location)
                                                <span class="mx-2 text-gray-400">&middot;</span>
                                                <span>{{ $position->location }}</span>
                                            @endif
                                        </div>
                                        <div class="mt-2 flex flex-wrap gap-2">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $position->type === 'full-time' ? 'bg-green-100 text-green-800' : ($position->type === 'internship' ? 'bg-blue-100 text-blue-800' : 'bg-purple-100 text-purple-800') }}">
                                                {{ ucfirst($position->type) }}
                                            </span>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                                {{ $position->category->name }}
                                            </span>
                                            @if($position->salary_min && $position->salary_max)
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                                    ${{ number_format($position->salary_min) }} - ${{ number_format($position->salary_max) }}
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="ml-4 flex flex-col items-end">
                                <span class="text-sm text-gray-500">
                                    {{ $position->created_at->diffForHumans() }}
                                </span>
                                <a href="{{ route('positions.show', $position) }}" class="mt-4 inline-flex items-center text-sm font-medium text-indigo-600 hover:text-indigo-500">
                                    View details
                                    <svg class="ml-1 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">No positions found</h3>
                    <p class="mt-1 text-sm text-gray-500">Try adjusting your search or filter criteria.</p>
                </div>
            @endforelse

            <!-- Pagination -->
            <div class="mt-8">
                {{ $positions->links() }}
            </div>
        </div>
    </div>
</div>
