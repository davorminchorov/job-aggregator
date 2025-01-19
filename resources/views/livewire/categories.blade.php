<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="md:flex md:items-center md:justify-between">
            <div class="flex-1 min-w-0">
                <h2 class="text-2xl font-bold leading-7 text-gray-900 dark:text-white sm:text-3xl sm:truncate">
                    Categories
                </h2>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Browse job positions by category
                </p>
            </div>
        </div>

        <!-- Filters -->
        <div class="mt-8 bg-white rounded-lg shadow-sm p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <!-- Search -->
                <div>
                    <label for="search" class="block text-sm font-medium text-gray-700">Search Categories</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input wire:model.live="search" type="text" name="search" id="search" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full pl-10 sm:text-sm border-gray-300 rounded-md" placeholder="Search by category name...">
                    </div>
                </div>

                <!-- Sort -->
                <div>
                    <label for="sort" class="block text-sm font-medium text-gray-700">Sort By</label>
                    <select wire:model.live="sortBy" id="sort" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="name">Name (A-Z)</option>
                        <option value="positions_count">Most Positions</option>
                        <option value="latest">Recently Added</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- Categories Grid -->
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse($categories as $category)
                <div wire:key="{{ $category->id }}" class="bg-white dark:bg-gray-800 overflow-hidden rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">
                                    <a href="{{ route('positions.index', ['category' => $category->slug]) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400">
                                        {{ $category->name }}
                                    </a>
                                </h3>
                                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                    {{ $category->description }}
                                </p>
                                <div class="mt-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                        {{ $category->positions_count }} {{ Str::plural('position', $category->positions_count) }}
                                    </span>
                                </div>
                            </div>
                            <div class="ml-4">
                                <a href="{{ route('positions.index', ['category' => $category->slug]) }}" class="text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300">
                                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full">
                    <div class="text-center py-12">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900">No categories found</h3>
                        <p class="mt-1 text-sm text-gray-500">Try adjusting your search criteria.</p>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="mt-8">
            {{ $categories->links() }}
        </div>
    </div>
</div>
