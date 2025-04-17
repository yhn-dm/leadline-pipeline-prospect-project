        <!-- Modal de Création de Liste -->
        <div id="createListModal" tabindex="-1" aria-hidden="true"
            class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-modal md:h-full bg-black bg-opacity-50 backdrop-blur-sm">
            <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
                <div class="relative p-4 bg-white rounded-lg shadow-lg sm:p-5">
                    <!-- Header du modal -->
                    <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
                        <h3 class="text-lg font-semibold text-gray-900">
                            Créer une Liste
                        </h3>
                        <button type="button" onclick="closeCreateListModal()"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center">
                            <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd"
                                    d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd"></path>
                            </svg>
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
                        <div class="flex justify-end space-x-3">
                            <button type="button" onclick="closeCreateListModal()"
                                class="px-5 py-2.5 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition">
                                Annuler
                            </button>
                            <button type="submit"
                                class="px-5 py-2.5 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                                Créer
                            </button>
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
