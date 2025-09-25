
    <!-- Modal Détails de l'Activité -->
    <div id="activityDetailsModal" tabindex="-1" aria-hidden="true"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
        <div class="relative p-4 w-full max-w-md h-auto">
            <div class="relative p-6 bg-white rounded-lg shadow-lg sm:p-6">

                <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Détails de l'Activité</h3>
                    <button type="button" onclick="closeActivityModal()"
                        class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5">
                        ✕
                    </button>
                </div>


                <div class="space-y-3 text-sm">
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Date</label>
                        <p id="activity_date" class="mt-1 text-gray-700"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Heure</label>
                        <p id="activity_time" class="mt-1 text-gray-700"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Description</label>
                        <p id="activity_description" class="mt-1 text-gray-700"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Participants</label>
                        <p id="activity_participants" class="mt-1 text-gray-700"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-900">Prospect</label>
                        <p id="activity_prospect" class="mt-1 text-gray-700"></p>
                    </div>
                </div>


                <div class="mt-6 flex justify-end">
                    <button type="button" onclick="closeActivityModal()"
                        class="px-5 py-2.5 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition">
                        Fermer
                    </button>
                </div>
            </div>
        </div>
    </div>