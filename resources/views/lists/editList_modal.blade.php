<!-- Modal pour Modifier une Liste -->
<div id="editListModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-2xl h-auto">
        <div class="relative p-6 bg-white rounded-lg shadow-lg sm:p-6">
            <!-- En-tête du modal -->
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
                <h3 class="text-lg font-semibold text-gray-900">
                    Modifier la Liste
                </h3>
                <button type="button"
                    class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5"
                    onclick="closeEditModal()">
                    ✕
                </button>
            </div>

            <!-- Formulaire d'édition -->
            <form id="editListForm" method="POST">

                @csrf
                @method('PUT')
                <input type="hidden" name="id" id="edit_list_id">

                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <!-- Nom de la Liste -->
                    <div class="sm:col-span-2">
                        <label for="edit_name" class="block mb-2 text-sm font-medium text-gray-900">Nom de la
                            Liste</label>
                        <input type="text" name="name" id="edit_name" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <!-- Description -->
                    <div class="sm:col-span-2">
                        <label for="edit_description"
                            class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                        <textarea name="description" id="edit_description" rows="3"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    </div>

                    <!-- Statut -->
                    <div class="sm:col-span-2">
                        <label for="edit_status" class="block mb-2 text-sm font-medium text-gray-900">Statut</label>
                        <select name="status" id="edit_status" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="active">Actif</option>
                            <option value="archived">Archivé</option>
                        </select>
                    </div>
                </div>

                <!-- Boutons -->
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeEditModal()"
                        class="px-5 py-2.5 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-yellow-500 text-white rounded-lg shadow hover:bg-yellow-600 transition">
                        Enregistrer les modifications
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function openEditModal(data) {
        document.getElementById('edit_list_id').value = data.id;
        document.getElementById('edit_name').value = data.name;
        document.getElementById('edit_description').value = data.description || '';
        document.getElementById('edit_status').value = data.status || 'active';

        const actionUrl = "{{ route('lists.update', ['space' => ':space', 'list' => ':list']) }}"
            .replace(':space', data.space_id)
            .replace(':list', data.id);

        document.getElementById('editListForm').setAttribute('data-action', actionUrl); // On stocke l'action ici
        let modal = document.getElementById('editListModal');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.add('opacity-100', 'scale-100'), 50);
    }

    function closeEditModal() {
        let modal = document.getElementById('editListModal');
        modal.classList.remove('opacity-100', 'scale-100');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    document.addEventListener('click', function(event) {
        let modal = document.getElementById('editListModal');
        let createModal = document.getElementById('createListModal');
        let assignModal = document.getElementById('assignCollaboratorModalSpace');

        if (event.target === createModal) closeCreateListModal();
        if (event.target === assignModal) closeAssignCollaboratorModalSpace();
        if (event.target === modal) closeEditModal();
    });

    // ✅ Formulaire de modification AJAX
    document.getElementById('editListForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const form = this;
        const actionUrl = form.getAttribute('data-action');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        const formData = new FormData(form);

        fetch(actionUrl, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: formData
            })
            .then(response => {
                if (!response.ok) throw new Error('Erreur serveur');
                return response.json(); // supposé que tu retournes une réponse JSON depuis le contrôleur
            })
            .then(data => {
                closeEditModal();
                // ✅ Soit tu rafraîchis toute la page :
                location.reload();
                // ✅ Ou tu peux mettre à jour les données dans le tableau directement (non traité ici)
            })
            .catch(error => {
                console.error('Erreur lors de la modification:', error);
                alert('Erreur lors de la modification.');
            });
    });
</script>
