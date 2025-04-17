@extends('layouts.app')

@section('content')
    <!-- Topbar  -->
    <div class="sticky top-0 bg-gray-50 border-b border-gray-200 shadow-sm px-6 py-3 z-10">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <!-- Infos & Breadcrumb -->
            <div>
                <h1 class="text-xl font-semibold text-gray-600 tracking-wide hover:text-gray-800 transition">
                    {{ $list->name }}
                </h1>

                <nav class="flex mt-1" aria-label="Breadcrumb">
                    <ol
                        class="inline-flex flex-wrap items-center space-x-1 md:space-x-2 rtl:space-x-reverse text-sm text-gray-600">
                        <li class="inline-flex items-center">
                            <a href="{{ route('dashboard') }}" class="flex items-center hover:text-gray-800">
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
                            <a href="{{ route('lists.index', $space->id) }}" class="hover:text-gray-800">
                                {{ $space->name }}
                            </a>
                        </li>
                        <li>
                            <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 9 4-4-4-4" />
                            </svg>
                        </li>
                        <li aria-current="page">
                            <span class="text-gray-500">{{ $list->name }}</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Boutons d’action -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-2 sm:gap-4">
                <button onclick="openCreateModal()"
                    class="flex items-center justify-center px-5 py-2.5 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-indigo-500 hover:bg-indigo-50 hover:text-gray-800 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Ajouter un Prospect
                </button>

                <button onclick="openAssignCollaboratorModalList()"
                    class="flex items-center justify-center px-5 py-2.5 text-sm text-gray-600 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-green-500 hover:bg-green-50 hover:text-gray-800 transition duration-300">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m9-4a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Assigner un Collaborateur
                </button>
            </div>
        </div>
    </div>


    <!-- Contenu principal -->
    <div class="mt-8 px-8 pb-10">
        <!-- 🔍 Recherche + Filtre -->
        <div
            class="flex flex-col md:flex-row items-center justify-between gap-4 p-6 bg-gray-50 border-b border-gray-200 rounded-t-lg">
            <!-- 🔍 Recherche -->
            <form class="w-full md:w-1/2 flex items-center space-x-3" id="searchForm">
                <div class="relative flex-1">
                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817
                                4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <input type="text" id="searchInput"
                        class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 text-gray-800 placeholder-gray-500"
                        placeholder="Rechercher un prospect...">
                </div>

                <span class="px-3 py-2 text-xs font-medium text-blue-600 bg-blue-100 rounded-full shadow-sm">
                    {{ $prospects->total() }} Prospects
                </span>
            </form>

            <!-- 🎯 Filtre par priorité -->
            <div class="relative">
                <button id="filterDropdownButton"
                    class="flex items-center py-2.5 px-4 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg shadow-sm hover:bg-gray-50 focus:outline-none">
                    <svg class="w-4 h-4 mr-2 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12
                                11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018
                                17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Filtrer par priorité
                </button>
                <div id="filterDropdown"
                    class="absolute hidden mt-2 w-48 bg-white border border-gray-200 rounded-lg shadow-md z-10">
                    <select id="priorityFilter" class="w-full p-2 border border-gray-300 rounded-b-lg focus:outline-none">
                        <option value="">Toutes les priorités</option>
                        <option value="low">Faible</option>
                        <option value="medium">Moyenne</option>
                        <option value="high">Élevée</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- 🧾 Tableau des prospects -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-b-lg overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <!-- En-tête visible uniquement sur desktop -->
                <thead class="bg-gray-50 hidden md:table-header-group">
                    <tr>
                        <th class="px-4 py-3 font-semibold text-gray-800 text-left">Nom</th>
                        <th class="px-4 py-3 font-semibold text-gray-800 text-left">Email</th>
                        <th class="px-4 py-3 font-semibold text-gray-800 text-left">Téléphone</th>
                        <th class="px-4 py-3 font-semibold text-gray-800 text-left">Ajouté le</th>
                        <th class="px-4 py-3 font-semibold text-gray-800 text-left">Statut</th>
                        <th class="px-4 py-3 font-semibold text-gray-800 text-left">Source</th>
                        <th class="px-4 py-3 font-semibold text-gray-800 text-left">Priorité</th>
                        <th class="px-4 py-3 font-semibold text-gray-800 text-left">Collaborateur</th>
                    </tr>
                </thead>

                <tbody id="prospectTable" class="divide-y divide-gray-100">
                    @foreach ($prospects as $prospect)
                        <tr class="block md:table-row border md:border-0 mb-4 md:mb-0 hover:bg-gray-50 transition cursor-pointer prospect-row"
                            data-id="{{ $prospect->id }}" data-name="{{ $prospect->name }}"
                            data-email="{{ $prospect->email }}" data-phone="{{ $prospect->phone }}"
                            data-comment="{{ $prospect->comment }}" data-status="{{ $prospect->status }}"
                            data-priority="{{ $prospect->priority }}"
                            data-source_acquisition="{{ $prospect->source_acquisition }}"
                            data-collaborator_id="{{ $prospect->collaborator_id }}"
                            data-list_id="{{ $prospect->list_id }}" data-created_at="{{ $prospect->created_at }}"
                            data-updated_at="{{ $prospect->updated_at }}">

                            <td class="px-4 py-3 text-gray-900 font-medium md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Nom :</span>
                                {{ $prospect->name }}
                            </td>

                            <td class="px-4 py-3 text-gray-700 md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Email :</span>
                                {{ $prospect->email }}
                            </td>

                            <td class="px-4 py-3 text-gray-700 md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Téléphone :</span>
                                {{ $prospect->phone ?? 'Non renseigné' }}
                            </td>

                            <td class="px-4 py-3 text-gray-700 md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Ajouté le :</span>
                                {{ $prospect->created_at->format('d/m/Y') }}
                            </td>

                            <td class="px-4 py-3 md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Statut :</span>
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match ($prospect->status) {
                                        'new' => 'bg-blue-100 text-blue-800',
                                        'contacted' => 'bg-yellow-100 text-yellow-800',
                                        'interested' => 'bg-green-100 text-green-800',
                                        'converted' => 'bg-indigo-100 text-indigo-800',
                                        'lost' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    } }}">
                                    {{ ucfirst($prospect->status) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-gray-700 md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Source :</span>
                                {{ $prospect->source_acquisition ?? 'Non renseignée' }}
                            </td>

                            <td class="px-4 py-3 md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Priorité :</span>
                                <span
                                    class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ match ($prospect->priority) {
                                        'low' => 'bg-green-100 text-green-800',
                                        'medium' => 'bg-yellow-100 text-yellow-800',
                                        'high' => 'bg-red-100 text-red-800',
                                        default => 'bg-gray-100 text-gray-800',
                                    } }}">
                                    {{ ucfirst($prospect->priority) }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-gray-700 md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Collaborateur :</span>
                                {{ $prospect->collaborator->name ?? 'Non renseigné' }}
                            </td>
                        </tr>
                    @endforeach

                    <!-- Ligne vide (gérée par JS si besoin) -->
                    <tr id="noProspectsRow" style="display: none;">
                        <td colspan="8" class="px-4 py-6 text-center text-gray-500">Aucun prospect trouvé.</td>
                    </tr>
                </tbody>
            </table>
        </div>


        <!-- Pagination -->
        <div class="{{ $prospects->lastPage() === 1 ? 'p-0' : 'p-4' }}">
            {{ $prospects->links() }}
        </div>
    </div>


    @include('prospects.assignCollabToList', ['spaces' => $spaces])
    @include('prospects.detail_modal', ['spaces' => $spaces])
    @include('prospects.create_modal', ['spaces' => $spaces])

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Initialisation
            const filterDropdownButton = document.getElementById('filterDropdownButton');
            const filterDropdown = document.getElementById('filterDropdown');
            const priorityFilter = document.getElementById('priorityFilter');
            const searchInput = document.getElementById('searchInput');
            const noRow = document.getElementById('noProspectsRow');

            // Récupère toutes les lignes sauf la ligne de message vide
            const tableRows = Array.from(document.querySelectorAll('#prospectTable tr')).filter(row => row.id !==
                'noProspectsRow');

            // Gère les clics pour afficher le modal de détails prospect
            document.querySelectorAll('.prospect-row').forEach(row => {
                row.addEventListener('click', function() {
                    const prospect = {
                        id: this.getAttribute('data-id'),
                        list_id: this.getAttribute('data-list_id'),
                        name: this.getAttribute('data-name'),
                        email: this.getAttribute('data-email'),
                        phone: this.getAttribute('data-phone'),
                        comment: this.getAttribute('data-comment'),
                        status: this.getAttribute('data-status'),
                        source_acquisition: this.getAttribute('data-source_acquisition'),
                        priority: this.getAttribute('data-priority'),
                        collaborator_id: this.getAttribute('data-collaborator_id'),
                        created_at: this.getAttribute('data-created_at'),
                        updated_at: this.getAttribute('data-updated_at')
                    };

                    openProspectDetailsModal(prospect);
                });
            });

            // Gestion du dropdown "Filtrer"
            filterDropdownButton.addEventListener('click', function() {
                filterDropdown.classList.toggle('hidden');
            });

            document.addEventListener('click', function(event) {
                if (!filterDropdown.contains(event.target) && !filterDropdownButton.contains(event
                    .target)) {
                    filterDropdown.classList.add('hidden');
                }
            });

            // Fonction de filtrage
            function filterTable() {
                const searchText = searchInput.value.toLowerCase();
                const selectedPriority = priorityFilter.value;
                let visibleCount = 0;

                tableRows.forEach(row => {
                    const name = row.cells[0].innerText.toLowerCase();
                    const email = row.cells[1].innerText.toLowerCase();
                    const phone = row.cells[2].innerText.toLowerCase();
                    const priority = row.getAttribute('data-priority');

                    const matchesSearch = name.includes(searchText) || email.includes(searchText) || phone
                        .includes(searchText);
                    const matchesPriority = selectedPriority === '' || priority === selectedPriority;

                    const shouldShow = matchesSearch && matchesPriority;
                    row.style.display = shouldShow ? '' : 'none';

                    if (shouldShow) visibleCount++;
                });

                // Affiche la ligne "Aucun prospect" si nécessaire
                if (noRow) {
                    noRow.style.display = visibleCount === 0 ? '' : 'none';
                }
            }

            // Événements de filtrage
            searchInput.addEventListener('input', filterTable);
            priorityFilter.addEventListener('change', filterTable);

            // Applique le filtre dès le chargement initial
            filterTable();
        });

        function closeDetailsModal() {
            document.getElementById('prospectDetailsModal').classList.add('hidden');
        }

        function openProspectDetailsModal(prospect) {
            document.getElementById('prospect_name').value = prospect.name;
            document.getElementById('prospect_email').value = prospect.email;
            document.getElementById('prospect_phone').value = prospect.phone;
            document.getElementById('prospect_comment').value = prospect.comment;
            document.getElementById('prospect_status').value = prospect.status;
            document.getElementById('prospect_source').value = prospect.source_acquisition || "";
            document.getElementById('prospect_priority').value = prospect.priority || "";
            document.getElementById('prospect_collaborator').value = prospect.collaborator_id || "";

            // Mise à jour de l'action du formulaire
            document.getElementById('updateProspectForm').action = `/lists/${prospect.list_id}/prospects/${prospect.id}`;

            // Mise à jour du champ caché pour la planification d'action
            document.getElementById('plan_prospect_id').value = prospect.id;
            document.getElementById('plan_collaborator_id').value = prospect.collaborator_id || "";
            document.getElementById('plan_list_id').value = prospect.list_id || "";

            // Ouvre le modal
            document.getElementById('prospectDetailsModal').classList.remove('hidden');

        }

        function closeProspectDetailsModal() {
            updateProspectModal(prospect);

            document.getElementById('prospectDetailsModal').classList.add('hidden');
        }
    </script>
@endsection
