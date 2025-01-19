<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Back button -->
        <div class="mb-8">
            <a href="{{ route('positions.index') }}" class="inline-flex items-center text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
                Back to Positions
            </a>
        </div>

        <!-- Position Header -->
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm ring-1 ring-slate-900/5 dark:ring-slate-800 p-6 mb-8">
            <div class="flex items-start space-x-6">
                <!-- Company Logo -->
                @if($position->company->logo)
                    <img src="{{ $position->company->logo }}" alt="{{ $position->company->name }}" class="h-16 w-16 rounded-lg object-cover flex-shrink-0">
                @else
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($position->company->name) }}&background=8B5CF6&color=fff&size=64&bold=true" alt="{{ $position->company->name }}" class="h-16 w-16 rounded-lg object-cover flex-shrink-0">
                @endif

                <div class="flex-1 min-w-0">
                    <h1 class="text-2xl font-bold text-slate-900 dark:text-white sm:text-3xl">
                        {{ $position->title }}
                    </h1>
                    <p class="mt-2 text-lg font-medium text-slate-500 dark:text-slate-400">
                        {{ $position->company->name }}
                    </p>
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

        <!-- Position Content -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm ring-1 ring-slate-900/5 dark:ring-slate-800 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Description</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $position->description !!}
                    </div>
                </div>

                <!-- Requirements -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm ring-1 ring-slate-900/5 dark:ring-slate-800 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Requirements</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $position->requirements !!}
                    </div>
                </div>

                <!-- Benefits -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm ring-1 ring-slate-900/5 dark:ring-slate-800 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Benefits</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $position->benefits !!}
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Apply Button -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm ring-1 ring-slate-900/5 dark:ring-slate-800 p-6">
                    <a href="{{ route('positions.apply', $position) }}" class="block w-full text-center px-4 py-2 text-sm font-medium text-white bg-violet-600 hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 dark:focus:ring-offset-slate-800 rounded-lg shadow-sm">
                        Apply for this position
                    </a>
                </div>

                <!-- Company Info -->
                <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm ring-1 ring-slate-900/5 dark:ring-slate-800 p-6">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">About {{ $position->company->name }}</h2>
                    <div class="prose dark:prose-invert">
                        <p>{{ $position->company->description }}</p>
                    </div>
                    @if($position->company->website)
                        <div class="mt-6">
                            <a href="{{ $position->company->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-sm font-medium text-violet-600 hover:text-violet-700 dark:text-violet-400 dark:hover:text-violet-300">
                                Visit website
                                <svg class="ml-1 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path d="M11 3a1 1 0 100 2h2.586l-6.293 6.293a1 1 0 101.414 1.414L15 6.414V9a1 1 0 102 0V4a1 1 0 00-1-1h-5z" />
                                    <path d="M5 5a2 2 0 00-2 2v8a2 2 0 002 2h8a2 2 0 002-2v-3a1 1 0 10-2 0v3H5V7h3a1 1 0 000-2H5z" />
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
