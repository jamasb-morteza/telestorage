<tr class="hover:bg-gray-50 dark:hover:bg-gray-700 cursor-pointer dark:bg-gray-800 text-gray-900 dark:text-gray-100" 
    data-path="{{ $directoryContent->path }}"
    @if($directoryContent->type === 'directory')
    hx-get="{{ route('file-explorer.directory.content', ['directoryId' => $directoryContent->id]) }}"
    hx-target="#directory-content"
    hx-trigger="click"
    @endif
>
    {{-- Icon + Name Column --}}
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-5 h-5">
                @if($directoryContent->type === 'directory')
                    <div>
                        <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z" />
                        </svg>
                    </div>
                @else
                    <svg class="w-5 h-5 text-gray-400 dark:text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    
                @endif
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ $directoryContent->name }}
                </div>
            </div>
        </div>
    </td>

    {{-- Size Column --}}
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-500">
            @if($directoryContent->type === 'file')
                {{ $directoryContent->size }}
            @else
                --
            @endif
        </div>
    </td>

    {{-- Last Modified Column --}}
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-500">
            {{ $directoryContent->updated_at }}
        </div>
    </td>

    {{-- Actions Column --}}
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex justify-end space-x-2">
            @if($directoryContent->type === 'file')
                <button class="text-indigo-600 hover:text-indigo-900" onclick="downloadFile('{{ $directoryContent->path }}')">
                    Download
                </button>
            @endif
            <button class="text-red-600 hover:text-red-900" onclick="deleteItem('{{ $directoryContent->path }}')">
                Delete
            </button>
        </div>
    </td>
</tr>