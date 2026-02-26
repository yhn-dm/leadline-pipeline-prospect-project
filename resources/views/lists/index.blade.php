@extends('layouts.app')

@section('content')
    <div class="sticky top-0 bg-gray-50 border-b border-gray-200 shadow-sm z-10 px-4 md:px-8 py-3">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

            <div>
                <h1 class="text-xl font-semibold text-gray-700">{{ $space->name }}</h1>

                <nav class="flex mt-1" aria-label="Breadcrumb">
                    <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}"
                                class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-800">
                                <svg class="w-4 h-4 me-2.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                                </svg>
                                Dashboard
                            </a>
                        </li>
                        <li>
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                        </li>
                        <li>
                            <span class="text-sm font-medium text-gray-500">{{ $space->name }}</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Boutons d'action -->
            <div class="flex flex-col sm:flex-row gap-2">
                <button type="button" onclick="openCreateListModal()"
                    class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Créer une Liste
                </button>

                <button type="button" onclick="openAssignCollaboratorModalSpace()"
                    class="flex items-center justify-center gap-2 px-4 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl shadow-sm hover:bg-gray-50 hover:border-gray-400 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-colors">
                    <svg class="w-5 h-5 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1
                                             m9-4a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Assigner un Collaborateur
                </button>
            </div>
        </div>
    </div>


    <!-- Contenu principal -->
    <div class="mt-4 sm:mt-6 px-4 sm:px-6 md:px-8 pb-10">
        <div class="bg-white border border-gray-200/80 shadow-card rounded-card-lg overflow-hidden">

            <!-- Barre de recherche + filtre -->
            <div
                class="flex flex-col md:flex-row items-center justify-between gap-3 p-6 bg-gray-50 border-b border-gray-200">
                <form id="searchForm" class="w-full md:w-1/2 flex items-center gap-x-3">
                    <div class="relative w-full">
                        <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                            <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817
                                            4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                            </svg>
                        </div>
                        <input type="text" id="searchInput" placeholder="Rechercher une liste..."
                            class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-800 placeholder-gray-500">
                    </div>
                    <span class="px-3 py-1 text-xs font-medium text-blue-600 bg-blue-100 rounded-full shadow-sm">
                        {{ $space->lists->count() }} listes
                    </span>
                </form>

                <div class="flex items-center gap-x-3">
                    <label for="filterStatus" class="text-gray-700 font-medium">Filtrer :</label>
                    <select id="filterStatus"
                        class="px-4 py-2 border border-gray-300 rounded-lg shadow-sm text-gray-800 focus:ring-blue-500 focus:border-blue-500">
                        <option value="all">Toutes les listes</option>
                        <option value="active">Actives</option>
                        <option value="archived">Archivées</option>
                    </select>
                </div>
            </div>

            <!-- Tableau des listes -->
            <div class="bg-white">
                <table class="w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 hidden md:table-header-group">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Nom</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Description</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Statut</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Prospects</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Collaborateurs</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Dernière activité</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="listsTable" class="divide-y divide-gray-200">
                        @forelse ($space->lists as $list)
                            <tr class="md:table-row block border md:border-0 mb-4 md:mb-0 list-row"
                                data-status="{{ $list->status }}">
                                <td class="px-6 py-4 font-medium text-gray-900 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Nom :</span>
                                    <a href="{{ route('lists.prospects.index', ['list' => $list->id]) }}"
                                        class="text-blue-600 hover:underline">
                                        {{ $list->name }}
                                    </a>

                                </td>
                                <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Description :</span>
                                    {{ $list->description }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Statut :</span>
                                    <span
                                        class="inline-block mt-1 md:mt-0 px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $list->status === 'active' ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }}">
                                        {{ ucfirst($list->status ?? 'N/A') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Prospects :</span>
                                    {{ $list->prospects_count ?? 0 }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Collaborateurs :</span>
                                    {{ $list->collaborators->count() }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Dernière activité :</span>
                                    {{ $list->updated_at->diffForHumans() }}
                                </td>
                                <td class="px-6 py-4 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600 block mb-2">Actions :</span>
                                    <div class="flex flex-wrap gap-2 justify-center">
                                        <button
                                            onclick="openEditModal({
                                        id: {{ $list->id }},
                                        name: '{{ addslashes($list->name) }}',
                                        description: '{{ addslashes($list->description) }}',
                                        status: '{{ $list->status }}',
                                        space_id: {{ $list->space_id }}
                                    })"
                                            class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-gray-800 bg-amber-100 rounded-lg hover:bg-amber-200 transition-colors">
                                            Modifier
                                        </button>
                                        <form action="{{ route('lists.destroy', [$list->space_id, $list->id]) }}" method="POST" class="inline" onsubmit="return confirm('Voulez-vous vraiment supprimer cette liste ?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 transition-colors">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">Aucune liste pour cet
                                    espace.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    @include('lists.editList_modal', ['spaces' => $spaces])
    @include('lists.createList_modal', ['spaces' => $spaces])
    @include('lists.assignCollabToSpace', ['spaces' => $spaces])


    <script>
        document.getElementById('filterStatus').addEventListener('change', function() {
            const selectedStatus = this.value;
            const rows = document.querySelectorAll('.list-row');

            rows.forEach(row => {
                const rowStatus = row.getAttribute('data-status');
                row.style.display = (selectedStatus === 'all' || rowStatus === selectedStatus) ? '' :
                    'none';
            });
        });

        document.getElementById('select_all')?.addEventListener('change', function() {
            const isChecked = this.checked;
            document.querySelectorAll('#user_id option').forEach(option => option.selected = isChecked);
        });
    </script>
@endsection
