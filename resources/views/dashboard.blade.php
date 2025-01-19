<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-bold text-slate-900 dark:text-white">
                {{ __('Welcome back') }}, {{ auth()->user()->name }}!
            </h2>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <!-- Stats Overview -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Job Applications -->
                <div class="bg-gradient-to-br from-violet-50 to-violet-100 dark:from-violet-900/50 dark:to-violet-800/50 p-6 rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Job Applications</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800 dark:bg-violet-800 dark:text-violet-200">
                            This Week
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-violet-600 dark:text-violet-400">0</p>
                    <div class="mt-1 flex items-center text-sm text-slate-600 dark:text-slate-400">
                        <span>Total applications submitted</span>
                    </div>
                </div>

                <!-- Saved Jobs -->
                <div class="bg-gradient-to-br from-violet-50 to-violet-100 dark:from-violet-900/50 dark:to-violet-800/50 p-6 rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Saved Jobs</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-violet-100 text-violet-800 dark:bg-violet-800 dark:text-violet-200">
                            Active
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-violet-600 dark:text-violet-400">0</p>
                    <div class="mt-1 flex items-center text-sm text-slate-600 dark:text-slate-400">
                        <span>Jobs saved for later</span>
                    </div>
                </div>

                <!-- Profile Completion -->
                <div class="bg-gradient-to-br from-violet-50 to-violet-100 dark:from-violet-900/50 dark:to-violet-800/50 p-6 rounded-lg">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Profile Completion</h3>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-800 dark:bg-amber-800 dark:text-amber-200">
                            In Progress
                        </span>
                    </div>
                    <p class="text-3xl font-bold text-violet-600 dark:text-violet-400">20%</p>
                    <div class="mt-1 flex items-center text-sm text-slate-600 dark:text-slate-400">
                        <span>Complete your profile to attract employers</span>
                    </div>
                </div>
            </div>

            <!-- Profile Completion Guide -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Complete Your Profile</h3>
                        <a href="{{ route('profile') }}" class="text-sm text-violet-600 hover:text-violet-500 dark:text-violet-400 dark:hover:text-violet-300" wire:navigate>
                            View Profile
                        </a>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="w-8 h-8 flex items-center justify-center rounded-full bg-violet-100 dark:bg-violet-900/50">
                                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-900 dark:text-white">Add Profile Picture</p>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Help employers put a face to your name</p>
                            </div>
                            <div class="ml-auto">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200">
                                    Pending
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="w-8 h-8 flex items-center justify-center rounded-full bg-violet-100 dark:bg-violet-900/50">
                                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-900 dark:text-white">Upload Resume</p>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Add your resume to apply with one click</p>
                            </div>
                            <div class="ml-auto">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200">
                                    Pending
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <span class="w-8 h-8 flex items-center justify-center rounded-full bg-violet-100 dark:bg-violet-900/50">
                                    <svg class="w-5 h-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </span>
                            </div>
                            <div class="ml-4">
                                <p class="text-sm font-medium text-slate-900 dark:text-white">Add Work Experience</p>
                                <p class="text-sm text-slate-600 dark:text-slate-400">Share your professional journey</p>
                            </div>
                            <div class="ml-auto">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-800 dark:text-red-200">
                                    Pending
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recommended Jobs -->
            <div class="bg-white dark:bg-slate-800 overflow-hidden shadow-lg rounded-lg">
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-slate-900 dark:text-white">Recommended Jobs</h3>
                        <a href="{{ route('positions.index') }}" class="text-sm text-violet-600 hover:text-violet-500 dark:text-violet-400 dark:hover:text-violet-300" wire:navigate>
                            View All Jobs
                        </a>
                    </div>
                    <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-6">
                        <p class="text-slate-600 dark:text-slate-400">Complete your profile to get personalized job recommendations.</p>
                        <a href="{{ route('positions.index') }}" class="inline-flex items-center mt-4 text-sm text-violet-600 hover:text-violet-500 dark:text-violet-400 dark:hover:text-violet-300" wire:navigate>
                            Browse all positions
                            <svg class="ml-1 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
