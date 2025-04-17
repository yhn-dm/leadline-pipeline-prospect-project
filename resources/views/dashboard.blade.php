@extends('layouts.app')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

@section('content')

<!-- Topbar sticky avec breadcrumb -->
<div class="sticky top-0 bg-gray-50 border-b border-gray-200 shadow-sm flex items-center justify-between px-8 py-3 z-10">
    <div>
        <div class="flex items-center gap-x-3">
            <h1 class="text-xl font-semibold text-gray-600 tracking-wide hover:text-gray-800 transition">
                Dashboard
            </h1>
        </div>

        <!-- Breadcrumb -->
        <nav class="flex mt-1" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                <li class="inline-flex items-center">
                    <svg class="w-4 h-4 me-2.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
                    </svg>
                    <span class="text-sm font-medium text-gray-600">Accueil</span>
                </li>
                <li>
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" viewBox="0 0 6 10">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 9 4-4-4-4" />
                    </svg>
                </li>
                <li aria-current="page">
                    <span class="text-sm font-medium text-gray-500">Dashboard</span>
                </li>
            </ol>
        </nav>
    </div>
</div>

<!-- Contenu principal -->
<div class="mt-8 px-8 pb-10 space-y-8">
    <!-- Statistiques principales -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @php
            $cards = [
                ['label' => 'Total Clients', 'value' => $totalClients, 'color' => 'text-green-600'],
                ['label' => 'Total Prospects', 'value' => $totalProspects, 'color' => 'text-orange-500'],
                ['label' => 'Total Listes', 'value' => $totalLists, 'color' => 'text-indigo-500'],
                ['label' => 'Activités Planifiées', 'value' => $totalActivities, 'color' => 'text-blue-500'],
            ];
        @endphp

        @foreach ($cards as $card)
            <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-6">
                <h3 class="text-sm text-gray-500 mb-1">{{ $card['label'] }}</h3>
                <p class="text-3xl font-bold {{ $card['color'] }}">{{ $card['value'] ?? 'Erreur' }}</p>
            </div>
        @endforeach
    </div>

    <!-- Graphiques -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Graphique Clients vs Prospects -->
        
        <div class="lg:col-span-2 bg-white border border-gray-200 shadow-sm rounded-lg p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-gray-800 text-lg font-semibold">Évolution Clients vs Prospects</h3>
        
                <!-- Sélecteur de durée -->
                <select id="durationSelect"
                    class="border border-gray-300 text-gray-700 rounded-md shadow-sm px-3 py-1 focus:ring-blue-500 focus:border-blue-500">
                    <option value="7">7 derniers jours</option>
                    <option value="14">14 derniers jours</option>
                    <option value="30" selected>30 derniers jours</option>
                </select>
            </div>
        
            <!-- Conteneur graphique -->
            <div class="relative w-full" style="height: 400px;">
                <canvas id="barChart"></canvas>
            </div>
        </div>
        

        <!-- Camembert -->
        <div class="bg-white border border-gray-200 shadow-sm rounded-lg p-6">
            <h3 class="text-gray-800 text-lg font-semibold mb-4">Répartition des Utilisateurs</h3>
            <div class="relative w-full h-[400px]">
                <canvas id="pieChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- scripts Charts.js -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // données Laravel
        const allLabels = {!! json_encode($dates->values()) !!};
        const allClients = {!! json_encode($clientsData->values()) !!};
        const allProspects = {!! json_encode($prospectsData->values()) !!};

        // initialisation du graphique principal
        const ctx = document.getElementById('barChart').getContext('2d');

        const barChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: allLabels.slice(-30),
                datasets: [
                    {
                        label: 'Clients',
                        data: allClients.slice(-30),
                        borderColor: 'rgba(59, 130, 246, 1)',
                        backgroundColor: 'rgba(59, 130, 246, 0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    },
                    {
                        label: 'Prospects',
                        data: allProspects.slice(-30),
                        borderColor: 'rgba(245, 158, 11, 1)',
                        backgroundColor: 'rgba(245, 158, 11, 0.2)',
                        borderWidth: 2,
                        fill: true,
                        tension: 0.3
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom' }
                },
                scales: {
                    x: { grid: { display: false } },
                    y: { beginAtZero: true }
                }
            }
        });

        // mise à jour dynamique du graphique selon la durée sélectionnée
        const durationSelect = document.getElementById('durationSelect');
        durationSelect.addEventListener('change', function () {
            const days = parseInt(this.value);

            // MAJ des données du graphique
            barChart.data.labels = allLabels.slice(-days);
            barChart.data.datasets[0].data = allClients.slice(-days);
            barChart.data.datasets[1].data = allProspects.slice(-days);

            barChart.update();
        });

        // Pie Chart
        new Chart(document.getElementById('pieChart').getContext('2d'), {
            type: 'pie',
            data: {
                labels: ['Clients', 'Prospects', 'Collaborateurs'],
                datasets: [{
                    data: [{{ $totalClients }}, {{ $totalProspects }}, {{ $totalCollaborators }}],
                    backgroundColor: ['#4CAF50', '#FF9800', '#2196F3'],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { position: 'bottom' }
                }
            }
        });
    });
</script>

@endsection
