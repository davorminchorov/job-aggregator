<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-950 dark:via-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('companies.index') }}" class="inline-flex items-center text-sm font-medium text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Companies
            </a>
        </div>

        <!-- Company Header -->
        <div class="bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 backdrop-blur-sm">
            <div class="lg:flex lg:items-start lg:justify-between">
                <div class="min-w-0 flex-1">
                    <div class="flex items-center">
                        <!-- Company Logo -->
                        <div class="flex-shrink-0">
                            @if($company->logo)
                                <img src="{{ $company->logo }}" alt="{{ $company->name }}" class="h-16 w-16 rounded-lg object-cover ring-1 ring-slate-900/5 dark:ring-slate-100/10">
                            @else
                                <div class="h-16 w-16 rounded-lg bg-violet-600/10 dark:bg-violet-400/10 flex items-center justify-center ring-1 ring-slate-900/5 dark:ring-slate-100/10">
                                    <span class="text-2xl font-bold text-violet-600 dark:text-violet-400">{{ substr($company->name, 0, 1) }}</span>
                                </div>
                            @endif
                        </div>

                        <!-- Company Info -->
                        <div class="ml-4">
                            <h1 class="text-2xl font-bold text-slate-900 dark:text-white sm:text-3xl">{{ $company->name }}</h1>
                            <div class="mt-4 flex flex-wrap gap-4">
                                <div class="flex items-center text-sm text-slate-600 dark:text-slate-300">
                                    <svg class="mr-1.5 h-5 w-5 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                    {{ $company->location }}
                                </div>
                                <div class="flex items-center text-sm text-slate-600 dark:text-slate-300">
                                    <svg class="mr-1.5 h-5 w-5 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    {{ $company->industry }}
                                </div>
                                <div class="flex items-center text-sm text-slate-600 dark:text-slate-300">
                                    <svg class="mr-1.5 h-5 w-5 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    {{ $company->size }}
                                </div>
                                <div class="flex items-center text-sm text-slate-600 dark:text-slate-300">
                                    <svg class="mr-1.5 h-5 w-5 text-slate-400 dark:text-slate-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Founded {{ $company->founded_year }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-6">
                        <p class="text-slate-600 dark:text-slate-300">{{ $company->description }}</p>
                    </div>
                </div>
                <div class="mt-6 lg:ml-4 lg:mt-0">
                    @if($company->website)
                        <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center px-4 py-2 text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 dark:bg-violet-500 dark:hover:bg-violet-600 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                            <svg class="h-5 w-5 mr-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                            </svg>
                            Visit Website
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Job Positions -->
        <div class="mt-8">
            <div class="bg-gradient-to-b from-white to-slate-50 dark:from-slate-800 dark:to-slate-900/50 border-b border-slate-200 dark:border-slate-800 pb-8">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                    <h2 class="text-2xl font-bold text-slate-900 dark:text-white mb-4">Open Positions</h2>
                    <p class="text-lg text-slate-600 dark:text-slate-300">Current job opportunities at {{ $company->name }}.</p>

                    <!-- Filters -->
                    <div class="mt-8 bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-4 sm:p-6 backdrop-blur-sm">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
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

                            <!-- Sort -->
                            <div>
                                <label for="sortBy" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1">Sort By</label>
                                <select
                                    wire:model.live="sortBy"
                                    id="sortBy"
                                    class="block w-full py-2.5 pl-3 pr-10 text-sm border-slate-300 dark:border-slate-600/50 rounded-lg bg-white dark:bg-slate-800 text-slate-900 dark:text-slate-100 focus:ring-2 focus:ring-violet-500 focus:border-violet-500 dark:focus:ring-violet-400 dark:focus:border-violet-400"
                                >
                                    <option value="latest">Latest</option>
                                    <option value="title">Title</option>
                                    <option value="salary_high">Highest Salary</option>
                                    <option value="salary_low">Lowest Salary</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                @if ($positions->count() > 0)
                    <div class="space-y-6">
                        @foreach($positions as $position)
                            <div class="group">
                                <a href="{{ route('positions.show', $position) }}" class="block">
                                    <div class="bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 hover:border-violet-500 dark:hover:border-violet-400 hover:ring-1 hover:ring-violet-500 dark:hover:ring-violet-400 transition duration-150 backdrop-blur-sm">
                                        <div class="flex items-start justify-between">
                                            <div>
                                                <h3 class="text-lg font-semibold text-slate-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-300">
                                                    {{ $position->title }}
                                                </h3>
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
                                            <div class="flex flex-col items-end gap-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800 dark:bg-violet-400/10 dark:text-violet-300 dark:ring-1 dark:ring-inset dark:ring-violet-400/20">
                                                    {{ $position->type }}
                                                </span>
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
                        <h3 class="mt-4 text-lg font-medium text-slate-900 dark:text-white">No positions available</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">There are currently no open positions at {{ $company->name }}.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
