<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between mb-12">
            <div class="flex-1 min-w-0">
                <h2 class="text-3xl font-extrabold tracking-tight text-slate-900 dark:text-white sm:text-4xl">
                    Categories
                </h2>
                <p class="mt-3 max-w-3xl text-lg text-slate-500 dark:text-slate-400">
                    Browse job positions by category to find your next opportunity
                </p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm ring-1 ring-slate-900/5 dark:ring-slate-800 p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Search Categories</label>
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
                            placeholder="Search by category name..."
                        >
                    </div>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-slate-700 dark:text-slate-300">Sort By</label>
                    <select
                        wire:model.live="sortBy"
                        id="sort"
                        class="mt-2 block w-full pl-3 pr-10 py-2.5 text-base border-slate-300 dark:border-slate-600 dark:bg-slate-700 dark:text-white rounded-lg focus:ring-2 focus:ring-violet-500 dark:focus:ring-violet-400 focus:border-transparent"
                    >
                        <option value="name">Name (A-Z)</option>
                        <option value="positions_count">Most Positions</option>
                        <option value="latest">Recently Added</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="mt-10 grid gap-8 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($categories as $category)
                <div
                    wire:key="{{ $category->id }}"
                    class="group relative bg-white dark:bg-slate-800 rounded-xl shadow-sm ring-1 ring-slate-900/5 dark:ring-slate-800 hover:shadow-md hover:-translate-y-1 transition-all duration-200"
                >
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1 min-w-0">
                                <h3 class="text-xl font-semibold text-slate-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors">
                                    <a href="{{ route('positions.index', ['category' => $category->slug]) }}" class="focus:outline-none">
                                        <span class="absolute inset-0" aria-hidden="true"></span>
                                        {{ $category->name }}
                                    </a>
                                </h3>
                                <p class="mt-3 text-base text-slate-500 dark:text-slate-400 line-clamp-3">
                                    {{ $category->description }}
                                </p>
                                <div class="mt-4 flex items-center gap-2">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-violet-50 text-violet-700 dark:bg-violet-900/50 dark:text-violet-300 ring-1 ring-inset ring-violet-700/10 dark:ring-violet-700">
                                        {{ $category->positions_count }} {{ Str::plural('position', $category->positions_count) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-6">
                                <svg class="h-6 w-6 text-slate-400 group-hover:text-violet-600 dark:text-slate-500 dark:group-hover:text-violet-400 transition-colors" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-16">
                        <svg class="mx-auto h-12 w-12 text-slate-400 dark:text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-4 text-base font-medium text-slate-900 dark:text-white">No categories found</h3>
                        <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Try adjusting your search criteria.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $categories->links() }}
        </div>
    </div>
</div>
