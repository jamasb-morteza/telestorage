<x-app-layout>
    <div class="w-full h-full">
        <!-- Top Navigation Bar -->
        @include('pages.file_explorer.partials.navigation-bar')

        <!-- Main Content -->
        <div class="">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800">
                    <div class="grid grid-cols-4 gap-4">
                        <!-- Left Panel - Directory Structure -->
                        @include('pages.file_explorer.partials.directory-tree')

                        <!-- Main Panel - Files List -->
                        <div id="directory-content" class="col-span-3">
                            @include('pages.file_explorer.partials.files-list')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
