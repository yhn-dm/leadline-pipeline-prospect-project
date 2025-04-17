    <!-- Modal Voir un Client -->
    <div id="viewClientModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
        <div class="relative p-4 w-full max-w-md h-auto">
            <div class="relative p-6 bg-white rounded-lg shadow-lg sm:p-6">

                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
                    <h3 class="text-lg font-semibold text-gray-900">
                        Informations du Client
                    </h3>
                    <button type="button"
                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5"
                        onclick="closeClientModal()">
                        ✕
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
                        class="px-5 py-2.5 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>