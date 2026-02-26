   <!-- Modal pour Créer un Client -->
   <div id="createClientModal" tabindex="-1" aria-hidden="true"
       class="hidden fixed inset-0 z-50 flex items-center justify-center w-full h-full bg-black/50 backdrop-blur-sm p-4">
       <div class="relative w-full max-w-md">
           <div class="relative p-6 bg-white rounded-card-lg shadow-xl border border-gray-200/80 sm:p-6">
               <div class="flex justify-between items-center pb-4 mb-4 border-b border-gray-200">
                   <h3 class="text-lg font-semibold text-gray-900">Créer un Nouveau Client</h3>
                   <button type="button" aria-label="Fermer"
                       class="text-gray-400 hover:bg-gray-100 hover:text-gray-700 rounded-lg p-2 transition-colors"
                       onclick="closeCreateClientModal()">
                       <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                   </button>
               </div>

               <!-- Formulaire -->
               <form id="createClientForm" action="{{ route('clients.store') }}" method="POST">
                   @csrf
                   <!-- Nom -->
                   <div class="mb-4">
                       <label for="client_name" class="block text-sm font-medium text-gray-900">Nom</label>
                       <input type="text" name="name" id="client_name" required
                           class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                   </div>

                   <!-- Email -->
                   <div class="mb-4">
                       <label for="client_email" class="block text-sm font-medium text-gray-900">Email</label>
                       <input type="email" name="email" id="client_email" required
                           class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                   </div>

                   <!-- Téléphone -->
                   <div class="mb-4">
                       <label for="client_phone" class="block text-sm font-medium text-gray-900">Téléphone</label>
                       <input type="text" name="phone" id="client_phone"
                           class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5">
                   </div>



                   <!-- Commentaire -->
                   <div class="mb-4">
                       <label for="client_comment" class="block text-sm font-medium text-gray-900">Commentaire</label>
                       <textarea name="comment" id="client_comment" rows="3"
                           class="border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"></textarea>
                   </div>

                   <!-- Boutons -->
                   <div class="flex justify-end gap-3 mt-4">
                       <button type="button" onclick="closeCreateClientModal()"
                           class="px-4 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">Annuler</button>
                       <button type="submit"
                           class="px-4 py-2.5 text-sm font-medium text-white bg-indigo-600 rounded-xl shadow-sm hover:bg-indigo-700 transition-colors">Créer</button>
                   </div>
               </form>
           </div>
       </div>
   </div>
