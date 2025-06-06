<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-950 dark:via-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="bg-gradient-to-b from-white to-slate-50 dark:from-slate-800 dark:to-slate-900/50 border-b border-slate-200 dark:border-slate-800 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Find Your Next Role</h1>
                <p class="text-lg text-slate-600 dark:text-slate-300">Discover opportunities that match your skills and aspirations.</p>

                <!-- Filters -->
                <div class="mt-8 bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-4 sm:p-6 backdrop-blur-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1">Search Positions</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input
                                    wire:model.live.debounce.300ms="search"
                                    type="search"
                                    id="search"
                                    class="block w-full pl-10 pr-4 py-2.5 text-sm border-slate-300 dark:border-slate-600/50 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 dark:focus:ring-violet-400 dark:focus:border-violet-400"
                                    placeholder="Search positions..."
                                >
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1">Category</label>
                            <select
                                wire:model.live="category"
                                id="category"
                                class="block w-full py-2.5 pl-3 pr-10 text-sm border-slate-300 dark:border-slate-600/50 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 dark:focus:ring-violet-400 dark:focus:border-violet-400"
                            >
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label for="sort" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1">Sort By</label>
                            <select
                                wire:model.live="sortBy"
                                id="sort"
                                class="block w-full py-2.5 pl-3 pr-10 text-sm border-slate-300 dark:border-slate-600/50 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 dark:focus:ring-violet-400 dark:focus:border-violet-400"
                            >
                                <option value="latest">Latest</option>
                                <option value="salary_high">Highest Salary</option>
                                <option value="salary_low">Lowest Salary</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Job Positions -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if ($positions->count() > 0)
                <div class="space-y-6">
                    @foreach($positions as $position)
                        <div class="group">
                            <a href="{{ route('positions.show', $position) }}" class="block">
                                <div class="bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 hover:border-violet-500 dark:hover:border-violet-400 hover:ring-1 hover:ring-violet-500 dark:hover:ring-violet-400 transition duration-150 backdrop-blur-sm">
                                    <div class="sm:flex items-start">
                                        <!-- Company Logo -->
                                        <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-8">
                                            @if($position->company->logo)
                                                <img src="{{ $position->company->logo }}" alt="{{ $position->company->name }}" class="h-12 w-12 rounded-lg object-cover ring-1 ring-slate-900/5 dark:ring-slate-100/10">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($position->company->name) }}&background=818CF8&color=fff&size=48&bold=true" alt="{{ $position->company->name }}" class="h-12 w-12 rounded-lg object-cover ring-1 ring-slate-900/5 dark:ring-slate-100/10">
                                            @endif
                                        </div>

                                        <!-- Position Info -->
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-300">
                                                        {{ $position->title }}
                                                    </h3>
                                                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">
                                                        {{ $position->company->name }}
                                                    </p>
                                                </div>
                                                <div class="flex flex-col items-end gap-2">
                                                    <div class="flex items-center space-x-2">
                                                        <div class="flex items-center space-x-2">
                                                            <span class="inline-flex items-center rounded-lg bg-violet-50 px-2.5 py-1 text-xs font-medium text-violet-700 ring-1 ring-inset ring-violet-600/10 dark:bg-violet-400/10 dark:text-violet-400 dark:ring-violet-400/30">
                                                                {{ $position->type->label() }}
                                                            </span>
                                                            @if($position->salary_range)
                                                                <span class="inline-flex items-center rounded-lg bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-700 ring-1 ring-inset ring-emerald-600/10 dark:bg-emerald-400/10 dark:text-emerald-400 dark:ring-emerald-400/30">
                                                                    {{ $position->salary_range }}
                                                                </span>
                                                            @endif
                                                        </div>
                                                        <button wire:click="toggleBookmark({{ $position->id }})" class="inline-flex items-center rounded-lg bg-violet-50 px-2.5 py-1 text-xs font-medium text-violet-700 ring-1 ring-inset ring-violet-600/10 hover:bg-violet-100 hover:text-violet-800 dark:bg-violet-400/10 dark:text-violet-400 dark:ring-violet-400/30 dark:hover:bg-violet-400/20 dark:hover:text-violet-300 transition-colors duration-150">
                                                            @if($position->isBookmarkedByUser(auth()->user()))
                                                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4 mr-1.5">
                                                                    <path fill-rule="evenodd" d="M6.32 2.577a49.255 49.255 0 0111.36 0c1.497.174 2.57 1.46 2.57 2.93V21a.75.75 0 01-1.085.67L12 18.089l-7.165 3.583A.75.75 0 013.75 21V5.507c0-1.47 1.073-2.756 2.57-2.93z" clip-rule="evenodd" />
                                                                </svg>
                                                                Bookmarked
                                                            @else
                                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-1.5">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.593 3.322c1.1.128 1.907 1.077 1.907 2.185V21L12 17.25 4.5 21V5.507c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0z" />
                                                                </svg>
                                                                Bookmark
                                                            @endif
                                                        </button>
                                                    </div>
                                                    <span class="inline-flex items-center rounded-lg bg-teal-50 px-2.5 py-1 text-xs font-medium text-teal-700 ring-1 ring-inset ring-teal-600/10 dark:bg-teal-400/10 dark:text-teal-300 dark:ring-teal-400/30">
                                                        {{ $position->category->name }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-600 dark:text-slate-300">
                                                <!-- Location -->
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-slate-400 dark:text-slate-500 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ $position->location }}
                                                </div>

                                                <!-- Salary -->
                                                <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                                                    <svg class="h-4 w-4 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    ${{ number_format($position->salary_min) }} - ${{ number_format($position->salary_max) }} per year
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                <div class="mt-8">
                    {{ $positions->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-slate-900 dark:text-white">No positions found</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Try adjusting your search or filters to find what you're looking for.</p>
                </div>
            @endif
        </div>
    </div>
</div>
