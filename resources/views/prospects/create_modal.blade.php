<!-- Modal pour Ajouter un Prospect -->
<div id="createProspectModal" tabindex="-1" aria-hidden="true"
     class="hidden overflow-y-auto overflow-x-hidden fixed inset-0 z-50 flex justify-center items-center w-full md:inset-0 h-modal md:h-full bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-2xl md:h-auto">
        <div class="relative p-4 bg-white rounded-lg shadow-lg sm:p-5">
            <!-- En-tête -->
            <div class="flex justify-between items-center pb-4 mb-4 border-b">
                <h3 class="text-lg font-semibold text-gray-900">Ajouter un Prospect</h3>
                <button type="button"
                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5"
                        onclick="closeCreateModal()">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                              d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                              clip-rule="evenodd"></path>
                    </svg>
                </button>
            </div>

            <!-- Formulaire principal de création du Prospect -->
            <form action="{{ isset($list) ? route('lists.prospects.store', $list->id) : '#' }}" method="POST">
                @csrf
                <input type="hidden" name="list_id" value="{{ $list->id ?? '' }}">
            
                <!-- Nom et Email -->
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nom</label>
                        <input type="text" name="name" id="name" required
                               class="bg-gray-50 border rounded-lg p-2.5 w-full">
                    </div>
                    <div>
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" name="email" id="email" required
                               class="bg-gray-50 border rounded-lg p-2.5 w-full">
                    </div>
                </div>
            
                <!-- Téléphone et Statut -->
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="phone" class="block mb-2 text-sm font-medium text-gray-900">Téléphone</label>
                        <input type="text" name="phone" id="phone"
                               class="bg-gray-50 border rounded-lg p-2.5 w-full">
                    </div>
                    <div>
                        <label for="status" class="block mb-2 text-sm font-medium text-gray-900">Statut</label>
                        <select name="status" id="status" class="bg-gray-50 border rounded-lg p-2.5 w-full">
                            <option value="new">Nouveau</option>
                            <option value="contacted">Contacté</option>
                            <option value="interested">Intéressé</option>
                            <option value="converted">Converti</option>
                            <option value="lost">Perdu</option>
                        </select>
                    </div>
                </div>
            
                <!-- Source et Priorité -->
                <div class="grid gap-4 mb-4 sm:grid-cols-2">
                    <div>
                        <label for="source_acquisition" class="block mb-2 text-sm font-medium text-gray-900">Source d'acquisition</label>
                        <select name="source_acquisition" id="source_acquisition" class="bg-gray-50 border rounded-lg p-2.5 w-full">
                            <option value="">Sélectionner</option>
                            <option value="site_web">Site Web</option>
                            <option value="publicite">Publicité</option>
                            <option value="reseaux_sociaux">Réseaux sociaux</option>
                            <option value="recommandation">Recommandation</option>
                        </select>
                    </div>
                    <div>
                        <label for="priority" class="block mb-2 text-sm font-medium text-gray-900">Priorité</label>
                        <select name="priority" id="priority" class="bg-gray-50 border rounded-lg p-2.5 w-full">
                            <option value="low">Faible</option>
                            <option value="medium">Moyenne</option>
                            <option value="high">Élevée</option>
                        </select>
                    </div>
                </div>
            
                <!-- Collaborateur -->
                <div class="mb-4">
                    <label for="collaborator_id" class="block mb-2 text-sm font-medium text-gray-900">Collaborateur en charge</label>
                    <select name="collaborator_id" id="collaborator_id" class="bg-gray-50 border rounded-lg p-2.5 w-full">
                        <option value="">Sélectionnez un collaborateur</option>
                        @foreach ($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                        @endforeach
                    </select>
                </div>
            
                <!-- Commentaire -->
                <div class="mb-4">
                    <label for="comment" class="block mb-2 text-sm font-medium text-gray-900">Commentaire</label>
                    <textarea name="comment" id="comment" rows="3"
                              class="block p-2.5 w-full bg-gray-50 border rounded-lg"></textarea>
                </div>
            
                <!-- Boutons -->
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closeCreateModal()"
                            class="px-5 py-2.5 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit"
                            class="px-5 py-2.5 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        Ajouter
                    </button>
                </div>
            </form>
            
        </div>
    </div>
</div>

<script>
    function openCreateModal() {
        document.getElementById('createProspectModal').classList.remove('hidden');
    }

    function closeCreateModal() {
        document.getElementById('createProspectModal').classList.add('hidden');
    }
</script>
