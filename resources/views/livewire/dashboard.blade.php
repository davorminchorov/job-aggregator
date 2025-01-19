<div>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-slate-900 dark:text-slate-100">
                    <h3 class="text-lg font-medium mb-4">{{ __('Bookmarked Job Positions') }}</h3>

                    @if($user->bookmarks->count() > 0)
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                            @foreach($user->bookmarks as $position)
                                <div class="relative flex items-center space-x-3 rounded-lg border border-slate-200 bg-white dark:bg-slate-800/50 dark:border-slate-700/50 px-6 py-5 shadow-sm focus-within:ring-2 focus-within:ring-violet-500 focus-within:ring-offset-2 hover:border-violet-500 dark:hover:border-violet-400">
                                    <div class="flex-shrink-0">
                                        @if($position->company->logo)
                                            <img src="{{ $position->company->logo }}" alt="{{ $position->company->name }}" class="h-10 w-10 rounded-lg object-cover ring-1 ring-slate-900/5 dark:ring-slate-100/10">
                                        @else
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($position->company->name) }}&background=818CF8&color=fff&size=40&bold=true" alt="{{ $position->company->name }}" class="h-10 w-10 rounded-lg object-cover ring-1 ring-slate-900/5 dark:ring-slate-100/10">
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <a href="{{ route('positions.show', $position) }}" class="focus:outline-none">
                                            <span class="absolute inset-0" aria-hidden="true"></span>
                                            <p class="text-sm font-medium text-slate-900 dark:text-slate-100">{{ $position->title }}</p>
                                            <p class="truncate text-sm text-slate-500 dark:text-slate-400">{{ $position->company->name }} • {{ $position->location }}</p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-slate-500 dark:text-slate-400">{{ __('You haven\'t bookmarked any job positions yet. Browse our job listings and bookmark positions you\'re interested in!') }}</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
