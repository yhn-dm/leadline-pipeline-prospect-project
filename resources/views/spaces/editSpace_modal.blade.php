
    <div id="editSpaceModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black/50 backdrop-blur-sm p-4">
        <div class="relative w-full max-w-md">
            <div class="relative p-6 bg-white rounded-card-lg shadow-xl border border-gray-200/80 sm:p-6">
                <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Modifier un Espace</h3>
                    <button type="button" aria-label="Fermer"
                        class="text-gray-400 hover:bg-gray-100 hover:text-gray-700 rounded-lg p-2 transition-colors"
                        onclick="closeEditSpaceModal()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Formulaire -->
                <form id="editSpaceForm" method="POST">
                    @csrf
                    @method('PUT')

                    <!-- ID caché -->
                    <input type="hidden" name="space_id" id="edit_space_id">

                    <!-- Nom -->
                    <div class="mb-4">
                        <label for="edit_space_name" class="block text-sm font-medium text-gray-900">Nom</label>
                        <input type="text" name="name" id="edit_space_name" required
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="edit_space_description"
                            class="block text-sm font-medium text-gray-900">Description</label>
                        <textarea name="description" id="edit_space_description" rows="3"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                    </div>

                    <!-- Statut -->
                    <div class="mb-4">
                        <label for="edit_space_status" class="block text-sm font-medium text-gray-900">Statut</label>
                        <select name="status" id="edit_space_status"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="active">Actif</option>
                            <option value="archived">Archivé</option>
                        </select>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end gap-3 mt-4">
                        <button type="button" onclick="closeEditSpaceModal()"
                            class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Annuler</button>
                        <button type="submit"
                            class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl shadow-sm hover:bg-indigo-700 transition-colors">Enregistrer</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
