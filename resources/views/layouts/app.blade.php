<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    <!-- HTMX -->
    <script src="https://unpkg.com/htmx.org@1.9.10"
            integrity="sha384-D1Kt99CQMDuVetoL1lrYwg5t+9QdHe7NLX/SoJYkXDFfX37iInKRy5xLSi8nO7UC"
            crossorigin="anonymous"></script>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/file-explorer.js'])
</head>
<body class="font-sans antialiased" hx-boost="true">
<div class="min-h-screen bg-gray-100 dark:bg-gray-900">
    @include('layouts.top_navigation.main_dashboard_navigation')

    <!-- Page Heading -->
    @isset($header)
        <header class="bg-white dark:bg-gray-800 shadow">
            <div class="max-w mx-auto py-2 px-2 sm:px-6 lg:px-8">
                <div class="flex justify-start text-gray-800 dark:text-gray-200">
                    {{ $header }}
                </div>
            </div>
        </header>
    @endisset

    <!-- Page Content -->
    <main>
        <div class="flex">
            <main class="flex-1">
                {{ $slot }}
            </main>

            <!-- Expandable Login Aside -->
            <x-panel-aside/>
        </div>
    </main>
</div>
</body>
</html>
