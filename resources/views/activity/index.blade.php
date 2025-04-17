@extends('layouts.app')

@section('content')
    <!-- HEADER  -->
    <div class="sticky top-0 bg-gray-50 border-b border-gray-200 shadow-sm flex items-center justify-between px-8 py-3 z-10">
        <!-- Infos & Breadcrumb -->
        <div>
            <div class="flex items-center gap-x-3">
                <h1 class="text-xl font-semibold text-gray-600 tracking-wide hover:text-gray-800 transition">
                    Planification des Activités
                </h1>
            </div>
            <!-- Facultatif : breadcrumb -->
            <nav class="flex mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <a href="{{ route('dashboard') }}"
                            class="inline-flex items-center text-sm font-medium text-gray-600 hover:text-gray-800">
                            <svg class="w-4 h-4 me-2.5" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                            </svg>
                            Dashboard
                        </a>
                    </li>
                    <li>
                        <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 9 4-4-4-4" />
                        </svg>
                    </li>
                    <li aria-current="page">
                        <span class="text-sm font-medium text-gray-500">Activités</span>
                    </li>
                </ol>
            </nav>
        </div>

        <!-- ✅ Bouton avec TON style -->
        <div class="flex space-x-4">
            <button onclick="openPlanActivityModal()"
                class="flex items-center px-6 py-2.5 text-gray-600 bg-white border border-gray-300 rounded-lg shadow-sm hover:border-blue-500 hover:bg-blue-50 hover:text-gray-800 transition duration-300 focus:outline-none">
                <span class="text-base tracking-wide">Planifier un RDV</span>
            </button>
        </div>
    </div>

    <!-- CONTENU PRINCIPAL -->
    <div class="mt-8 px-8">
        <div class="bg-white border border-gray-200 shadow-lg rounded-lg overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50 hidden md:table-header-group">
                    <tr>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Date</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Heure</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Description</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Participant(s)</th>
                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-800">Prospect</th>
                        <th class="px-6 py-3 text-center text-sm font-semibold text-gray-800">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200" id="activitiesTable">
                    @forelse ($activities as $activity)
                        @php
                            $prospect = $activity->prospects->first();
                        @endphp
                        <tr class="activity-row block md:table-row border md:border-0 mb-4 md:mb-0 hover:bg-gray-100 transition cursor-pointer"
                            onclick="openEditActivityModal({
                            id: '{{ $activity->id }}',
                            date: '{{ $activity->date }}',
                            time: '{{ $activity->time }}',
                            description: '{{ addslashes($activity->description) }}',
                            participants: @json($activity->participants->pluck('id')),
                            prospect_id: '{{ $prospect?->id }}',
                            prospect_name: '{{ addslashes($prospect?->name ?? '') }}',
                            prospect_list_id: '{{ $prospect?->list_id ?? '' }}'
                        })">

                            {{-- Date --}}
                            <td class="px-6 py-4 text-gray-900 font-medium md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Date :</span>
                                {{ \Carbon\Carbon::parse($activity->date)->format('d/m/Y') }}
                            </td>

                            {{-- Heure --}}
                            <td class="px-6 py-4 text-gray-900 font-medium md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Heure :</span>
                                {{ \Carbon\Carbon::parse($activity->time)->format('H:i') }}
                            </td>

                            {{-- Description --}}
                            <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Description :</span>
                                {{ $activity->description }}
                            </td>

                            {{-- Participants --}}
                            <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Participants :</span>
                                {{ implode(', ', $activity->participants->pluck('name')->toArray()) }}
                            </td>

                            {{-- Prospect --}}
                            <td class="px-6 py-4 text-gray-600 md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600">Prospect :</span>
                                @if ($prospect)
                                    <a href="{{ route('lists.prospects.index', ['list' => $prospect->list->id]) }}">Voir
                                        prospects</a>
                                @else
                                    N/A
                                @endif
                            </td>

                            {{-- Actions --}}
                            <td class="px-6 py-4 text-center md:table-cell block">
                                <span class="md:hidden font-semibold text-gray-600 block mb-2">Actions :</span>
                                <div class="flex flex-wrap gap-2 justify-center">
                                    <form action="{{ route('activities.destroy', $activity->id) }}" method="POST"
                                        onsubmit="event.stopPropagation()">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                            onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette activité ?')"
                                            class="px-4 py-2 text-sm font-medium text-white bg-red-500 rounded-md shadow-md hover:bg-red-600">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr id="noActivitiesRow">
                            <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                Aucune activité planifiée.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>
    </div>


    @include('activity.editActivity_modal', ['spaces' => $spaces])
    @include('activity.detailActivity_modal', ['spaces' => $spaces])
    @include('activity.planActivity_modal', ['spaces' => $spaces])
    <script>
        // Lors de l'ouverture du modal de détails d'activité (exemple dans votre script)
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.activity-row').forEach(row => {
                row.addEventListener('click', function() {
                    const activity = {
                        id: this.getAttribute('data-id'),
                        date: this.getAttribute('data-date'),
                        time: this.getAttribute('data-time'),
                        description: this.getAttribute('data-description'),
                        participants: this.getAttribute('data-participants'),
                        prospect_name: this.getAttribute('data-prospect_name'),
                        prospect_list_id: this.getAttribute('data-prospect_list_id'),
                        prospect_list_name: this.getAttribute('data-prospect_list_name'),
                    };

                    // Ajoute ceci pour transformer la chaîne participants en tableau d’IDs
                    activity.participants = activity.participants
                        .split(',')
                        .map(p => parseInt(p.trim()))
                        .filter(p => !isNaN(p));

                    // Appelle bien la fonction d’édition avec les bonnes données
                    openEditActivityModal(activity);
                });
            });

            document.getElementById('editActivityModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    this.classList.add('hidden');
                }
            });
        });
    </script>
@endsection
