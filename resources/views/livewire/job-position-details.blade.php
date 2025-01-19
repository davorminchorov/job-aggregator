<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-950 dark:via-slate-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('positions.index') }}" class="inline-flex items-center text-sm font-medium text-slate-600 hover:text-slate-900 dark:text-slate-300 dark:hover:text-white">
                <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Positions
            </a>
        </div>

        <!-- Position Header -->
        <div class="bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 backdrop-blur-sm">
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
                            <h1 class="text-2xl font-bold text-slate-900 dark:text-white">
                                {{ $position->title }}
                            </h1>
                            <p class="mt-1 text-lg text-slate-600 dark:text-slate-300">
                                {{ $position->company->name }}
                            </p>
                        </div>
                        <div class="flex flex-col items-end gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800 dark:bg-violet-400/10 dark:text-violet-300 dark:ring-1 dark:ring-inset dark:ring-violet-400/20">
                                {{ $position->type }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-400/10 dark:text-emerald-300 dark:ring-1 dark:ring-inset dark:ring-emerald-400/20">
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
                        <div class="flex items-center">
                            <svg class="h-5 w-5 text-slate-400 dark:text-slate-500 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            {{ $position->salary_range }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="mt-8 grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Description -->
                <div class="bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 backdrop-blur-sm">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Description</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $position->description !!}
                    </div>
                </div>

                <!-- Requirements -->
                <div class="bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 backdrop-blur-sm">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Requirements</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $position->requirements !!}
                    </div>
                </div>

                <!-- Benefits -->
                <div class="bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 backdrop-blur-sm">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Benefits</h2>
                    <div class="prose dark:prose-invert max-w-none">
                        {!! $position->benefits !!}
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Company Info -->
                <div class="bg-white dark:bg-slate-800/50 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700/50 p-6 backdrop-blur-sm">
                    <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">About {{ $position->company->name }}</h2>
                    <div class="prose dark:prose-invert max-w-none mb-4">
                        <p>{{ $position->company->description }}</p>
                    </div>
                    <a href="{{ $position->company->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-sm font-medium text-violet-600 hover:text-violet-700 dark:text-violet-400 dark:hover:text-violet-300">
                        Visit Website
                        <svg class="h-5 w-5 ml-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
