<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                {{ __('Dashboard') }}
            </h2>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Job Applications -->
                        <div class="bg-gradient-to-br from-violet-50 to-violet-100 dark:from-violet-900/50 dark:to-violet-800/50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Job Applications</h3>
                            <p class="text-3xl font-bold text-violet-600 dark:text-violet-400">0</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Total applications submitted</p>
                        </div>

                        <!-- Saved Jobs -->
                        <div class="bg-gradient-to-br from-violet-50 to-violet-100 dark:from-violet-900/50 dark:to-violet-800/50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Saved Jobs</h3>
                            <p class="text-3xl font-bold text-violet-600 dark:text-violet-400">0</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Jobs saved for later</p>
                        </div>

                        <!-- Profile Completion -->
                        <div class="bg-gradient-to-br from-violet-50 to-violet-100 dark:from-violet-900/50 dark:to-violet-800/50 p-6 rounded-lg">
                            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Profile Completion</h3>
                            <p class="text-3xl font-bold text-violet-600 dark:text-violet-400">20%</p>
                            <p class="text-sm text-slate-600 dark:text-slate-400 mt-1">Complete your profile to attract employers</p>
                        </div>
                    </div>

                    <!-- Recent Activity -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4">Recent Activity</h3>
                        <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-6">
                            <p class="text-slate-600 dark:text-slate-400">No recent activity to show.</p>
                            <a href="{{ route('positions.index') }}" class="inline-flex items-center mt-4 text-sm text-violet-600 hover:text-violet-500 dark:text-violet-400 dark:hover:text-violet-300">
                                Start browsing jobs
                                <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
