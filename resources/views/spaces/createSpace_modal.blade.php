<!-- Modal pour Créer un Espace -->
<div id="createSpaceModal" tabindex="-1" aria-hidden="true"
class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50 backdrop-blur-sm">
<div class="relative p-4 w-full max-w-md h-auto">
    <div class="relative p-6 bg-white rounded-lg shadow-lg sm:p-6">
        <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
            <h3 class="text-lg font-semibold text-gray-900">
                Créer un Espace
            </h3>
            <button type="button"
                class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5"
                onclick="closeCreateSpaceModal()">
                ✕
            </button>
        </div>

        <!-- Formulaire -->
        <form action="{{ route('spaces.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-900">Nom de l'Espace</label>
                <input type="text" name="name" id="name" required
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
            </div>
            <div class="mb-4">
                <label for="description" class="block text-sm font-medium text-gray-900">Description</label>
                <textarea name="description" id="description" rows="3"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
            </div>
            <div class="mb-4">
                <label for="status" class="block text-sm font-medium text-gray-900">Statut</label>
                <select name="status" id="status"
                    class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                    <option value="active">Actif</option>
                    <option value="archived">Archivé</option>
                </select>
            </div>

            <!-- Boutons -->
            <div class="flex justify-end space-x-3">
                <button type="button" onclick="closeCreateSpaceModal()"
                    class="px-5 py-2.5 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition">Annuler</button>
                <button type="submit"
                    class="px-5 py-2.5 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">Créer</button>
            </div>
        </form>
    </div>
</div>
</div>