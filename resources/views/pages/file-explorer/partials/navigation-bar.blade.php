<div class="flex justify-between py-2 text-gray-700 hover:text-gray-900 dark:text-gray-300 dark:hover:text-gray-200">
    <!-- Breadcrumbs -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 text-sm">
            <li class="inline-flex items-center">
                <a href="#">
                    <div class="flex justify-start">
                        <x-heroicon-o-home class="w-5 h-5 mr-2"/>
                        <span>Home</span>
                    </div>
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <x-heroicon-s-chevron-right class="w-5 h-5 mx-2"/>
                    <span class="text-gray-500">Current Directory</span>
                </div>
            </li>
        </ol>
    </nav>
    <div>
        @include('pages.file-explorer.partials.action-buttons')
    </div>
</div>

