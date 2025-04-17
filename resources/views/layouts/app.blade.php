<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>CRM Prospects</title>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>

<body class="bg-gray-100">

    <div class="flex pt-16 md:pt-0">
        @include('components.sidebar', ['spaces' => $spaces])
        <div class="flex-1 md:ml-64">
            @yield('content')
        </div>
    </div>

    <!-- Overlay mobile pour fermer la sidebar -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black bg-opacity-40 z-30 hidden md:hidden"></div>
    <!-- topbar mobile -->
    <div id="topbarMobile"
        class="md:hidden fixed top-0 left-0 right-0 z-50 bg-white h-16 shadow flex items-center justify-between px-4 border-b">
        <img src="{{ asset('logo.png') }}" alt="Logo" class="h-8">
        <button id="sidebarToggle"
            class="p-2 rounded-xl border border-gray-200 bg-white shadow hover:bg-gray-100 transition">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
        </button>
    </div>



    <script src="./node_modules/preline/dist/preline.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            const toggleBtn = document.getElementById('sidebarToggle');

            const openSidebar = () => {
                sidebar.classList.remove('-translate-x-full');
                overlay.classList.remove('hidden');
            };

            const closeSidebar = () => {
                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');
            };

            toggleBtn.addEventListener('click', () => {
                const isOpen = !sidebar.classList.contains('-translate-x-full');
                if (isOpen) {
                    closeSidebar();
                } else {
                    openSidebar();
                }
            });

            overlay.addEventListener('click', closeSidebar);
        });
    </script>
</body>

</html>
