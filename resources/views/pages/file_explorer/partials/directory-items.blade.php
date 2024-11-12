@foreach($directoryTree as $directory)
    <li class="directory-item">
        <div class="flex items-center gap-1 py-1 hover:bg-gray-100 rounded cursor-pointer">
            <x-heroicon-s-folder class="w-4 h-4 text-yellow-500" />
            <span>{{ $directory->name }}</span>
        </div>
        @if($directory->children->count() > 0 || $directory->files->count() > 0)
            <ul class="pl-4">
                @include('pages.file_explorer.partials.directory-items', ['directoryTree' => $directory->children])
                @foreach($directory->files as $file)
                    <li class="file-item">
                        <div class="flex items-center gap-1 py-1 hover:bg-gray-100 rounded cursor-pointer">
                            <x-heroicon-s-document class="w-4 h-4 text-gray-500" />
                            <span>{{ $file->name }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach