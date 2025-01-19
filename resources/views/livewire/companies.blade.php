<div>
    <!-- Header -->
    <header class="bg-white dark:bg-slate-800 shadow">
        <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 dark:text-white">Companies</h1>
                <div class="flex items-center space-x-4">
                    <!-- Search -->
                    <div class="flex items-center">
                        <label for="search" class="sr-only">Search companies</label>
                        <div class="relative rounded-md shadow-sm">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="search" name="search" id="search" class="block w-full rounded-md border-0 py-1.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-violet-600 dark:bg-slate-900 dark:text-white dark:ring-slate-700 dark:placeholder:text-slate-500 dark:focus:ring-violet-500 sm:text-sm sm:leading-6" placeholder="Search companies...">
                        </div>
                    </div>

                    <!-- Sort -->
                    <div class="flex items-center">
                        <label for="sortBy" class="sr-only">Sort by</label>
                        <select wire:model.live="sortBy" id="sortBy" name="sortBy" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-violet-600 dark:bg-slate-900 dark:text-white dark:ring-slate-700 dark:focus:ring-violet-500 sm:text-sm sm:leading-6">
                            <option value="name">Name</option>
                            <option value="positions_count">Most positions</option>
                            <option value="latest">Latest</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Companies Grid -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @forelse ($companies as $company)
                    <article class="relative group bg-white dark:bg-slate-800/50 rounded-xl shadow-sm hover:shadow-md transition-shadow duration-300 border border-slate-200 dark:border-slate-700/50 overflow-hidden backdrop-blur-sm">
                        <a href="{{ route('companies.show', $company) }}" class="block p-6">
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
                                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white truncate">{{ $company->name }}</h2>
                                    <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">{{ $company->location }}</p>
                                </div>
                            </div>

                            <!-- Company Details -->
                            <div class="mt-4">
                                <p class="text-sm text-slate-600 dark:text-slate-300 line-clamp-2">{{ $company->description }}</p>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-2">
                                        <span class="inline-flex items-center rounded-md bg-violet-50 dark:bg-violet-400/10 px-2 py-1 text-xs font-medium text-violet-700 dark:text-violet-400 ring-1 ring-inset ring-violet-700/10">{{ $company->industry }}</span>
                                        <span class="inline-flex items-center rounded-md bg-slate-50 dark:bg-slate-400/10 px-2 py-1 text-xs font-medium text-slate-600 dark:text-slate-400 ring-1 ring-inset ring-slate-600/10">{{ $company->size }}</span>
                                    </div>
                                    <span class="text-sm text-slate-500 dark:text-slate-400">{{ $company->job_positions_count }} {{ Str::plural('position', $company->job_positions_count) }}</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="col-span-full">
                        <p class="text-center text-slate-500 dark:text-slate-400">No companies found.</p>
                    </div>
                @endforelse
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $companies->links() }}
            </div>
        </div>
    </main>
</div>
