<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-950 dark:via-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="bg-gradient-to-b from-white to-slate-50 dark:from-slate-800 dark:to-slate-900/50 border-b border-slate-200 dark:border-slate-800 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                <h1 class="text-3xl font-bold text-slate-900 dark:text-white mb-4">Browse Companies</h1>
                <p class="text-lg text-slate-600 dark:text-slate-300">Discover great companies hiring in your field.</p>

                <!-- Filters -->
                <div class="mt-8 bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-4 sm:p-6 backdrop-blur-sm">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Search -->
                        <div>
                            <label for="search" class="block text-sm font-medium text-slate-700 dark:text-slate-200 mb-1">Search Companies</label>
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
                                    placeholder="Search companies..."
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
                                <option value="name">Name</option>
                                <option value="positions_count">Most Positions</option>
                                <option value="latest">Latest</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Companies Grid -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            @if ($companies->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($companies as $company)
                        <div class="group">
                            <a href="{{ route('companies.show', $company) }}" class="block">
                                <div class="bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 hover:border-violet-500 dark:hover:border-violet-400 hover:ring-1 hover:ring-violet-500 dark:hover:ring-violet-400 transition duration-150 backdrop-blur-sm">
                                    <div class="flex items-center space-x-4">
                                        <!-- Company Logo -->
                                        <div class="flex-shrink-0">
                                            @if($company->logo)
                                                <img src="{{ $company->logo }}" alt="{{ $company->name }}" class="h-12 w-12 rounded-lg object-cover ring-1 ring-slate-900/5 dark:ring-slate-100/10">
                                            @else
                                                <div class="h-12 w-12 rounded-lg bg-violet-600/10 dark:bg-violet-400/10 flex items-center justify-center ring-1 ring-slate-900/5 dark:ring-slate-100/10">
                                                    <span class="text-lg font-bold text-violet-600 dark:text-violet-400">{{ substr($company->name, 0, 1) }}</span>
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Company Info -->
                                        <div class="min-w-0 flex-1">
                                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-300 truncate">
                                                {{ $company->name }}
                                            </h3>
                                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">{{ $company->location }}</p>
                                        </div>
                                    </div>

                                    <!-- Company Details -->
                                    <div class="mt-4">
                                        <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-2">{{ $company->description }}</p>
                                        <div class="mt-4 flex items-center justify-between">
                                            <div class="flex items-center space-x-2">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800 dark:bg-violet-400/10 dark:text-violet-300 dark:ring-1 dark:ring-inset dark:ring-violet-400/20">
                                                    {{ $company->industry }}
                                                </span>
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-100 text-slate-800 dark:bg-slate-400/10 dark:text-slate-300 dark:ring-1 dark:ring-inset dark:ring-slate-400/20">
                                                    {{ $company->size }}
                                                </span>
                                            </div>
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-400/10 dark:text-emerald-300 dark:ring-1 dark:ring-inset dark:ring-emerald-400/20">
                                                {{ $company->job_positions_count }} {{ Str::plural('position', $company->job_positions_count) }}
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
                    {{ $companies->links() }}
                </div>
            @else
                <div class="text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-slate-900 dark:text-white">No companies found</h3>
                    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Try adjusting your search to find what you're looking for.</p>
                </div>
            @endif
        </div>
    </div>
</div>
