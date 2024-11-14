<div class="flex justify-between">
    <!-- Breadcrumbs -->
    <nav class="flex" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="#" class="text-gray-700 hover:text-gray-900">
                    <div class="flex justify-start">
                        <x-heroicon-o-home class="w-5 h-5 mr-2"/>
                        <span>Home</span>
                    </div>
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
    @include('pages.file-explorer.partials.action-buttons')
</div>

