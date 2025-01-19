<div>
    <!-- Company Header -->
    <header class="bg-white dark:bg-slate-800 shadow">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="lg:flex lg:items-center lg:justify-between">
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
                            <h1 class="text-2xl font-bold text-slate-900 dark:text-white sm:text-3xl sm:truncate">{{ $company->name }}</h1>
                            <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                                <div class="mt-2 flex items-center text-sm text-slate-500 dark:text-slate-400">
                                    <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $company->location }}
                                </div>
                                <div class="mt-2 flex items-center text-sm text-slate-500 dark:text-slate-400">
                                    <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M7 3.5A1.5 1.5 0 018.5 2h3.879a1.5 1.5 0 011.06.44l3.122 3.12A1.5 1.5 0 0117 6.622V12.5a1.5 1.5 0 01-1.5 1.5h-1v-3.379a3 3 0 00-.879-2.121L10.5 5.379A3 3 0 008.379 4.5H7v-1z" />
                                        <path d="M4.5 6A1.5 1.5 0 003 7.5v9A1.5 1.5 0 004.5 18h7a1.5 1.5 0 001.5-1.5v-5.879a1.5 1.5 0 00-.44-1.06L9.44 6.439A1.5 1.5 0 008.378 6H4.5z" />
                                    </svg>
                                    {{ $company->industry }}
                                </div>
                                <div class="mt-2 flex items-center text-sm text-slate-500 dark:text-slate-400">
                                    <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M3.5 2A1.5 1.5 0 002 3.5V15a1.5 1.5 0 001.5 1.5h6.086a1.5 1.5 0 001.06-.44l6.915-6.914A1.5 1.5 0 0018 8.086V3.5A1.5 1.5 0 0016.5 2h-13zM6 6a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 016 6zm3 0a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 019 6zm3 0a.75.75 0 01.75.75v3.5a.75.75 0 01-1.5 0v-3.5A.75.75 0 0112 6z" clip-rule="evenodd" />
                                    </svg>
                                    {{ $company->size }}
                                </div>
                                <div class="mt-2 flex items-center text-sm text-slate-500 dark:text-slate-400">
                                    <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M5.75 2a.75.75 0 01.75.75V4h7V2.75a.75.75 0 011.5 0V4h.25A2.75 2.75 0 0118 6.75v8.5A2.75 2.75 0 0115.25 18H4.75A2.75 2.75 0 012 15.25v-8.5A2.75 2.75 0 014.75 4H5V2.75A.75.75 0 015.75 2zm-1 5.5c-.69 0-1.25.56-1.25 1.25v6.5c0 .69.56 1.25 1.25 1.25h10.5c.69 0 1.25-.56 1.25-1.25v-6.5c0-.69-.56-1.25-1.25-1.25H4.75z" clip-rule="evenodd" />
                                    </svg>
                                    Founded {{ $company->founded_year }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4">
                        <p class="text-slate-600 dark:text-slate-300">{{ $company->description }}</p>
                    </div>
                </div>
                <div class="mt-5 flex lg:ml-4 lg:mt-0">
                    @if($company->website)
                        <a href="{{ $company->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center rounded-md bg-white dark:bg-slate-700 px-3 py-2 text-sm font-semibold text-slate-900 dark:text-white shadow-sm ring-1 ring-inset ring-slate-300 dark:ring-slate-600 hover:bg-slate-50 dark:hover:bg-slate-600">
                            <svg class="-ml-0.5 mr-1.5 h-5 w-5 text-slate-400 dark:text-slate-300" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M4.25 5.5a.75.75 0 00-.75.75v8.5c0 .414.336.75.75.75h8.5a.75.75 0 00.75-.75v-4a.75.75 0 011.5 0v4A2.25 2.25 0 0112.75 17h-8.5A2.25 2.25 0 012 14.75v-8.5A2.25 2.25 0 014.25 4h5a.75.75 0 010 1.5h-5z" clip-rule="evenodd" />
                                <path fill-rule="evenodd" d="M6.194 12.753a.75.75 0 001.06.053L16.5 4.44v2.81a.75.75 0 001.5 0v-4.5a.75.75 0 00-.75-.75h-4.5a.75.75 0 000 1.5h2.553l-9.056 8.194a.75.75 0 00-.053 1.06z" clip-rule="evenodd" />
                            </svg>
                            Visit Website
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </header>

    <!-- Job Positions -->
    <main class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <!-- Search and Sort -->
            <div class="mb-6 flex flex-col sm:flex-row sm:items-center sm:justify-between">
                <div class="flex-1 min-w-0">
                    <div class="max-w-lg flex items-center">
                        <label for="search" class="sr-only">Search positions</label>
                        <div class="relative rounded-md shadow-sm flex-1">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                <svg class="h-5 w-5 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input wire:model.live.debounce.300ms="search" type="search" name="search" id="search" class="block w-full rounded-md border-0 py-1.5 pl-10 text-slate-900 ring-1 ring-inset ring-slate-300 placeholder:text-slate-400 focus:ring-2 focus:ring-inset focus:ring-violet-600 dark:bg-slate-900 dark:text-white dark:ring-slate-700 dark:placeholder:text-slate-500 sm:text-sm sm:leading-6" placeholder="Search positions...">
                        </div>
                    </div>
                </div>
                <div class="mt-3 sm:ml-4 sm:mt-0">
                    <label for="sortBy" class="sr-only">Sort by</label>
                    <select wire:model.live="sortBy" id="sortBy" name="sortBy" class="block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-slate-900 ring-1 ring-inset ring-slate-300 focus:ring-2 focus:ring-violet-600 dark:bg-slate-900 dark:text-white dark:ring-slate-700 dark:focus:ring-violet-500 sm:text-sm sm:leading-6">
                        <option value="latest">Latest</option>
                        <option value="title">Title</option>
                        <option value="salary_high">Highest Salary</option>
                        <option value="salary_low">Lowest Salary</option>
                    </select>
                </div>
            </div>

            <!-- Job Listings -->
            <div class="overflow-hidden bg-white dark:bg-slate-800/50 shadow sm:rounded-md border border-slate-200 dark:border-slate-700/50 backdrop-blur-sm">
                <ul role="list" class="divide-y divide-slate-200 dark:divide-slate-700/50">
                    @forelse ($positions as $position)
                        <li>
                            <a href="{{ route('positions.show', $position) }}" class="block hover:bg-slate-50 dark:hover:bg-slate-700/50">
                                <div class="px-4 py-4 sm:px-6">
                                    <div class="flex items-center justify-between">
                                        <div class="truncate">
                                            <div class="flex items-center space-x-3">
                                                <h2 class="text-sm font-medium text-violet-600 dark:text-violet-400 truncate">{{ $position->title }}</h2>
                                                <span class="inline-flex items-center rounded-md bg-violet-50 dark:bg-violet-400/10 px-2 py-1 text-xs font-medium text-violet-700 dark:text-violet-400 ring-1 ring-inset ring-violet-700/10">{{ $position->type }}</span>
                                            </div>
                                            <div class="mt-2 flex">
                                                <div class="flex items-center text-sm text-slate-500 dark:text-slate-400">
                                                    <svg class="mr-1.5 h-5 w-5 flex-shrink-0 text-slate-400" viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd" d="M9.69 18.933l.003.001C9.89 19.02 10 19 10 19s.11.02.308-.066l.002-.001.006-.003.018-.008a5.741 5.741 0 00.281-.14c.186-.096.446-.24.757-.433.62-.384 1.445-.966 2.274-1.765C15.302 14.988 17 12.493 17 9A7 7 0 103 9c0 3.492 1.698 5.988 3.355 7.584a13.731 13.731 0 002.273 1.765 11.842 11.842 0 00.976.544l.062.029.018.008.006.003zM10 11.25a2.25 2.25 0 100-4.5 2.25 2.25 0 000 4.5z" clip-rule="evenodd" />
                                                    </svg>
                                                    {{ $position->location }}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="ml-2 flex flex-shrink-0">
                                            <span class="inline-flex items-center text-sm text-slate-500 dark:text-slate-400">${{ number_format($position->salary_min) }} - ${{ number_format($position->salary_max) }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @empty
                        <li class="px-4 py-5 sm:px-6">
                            <div class="text-center text-sm text-slate-500 dark:text-slate-400">
                                No positions available at this time.
                            </div>
                        </li>
                    @endforelse
                </ul>
            </div>

            <!-- Pagination -->
            <div class="mt-6">
                {{ $positions->links() }}
            </div>
        </div>
    </main>
</div>
