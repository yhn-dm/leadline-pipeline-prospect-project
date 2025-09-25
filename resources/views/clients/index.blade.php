@extends('layouts.app')
<meta name="csrf-token" content="{{ csrf_token() }}">

@section('content')
    <div class="sticky top-0 bg-gray-50 border-b border-gray-200 shadow-sm flex items-center justify-between px-8 py-3 z-10">

        <div>
            <div class="flex items-center gap-x-3">
                <h1 class="text-xl font-semibold text-gray-600 tracking-wide hover:text-gray-800 transition">
                    Clients
                </h1>
            </div>

            <nav class="flex mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-800">
                            <svg class="w-4 h-4 me-2.5" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
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
                    <li aria-current="page">
                        <span class="text-sm font-medium text-gray-500">Clients</span>
                    </li>
                </ol>
            </nav>
        </div>


        <div class="flex items-end space-x-3">
            <button onclick="openModal()"
                class="flex items-center px-4 md:px-6 py-2 text-sm md:text-base text-white bg-blue-500 border border-transparent rounded-lg shadow-sm hover:border-indigo-500 hover:bg-indigo-50 hover:text-gray-800 transition ease-in-out duration-300 focus:outline-none">
                <span class="hidden md:inline-flex justify-center items-center mr-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                <span class="tracking-wide whitespace-nowrap">Créer un Client</span>
            </button>
        </div>
    </div>

    <div class="mt-8 px-8">
        <div class="bg-white border border-gray-200 shadow-lg rounded-lg overflow-hidden">
            <!-- Barre de recherche -->
            <div
                class="flex flex-col md:flex-row items-center justify-between space-y-3 md:space-y-0 md:space-x-4 p-6 bg-gray-50 border-b border-gray-200">
                <div class="w-full md:w-1/2">
                    <form class="flex items-center space-x-3" id="searchForm">
                        <label for="searchInput" class="sr-only">Rechercher</label>
                        <div class="relative flex-1">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" id="searchInput" placeholder="Rechercher un client..."
                                class="pl-10 pr-4 py-2 w-full border border-gray-300 rounded-lg shadow-sm focus:ring-blue-500 focus:border-blue-500 bg-white text-gray-800 placeholder-gray-500">
                        </div>
                        <span class="px-3 py-2 text-xs font-medium text-blue-700 bg-blue-100 rounded-full shadow-sm">
                            {{ $clients->total() }} Clients
                        </span>
                    </form>
                </div>
            </div>

            <!-- Tableau des Clients -->
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table id="clientTable" class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50 hidden md:table-header-group">
                        <tr>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Nom</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Email</th>
                            <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Téléphone</th>
                            <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse ($clients as $client)
                            <tr class="md:table-row block border md:border-0 mb-4 md:mb-0">
                                <td class="px-6 py-4 text-gray-900 font-medium md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Nom :</span>
                                    {{ $client->name }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Email :</span>
                                    {{ $client->email }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600">Téléphone :</span>
                                    {{ $client->phone ?? 'Non renseigné' }}
                                </td>
                                <td class="px-6 py-4 md:table-cell block">
                                    <span class="md:hidden font-semibold text-gray-600 block mb-2">Actions :</span>
                                    <div class="flex flex-wrap gap-2 md:justify-center">
                                        <button
                                            onclick="openClientModal({
        id: '{{ $client->id }}',
        name: '{{ addslashes($client->name) }}',
        email: '{{ addslashes($client->email) }}',
        phone: '{{ addslashes($client->phone ?? 'Non renseigné') }}'
    })"
                                            class="px-4 py-2 text-sm font-medium text-white bg-blue-500 rounded-md shadow-md hover:bg-blue-600">
                                            Voir
                                        </button>

                                        <button
                                            onclick="openEditClientModal({
        id: '{{ $client->id }}',
        name: '{{ addslashes($client->name) }}',
        email: '{{ addslashes($client->email) }}',
        phone: '{{ addslashes($client->phone ?? 'Non renseigné') }}'
    })"
                                            class="px-4 py-2 text-sm font-medium text-black bg-yellow-400 rounded-md shadow-md hover:bg-yellow-500">
                                            Modifier
                                        </button>

                                        <button onclick="deleteClient('{{ $client->id }}')"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md shadow-md hover:bg-red-600">
                                            Supprimer
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noClientsRow">
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Aucun client trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>



    @include('clients.createClient_modal', ['spaces' => $spaces])
    @include('clients.viewClient_modal', ['spaces' => $spaces])
    @include('clients.editClient_modal', ['spaces' => $spaces])
@endsection
<script>
    function openModal() {
        document.getElementById('createClientModal').classList.remove('hidden');
    }


    function openCreateClientModal() {
        let modal = document.getElementById('createClientModal');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.add('opacity-100', 'scale-100'), 50);
    }

    function closeCreateClientModal() {
        let modal = document.getElementById('createClientModal');
        modal.classList.remove('opacity-100', 'scale-100');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    // Fermer le modal en cliquant à l'extérieur
    document.addEventListener('click', function(event) {
        let modal = document.getElementById('createClientModal');
        if (event.target === modal) closeCreateClientModal();
    });

    // Ouvrir le modal en injectant les données du client
    function openClientModal(client) {
        // Injecte les données dans le modal
        document.getElementById('viewClientName').textContent = client.name;
        document.getElementById('viewClientEmail').textContent = client.email;
        document.getElementById('viewClientPhone').textContent = client.phone;


        // Affiche le modal
        const modal = document.getElementById('viewClientModal');
        modal.classList.remove('hidden');
    }

    // Fermer le modal
    function closeClientModal() {
        const modal = document.getElementById('viewClientModal');
        modal.classList.add('hidden');
    }

    // Optionnel : fermer le modal si on clique en dehors
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('viewClientModal');
        if (e.target === modal) {
            closeClientModal();
        }
    });

    // Ouvrir le modal d'édition et pré-remplir le formulaire avec les données du client
    function openEditClientModal(client) {
        // Pré-remplissage des champs du formulaire
        document.getElementById('edit_client_name').value = client.name;
        document.getElementById('edit_client_email').value = client.email;
        document.getElementById('edit_client_phone').value = client.phone;

        document.getElementById('edit_client_comment').value = client.comment || '';

        // Définir l'action du formulaire (supposons une route de type /clients/{id})
        document.getElementById('editClientForm').action = `/clients/${client.id}`;

        // Afficher le modal
        document.getElementById('editClientModal').classList.remove('hidden');
    }

    // Fermer le modal d'édition
    function closeEditClientModal() {
        document.getElementById('editClientModal').classList.add('hidden');
    }

    // Optionnel : fermer le modal en cliquant en dehors de la boîte
    document.addEventListener('click', function(e) {
        const modal = document.getElementById('editClientModal');
        if (!modal.classList.contains('hidden') && e.target === modal) {
            closeEditClientModal();
        }
    });

    function deleteClient(clientId) {
        if (!confirm('Êtes-vous sûr de vouloir supprimer ce client ?')) return;

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        fetch(`/clients/${clientId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Accept': 'application/json', // Indique qu'on attend JSON
                }
            })
            .then(response => {
                if (!response.ok) throw new Error("Réponse non OK");

                return response.json();
            })
            .then(data => {
                // Supprimer la ligne du tableau
                const row = document.querySelector(`button[onclick="deleteClient('${clientId}')"]`)?.closest('tr');
                if (row) row.remove();

                // Message visuel optionnel
                console.log(data.message);
            })
            .catch(error => {
                console.error(error);
                alert('Erreur lors de la suppression.');
            });
    }
</script>
