<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bad Request | {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full antialiased">
    <div class="min-h-full bg-gradient-to-br from-violet-50 to-violet-100 dark:from-slate-900 dark:to-slate-800 px-4 py-16 sm:px-6 sm:py-24 md:grid md:place-items-center lg:px-8">
        <div class="max-w-max mx-auto">
            <main class="sm:flex">
                <p class="text-4xl font-bold tracking-tight text-violet-600 dark:text-violet-400 sm:text-5xl">400</p>
                <div class="sm:ml-6">
                    <div class="sm:border-l sm:border-slate-200 dark:sm:border-slate-700 sm:pl-6">
                        <h1 class="text-4xl font-bold tracking-tight text-slate-900 dark:text-white sm:text-5xl">Bad Request</h1>
                        <p class="mt-3 text-base text-slate-600 dark:text-slate-400">Sorry, we couldn't process your request. Please check your input and try again.</p>
                    </div>
                    <div class="mt-10 flex space-x-3 sm:border-l sm:border-transparent sm:pl-6">
                        <a href="{{ url()->previous() }}" class="inline-flex items-center rounded-md border border-transparent bg-violet-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 dark:focus:ring-offset-slate-900">
                            Go back
                        </a>
                        <a href="{{ route('home') }}" class="inline-flex items-center rounded-md border border-transparent bg-violet-100 px-4 py-2 text-sm font-medium text-violet-700 hover:bg-violet-200 focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 dark:bg-violet-900 dark:text-violet-300 dark:hover:bg-violet-800 dark:focus:ring-offset-slate-900">
                            Return home
                        </a>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
