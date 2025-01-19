<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <h3 class="text-lg font-medium mb-4">{{ __('Bookmarked Job Positions') }}</h3>

                    @if($user->bookmarks->count() > 0)
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($user->bookmarks as $position)
                                <div class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white dark:bg-gray-700 dark:border-gray-600 px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-violet-500 focus-within:ring-offset-2 hover:border-gray-400">
                                    <div class="flex-shrink-0">
                                        <img class="h-10 w-10 rounded-full" src="{{ $position->company->logo_url }}" alt="{{ $position->company->name }}">
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('positions.show', $position) }}" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100">{{ $position->title }}</p>
                                            <p class="truncate text-sm text-gray-500 dark:text-gray-400">{{ $position->company->name }} • {{ $position->location }}</p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 dark:text-gray-400">{{ __('You haven\'t bookmarked any job positions yet. Browse our job listings and bookmark positions you\'re interested in!') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
