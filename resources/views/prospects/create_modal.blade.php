<!-- Modal pour Ajouter un Prospect -->
<div id="createProspectModal" tabindex="-1" aria-hidden="true"
     class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="relative w-full max-w-2xl my-auto">
        <div class="relative p-5 sm:p-6 bg-white rounded-card-lg shadow-xl border border-gray-200/80">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Ajouter un Prospect</h3>
                <button type="button" aria-label="Fermer" onclick="closeCreateModal()"
                    class="text-gray-400 hover:bg-gray-100 hover:text-gray-700 rounded-lg p-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
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
                <div class="flex justify-end gap-3 mt-4">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Annuler</button>
                    <button type="submit"
                        class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl shadow-sm hover:bg-indigo-700 transition-colors">Ajouter</button>
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
