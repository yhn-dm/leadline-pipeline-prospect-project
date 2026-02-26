<!-- Modal Détails Prospect -->
<div id="prospectDetailsModal"
     class="fixed inset-0 z-50 hidden bg-black/50 backdrop-blur-sm flex items-center justify-center p-4">
    <div class="relative w-full max-w-xl">
        <div class="relative bg-white rounded-card-lg shadow-xl border border-gray-200/80 p-5 sm:p-6 w-full">
            <div class="flex justify-between items-center pb-3 mb-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Détails du Prospect</h3>
                <button type="button" aria-label="Fermer" onclick="closeDetailsModal()"
                    class="text-gray-400 hover:bg-gray-100 hover:text-gray-700 rounded-lg p-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
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
                    <button type="submit" class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl hover:bg-indigo-700 transition-colors">
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
                        <button type="submit" class="px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl hover:bg-emerald-700 transition-colors">
                            Planifier l'action
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

