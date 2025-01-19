<div class="min-h-screen bg-gradient-to-b from-slate-50 to-white dark:from-slate-900 dark:to-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Header -->
        <div class="bg-gradient-to-b from-white to-slate-50 dark:from-slate-800 dark:to-slate-900 border-b border-slate-200 dark:border-slate-700 pb-8">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-8">
                <!-- Back Button -->
                <a href="{{ route('positions.index') }}" class="inline-flex items-center text-sm font-medium text-slate-600 hover:text-slate-900 dark:text-slate-400 dark:hover:text-white mb-6">
                    <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Positions
                </a>

                <!-- Position Header -->
                <div class="sm:flex items-start justify-between">
                    <div class="flex-1">
                        <div class="sm:flex items-center mb-4">
                            <!-- Company Logo -->
                            <div class="flex-shrink-0 mb-4 sm:mb-0 sm:mr-6">
                                @if($position->company->logo)
                                    <img src="{{ $position->company->logo }}" alt="{{ $position->company->name }}" class="h-12 w-12 rounded-lg object-cover">
                                @else
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($position->company->name) }}&background=818CF8&color=fff&size=48&bold=true" alt="{{ $position->company->name }}" class="h-12 w-12 rounded-lg object-cover">
                                @endif
                            </div>

                            <div>
                                <h1 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $position->title }}</h1>
                                <p class="mt-1 text-lg text-slate-600 dark:text-slate-400">{{ $position->company->name }}</p>
                            </div>
                        </div>

                        <!-- Position Meta -->
                        <div class="flex flex-wrap gap-4 text-sm text-slate-600 dark:text-slate-400">
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

                            <!-- Type -->
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-slate-400 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                                {{ $position->type }}
                            </div>

                            <!-- Category -->
                            <div class="flex items-center">
                                <svg class="h-5 w-5 text-slate-400 mr-1.5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                </svg>
                                {{ $position->category->name }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Main Content -->
                <div class="lg:col-span-2">
                    <!-- Description -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 mb-8">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Description</h2>
                        <div class="prose prose-slate dark:prose-invert max-w-none">
                            {!! $position->description !!}
                        </div>
                    </div>

                    <!-- Requirements -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6 mb-8">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Requirements</h2>
                        <div class="prose prose-slate dark:prose-invert max-w-none">
                            {!! $position->requirements !!}
                        </div>
                    </div>

                    <!-- Benefits -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Benefits</h2>
                        <div class="prose prose-slate dark:prose-invert max-w-none">
                            {!! $position->benefits !!}
                        </div>
                    </div>
                </div>

                <!-- Sidebar -->
                <div class="lg:col-span-1">
                    <!-- Company Info -->
                    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
                        <h2 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">About {{ $position->company->name }}</h2>
                        <div class="prose prose-slate dark:prose-invert max-w-none">
                            <p>{{ $position->company->description }}</p>
                        </div>
                        @if($position->company->website)
                            <div class="mt-6">
                                <a href="{{ $position->company->website }}" target="_blank" rel="noopener noreferrer" class="inline-flex items-center text-sm font-medium text-violet-600 hover:text-violet-700 dark:text-violet-400 dark:hover:text-violet-300">
                                    <svg class="h-5 w-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                                    </svg>
                                    Visit Website
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
