<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-12">
            <div class="flex-1 min-w-0">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                    Job Positions
                </h2>
                <p class="mt-3 max-w-3xl text-lg text-slate-500 dark:text-slate-400">
                    Find your dream job from our curated list of opportunities
                </p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm ring-1 ring-slate-900/5 dark:ring-slate-800 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Search Positions</label>
                    <div class="mt-2 relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input
                            wire:model.live="search"
                            type="text"
                            name="search"
                            id="search"
                            class="block w-full pl-10 pr-4 py-2.5 text-base border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 focus:border-transparent"
                            placeholder="Search by position title or company..."
                        >
                    </div>
                </div>

                <!-- Category Filter -->
                <div>
                    <label for="category" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Category</label>
                    <select
                        wire:model.live="category"
                        id="category"
                        class="mt-2 block w-full pl-3 pr-10 py-2.5 text-base border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 focus:border-transparent"
                    >
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->slug }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Sort By</label>
                    <select
                        wire:model.live="sortBy"
                        id="sort"
                        class="mt-2 block w-full pl-3 pr-10 py-2.5 text-base border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 focus:border-transparent"
                    >
                        <option value="latest">Most Recent</option>
                        <option value="salary">Highest Salary</option>
                        <option value="title">Title (A-Z)</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Job Positions List -->
        <div class="mt-10 space-y-8">
            @forelse($positions as $position)
                <div
                    wire:key="{{ $position->id }}"
                    class="group relative bg-white dark:bg-slate-800 rounded-xl shadow-sm ring-1 ring-slate-900/5 dark:ring-slate-800 hover:shadow-md hover:-translate-y-1 transition-all duration-200"
                >
                    <div class="p-6">
                        <div class="flex items-start space-x-6">
                            <!-- Company Logo -->
                            @if($position->company->logo)
                                <img src="{{ $position->company->logo }}" alt="{{ $position->company->name }}" class="h-12 w-12 rounded-lg object-cover flex-shrink-0">
                            @else
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($position->company->name) }}&background=8B5CF6&color=fff&size=48&bold=true" alt="{{ $position->company->name }}" class="h-12 w-12 rounded-lg object-cover flex-shrink-0">
                            @endif

                            <!-- Content -->
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-xl font-semibold text-slate-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">
                                            <a href="{{ route('positions.show', $position) }}" class="focus:outline-none">
                                                <span class="absolute inset-0" aria-hidden="true"></span>
                                                {{ $position->title }}
                                            </a>
                                        </h3>
                                        <p class="mt-1 text-base font-medium text-slate-500 dark:text-slate-400">
                                            {{ $position->company->name }}
                                        </p>
                                    </div>
                                    <div class="ml-6">
                                        <svg class="h-6 w-6 text-slate-400 group-hover:text-violet-600 dark:text-slate-500 dark:group-hover:text-violet-400 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </div>
                                </div>

                                <div class="mt-4 flex flex-wrap items-center gap-3">
                                    <!-- Category Badge -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-violet-50 text-violet-700 dark:bg-violet-900/50 dark:text-violet-300 ring-1 ring-inset ring-violet-700/10 dark:ring-violet-700">
                                        {{ $position->category->name }}
                                    </span>

                                    <!-- Type Badge -->
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-emerald-50 text-emerald-700 dark:bg-emerald-900/50 dark:text-emerald-300 ring-1 ring-inset ring-emerald-600/10 dark:ring-emerald-500">
                                        {{ $position->type }}
                                    </span>

                                    <!-- Location -->
                                    <span class="inline-flex items-center text-sm text-slate-500 dark:text-slate-400">
                                        <svg class="mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        {{ $position->location }}
                                    </span>

                                    <!-- Salary -->
                                    @if($position->salary_range)
                                        <span class="inline-flex items-center text-sm text-slate-500 dark:text-slate-400">
                                            <svg class="mr-1.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $position->salary_range }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-16">
                    <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                    </svg>
                    <h3 class="mt-4 text-base font-medium text-slate-900 dark:text-white">No positions found</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Try adjusting your search criteria or check back later for new opportunities.</p>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $positions->links() }}
        </div>
    </div>
</div>
