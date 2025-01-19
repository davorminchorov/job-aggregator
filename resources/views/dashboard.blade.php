<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 dark:text-slate-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <livewire:dashboard />
</x-app-layout>
