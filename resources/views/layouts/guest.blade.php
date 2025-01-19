<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" x-data="{
    darkMode: localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
    toggleDarkMode() {
        if (this.darkMode) {
            localStorage.theme = 'light'
            document.documentElement.classList.remove('dark')
        } else {
            localStorage.theme = 'dark'
            document.documentElement.classList.add('dark')
        }
        this.darkMode = !this.darkMode
    }
}" x-init="$nextTick(() => {
    if (darkMode) {
        document.documentElement.classList.add('dark')
    } else {
        document.documentElement.classList.remove('dark')
    }
})" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'JobNexus') }}</title>

        <!-- Favicon -->
        <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>JN</text></svg>">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 dark:bg-slate-900">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-slate-50 to-slate-100 dark:from-slate-900 dark:to-slate-800">
            <div>
                <a href="/" wire:navigate class="flex items-center">
                    <svg class="h-12 w-auto text-violet-600 dark:text-violet-400" viewBox="0 0 200 40">
                        <text x="0" y="30" font-family="ui-sans-serif" font-weight="bold" font-size="24">
                            <tspan fill="currentColor">Job</tspan>
                            <tspan fill="#818CF8">Nexus</tspan>
                        </text>
                    </svg>
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-8 py-6 bg-white dark:bg-slate-800 shadow-lg rounded-lg">
                {{ $slot }}
            </div>

            <!-- Theme toggle -->
            <div class="mt-6">
                <button
                    x-on:click="toggleDarkMode()"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800"
                    :class="darkMode ? 'bg-violet-600' : 'bg-slate-200'"
                    title="Toggle theme"
                >
                    <span
                        class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                        :class="darkMode ? 'translate-x-6' : 'translate-x-1'"
                        aria-hidden="true"
                    >
                    </span>
                    <span class="sr-only">Toggle dark mode</span>
                </button>
            </div>
        </div>
    </body>
</html>
