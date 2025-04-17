@extends('layouts.app')


@section('content')
    <div class="sticky top-0 bg-gray-50 border-b border-gray-200 shadow-sm flex items-center justify-between px-8 py-3 z-10">

        <div>
            <div class="flex items-center gap-x-3">
                <h1 class="text-xl font-semibold text-gray-600 tracking-wide hover:text-gray-800 transition">
                    Espaces
                </h1>

            </div>

            <nav class="flex mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-800">
                            <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <svg class="w-3 h-3 text-gray-400 mx-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                            fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    </li>

                    <li aria-current="page">
                        <span class="text-sm font-medium text-gray-500">
                            Espaces
                        </span>
                    </li>
                </ol>
            </nav>
        </div>

        <div class="flex items-end space-x-3">
            <button onclick="openCreateSpaceModal()"
                class="flex items-center px-4 md:px-6 py-2 text-sm md:text-base text-white bg-blue-500 border border-transparent rounded-lg shadow-sm hover:border-indigo-500 hover:bg-indigo-50 hover:text-gray-800 transition ease-in-out duration-300 focus:outline-none">

                <span class="hidden md:inline-flex justify-center items-center mr-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </span>

                <span class="tracking-wide whitespace-nowrap">Créer un Espace</span>
            </button>
        </div>

    </div>


    <div class="mt-8 px-8">
        <div class="bg-white border border-gray-200 shadow-lg rounded-lg overflow-hidden">

            <!-- Barre de recherche et filtres -->
            <div
                class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-6 bg-gray-50 border-b border-gray-200">
                <!-- Barre de recherche -->
                <div class="w-full md:w-1/2">
                    <form class="flex items-center space-x-3" id="searchForm">
                        <label for="searchInput" class="sr-only">Rechercher</label>

                        <!-- Conteneur du champ de recherche -->
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="searchInput" placeholder="Rechercher un espace..."
                                class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-800 placeholder-gray-500">
                        </div>

                        <!-- Badge affichant le nombre total d'espaces -->
                        <span class="px-3 py-2 text-xs font-medium text-blue-700 bg-blue-100 rounded-full shadow-sm">
                            {{ $spaces->count() }} Espaces
                        </span>
                    </form>
                </div>

                <!-- Filtres -->
                <div class="flex items-center gap-x-3">
                    <label for="filterStatus" class="text-gray-700 font-medium">Filtrer :</label>
                    <select id="filterStatus"
                        class="px-4 py-2 border border-gray-300 bg-white text-gray-800 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 hover:bg-gray-50 transition">
                        <option value="all">Tous les espaces</option>
                        <option value="active">Espaces actifs</option>
                        <option value="archived">Espaces archivés</option>
                    </select>

                </div>
            </div>



            <!-- Tableau des Espaces -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table id="spacesTable" class="min-w-full divide-y divide-gray-200">
                    <!-- En-tête visible uniquement sur desktop -->
                    <thead class="bg-gray-50 hidden md:table-header-group">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Nom</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Description</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Collaborateurs</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Nombre de Listes</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Statut</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200" id="spacesTbody">
                        @forelse ($spaces as $space)
                            <tr id="space-row-{{ $space->id }}"
                                class="md:table-row block border md:border-0 mb-4 md:mb-0"
                                data-status="{{ $space->status }}">
                                {{-- Nom --}}

                                
                                <td class="px-6 py-4 text-gray-900 font-medium md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Nom :</span>
                                    {{ $space->name }}
                                </td>

                                {{-- Description --}}
                                <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Description :</span>
                                    {{ $space->description ?? 'Aucune description' }}
                                </td>

                                {{-- Collaborateurs --}}
                                <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Collaborateurs :</span>
                                    {{ $space->collaborators->count() }}
                                </td>

                                {{-- Nombre de listes --}}
                                <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Nombre de Listes :</span>
                                    {{ $space->lists->count() }}
                                </td>

                                {{-- Statut --}}
                                <td class="px-6 py-4 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Statut :</span>
                                    <span
                                        class="inline-block mt-1 md:mt-0 px-3 py-1 text-xs font-semibold rounded-full 
                                    {{ $space->status === 'active' ? 'text-green-700 bg-green-100' : 'text-red-700 bg-red-100' }}">
                                        {{ ucfirst($space->status) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600 block mb-2">Actions :</span>
                                    <div class="flex flex-wrap gap-2 md:justify-center">
                                        <a href="{{ route('lists.index', $space->id) }}"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md shadow-md hover:bg-blue-600">
                                            Voir
                                        </a>
                                        <button onclick="openEditSpaceModal({{ $space->id }})"
                                            class="px-4 py-2 text-sm font-medium text-black bg-yellow-400 rounded-md shadow-md hover:bg-yellow-500">
                                            Modifier
                                        </button>
                                        <button onclick="confirmDelete({{ $space->id }})"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md shadow-md hover:bg-red-600">
                                            Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>




                        @empty
                            <tr id="noSpacesRow">
                                <td colspan="6" class="px-6 py-4 text-center text-gray-500">Aucun espace trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
    </div>


    @include('spaces.createSpace_modal', ['spaces' => $spaces])
    @include('spaces.editSpace_modal', ['spaces' => $spaces])




    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const rowsPerPage = 10;
            let currentPage = 1;

            const originalRows = Array.from(document.querySelectorAll("#spacesTable tbody tr[data-status]"));
            const noSpacesRow = document.getElementById("noSpacesRow");

            let filteredRows = [...originalRows];

            function updateTableDisplay(rows) {
                originalRows.forEach(row => row.style.display = "none");
                rows.forEach(row => row.style.display = "");

                if (noSpacesRow) {
                    noSpacesRow.style.display = rows.length === 0 ? "" : "none";
                }
            }

            function renderPage(page, rows = filteredRows) {
                updateTableDisplay(rows);
                const start = (page - 1) * rowsPerPage;
                const end = start + rowsPerPage;
                rows.slice(start, end).forEach(row => row.style.display = "");
            }

            function setupPagination(rows = filteredRows) {
                const paginationContainer = document.getElementById("clientPagination");
                if (!paginationContainer) return;

                paginationContainer.innerHTML = "";
                const totalPages = Math.ceil(rows.length / rowsPerPage);

                for (let i = 1; i <= totalPages; i++) {
                    const btn = document.createElement("button");
                    btn.textContent = i;
                    btn.className = "px-3 py-1 bg-gray-300 text-gray-800 rounded-md shadow hover:bg-gray-400";
                    if (i === currentPage) btn.classList.add("bg-blue-500", "text-white");

                    btn.addEventListener("click", function() {
                        currentPage = i;
                        renderPage(currentPage, filteredRows);
                        document.querySelectorAll("#clientPagination button").forEach(el =>
                            el.classList.remove("bg-blue-500", "text-white"));
                        btn.classList.add("bg-blue-500", "text-white");
                    });

                    paginationContainer.appendChild(btn);
                }
            }

            function filterSpaces() {
                const selectedFilter = document.getElementById("filterStatus").value;

                filteredRows = originalRows.filter(row => {
                    const status = row.getAttribute("data-status");
                    return selectedFilter === "all" || status === selectedFilter;
                });

                currentPage = 1;
                setupPagination(filteredRows);
                renderPage(currentPage, filteredRows);
            }

            const filterDropdown = document.getElementById("filterStatus");
            if (filterDropdown) {
                filterDropdown.addEventListener("change", filterSpaces);
                filterDropdown.value = "all";
                filterSpaces();
            }

            function sortTable(columnIndex = 0) {
                filteredRows.sort((a, b) => {
                    const aValue = a.cells[columnIndex]?.textContent.trim() || "";
                    const bValue = b.cells[columnIndex]?.textContent.trim() || "";

                    const aNum = parseFloat(aValue);
                    const bNum = parseFloat(bValue);

                    return (!isNaN(aNum) && !isNaN(bNum)) ? aNum - bNum : aValue.localeCompare(bValue,
                        undefined, {
                            numeric: true
                        });
                });

                renderPage(currentPage, filteredRows);
            }

            document.querySelectorAll("#spacesTable th").forEach((th, index) => {
                th.addEventListener("click", () => sortTable(index));
            });

            setupPagination(filteredRows);
            renderPage(currentPage, filteredRows);
        });

        function openCreateSpaceModal() {
            const modal = document.getElementById('createSpaceModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeCreateSpaceModal() {
            const modal = document.getElementById('createSpaceModal');
            modal.classList.remove('flex');
            modal.classList.add('hidden');
        }

        function openEditSpaceModal(spaceId) {
            fetch(`/spaces/${spaceId}/edit`)
                .then(response => response.json())
                .then(space => {
                    document.getElementById('edit_space_id').value = space.id;
                    document.getElementById('edit_space_name').value = space.name;
                    document.getElementById('edit_space_description').value = space.description ?? '';
                    document.getElementById('edit_space_status').value = space.status;
                    document.getElementById('editSpaceForm').action = `/spaces/${space.id}`;

                    document.getElementById('editSpaceModal').classList.remove('hidden');
                })
                .catch(error => console.error('Erreur lors de la récupération des données:', error));
        }

        function closeEditSpaceModal() {
            document.getElementById('editSpaceModal').classList.add('hidden');
        }

        document.addEventListener('click', function(event) {
            const modal = document.getElementById('editSpaceModal');
            if (event.target === modal) closeEditSpaceModal();
        });

        function confirmDelete(spaceId) {
            if (!confirm("Êtes-vous sûr de vouloir supprimer cet espace ? Cette action est irréversible.")) return;

            fetch(`/spaces/${spaceId}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) throw new Error('La suppression a échoué.');

                    const row = document.getElementById(`space-row-${spaceId}`);
                    if (row) row.remove();

                    alert("L'espace a été supprimé avec succès.");
                })
                .catch(error => {
                    console.error('Erreur lors de la suppression:', error);
                    alert("Une erreur est survenue lors de la suppression.");
                });
        }
    </script>
@endsection
