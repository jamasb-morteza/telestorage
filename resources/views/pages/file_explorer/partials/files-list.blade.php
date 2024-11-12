<div class="col-span-3">
    <div class="files-container">
        <table class="min-w-full divide-y divide-gray-200">
            @include('pages.file_explorer.partials.files-header')
            <tbody id="files-list" class="bg-white divide-y divide-gray-200">
                @foreach ($contents as $content)
                    @include('pages.file_explorer.partials.file-row', ['content' => $content])
                @endforeach
            </tbody>
        </table>
    </div>
</div> 