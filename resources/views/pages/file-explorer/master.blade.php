<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Explorer') }}
        </h2>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{--
<x-app-layout>
    <div class="w-full h-full">
        <!-- Top Navigation Bar -->
        @include('pages.file-explorer.partials.navigation-bar')

        <!-- Main Content -->
        <div class="h-max">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800">
                    <div class="grid grid-cols-4 gap-4">
                        <!-- Left Panel - Directory Structure -->
                        @include('pages.file-explorer.partials.navigation.navigation-tree')

                        <!-- Main Panel - Files List -->
                        <div id="directory-content" class="col-span-3 h-svh">
                            <div class="dark:bg-gray-800">
                                @include('pages.file-explorer.partials.files-table.files-table')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
--}}
