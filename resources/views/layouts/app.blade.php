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

<body class="bg-gray-100 min-h-screen antialiased">

    <div class="flex pt-16 md:pt-0">
        @include('components.sidebar', ['spaces' => $spaces])
        <main class="flex-1 md:ml-64 min-w-0">
            @yield('content')
        </main>
    </div>

    <!-- Overlay mobile pour fermer la sidebar -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-30 hidden md:hidden transition-opacity"></div>
    <!-- Topbar mobile -->
    <div id="topbarMobile"
        class="md:hidden fixed top-0 left-0 right-0 z-50 bg-white h-14 sm:h-16 shadow-sm flex items-center justify-between px-4 border-b border-gray-200">
        <img src="{{ asset('logo.png') }}" alt="Leadline" class="h-8 sm:h-9 w-auto object-contain">
        <button id="sidebarToggle" type="button" aria-label="Ouvrir le menu"
            class="p-2.5 rounded-xl border border-gray-200 bg-white shadow-sm hover:bg-gray-50 hover:border-gray-300 transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
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
