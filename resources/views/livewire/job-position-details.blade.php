<div class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Back Button -->
        <div class="mb-8">
            <a href="{{ route('positions.index') }}" class="inline-flex items-center text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300">
                <svg class="mr-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Back to Positions
            </a>
        </div>

        <!-- Job Details -->
        <div class="bg-white dark:bg-gray-800 shadow-sm rounded-lg">
            <div class="px-4 py-5 sm:px-6">
                <div class="flex items-start">
                    @php
                        $initials = collect(explode(' ', $position->company->name))->map(function($word) {
                            return strtoupper(substr($word, 0, 1));
                        })->take(2)->join('');
                    @endphp
                    <div class="flex-shrink-0">
                        @if($position->company->logo)
                            <img src="{{ $position->company->logo }}" alt="{{ $position->company->name }}" class="h-12 w-12 rounded-lg object-cover">
                        @else
                            <div class="h-12 w-12 rounded-lg bg-indigo-100 dark:bg-indigo-900 flex items-center justify-center text-lg font-bold text-indigo-600 dark:text-indigo-300">
                                {{ $initials }}
                            </div>
                        @endif
                    </div>
                    <div class="ml-6">
                        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                            {{ $position->title }}
                        </h1>
                        <div class="mt-1 flex items-center text-sm text-gray-600 dark:text-gray-400">
                            <span>{{ $position->company->name }}</span>
                            @if($position->location)
                                <span class="mx-2 text-gray-400 dark:text-gray-500">&middot;</span>
                                <span>{{ $position->location }}</span>
                            @endif
                        </div>
                        <div class="mt-2 flex flex-wrap gap-2">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $position->type === 'full-time' ? 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300' : ($position->type === 'internship' ? 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300' : 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-300') }}">
                                {{ ucfirst($position->type) }}
                            </span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800 dark:bg-indigo-900 dark:text-indigo-300">
                                {{ $position->category->name }}
                            </span>
                            @if($position->salary_min && $position->salary_max)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                    ${{ number_format($position->salary_min) }} - ${{ number_format($position->salary_max) }}
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:px-6">
                <div class="prose dark:prose-invert max-w-none">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">Description</h2>
                    <div class="text-gray-700 dark:text-gray-300">
                        {!! $position->description !!}
                    </div>

                    @if($position->requirements)
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">Requirements</h2>
                        <div class="text-gray-700 dark:text-gray-300">
                            {!! $position->requirements !!}
                        </div>
                    @endif

                    @if($position->benefits)
                        <h2 class="text-xl font-semibold text-gray-900 dark:text-white mt-8 mb-4">Benefits</h2>
                        <div class="text-gray-700 dark:text-gray-300">
                            {!! $position->benefits !!}
                        </div>
                    @endif
                </div>
            </div>
            <div class="border-t border-gray-200 dark:border-gray-700 px-4 py-5 sm:px-6">
                <button wire:click="apply" class="w-full sm:w-auto inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    Apply for this position
                </button>
            </div>
        </div>
    </div>
</div>
