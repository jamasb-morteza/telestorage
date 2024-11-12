<div class="col-span-1 border-r">
    <div class="directory-tree">
        <ul class="list-none">
            <li>
                <x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Root
                <ul class="pl-4">
                    <!-- Directory structure will be populated dynamically -->
                    @include('pages.file_explorer.partials.directory-items')
                </ul>
            </li>
        </ul>
    </div>
</div> 