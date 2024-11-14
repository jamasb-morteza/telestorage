<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl ">
            {{ __('Explorer') }}
        </h2>
    </x-slot>
    <hr>
    <div class="py-0">
        <div class="shadow">
            <div class="w-full px-2 sm:px-6 lg:px-8 ">
                @include('pages.file-explorer.partials.navigation-bar')
            </div>
        </div>

        <div class="max-w mx-auto">
            <div class="p-3 text-gray-900 dark:text-gray-100">
                <div class="grid grid-cols-5 gap-2">
                    <!-- Left Panel - Directory Structure -->
                    <div class="col-span-1 p-4 px-2 bg-white dark:bg-gray-800">
                        @include('pages.file-explorer.partials.navigation.navigation-tree')
                    </div>
                    <!-- Main Panel - Files List -->
                    <div id="directory-content" class="col-span-4 h-svh">
                        <div class="dark:bg-gray-800">
                            @include('pages.file-explorer.partials.files-table.files-table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

{{--
<x-app-layout>
    <div class="w-full h-full">
        <!-- Top Navigation Bar -->


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
