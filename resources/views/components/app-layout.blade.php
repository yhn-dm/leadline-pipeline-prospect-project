<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'CRM Prospects' }}</title>
    @vite('resources/css/app.css') 
    @vite('resources/js/app.js')

</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- Sidebar -->
        @include('components.sidebar')

        <!-- Main Content -->
        @if (session('success'))
            <div class="bg-green-500 text-white p-4 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        <main class="flex-1 p-6">
            {{ $slot }}
            <p>Test depuis app-layout</p>
        </main>
    </div>
</body>

</html>
