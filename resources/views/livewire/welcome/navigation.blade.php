<nav x-data="{ open: false }" class="bg-white dark:bg-slate-800 border-b border-slate-200 dark:border-slate-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('positions.index') }}" wire:navigate class="flex items-center">
                        <svg class="h-8 w-auto text-violet-600 dark:text-violet-400" viewBox="0 0 200 40">
                            <text x="0" y="30" font-family="ui-sans-serif" font-weight="bold" font-size="24">
                                <tspan fill="currentColor">Job</tspan>
                                <tspan fill="#818CF8">Nexus</tspan>
                            </text>
                        </svg>
                    </a>
                </div>

                @auth
                    <!-- Navigation Links -->
                    <div class="hidden sm:ml-6 sm:flex sm:space-x-8">
                        <a href="{{ route('positions.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('positions.*') ? 'text-slate-900 dark:text-white border-b-2 border-violet-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300' }}" wire:navigate>
                            {{ __('Positions') }}
                        </a>
                        <a href="{{ route('categories.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('categories.*') ? 'text-slate-900 dark:text-white border-b-2 border-violet-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300' }}" wire:navigate>
                            {{ __('Categories') }}
                        </a>
                        <a href="{{ route('companies.index') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('companies.*') ? 'text-slate-900 dark:text-white border-b-2 border-violet-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300' }}" wire:navigate>
                            {{ __('Companies') }}
                        </a>
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-1 pt-1 text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-slate-900 dark:text-white border-b-2 border-violet-500' : 'text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300' }}" wire:navigate>
                            {{ __('Dashboard') }}
                        </a>
                    </div>
                @endauth
            </div>

            <div class="flex items-center">
                <!-- Theme toggle -->
                <button
                    x-data="{
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
                    }"
                    x-on:click="toggleDarkMode()"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors focus:outline-none focus:ring-2 focus:ring-violet-500 focus:ring-offset-2 dark:focus:ring-offset-slate-800 mr-4"
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

                @auth
                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none transition ease-in-out duration-150">
                                    <div x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>

                                    <div class="ml-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile')" wire:navigate>
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <button wire:click="logout" class="w-full text-left px-4 py-2 text-sm text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-700 focus:outline-none transition duration-150 ease-in-out">
                                    {{ __('Log Out') }}
                                </button>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Hamburger -->
                    <div class="-mr-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-slate-500 dark:text-slate-400 hover:text-slate-900 dark:hover:text-slate-100 focus:outline-none transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                @else
                    <div class="flex items-center space-x-4">
                        <a
                            href="{{ route('login') }}"
                            class="text-sm font-medium text-slate-500 dark:text-slate-400 hover:text-slate-700 dark:hover:text-slate-300 focus:outline-none transition"
                            wire:navigate
                        >
                            {{ __('Sign in') }}
                        </a>

                        @if (Route::has('register'))
                            <a
                                href="{{ route('register') }}"
                                class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-violet-600 border border-transparent rounded-lg shadow-sm hover:bg-violet-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-violet-500 dark:focus:ring-offset-slate-800"
                                wire:navigate
                            >
                                {{ __('Sign up') }}
                            </a>
                        @endif
                    </div>
                @endauth
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    @auth
        <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
            <div class="pt-2 pb-3 space-y-1">
                <x-responsive-nav-link :href="route('positions.index')" :active="request()->routeIs('positions.*')" wire:navigate>
                    {{ __('Positions') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.*')" wire:navigate>
                    {{ __('Categories') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('companies.index')" :active="request()->routeIs('companies.*')" wire:navigate>
                    {{ __('Companies') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')" wire:navigate>
                    {{ __('Dashboard') }}
                </x-responsive-nav-link>
            </div>

            <!-- Responsive Settings Options -->
            <div class="pt-4 pb-1 border-t border-slate-200 dark:border-slate-700">
                <div class="px-4">
                    <div class="font-medium text-base text-slate-800 dark:text-slate-200" x-data="{{ json_encode(['name' => auth()->user()->name]) }}" x-text="name" x-on:profile-updated.window="name = $event.detail.name"></div>
                    <div class="font-medium text-sm text-slate-500">{{ auth()->user()->email }}</div>
                </div>

                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('profile')" wire:navigate>
                        {{ __('Profile') }}
                    </x-responsive-nav-link>

                    <!-- Authentication -->
                    <button wire:click="logout" class="w-full text-left block pl-3 pr-4 py-2 border-l-4 border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-800 dark:hover:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 hover:border-slate-300 dark:hover:border-slate-600 focus:outline-none transition duration-150 ease-in-out">
                        {{ __('Log Out') }}
                    </button>
                </div>
            </div>
        </div>
    @endauth
</nav>
