<div class="relative" x-data="{ open: false }">
    <button @click="open = !open"
            class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-700 text-white rounded-md hover:bg-gray-700 dark:hover:bg-gray-600">
        <x-heroicon-s-cog class="w-5 h-5 mr-2 text-yellow-400 animate-spin"/>
        Actions
        <x-heroicon-s-chevron-down class="w-4 h-4 ml-2"/>
    </button>
    <div x-show="open"
         @click.away="open = false"
         class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 rounded-md shadow-lg"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95">
        <div class="py-1">
            @include('pages.file-explorer.partials.action-buttons-list')
        </div>
    </div>
</div>
