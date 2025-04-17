<!-- Modal pour Assigner un Collaborateur -->
<div id="assignCollaboratorModalSpace" tabindex="-1" aria-hidden="true"
    class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 flex justify-center items-center w-full md:inset-0 h-modal md:h-full bg-black bg-opacity-50 backdrop-blur-sm">
    <div class="relative p-4 w-full max-w-2xl h-full md:h-auto">
        <div class="relative p-4 bg-white rounded-lg shadow-lg sm:p-5">
            <div class="flex justify-between items-center pb-4 mb-4 rounded-t border-b">
                <h3 class="text-lg font-semibold text-gray-900">
                    Assigner un Collaborateur
                </h3>
                <button type="button" onclick="closeAssignCollaboratorModalSpace()"
                    class="text-gray-400 hover:bg-gray-200 rounded-lg p-1.5">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
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

                    <div class="flex justify-end space-x-3">
                        <button type="button" onclick="closeAssignCollaboratorModalSpace()"
                            class="px-5 py-2.5 bg-gray-300 text-black rounded-lg hover:bg-gray-400 transition">
                            Annuler
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 transition">
                            Assigner
                        </button>
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
