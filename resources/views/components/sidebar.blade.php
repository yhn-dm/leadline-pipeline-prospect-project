<div id="sidebar"
    class="fixed top-14 sm:top-16 md:top-0 left-0 z-40 w-64 h-full bg-white border-r border-gray-200 shadow-sm transform -translate-x-full md:translate-x-0 transition-transform duration-300 ease-in-out">

    <div class="min-h-screen flex flex-col w-64 flex-shrink-0 antialiased text-gray-800">
        <div class="fixed flex flex-col top-0 left-0 w-64 bg-white h-full border-r border-gray-200">
            <div class="hidden md:flex items-center justify-center h-16 border-b border-gray-100 px-4">
                <img src="{{ asset('logo.png') }}" alt="Leadline" class="h-9 w-auto object-contain">
            </div>

            <div class="overflow-y-auto overflow-x-hidden flex-grow py-2">
                <ul class="flex flex-col space-y-0.5">
                    <li class="px-3 pt-2 pb-1">
                        <span class="text-xs font-medium uppercase tracking-wider text-gray-400">Menu</span>
                    </li>
                    <li>
                        <a href="{{ route('dashboard') }}"
                            class="relative flex flex-row items-center h-10 px-4 rounded-lg mx-2 focus:outline-none hover:bg-gray-100 text-gray-600 hover:text-gray-900 border-l-4 border-transparent hover:border-indigo-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500/20 transition-colors {{ request()->routeIs('dashboard') ? 'bg-indigo-50/80 text-indigo-700 border-indigo-500' : '' }}">
                            <span class="inline-flex justify-center items-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            </span>
                            <span class="ml-3 text-sm font-medium truncate">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('spaces.index') }}"
                            class="relative flex flex-row items-center h-10 px-4 rounded-lg mx-2 focus:outline-none hover:bg-gray-100 text-gray-600 hover:text-gray-900 border-l-4 border-transparent hover:border-indigo-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500/20 transition-colors {{ request()->routeIs('spaces.*') ? 'bg-indigo-50/80 text-indigo-700 border-indigo-500' : '' }}">
                            <span class="inline-flex justify-center items-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                            </span>
                            <span class="ml-3 text-sm font-medium truncate">Espaces</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('clients.index') }}"
                            class="relative flex flex-row items-center h-10 px-4 rounded-lg mx-2 focus:outline-none hover:bg-gray-100 text-gray-600 hover:text-gray-900 border-l-4 border-transparent hover:border-indigo-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500/20 transition-colors {{ request()->routeIs('clients.*') ? 'bg-indigo-50/80 text-indigo-700 border-indigo-500' : '' }}">
                            <span class="inline-flex justify-center items-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z"></path></svg>
                            </span>
                            <span class="ml-3 text-sm font-medium truncate">Clients</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('organizations.index') }}"
                            class="relative flex flex-row items-center h-10 px-4 rounded-lg mx-2 focus:outline-none hover:bg-gray-100 text-gray-600 hover:text-gray-900 border-l-4 border-transparent hover:border-indigo-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500/20 transition-colors {{ request()->routeIs('organizations.*') ? 'bg-indigo-50/80 text-indigo-700 border-indigo-500' : '' }}">
                            <span class="inline-flex justify-center items-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            </span>
                            <span class="ml-3 text-sm font-medium truncate">Organisation</span>
                            <span class="px-2 py-0.5 ml-auto text-xs font-medium text-indigo-600 bg-indigo-100 rounded-full shrink-0">New</span>
                        </a>
                    </li>
                    <li class="px-3 pt-3 pb-1">
                        <span class="text-xs font-medium uppercase tracking-wider text-gray-400">Tasks</span>
                    </li>
                    <li>
                        <a href="{{ route('activities.index') }}"
                            class="relative flex flex-row items-center h-10 px-4 rounded-lg mx-2 focus:outline-none hover:bg-gray-100 text-gray-600 hover:text-gray-900 border-l-4 border-transparent hover:border-indigo-500 focus:ring-2 focus:ring-inset focus:ring-indigo-500/20 transition-colors {{ request()->routeIs('activities.*') ? 'bg-indigo-50/80 text-indigo-700 border-indigo-500' : '' }}">
                            <span class="inline-flex justify-center items-center shrink-0">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                            </span>
                            <span class="ml-3 text-sm font-medium truncate">Activités</span>
                        </a>
                    </li>
                    <li class="mt-auto pt-2 border-t border-gray-100">
                        <form method="POST" action="{{ route('logout') }}" class="block">
                            @csrf
                            <button type="submit"
                                class="relative flex flex-row items-center w-full h-10 px-4 rounded-lg mx-2 text-left focus:outline-none hover:bg-red-50 text-gray-600 hover:text-red-700 border-l-4 border-transparent hover:border-red-400 transition-colors focus:ring-2 focus:ring-inset focus:ring-red-500/20">
                                <span class="inline-flex justify-center items-center shrink-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                                </span>
                                <span class="ml-3 text-sm font-medium truncate">Déconnexion</span>
                            </button>
                        </form>
                    </li>

                </ul>
            </div>
        </div>
    </div>
</div>
