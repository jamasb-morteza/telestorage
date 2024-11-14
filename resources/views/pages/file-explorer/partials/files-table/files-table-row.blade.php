<tr class="hover:bg-gray-50 dark:hover:bg-gray-700 cursor-move dark:bg-gray-800 text-gray-900 dark:text-gray-100"
    data-path="{{ $directoryContent->path }}"
    data-content-type="{{ $directoryContent->type }}"
    data-content-uuid="{{ $directoryContent->uuid }}"
>

    <td class="w-12 px-6 py-4">
        <x-heroicon-c-arrow-path/>
        path
        <input type="checkbox"
               class="select-file-checkbox rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:border-gray-600 dark:bg-gray-700 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"
               aria-label="Select file">
    </td>

    {{-- Icon + Name Column --}}
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center file-name-column"
             @if($directoryContent->type === 'directory')
                 hx-get="{{ route('file-explorer.directory.content', ['directoryId' => $directoryContent->id]) }}"
             hx-target="#directory-content"
             hx-trigger="click"
            @endif
        >
            <div class="flex-shrink-0 w-5 h-5">
                <x-file-icon :type="$directoryContent->type"/>
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
                <button class="text-indigo-600 hover:text-indigo-900"
                        onclick="downloadFile('{{ $directoryContent->path }}')">
                    Download
                </button>
            @endif
            <button class="text-red-600 hover:text-red-900" onclick="deleteItem('{{ $directoryContent->path }}')">
                Delete
            </button>
        </div>
    </td>
</tr>
