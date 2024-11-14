<div class="files-container table-responsive">
    <table class="min-w-full divide-y divide-gray-200">
        @include('pages.file-explorer.partials.files-table.files-table-header')
        <tbody id="files-list" class="bg-white divide-y divide-gray-200">
        @foreach ($directoryContents as $directoryContent)
            @include('pages.file-explorer.partials.files-table.files-table-row', ['directoryContent' => $directoryContent])
        @endforeach
        </tbody>
    </table>
</div>
