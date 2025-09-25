

    <!-- Modal Modifier une activité -->
    <div id="editActivityModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black bg-opacity-50 backdrop-blur-sm transition-opacity">
        <div class="relative p-4 w-full max-w-lg h-auto">
            <div class="relative p-6 bg-white rounded-lg shadow-lg sm:p-6">
                <!-- En-tête -->
                <div class="flex justify-between items-center pb-4 mb-4 border-b">
                    <h3 class="text-lg font-semibold text-gray-900">Modifier l'Activité</h3>
                    <button type="button" onclick="closeEditActivityModal()"
                        class="text-gray-400 hover:bg-gray-200 rounded-lg p-1.5">✕</button>
                </div>

                <!-- Formulaire -->
                <form id="editActivityForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" value="PUT">

                    <!-- Date -->
                    <div class="mb-4">
                        <label for="edit_activity_date" class="block text-sm font-medium text-gray-900">Date</label>
                        <input type="date" name="date" id="edit_activity_date" required
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
                    </div>

                    <!-- Heure -->
                    <div class="mb-4">
                        <label for="edit_activity_time" class="block text-sm font-medium text-gray-900">Heure</label>
                        <input type="time" name="time" id="edit_activity_time" required
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
                    </div>

                    <!-- Description -->
                    <div class="mb-4">
                        <label for="edit_activity_description"
                            class="block text-sm font-medium text-gray-900">Description</label>
                        <textarea name="description" id="edit_activity_description" rows="3" required
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2"></textarea>
                    </div>

                    <!-- Participants -->
                    <div class="mb-4">
                        <label for="edit_activity_participants"
                            class="block text-sm font-medium text-gray-900">Participants</label>
                        <select name="participants[]" id="edit_activity_participants" multiple
                            class="mt-1 block w-full border border-gray-300 rounded-lg p-2">
                            @foreach ($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Boutons -->
                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeEditActivityModal()"
                            class="px-5 py-2 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-5 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition">
                            Enregistrer
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openEditActivityModal(data) {
            // Remplir les champs de base
            document.getElementById('edit_activity_date').value = data.date;
            document.getElementById('edit_activity_time').value = data.time;
            document.getElementById('edit_activity_description').value = data.description;

            // Remplir les participants
            const select = document.getElementById('edit_activity_participants');
            const participants = Array.isArray(data.participants) ? data.participants.map(id => parseInt(id)) : [];

            select.querySelectorAll('option').forEach(option => {
                option.selected = participants.includes(parseInt(option.value));
            });

            // Définir l'action du formulaire
            const form = document.getElementById('editActivityForm');
            form.action = `/activities/${data.id}`;

            // Affiche le modal
            const modal = document.getElementById('editActivityModal');
            modal.classList.remove('hidden');
            setTimeout(() => modal.classList.add('opacity-100', 'scale-100'), 50);
        }

        function closeEditActivityModal() {
            const modal = document.getElementById('editActivityModal');
            modal.classList.remove('opacity-100', 'scale-100');
            setTimeout(() => modal.classList.add('hidden'), 200);
        }

        document.addEventListener('click', function(e) {
            const modal = document.getElementById('editActivityModal');
            if (e.target === modal) closeEditActivityModal();
        });
    </script>