<x-filament-panels::page>
    <x-slot name="header">
        <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
            {{ __('Example Page') }}
        </h1>
    </x-slot>

    <div class="p-4">
        <p class="text-gray-700 dark:text-gray-300">
            {{ __('This is an example page using Filament Panels.') }}
        </p>
    </div>

    {{--<x-filament-panels::footer>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Footer content goes here.') }}
        </p>
    </x-filament-panels::footer>--}}
</x-filament-panels::page>
