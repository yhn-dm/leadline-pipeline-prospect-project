@extends('layouts.app')

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-chart-funnel@4.3.0/dist/chartjs-chart-funnel.umd.min.js"></script>

@section('content')
    <!-- Topbar sticky breadcrumb -->
    <div class="sticky top-0 bg-white/95 backdrop-blur border-b border-gray-200 shadow-sm flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 px-4 sm:px-6 md:px-8 py-3 z-10">
        <div class="min-w-0">
            <h1 class="text-lg sm:text-xl font-semibold text-gray-800 tracking-tight">
                Dashboard
            </h1>

            <!-- Breadcrumb -->
            <nav class="flex mt-1" aria-label="Breadcrumb">
                <ol class="inline-flex items-center space-x-1 md:space-x-2 rtl:space-x-reverse">
                    <li class="inline-flex items-center">
                        <svg class="w-4 h-4 me-2.5 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z" />
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

    <!-- Contenu -->
    <div class="mt-4 sm:mt-6 px-4 sm:px-6 md:px-8 pb-8 space-y-6">
        {{-- KPI --}}
        @php
            $deltaClass = fn($n) => ($n ?? 0) >= 0 ? 'text-green-600' : 'text-red-600';
            $cards = [
                [
                    'label' => 'Total Clients',
                    'value' => number_format($totalClients, 0, ',', ' '),
                    'sub' =>
                        ($clients30 ?? 0) !== null
                            ? sprintf('+%s ce mois ci', number_format($clients30 ?? 0, 0, ',', ' '))
                            : null,
                    'subClass' => $deltaClass($clients30 ?? 0),
                ],
                [
                    'label' => 'Total Prospects',
                    'value' => number_format($totalProspects, 0, ',', ' '),
                    'sub' =>
                        ($prospects30 ?? 0) !== null
                            ? sprintf('+%s ce mois ci', number_format($prospects30 ?? 0, 0, ',', ' '))
                            : null,
                    'subClass' => $deltaClass($prospects30 ?? 0),
                ],
                [
                    'label' => 'Activités planifiées',
                    'value' => number_format($totalActivities, 0, ',', ' '),
                    'sub' =>
                        ($activities30 ?? 0) !== null
                            ? sprintf('+%s ce mois ci', number_format($activities30 ?? 0, 0, ',', ' '))
                            : null,
                    'subClass' => $deltaClass($activities30 ?? 0),
                ],
                [
                    'label' => 'Taux de conversion',
                    'value' => number_format($conversionRate, 1, ',', ' ') . '%',
                    'sub' => 'sur les 30 derniers jours',
                    'subClass' => 'text-gray-500',
                ],
                [
                    'label' => 'Clients actifs',
                    'value' => number_format($activeClientsPct, 1, ',', ' ') . '%',
                    'sub' => isset($activeClientsPctDelta3m)
                        ? sprintf(
                            '%s%s sur les 3 derniers mois',
                            $activeClientsPctDelta3m >= 0 ? '+' : '',
                            number_format($activeClientsPctDelta3m, 1, ',', ' '),
                        )
                        : '90 derniers jours',
                    'subClass' => isset($activeClientsPctDelta3m)
                        ? $deltaClass($activeClientsPctDelta3m)
                        : 'text-gray-500',
                ],
            ];
        @endphp

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-3 sm:gap-4">
            @foreach ($cards as $card)
                <div class="bg-white border border-gray-200/80 shadow-card rounded-card-lg p-4 hover:shadow-card-hover transition-shadow">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wide mb-1">{{ $card['label'] }}</h3>
                    <p class="text-2xl font-bold text-gray-900 leading-tight">{{ $card['value'] }}</p>
                    @if (!empty($card['sub']))
                        <p class="text-xs font-medium mt-1.5 {{ $card['subClass'] }}">{{ $card['sub'] }}</p>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- Graphiques -->
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 items-stretch">
            <!-- Évolution Clients vs Prospects -->
            <div
                class="lg:col-span-2 bg-white border border-gray-200/80 shadow-card rounded-card-lg p-4 sm:p-5 h-full flex flex-col min-w-0">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-gray-800 text-mg font-bold">Évolution Clients vs Prospects</h3>
                    <div class="flex items-center gap-2">
                        <div class="inline-flex rounded-md overflow-hidden border border-gray-300">
                            <button id="modeDaily" type="button"
                                class="px-2.5 py-1 text-mg bg-white hover:bg-gray-50">Quotidien</button>
                            <button id="modeCumulative" type="button"
                                class="px-2.5 py-1 text-mg bg-gray-100 font-medium">Cumulé</button>
                        </div>
                        <select id="durationSelect"
                            class="border border-gray-300 text-gray-700 rounded-md shadow-sm px-2.5 py-1 text-mg focus:ring-blue-500 focus:border-blue-500">
                            <option value="7">7 derniers jours</option>
                            <option value="14">14 derniers jours</option>
                            <option value="30" selected>30 derniers jours</option>
                        </select>
                    </div>
                </div>
                <div class="relative w-full flex-1 min-h-[300px]">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

            <!-- Pipeline des prospects -->
            <div class="bg-white border border-gray-200/80 shadow-card rounded-card-lg p-4 sm:p-5 h-full flex flex-col min-w-0">
                <div class="flex items-center justify-between mb-3">
                    <h3 class="text-gray-800 text-base font-semibold">Pipeline des prospects</h3>
                    <span class="text-[11px] text-gray-500">30 derniers jours</span>
                </div>

                <div class="relative w-full flex-1 min-h-[300px]">
                    <!-- Image de fond -->
                    <img src="{{ asset('entonoir.png') }}" alt="Entonnoir des prospects"
                        class="absolute inset-0 w-full h-full object-contain pointer-events-none select-none" />

                    <!-- Chiffres en blanc  -->
                    <span
                        class="absolute left-[60%] top-[17%] -translate-x-1/2 text-white font-extrabold text-[22px] drop-shadow"
                        style="text-shadow:0 1px 2px rgba(0,0,0,.45);">
                        {{ $funnelNums['top'] ?? 0 }}
                    </span>

                    <span
                        class="absolute left-[60%] top-[38.5%] -translate-x-1/2 text-white font-extrabold text-[22px] drop-shadow"
                        style="text-shadow:0 1px 2px rgba(0,0,0,.45);">
                        {{ $funnelNums['mid1'] ?? 0 }}
                    </span>

                    <span
                        class="absolute left-[60%] top-[58.5%] -translate-x-1/2 text-white font-extrabold text-[22px] drop-shadow"
                        style="text-shadow:0 1px 2px rgba(0,0,0,.45);">
                        {{ $funnelNums['mid2'] ?? 0 }}
                    </span>

                    <span
                        class="absolute left-[60%] top-[77.5%] -translate-x-1/2 text-white font-extrabold text-[20px] drop-shadow"
                        style="text-shadow:0 1px 2px rgba(0,0,0,.45);">
                        {{ $funnelNums['bottom'] ?? 0 }}
                    </span>
                </div>
            </div>



            <!-- Sources d’acquisition -->
            <div class="bg-white border border-gray-200/80 shadow-card rounded-card-lg p-4 sm:p-5 h-full flex flex-col min-w-0">
                <h3 class="text-gray-800 text-mg font-bold mb-3">Sources d’acquisition</h3>
                <div class="relative w-full flex-1 min-h-[300px]">
                    <canvas id="acqPie"></canvas>
                </div>

            </div>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-[3fr_4fr_3fr] gap-3 items-stretch">
            {{-- Activités à venir - Aujourd’hui --}}
            <div class="bg-white border border-gray-200/80 shadow-card rounded-card-lg p-4 lg:h-[210px]">
                <h3 class="text-gray-800 text-mg font-bold mb-2 leading-tight">Activités à venir - Aujourd’hui</h3>
                <ul class="divide-y divide-gray-100 lg:max-h-[160px] overflow-y-auto">
                    @forelse ($todayActivities as $a)
                        <li class="py-1.5 flex items-center justify-between">
                            <span
                                class="text-mg text-gray-700 truncate leading-tight">{{ $a->description ?? 'Sans libellé' }}</span>
                            <span class="text-[11px] font-medium text-gray-500 leading-tight">
                                {{ $a->time ? \Carbon\Carbon::parse($a->time)->format('H:i') : '' }}
                            </span>
                        </li>
                    @empty
                        <li class="py-2"><span class="text-mg text-gray-500">Aucune activité prévue aujourd’hui.</span>
                        </li>
                    @endforelse
                </ul>
            </div>
            {{-- Performance Collaborateurs --}}
            <div class="bg-white border border-gray-200/80 shadow-card rounded-card-lg p-4 lg:h-[210px]">
                <h3 class="text-gray-800 text-base font-semibold mb-2 leading-tight">Performance Collaborateurs</h3>

                @php
                    $left = $topCollaborators->slice(0, ceil($topCollaborators->count() / 2));
                    $right = $topCollaborators->slice(ceil($topCollaborators->count() / 2));
                @endphp

                <div class="grid grid-cols-2 gap-x-8 lg:max-h-[160px] overflow-y-auto">
                    {{-- Colonne gauche --}}
                    <div class="space-y-2 pr-6 border-r border-gray-200">
                        @foreach ($left as $u)
                            <div class="flex items-center justify-between gap-6 py-0.5">
                                <span class="text-gray-700 text-sm truncate">{{ $u->name }}</span>
                                <span class="text-gray-600 text-sm whitespace-nowrap shrink-0 tabular-nums">
                                    {{ $u->conversions }} Conversion{{ $u->conversions > 1 ? 's' : '' }}
                                </span>
                            </div>
                        @endforeach
                    </div>

                    {{-- Colonne droite --}}
                    <div class="space-y-2 pl-6">
                        @foreach ($right as $u)
                            <div class="flex items-center justify-between gap-6 py-0.5">
                                <span class="text-gray-700 text-sm truncate">{{ $u->name }}</span>
                                <span class="text-gray-600 text-sm whitespace-nowrap shrink-0 tabular-nums">
                                    {{ $u->conversions }} Conversion{{ $u->conversions > 1 ? 's' : '' }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>


            {{-- Activité Urgente --}}
            <div class="bg-white border border-gray-200/80 shadow-card rounded-card-lg p-4 lg:h-[210px]">
                <h3 class="text-gray-800 text-mg font-bold mb-2 leading-tight">Activité Urgente</h3>
                <div class="border-t border-gray-200 pt-1 lg:max-h-[160px] overflow-y-auto">
                    <div class="grid grid-cols-2 text-[11px] text-gray-500 py-1">
                        <div>Nom</div>
                        <div>Date</div>
                    </div>
                    @forelse ($urgentActivities as $a)
                        <div class="grid grid-cols-2 text-mg py-1.5 border-t border-gray-100 leading-tight">
                            <div class="text-gray-700 truncate">{{ $a->description ?? 'Sans libellé' }}</div>
                            <div class="text-gray-600">
                                {{ \Carbon\Carbon::parse($a->date)->format('d/m/Y') }}
                                {{ $a->time ? \Carbon\Carbon::parse($a->time)->format('H:i') : '' }}
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-mg text-gray-500 py-4">Aucune activité urgente trouvé</div>
                    @endforelse
                </div>
            </div>
        </div>


    </div>


    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // ===== Données Laravel =====
            const allLabels = {!! json_encode($dates->values()) !!};
            const clientsDaily = {!! json_encode($clientsDaily) !!};
            const prospectsDaily = {!! json_encode($prospectsDaily) !!};
            const clientsCum = {!! json_encode($clientsCumData) !!};
            const prospectsCum = {!! json_encode($prospectsCumData) !!};

            const acqLabels = {!! json_encode($acqLabels ?? []) !!};
            const acqValues = {!! json_encode($acqValues ?? []) !!};

            const funnelLabels = {!! json_encode($pipelineLabels ?? []) !!};
            const funnelValues = {!! json_encode($pipelineValues ?? []) !!};

            // ===== Helpers =====
            let currentMode = 'cumulative';
            let currentDays = parseInt(document.getElementById('durationSelect').value || '30', 10);

            const tailSlice = (arr, n) => arr.slice(Math.max(0, arr.length - Math.max(1, Math.min(n, arr.length))));
            const fmtDM = (iso) => (typeof iso === 'string' && iso.length >= 10) ?
                `${iso.slice(8,10)}/${iso.slice(5,7)}` : iso;

            function getSeries() {
                if (currentMode === 'daily') {
                    return {
                        labels: tailSlice(allLabels, currentDays),
                        prospects: tailSlice(prospectsDaily, currentDays).map(Number),
                        clients: tailSlice(clientsDaily, currentDays).map(Number),
                    };
                }
                return {
                    labels: tailSlice(allLabels, currentDays),
                    prospects: tailSlice(prospectsCum, currentDays).map(Number),
                    clients: tailSlice(clientsCum, currentDays).map(Number),
                };
            }

            function niceStep(n) {
                if (n <= 5) return 1;
                if (n <= 10) return 2;
                if (n <= 25) return 5;
                if (n <= 50) return 10;
                if (n <= 100) return 20;
                if (n <= 250) return 50;
                if (n <= 500) return 100;
                return Math.pow(10, Math.floor(Math.log10(n)) - 1);
            }

            function computeY(series) {
                const maxVal = Math.max(0, ...series.clients, ...series.prospects);
                const base = Math.max(maxVal, 5);
                const step = niceStep(base);
                const max = Math.ceil((base * 1.12) / step) * step;
                return {
                    step,
                    max
                };
            }

            // Line Clients vs Prospects =====
            const lineCanvas = document.getElementById('barChart');
            if (lineCanvas) {
                const ctx = lineCanvas.getContext('2d');
                const initial = getSeries();
                const y0 = computeY(initial);
                const lineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: initial.labels,
                        datasets: [{
                                label: 'Prospects',
                                data: initial.prospects,
                                borderColor: 'rgba(245, 158, 11, 1)',
                                pointBackgroundColor: 'rgba(245, 158, 11, 1)',
                                borderWidth: 2,
                                pointRadius: 3,
                                pointHoverRadius: 4,
                                fill: false,
                                tension: 0.35
                            },
                            {
                                label: 'Clients',
                                data: initial.clients,
                                borderColor: 'rgba(59, 130, 246, 1)',
                                pointBackgroundColor: 'rgba(59, 130, 246, 1)',
                                borderWidth: 2,
                                pointRadius: 3,
                                pointHoverRadius: 4,
                                fill: false,
                                tension: 0.35
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: {
                            padding: {
                                top: 4,
                                right: 8,
                                left: 4,
                                bottom: 0
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 8,
                                    boxHeight: 8,
                                    padding: 16
                                }
                            },
                            tooltip: {
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    title: (items) => fmtDM(items[0]?.label ?? ''),
                                    label: (ctx) =>
                                        `${ctx.dataset.label}: ${Number(ctx.parsed.y).toLocaleString('fr-FR')}`
                                }
                            }
                        },
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            x: {
                                grid: {
                                    display: true,
                                    color: '#e5e7eb',
                                    borderColor: '#e5e7eb'
                                },
                                ticks: {
                                    autoSkip: true,
                                    maxRotation: 0,
                                    callback: function(value) {
                                        return fmtDM(this.getLabelForValue(value));
                                    }
                                }
                            },
                            y: {
                                beginAtZero: true,
                                grid: {
                                    color: '#e5e7eb',
                                    borderColor: '#e5e7eb'
                                },
                                ticks: {
                                    stepSize: y0.step,
                                    callback: (v) => Number(v).toLocaleString('fr-FR')
                                },
                                title: {
                                    display: true,
                                    text: 'Nombre (cumulé)'
                                },
                                max: y0.max
                            }
                        }
                    }
                });

                function refreshChart() {
                    const series = getSeries();
                    const y = computeY(series);
                    lineChart.data.labels = series.labels;
                    lineChart.data.datasets[0].data = series.prospects;
                    lineChart.data.datasets[1].data = series.clients;
                    const yAxis = lineChart.options.scales.y;
                    yAxis.ticks.stepSize = y.step;
                    yAxis.max = y.max;
                    yAxis.title.text = (currentMode === 'daily') ? 'Nombre (quotidien)' : 'Nombre (cumulé)';
                    lineChart.update();
                }

                const durationSelect = document.getElementById('durationSelect');
                durationSelect?.addEventListener('change', function() {
                    currentDays = parseInt(this.value, 10);
                    refreshChart();
                });
                const modeDailyBtn = document.getElementById('modeDaily');
                const modeCumulativeBtn = document.getElementById('modeCumulative');

                function setMode(mode) {
                    currentMode = mode;
                    if (mode === 'daily') {
                        modeDailyBtn?.classList.add('bg-gray-100', 'font-medium');
                        modeCumulativeBtn?.classList.remove('bg-gray-100', 'font-medium');
                    } else {
                        modeCumulativeBtn?.classList.add('bg-gray-100', 'font-medium');
                        modeDailyBtn?.classList.remove('bg-gray-100', 'font-medium');
                    }
                    refreshChart();
                }
                modeDailyBtn?.addEventListener('click', () => setMode('daily'));
                modeCumulativeBtn?.addEventListener('click', () => setMode('cumulative'));
                setMode('cumulative');
            }

            // ===== Chart 2 : Donut Sources d’acquisition =====
            const acqCanvas = document.getElementById('acqPie');
            if (acqCanvas) {
                new Chart(acqCanvas.getContext('2d'), {
                    type: 'doughnut',
                    data: {
                        labels: acqLabels,
                        datasets: [{
                            data: acqValues,
                            backgroundColor: ['#3b82f6', '#93c5fd', '#bfdbfe', '#cbd5e1'],
                            borderColor: '#ffffff',
                            borderWidth: 2
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '58%',
                        plugins: {
                            legend: {
                                position: 'left',
                                labels: {
                                    boxWidth: 12,
                                    boxHeight: 12,
                                    padding: 12
                                }
                            },
                            tooltip: {
                                callbacks: {
                                    label: (ctx) =>
                                        `${ctx.label}: ${Number(ctx.parsed).toLocaleString('fr-FR')}`
                                }
                            }
                        }
                    }
                });
            }

            //  Entonnoir Pipeline =====
            const funnelCanvas = document.getElementById('funnelChart');
            if (funnelCanvas) {
                if (window.ChartFunnel) {
                    Chart.register(window.ChartFunnel.FunnelController, window.ChartFunnel.TrapezoidElement);
                }
                try {
                    new Chart(funnelCanvas.getContext('2d'), {
                        type: 'funnel',
                        data: {
                            labels: funnelLabels,
                            datasets: [{
                                data: funnelValues,
                                backgroundColor: ['#93c5fd', '#60a5fa', '#3b82f6', '#22c55e',
                                    '#f87171'
                                ],
                                borderColor: '#e5e7eb',
                                borderWidth: 1
                            }]
                        },
                        options: {
                            maintainAspectRatio: false,
                            sort: 'desc',
                            funnel: {
                                dynamicSlope: true,
                                dynamicHeight: true
                            },
                            plugins: {
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: (ctx) =>
                                            `${ctx.label}: ${Number(ctx.raw).toLocaleString('fr-FR')}`
                                    }
                                }
                            }
                        }
                    });
                } catch (e) {
                    new Chart(funnelCanvas.getContext('2d'), {
                        type: 'bar',
                        data: {
                            labels: funnelLabels,
                            datasets: [{
                                data: funnelValues,
                                backgroundColor: ['#93c5fd', '#60a5fa', '#3b82f6', '#22c55e',
                                    '#f87171'
                                ]
                            }]
                        },
                        options: {
                            indexAxis: 'y',
                            maintainAspectRatio: false,
                            plugins: {
                                legend: {
                                    display: false
                                }
                            },
                            scales: {
                                x: {
                                    beginAtZero: true,
                                    grid: {
                                        color: '#e5e7eb'
                                    },
                                    ticks: {
                                        callback: (v) => Number(v).toLocaleString('fr-FR')
                                    }
                                },
                                y: {
                                    grid: {
                                        display: false
                                    }
                                }
                            },
                            elements: {
                                bar: {
                                    borderRadius: 10
                                }
                            }
                        }
                    });
                }
            }
        });
    </script>
@endsection
