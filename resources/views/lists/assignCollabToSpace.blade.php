<!-- Modal pour Assigner un Collaborateur -->
<div id="assignCollaboratorModalSpace" tabindex="-1" aria-hidden="true"
    class="hidden fixed inset-0 z-50 flex justify-center items-center w-full h-full bg-black/50 backdrop-blur-sm p-4 overflow-y-auto">
    <div class="relative w-full max-w-2xl my-auto">
        <div class="relative p-5 sm:p-6 bg-white rounded-card-lg shadow-xl border border-gray-200/80">
            <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Assigner un Collaborateur</h3>
                <button type="button" aria-label="Fermer" onclick="closeAssignCollaboratorModalSpace()"
                    class="text-gray-400 hover:bg-gray-100 hover:text-gray-700 rounded-lg p-2 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            </div>

            @if (isset($list))
            <form action="{{ route('spaces.storeCollaboratorSpace', $list->space_id) }}" method="POST">

                    @csrf
                    <div class="mb-4">
                        <label for="user_id" class="block mb-2 text-sm font-medium text-gray-900">Collaborateur</label>
                        <select name="user_id" id="user_id" required
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                            <option value="">-- Sélectionnez un collaborateur --</option>
                            @foreach ($users as $user)
                                @if ($user->organization_id == auth()->user()->organization_id)
                                    <option value="{{ $user->id }}">{{ $user->name }} -
                                        {{ $user->email }}
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>

                    <div class="flex justify-end gap-3 mt-4">
                        <button type="button" onclick="closeAssignCollaboratorModalSpace()"
                            class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Annuler</button>
                        <button type="submit"
                            class="px-4 py-2.5 text-sm font-medium text-white bg-emerald-600 rounded-xl shadow-sm hover:bg-emerald-700 transition-colors">Assigner</button>
                    </div>
                </form>
            @else
                <p class="text-red-500 text-sm">Aucune liste disponible pour cet espace.</p>
            @endif
        </div>
    </div>
</div>
<script>
    function openAssignCollaboratorModalSpace() {
        let modal = document.getElementById('assignCollaboratorModalSpace');
        modal.classList.remove('hidden');
        setTimeout(() => modal.classList.add('opacity-100', 'scale-100'), 50);
    }

    function closeAssignCollaboratorModalSpace() {
        let modal = document.getElementById('assignCollaboratorModalSpace');
        modal.classList.remove('opacity-100', 'scale-100');
        setTimeout(() => modal.classList.add('hidden'), 20);
    }
</script>
