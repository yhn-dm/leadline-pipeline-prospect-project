
    <!-- Modal pour Modifier un Client -->
    <div id="editClientModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
        <div class="relative p-4 w-full max-w-md h-auto">
            <div class="relative p-6 bg-white rounded-lg shadow-lg sm:p-6">
                <!-- En-tête du modal -->
                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Modifier le Client
                    </h3>
                    <button type="button" onclick="closeEditClientModal()"
                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5">
                        ✕
                    </button>
                </div>

                <!-- Formulaire d'édition -->
                <form id="editClientForm" action="" method="POST">
                    @csrf
                    @method('PUT')
                    <!-- Nom -->
                    <div class="mb-4">
                        <label for="edit_client_name" class="block text-sm font-medium text-gray-900">Nom</label>
                        <input type="text" name="name" id="edit_client_name" required
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <!-- Email -->
                    <div class="mb-4">
                        <label for="edit_client_email" class="block text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="edit_client_email" required
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>

                    <!-- Téléphone -->
                    <div class="mb-4">
                        <label for="edit_client_phone" class="block text-sm font-medium text-gray-900">Téléphone</label>
                        <input type="text" name="phone" id="edit_client_phone"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    </div>



                    <!-- Commentaire -->
                    <div class="mb-4">
                        <label for="edit_client_comment"
                            class="block text-sm font-medium text-gray-900">Commentaire</label>
                        <textarea name="comment" id="edit_client_comment" rows="3"
                            class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditClientModal()"
                            class="px-5 py-2.5 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

