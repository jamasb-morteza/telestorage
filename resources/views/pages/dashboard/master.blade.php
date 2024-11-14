<x-app-layout>
    <x-slot name="header">
        <div class="flex"></div>
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>
    <hr>
    <div class="py-0">
        <div class="max-w mx-auto">
            <div class="p-6 text-gray-900 dark:text-gray-100">
                {{ __("You're logged in!") }}
            </div>
        </div>
    </div>
</x-app-layout>
