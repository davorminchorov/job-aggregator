<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="bg-gradient-to-b from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 border-b border-slate-200 dark:border-slate-700 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Find Your Next Role</h1>
                <p class="text-lg text-slate-600 dark:text-slate-300">Discover opportunities that match your skills and aspirations.</p>

                <!-- Filters -->
                <div class="mt-8 bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-4 sm:p-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Search Positions</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                    </svg>
                                </div>
                                <input
                                    wire:model.live.debounce.300ms="search"
                                    type="search"
                                    id="search"
                                    class="block w-full pl-10 pr-4 py-2.5 text-sm border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white placeholder-slate-500 dark:placeholder-slate-400 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 dark:focus:ring-violet-400 dark:focus:border-violet-400"
                                    placeholder="Search positions..."
                                >
                            </div>
                        </div>

                        <!-- Category Filter -->
                        <div>
                            <label for="category" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Category</label>
                            <select
                                wire:model.live="category"
                                id="category"
                                class="block w-full py-2.5 pl-3 pr-10 text-sm border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 dark:focus:ring-violet-400 dark:focus:border-violet-400"
                            >
                                <option value="">All Categories</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->slug }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Sort -->
                        <div>
                            <label for="sort" class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1">Sort By</label>
                            <select
                                wire:model.live="sortBy"
                                id="sort"
                                class="block w-full py-2.5 pl-3 pr-10 text-sm border-slate-300 dark:border-slate-600 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-white focus:ring-2 focus:ring-violet-500 focus:border-violet-500 dark:focus:ring-violet-400 dark:focus:border-violet-400"
                            >
                                <option value="latest">Latest</option>
                                <option value="salary_desc">Highest Salary</option>
                                <option value="salary_asc">Lowest Salary</option>
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
                                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 hover:border-violet-500 dark:hover:border-violet-400 hover:ring-1 hover:ring-violet-500 dark:hover:ring-violet-400 transition duration-150">
                                    <div class="sm:flex items-start">
                                        <!-- Company Logo -->
                                        <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-8">
                                            @if($position->company->logo)
                                                <img src="{{ $position->company->logo }}" alt="{{ $position->company->name }}" class="h-12 w-12 rounded-lg object-cover">
                                            @else
                                                <img src="https://ui-avatars.com/api/?name={{ urlencode($position->company->name) }}&background=818CF8&color=fff&size=48&bold=true" alt="{{ $position->company->name }}" class="h-12 w-12 rounded-lg object-cover">
                                            @endif
                                        </div>

                                        <!-- Position Info -->
                                        <div class="flex-1">
                                            <div class="flex items-start justify-between">
                                                <div>
                                                    <h3 class="text-lg font-semibold text-slate-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400">
                                                        {{ $position->title }}
                                                    </h3>
                                                    <p class="mt-1 text-sm text-slate-600 dark:text-slate-400">
                                                        {{ $position->company->name }}
                                                    </p>
                                                </div>
                                                <div class="flex flex-col items-end gap-2">
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800 dark:bg-violet-900 dark:text-violet-300">
                                                        {{ $position->type }}
                                                    </span>
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-300">
                                                        {{ $position->category->name }}
                                                    </span>
                                                </div>
                                            </div>

                                            <div class="mt-4 flex flex-wrap gap-4 text-sm text-slate-600 dark:text-slate-400">
                                                <!-- Location -->
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-slate-400 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    {{ $position->location }}
                                                </div>

                                                <!-- Salary -->
                                                <div class="flex items-center">
                                                    <svg class="h-5 w-5 text-slate-400 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    {{ $position->salary_range }}
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
                    <svg class="mx-auto h-12 w-12 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-slate-900 dark:text-white">No positions found</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Try adjusting your search or filters to find what you're looking for.</p>
                </div>
            @endif
        </div>
    </div>
</div>
