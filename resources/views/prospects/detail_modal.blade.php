<!-- Modal Prospect Centré & Compact -->
<div id="prospectDetailsModal"
     class="fixed inset-0 z-50 hidden bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center">
    <div class="relative w-full max-w-xl p-4">
        <div class="relative bg-white rounded-lg shadow-lg p-5 w-full">
            <!-- En-tête -->
            <div class="flex justify-between items-center pb-3 mb-4 border-b">
                <h3 class="text-base font-semibold text-gray-800">Détails du Prospect</h3>
                <button type="button" onclick="closeDetailsModal()"
                    class="text-gray-400 hover:bg-gray-200 rounded-lg p-1">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 
                            1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 
                            1.414L10 11.414l-4.293 4.293a1 1 0 
                            01-1.414-1.414L8.586 10 4.293 
                            5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>

            <!-- Formulaire principal -->
            <form id="updateProspectForm" action="" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <input type="hidden" id="prospect_id" name="prospect_id">
                <input type="hidden" id="prospect_list_id" name="list_id">

                <div class="grid gap-3 sm:grid-cols-2">
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Nom</label>
                        <input type="text" id="prospect_name" name="name" class="w-full p-2 text-sm border rounded-md bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Email</label>
                        <input type="email" id="prospect_email" name="email" class="w-full p-2 text-sm border rounded-md bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Téléphone</label>
                        <input type="text" id="prospect_phone" name="phone" class="w-full p-2 text-sm border rounded-md bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Statut</label>
                        <select id="prospect_status" name="status" class="w-full p-2 text-sm border rounded-md bg-gray-50">
                            <option value="new">Nouveau</option>
                            <option value="contacted">Contacté</option>
                            <option value="interested">Intéressé</option>
                            <option value="converted">Converti</option>
                            <option value="lost">Perdu</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Source</label>
                        <select id="prospect_source" name="source_acquisition" class="w-full p-2 text-sm border rounded-md bg-gray-50">
                            <option value="">Sélectionner</option>
                            <option value="site_web">Site Web</option>
                            <option value="publicite">Publicité</option>
                            <option value="reseaux_sociaux">Réseaux sociaux</option>
                            <option value="recommandation">Recommandation</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Priorité</label>
                        <select id="prospect_priority" name="priority" class="w-full p-2 text-sm border rounded-md bg-gray-50">
                            <option value="low">Faible</option>
                            <option value="medium">Moyenne</option>
                            <option value="high">Élevée</option>
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-gray-700">Collaborateur</label>
                        <select id="prospect_collaborator" name="collaborator_id" class="w-full p-2 text-sm border rounded-md bg-gray-50">
                            <option value="">Sélectionnez</option>
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} - {{ $user->email }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-medium text-gray-700">Commentaire</label>
                        <textarea id="prospect_comment" name="comment" rows="3" class="w-full p-2 text-sm border rounded-md bg-gray-50"></textarea>
                    </div>
                </div>

                <div class="flex justify-end pt-2">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white text-sm rounded-md hover:bg-blue-700">
                        Mettre à jour
                    </button>
                </div>
            </form>

            <!-- Section action -->
            <div class="mt-4 pt-4 border-t">
                <h4 class="text-sm font-semibold text-gray-800 mb-2">Planifier une action</h4>
                <form id="planActionForm" action="{{ route('activities.store') }}" method="POST" class="space-y-2">
                    @csrf
                    <input type="hidden" name="prospect_id" id="plan_prospect_id">
                    <input type="hidden" name="collaborator_id" id="plan_collaborator_id">
                    <input type="hidden" name="list_id" id="plan_list_id">

                    <div>
                        <label class="block text-xs font-medium text-gray-700">Date</label>
                        <input type="date" name="date" required class="w-full p-2 text-sm border rounded-md bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Heure</label>
                        <input type="time" name="time" required class="w-full p-2 text-sm border rounded-md bg-gray-50">
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700">Description</label>
                        <textarea name="description" rows="2" class="w-full p-2 text-sm border rounded-md bg-gray-50"></textarea>
                    </div>
                    <div class="text-right pt-2">
                        <button type="submit" class="px-4 py-2 bg-green-600 text-white text-sm rounded-md hover:bg-green-700">
                            Planifier l'action
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

