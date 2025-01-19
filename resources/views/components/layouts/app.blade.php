<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', mobileMenuOpen: false }" x-init="$watch('darkMode', val => localStorage.setItem('darkMode', val))" :class="{ 'dark': darkMode }">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Job Aggregator' }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 dark:bg-gray-900">
    <nav class="bg-white dark:bg-gray-800 shadow">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex">
                    <div class="flex-shrink-0 flex items-center">
                        <a href="/" class="text-xl font-bold text-indigo-600 dark:text-indigo-400">Job Aggregator</a>
                    </div>
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('positions.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('positions.*') ? 'text-gray-900 dark:text-white border-b-2 border-indigo-500' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                            Positions
                        </a>
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('categories.*') ? 'text-gray-900 dark:text-white border-b-2 border-indigo-500' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }}">
                            Categories
                        </a>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <!-- Auth Links -->
                    <div class="hidden sm:flex sm:items-center sm:space-x-4">
                        <a href="{{ route('login') }}" class="text-sm font-medium text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-300">
                            Sign in
                        </a>
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                            Sign up
                        </a>
                    </div>
                    <!-- Mobile menu button -->
                    <div class="sm:hidden">
                        <button
                            type="button"
                            class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none"
                            x-on:click="mobileMenuOpen = !mobileMenuOpen"
                        >
                            <span class="sr-only">Open main menu</span>
                            <svg
                                x-show="!mobileMenuOpen"
                                class="h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg
                                x-show="mobileMenuOpen"
                                class="h-6 w-6"
                                xmlns="http://www.w3.org/2000/svg"
                                fill="none"
                                viewBox="0 0 24 24"
                                stroke="currentColor"
                            >
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <!-- Theme toggle -->
                    <button
                        x-on:click="darkMode = !darkMode"
                        class="inline-flex items-center justify-center p-2 rounded-md text-gray-500 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 focus:outline-none"
                        title="Toggle theme"
                    >
                        <span x-show="!darkMode" class="w-5 h-5">
                            <!-- Moon icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z" />
                            </svg>
                        </span>
                        <span x-show="darkMode" class="w-5 h-5">
                            <!-- Sun icon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v2.25m6.364.386l-1.591 1.591M21 12h-2.25m-.386 6.364l-1.591-1.591M12 18.75V21m-4.773-4.227l-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" />
                            </svg>
                        </span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile menu -->
        <div x-show="mobileMenuOpen" class="sm:hidden bg-white dark:bg-gray-800 border-t border-gray-200 dark:border-gray-700">
            <div class="pt-2 pb-3 space-y-1">
                <a href="{{ route('positions.index') }}" class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('positions.*') ? 'text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 border-l-4 border-indigo-500' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                    Positions
                </a>
                <a href="{{ route('categories.index') }}" class="block pl-3 pr-4 py-2 text-base font-medium {{ request()->routeIs('categories.*') ? 'text-indigo-700 dark:text-indigo-300 bg-indigo-50 dark:bg-indigo-900/50 border-l-4 border-indigo-500' : 'text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white' }}">
                    Categories
                </a>
                <div class="pt-4 pb-3 border-t border-gray-200 dark:border-gray-700">
                    <div class="space-y-1">
                        <a href="{{ route('login') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">
                            Sign in
                        </a>
                        <a href="{{ route('register') }}" class="block pl-3 pr-4 py-2 text-base font-medium text-gray-600 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 hover:text-gray-900 dark:hover:text-white">
                            Sign up
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <main>
        {{ $slot }}
    </main>
</body>
</html>
