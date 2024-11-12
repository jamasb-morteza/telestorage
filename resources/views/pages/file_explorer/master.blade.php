
<x-app-layout>
    <div class="w-full h-full">
        <!-- Top Navigation Bar -->
        <div class="bg-white border-b border-gray-200">
            <div class="px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-16">
                    <div class="flex items-center">
                        <!-- Breadcrumbs -->
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="#" class="text-gray-700 hover:text-gray-900">
                                        <x-heroicon-s-home class="w-5 h-5 mr-2" /> Home
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <x-heroicon-s-chevron-right class="w-5 h-5 text-gray-400 mx-2" />
                                        <span class="text-gray-500">Current Directory</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    
                    <!-- Action Buttons Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            <x-heroicon-s-cog class="w-5 h-5 mr-2 text-yellow-400 animate-spin" />
                            Actions 
                            <x-heroicon-s-chevron-down class="w-4 h-4 ml-2" />
                        </button>
                        <div x-show="open" 
                             @click.away="open = false"
                             class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg"
                             x-transition:enter="transition ease-out duration-100"
                             x-transition:enter-start="transform opacity-0 scale-95"
                             x-transition:enter-end="transform opacity-100 scale-100"
                             x-transition:leave="transition ease-in duration-75"
                             x-transition:leave-start="transform opacity-100 scale-100"
                             x-transition:leave-end="transform opacity-0 scale-95">
                            <div class="py-1">
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 group" id="upload-btn">
                                    <x-heroicon-s-cloud-upload class="w-5 h-5 mr-2 inline text-blue-500 group-hover:text-blue-600 transition-colors" />
                                    Upload
                                </button>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 group" id="new-folder-btn">
                                    <x-heroicon-s-folder-add class="w-5 h-5 mr-2 inline text-amber-500 group-hover:text-amber-600 transition-colors" />
                                    New Folder
                                </button>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 group" id="delete-btn">
                                    <x-heroicon-s-trash class="w-5 h-5 mr-2 inline text-red-500 group-hover:text-red-600 transition-colors" />
                                    Delete
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white">
                    <div class="grid grid-cols-4 gap-4">
                        <!-- Left Panel - Directory Structure -->
                        <div class="col-span-1 border-r">
                            <div class="directory-tree">
                                <ul class="list-none">
                                    <li>
                                        <x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Root
                                        <ul class="pl-4">
                                            <li>
                                                <x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Documents
                                                <ul class="pl-4">
                                                    <li><x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Work Files</li>
                                                    <li><x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Personal</li>
                                                </ul>
                                            </li>
                                            <li>
                                                <x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Images
                                                <ul class="pl-4">
                                                    <li><x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Vacation 2023</li>
                                                    <li><x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Profile Pictures</li>
                                                </ul>
                                            </li>
                                            <li>
                                                <x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Downloads
                                                <ul class="pl-4">
                                                    <li><x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Software</li>
                                                    <li><x-heroicon-s-folder class="w-5 h-5 inline text-yellow-500" /> Music</li>
                                                </ul>
                                            </li>
                                            <!-- Directory structure will be populated dynamically -->
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Main Panel - Files List -->
                        <div class="col-span-3">
                            <div class="files-container">
                                <table class="min-w-full divide-y divide-gray-200">
                                    <thead class="bg-gray-50">
                                        <tr>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                                <input type="checkbox" id="select-all" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            </th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Size</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Modified</th>
                                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="files-list" class="bg-white divide-y divide-gray-200">
                                        <!-- Files will be populated dynamically -->
                                        @foreach ($contents as $content)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    @if($content['type'] === 'dir')
                                                        <x-heroicon-s-folder class="w-5 h-5 text-yellow-500 mr-2" />
                                                    @elseif(preg_match('/\.(pdf)$/i', $content['name']))
                                                        <x-heroicon-s-document class="w-5 h-5 text-red-500 mr-2" />
                                                    @elseif(preg_match('/\.(jpg|png|gif)$/i', $content['name']))
                                                        <x-heroicon-s-photograph class="w-5 h-5 text-blue-500 mr-2" />
                                                    @elseif(preg_match('/\.(doc|docx)$/i', $content['name']))
                                                        <x-heroicon-s-document-text class="w-5 h-5 text-blue-700 mr-2" />
                                                    @else
                                                        <x-heroicon-s-document class="w-5 h-5 text-gray-500 mr-2" />
                                                    @endif
                                                    <span>{{ $content['name'] }}</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                @if($content['type'] === 'file')
                                                    {{ $content['human_size'] }}
                                                @else
                                                    --
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ $content['last_modified'] }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex space-x-2">
                                                    @if($content['type'] === 'file')
                                                        <button class="text-indigo-600 hover:text-indigo-900" title="Download">
                                                            <x-heroicon-s-download class="w-5 h-5" />
                                                        </button>
                                                        <button class="text-indigo-600 hover:text-indigo-900" title="Share">
                                                            <x-heroicon-s-share class="w-5 h-5" />
                                                        </button>
                                                    @endif
                                                    <button class="text-red-600 hover:text-red-900" title="Delete">
                                                        <x-heroicon-s-trash class="w-5 h-5" />
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
