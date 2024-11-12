
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
                                        <i class="fas fa-home mr-2"></i> Home
                                    </a>
                                </li>
                                <li>
                                    <div class="flex items-center">
                                        <i class="fas fa-chevron-right text-gray-400 mx-2"></i>
                                        <span class="text-gray-500">Current Directory</span>
                                    </div>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    
                    <!-- Action Buttons Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button @click="open = !open" class="inline-flex items-center px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                            <svg class="w-5 h-5 mr-2 text-yellow-400 animate-spin" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor" d="M487.4 315.7l-42.6-24.6c4.3-23.2 4.3-47 0-70.2l42.6-24.6c4.9-2.8 7.1-8.6 5.5-14-11.1-35.6-30-67.8-54.7-94.6-3.8-4.1-10-5.1-14.8-2.3L380.8 110c-17.9-15.4-38.5-27.3-60.8-35.1V25.8c0-5.6-3.9-10.5-9.4-11.7-36.7-8.2-74.3-7.8-109.2 0-5.5 1.2-9.4 6.1-9.4 11.7V75c-22.2 7.9-42.8 19.8-60.8 35.1L88.7 85.5c-4.9-2.8-11-1.9-14.8 2.3-24.7 26.7-43.6 58.9-54.7 94.6-1.7 5.4.6 11.2 5.5 14L67.3 221c-4.3 23.2-4.3 47 0 70.2l-42.6 24.6c-4.9 2.8-7.1 8.6-5.5 14 11.1 35.6 30 67.8 54.7 94.6 3.8 4.1 10 5.1 14.8 2.3l42.6-24.6c17.9 15.4 38.5 27.3 60.8 35.1v49.2c0 5.6 3.9 10.5 9.4 11.7 36.7 8.2 74.3 7.8 109.2 0 5.5-1.2 9.4-6.1 9.4-11.7v-49.2c22.2-7.9 42.8-19.8 60.8-35.1l42.6 24.6c4.9 2.8 11 1.9 14.8-2.3 24.7-26.7 43.6-58.9 54.7-94.6 1.5-5.5-.7-11.3-5.6-14.1zM256 336c-44.1 0-80-35.9-80-80s35.9-80 80-80 80 35.9 80 80-35.9 80-80 80z"/>
                            </svg>
                            Actions 
                            <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                <path fill="currentColor" d="M31.3 192h257.3c17.8 0 26.7 21.5 14.1 34.1L174.1 354.8c-7.8 7.8-20.5 7.8-28.3 0L17.2 226.1C4.6 213.5 13.5 192 31.3 192z"/>
                            </svg>
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
                                    <svg class="w-5 h-5 mr-2 inline text-blue-500 group-hover:text-blue-600 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512">
                                        <path fill="currentColor" d="M144 480C64.5 480 0 415.5 0 336c0-62.8 40.2-116.2 96.2-135.9c-.1-2.7-.2-5.4-.2-8.1c0-88.4 71.6-160 160-160c59.3 0 111 32.2 138.7 80.2C409.9 102 428.3 96 448 96c53 0 96 43 96 96c0 12.2-2.3 23.8-6.4 34.6C596 238.4 640 290.1 640 352c0 70.7-57.3 128-128 128H144zm79-217c-3.8-3.9-10.1-3.9-13.9 0L168 304.3V208c0-5.5-4.5-10-10-10s-10 4.5-10 10v96.3l-41.1-41.3c-3.8-3.9-10.1-3.9-13.9 0s-3.8 10.2 0 14.1l58 58.3c3.8 3.9 10.1 3.9 13.9 0l58-58.3c3.8-3.9 3.8-10.2 0-14.1z"/>
                                    </svg>
                                    Upload
                                </button>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 group" id="new-folder-btn">
                                    <svg class="w-5 h-5 mr-2 inline text-amber-500 group-hover:text-amber-600 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                        <path fill="currentColor" d="M464 128H272l-64-64H48C21.49 64 0 85.49 0 112v288c0 26.51 21.49 48 48 48h416c26.51 0 48-21.49 48-48V176c0-26.51-21.49-48-48-48zm-96 168c0 8.84-7.16 16-16 16h-72v72c0 8.84-7.16 16-16 16h-16c-8.84 0-16-7.16-16-16v-72h-72c-8.84 0-16-7.16-16-16v-16c0-8.84 7.16-16 16-16h72v-72c0-8.84 7.16-16 16-16h16c8.84 0 16 7.16 16 16v72h72c8.84 0 16 7.16 16 16v16z"/>
                                    </svg>
                                    New Folder
                                </button>
                                <button class="w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 group" id="delete-btn">
                                    <svg class="w-5 h-5 mr-2 inline text-red-500 group-hover:text-red-600 transition-colors" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                                        <path fill="currentColor" d="M432 32H312l-9.4-18.7A24 24 0 0 0 281.1 0H166.8a23.72 23.72 0 0 0-21.4 13.3L136 32H16A16 16 0 0 0 0 48v32a16 16 0 0 0 16 16h416a16 16 0 0 0 16-16V48a16 16 0 0 0-16-16zM53.2 467a48 48 0 0 0 47.9 45h245.8a48 48 0 0 0 47.9-45L416 128H32z"/>
                                    </svg>
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
                                        <i class="fas fa-folder text-yellow-500"></i> Root
                                        <ul class="pl-4">
                                            <li>
                                                <i class="fas fa-folder text-yellow-500"></i> Documents
                                                <ul class="pl-4">
                                                    <li><i class="fas fa-folder text-yellow-500"></i> Work Files</li>
                                                    <li><i class="fas fa-folder text-yellow-500"></i> Personal</li>
                                                </ul>
                                            </li>
                                            <li>
                                                <i class="fas fa-folder text-yellow-500"></i> Images
                                                <ul class="pl-4">
                                                    <li><i class="fas fa-folder text-yellow-500"></i> Vacation 2023</li>
                                                    <li><i class="fas fa-folder text-yellow-500"></i> Profile Pictures</li>
                                                </ul>
                                            </li>
                                            <li>
                                                <i class="fas fa-folder text-yellow-500"></i> Downloads
                                                <ul class="pl-4">
                                                    <li><i class="fas fa-folder text-yellow-500"></i> Software</li>
                                                    <li><i class="fas fa-folder text-yellow-500"></i> Music</li>
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
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <i class="fas fa-file-pdf text-red-500 mr-2"></i>
                                                    <span>Document1.pdf</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2.5 MB</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2023-10-15 14:30</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex space-x-2">
                                                    <button class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-download"></i></button>
                                                    <button class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-share"></i></button>
                                                    <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <i class="fas fa-file-image text-blue-500 mr-2"></i>
                                                    <span>Vacation.jpg</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">4.8 MB</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2023-10-14 09:15</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex space-x-2">
                                                    <button class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-download"></i></button>
                                                    <button class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-share"></i></button>
                                                    <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <input type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <i class="fas fa-file-word text-blue-700 mr-2"></i>
                                                    <span>Report.docx</span>
                                                </div>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">1.2 MB</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">2023-10-13 16:45</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <div class="flex space-x-2">
                                                    <button class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-download"></i></button>
                                                    <button class="text-indigo-600 hover:text-indigo-900"><i class="fas fa-share"></i></button>
                                                    <button class="text-red-600 hover:text-red-900"><i class="fas fa-trash"></i></button>
                                                </div>
                                            </td>
                                        </tr>
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


