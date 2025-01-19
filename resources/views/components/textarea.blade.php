@props(['disabled' => false])

<textarea {{ $disabled ? 'disabled' : '' }} {!! $attributes->merge(['class' => 'mt-1 block w-full rounded-md border-slate-300 shadow-sm focus:border-violet-500 focus:ring-violet-500 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-300 dark:focus:border-violet-500 dark:focus:ring-violet-500 sm:text-sm']) !!}></textarea>
