    <!-- Modal Voir un Client -->
    <div id="viewClientModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black/50 backdrop-blur-sm p-4">
        <div class="relative w-full max-w-md">
            <div class="relative p-6 bg-white rounded-card-lg shadow-xl border border-gray-200/80 sm:p-6">
                <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900">Informations du Client</h3>
                    <button type="button" aria-label="Fermer"
                        class="text-gray-400 hover:bg-gray-100 hover:text-gray-700 rounded-lg p-2 transition-colors"
                        onclick="closeClientModal()">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                    </button>
                </div>

                <!-- Contenu : informations du client -->
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Nom</label>
                        <p id="viewClientName"
                            class="mt-1 text-gray-700 text-sm border border-gray-200 rounded-md px-3 py-2 bg-gray-50"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Email</label>
                        <p id="viewClientEmail"
                            class="mt-1 text-gray-700 text-sm border border-gray-200 rounded-md px-3 py-2 bg-gray-50"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Téléphone</label>
                        <p id="viewClientPhone"
                            class="mt-1 text-gray-700 text-sm border border-gray-200 rounded-md px-3 py-2 bg-gray-50"></p>
                    </div>
                </div>


                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="closeClientModal()"
                        class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>