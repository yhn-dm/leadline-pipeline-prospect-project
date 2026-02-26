        <!-- Modal de Création de Liste -->
        <div id="createListModal" tabindex="-1" aria-hidden="true"
            class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
            <div class="relative w-full max-w-2xl my-auto">
                <div class="relative p-5 sm:p-6 bg-white rounded-card-lg shadow-xl border border-gray-200/80">
                    <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-900">Créer une Liste</h3>
                        <button type="button" aria-label="Fermer" onclick="closeCreateListModal()"
                            class="text-gray-400 hover:bg-gray-100 hover:text-gray-700 rounded-lg p-2 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </button>
                    </div>

                    <!-- Formulaire de création -->
                    <form action="{{ route('lists.store', $space->id) }}" method="POST">
                        @csrf
                        <div class="grid gap-4 mb-4 sm:grid-cols-2">
                            <!-- Nom de la Liste -->
                            <div class="sm:col-span-2">
                                <label for="name" class="block mb-2 text-sm font-medium text-gray-900">Nom de la
                                    Liste</label>
                                <input type="text" name="name" id="name" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            </div>

                            <!-- Description -->
                            <div class="sm:col-span-2">
                                <label for="description"
                                    class="block mb-2 text-sm font-medium text-gray-900">Description</label>
                                <textarea name="description" id="description" rows="3"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"></textarea>
                            </div>

                            <!-- Statut de la Liste -->
                            <div class="sm:col-span-2">
                                <label for="status"
                                    class="block mb-2 text-sm font-medium text-gray-900">Statut</label>
                                <select name="status" id="status" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                                    <option value="active">Actif</option>
                                    <option value="archived">Archivé</option>
                                </select>
                            </div>
                        </div>

                        <!-- Boutons -->
                        <div class="flex justify-end gap-3 mt-4">
                            <button type="button" onclick="closeCreateListModal()"
                                class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Annuler</button>
                            <button type="submit"
                                class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl shadow-sm hover:bg-indigo-700 transition-colors">Créer</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openCreateListModal() {
                let modal = document.getElementById('createListModal');
                modal.classList.remove('hidden');
                setTimeout(() => modal.classList.add('opacity-100', 'scale-100'), 50);
            }

            function closeCreateListModal() {
                let modal = document.getElementById('createListModal');
                modal.classList.remove('opacity-100', 'scale-100');
                setTimeout(() => modal.classList.add('hidden'), 200);
            }
        </script>
