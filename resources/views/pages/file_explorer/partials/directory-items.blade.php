@foreach($directoryTree as $directory)
    <li class="directory-item">
        <div class="flex items-center gap-1 py-1 hover:bg-gray-100 rounded cursor-pointer" 
             onclick="toggleDirectory(this)"
             x-data="{ expanded: {{ $directory->name === 'Root' ? 'true' : 'false' }} }"
             x-bind:class="{ 'expanded': expanded }"
             hx-get="{{ route('file-explorer.directory.content', ['directoryId' => $directory->id]) }}"
             hx-target="#directory-content"
             hx-trigger="click">
            <div class="flex items-center">
                <x-heroicon-o-chevron-down class="w-3 h-3 text-gray-400 transition-transform duration-300" 
                    x-bind:class="{ 'rotate-[-90deg]': !expanded }" />
                <x-heroicon-o-folder class="w-4 h-4 text-gray-400 ml-1" />
            </div>
            <span>{{ $directory->name }}</span>
        </div>
        @if($directory->children->count() > 0 || $directory->files->count() > 0)
            <ul class="pl-4 overflow-hidden transition-all duration-300" 
                style="max-height: {{ $directory->name === 'Root' ? '1000px' : '0px' }}">
                @include('pages.file_explorer.partials.directory-items', ['directoryTree' => $directory->children])
                @foreach($directory->files as $file)
                    <li class="file-item">
                        <div class="flex items-center gap-1 py-1 hover:bg-gray-100 rounded cursor-pointer">
                            <x-heroicon-o-document class="w-4 h-4 text-gray-400 ml-4" />
                            <span>{{ $file->name }}</span>
                        </div>
                    </li>
                @endforeach
            </ul>
        @endif
    </li>
@endforeach