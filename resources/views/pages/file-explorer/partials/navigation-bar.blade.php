<div class="bg-white border-b border-gray-200 dark:bg-gray-800">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <!-- Breadcrumbs -->
                <nav class="flex" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-3">
                        <li class="inline-flex items-center">
                            <a href="#" class="text-gray-700 hover:text-gray-900">
                                <x-heroicon-s-home class="w-5 h-5 mr-2"/>
                                Home
                            </a>
                        </li>
                        <li>
                            <div class="flex items-center">
                                <x-heroicon-s-chevron-right class="w-5 h-5 text-gray-400 mx-2"/>
                                <span class="text-gray-500">Current Directory</span>
                            </div>
                        </li>
                    </ol>
                </nav>
            </div>

            @include('pages.file-explorer.partials.action-buttons')
        </div>
    </div>
</div>
