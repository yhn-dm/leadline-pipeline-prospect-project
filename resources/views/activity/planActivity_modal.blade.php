<!-- Modal Planifier un RDV -->
<div id="planActivityModal" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
    <div class="relative p-4 w-full max-w-lg h-auto">
        <div class="relative p-6 bg-white rounded-lg shadow-lg sm:p-6">

            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
                <h3 class="text-lg font-semibold text-gray-900">Planifier un RDV</h3>
                <button type="button" onclick="closePlanActivityModal()"
                    class="text-gray-400 hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5">
                    ✕
                </button>
            </div>

            <form id="planActivityForm" action="{{ route('activities.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="activity_date" class="block text-sm font-medium text-gray-900">Date</label>
                    <input type="date" name="date" id="activity_date" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="activity_time" class="block text-sm font-medium text-gray-900">Heure</label>
                    <input type="time" name="time" id="activity_time" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500">
                </div>
                <div class="mb-4">
                    <label for="activity_description"
                        class="block text-sm font-medium text-gray-900">Description</label>
                    <textarea name="description" id="activity_description" rows="3" required
                        class="mt-1 block w-full border border-gray-300 rounded-lg p-2 focus:ring-blue-500 focus:border-blue-500"></textarea>
                </div>
                <!-- Boutons -->
                <div class="flex justify-end space-x-3">
                    <button type="button" onclick="closePlanActivityModal()"
                        class="px-5 py-2 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition">
                        Annuler
                    </button>
                    <button type="submit"
                        class="px-5 py-2 bg-blue-600 text-white rounded-lg shadow hover:bg-blue-700 transition">
                        Planifier
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function openPlanActivityModal() {
        const modal = document.getElementById('planActivityModal');
        modal.classList.remove('hidden');
        // Optionnel: ajouter des classes pour une transition (si besoin)
        setTimeout(() => modal.classList.add('opacity-100', 'scale-100'), 50);
    }

    function closePlanActivityModal() {
        const modal = document.getElementById('planActivityModal');
        modal.classList.remove('opacity-100', 'scale-100');
        setTimeout(() => modal.classList.add('hidden'), 200);
    }

    // Facultatif : fermer le modal en cliquant en dehors de la boîte
    document.getElementById('planActivityModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closePlanActivityModal();
        }
    });
</script>
