<tr class="hover:bg-gray-50 cursor-pointer" data-path="{{ $content['path'] }}">
    {{-- Icon + Name Column --}}
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="flex items-center">
            <div class="flex-shrink-0 w-5 h-5">
                @if($content['type'] === 'directory')
                    <svg class="w-5 h-5 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M2 6a2 2 0 012-2h5l2 2h5a2 2 0 012 2v6a2 2 0 01-2 2H4a2 2 0 01-2-2V6z" />
                    </svg>
                @else
                    <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" clip-rule="evenodd" />
                    </svg>
                @endif
            </div>
            <div class="ml-4">
                <div class="text-sm font-medium text-gray-900">
                    {{ $content['name'] }}
                </div>
            </div>
        </div>
    </td>

    {{-- Size Column --}}
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-500">
            @if($content['type'] === 'file')
                {{ $content['size'] }}
            @else
                --
            @endif
        </div>
    </td>

    {{-- Last Modified Column --}}
    <td class="px-6 py-4 whitespace-nowrap">
        <div class="text-sm text-gray-500">
            {{ $content['last_modified'] }}
        </div>
    </td>

    {{-- Actions Column --}}
    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
        <div class="flex justify-end space-x-2">
            @if($content['type'] === 'file')
                <button class="text-indigo-600 hover:text-indigo-900" onclick="downloadFile('{{ $content['path'] }}')">
                    Download
                </button>
            @endif
            <button class="text-red-600 hover:text-red-900" onclick="deleteItem('{{ $content['path'] }}')">
                Delete
            </button>
        </div>
    </td>
</tr> 