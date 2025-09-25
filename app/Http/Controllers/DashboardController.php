<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Space;
use App\Models\Lists;
use App\Models\Activity;
use App\Models\User;
use App\Models\Prospect;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;


class DashboardController extends Controller
{
    public function index()
    {
        // =========================
        // 1) Comptes globaux
        // =========================
        $totalClients = Client::count();
        $totalSpaces = Space::count();
        $totalLists = Lists::count();
        $totalActivities = Activity::count();
        $totalProspects = Prospect::count();
        $totalCollaborators = User::count();

        // =========================
        // 2) KPI - Conversion (30j)
        // =========================
        $periodDays = 30;
        $since = Carbon::now()->subDays($periodDays);

        $prospectsInPeriod = Prospect::where('created_at', '>=', $since)->count();
        $clientsInPeriod = Client::where('created_at', '>=', $since)->count();

        $conversionRate = $prospectsInPeriod > 0
            ? round(($clientsInPeriod / $prospectsInPeriod) * 100, 1)
            : 0.0;

        // =========================
        // 3) KPI - Clients actifs (>= 1 activité sur 90j)
        // =========================
        $activeWindowDays = 90;
        $sinceActive = Carbon::now()->subDays($activeWindowDays);

        $activeClients = Client::whereHas('activities', function ($q) use ($sinceActive) {
            $q->whereDate('date', '>=', $sinceActive->toDateString());
        })->count();

        $activeClientsPct = $totalClients > 0
            ? round(($activeClients / $totalClients) * 100, 1)
            : 0.0;

        // =========================
        // 4) Fenêtres temporelles pour variations (30j vs 30j précédents)
        // =========================
        $now = Carbon::now();
        $since30 = $now->copy()->subDays(30);
        $since60 = $now->copy()->subDays(60);

        // =========================
        // 5) Évolution par mois (6 derniers mois)
        // =========================
        $clientsByMonth = Client::selectRaw('MONTH(created_at) as month, COUNT(id) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');

        // =========================
// -------- Sources d’acquisition --------
// Fenêtre par défaut : 90 jours
        $sourceSince = Carbon::now()->subDays(90);

        // On récupère juste les valeurs "source_acquisition" des prospects récents
        $sources = Prospect::where('created_at', '>=', $sourceSince)
            ->pluck('source_acquisition'); // collection de strings/null

        // Buckets cibles
        $acqBuckets = ['Marketing' => 0, 'Référ.' => 0, 'RS' => 0, 'Autre' => 0];

        // Fonction de normalisation (minuscule, sans accents, trim)
        $norm = function (?string $s) {
            $s = Str::of((string) $s)->squish()->lower();
            $s = Str::ascii($s); // enlève les accents
            return (string) $s;
        };

        // Dispatch tolérant par mots-clés (contient…)
        foreach ($sources as $raw) {
            $v = $norm($raw);

            if ($v === '') {
                $acqBuckets['Autre']++;
                continue;
            }

            if (Str::contains($v, ['market', 'pub', 'publicite', 'sea', 'seo', 'email', 'news', 'campagne', 'landing', 'ad', 'ads'])) {
                $acqBuckets['Marketing']++;
            } elseif (Str::contains($v, ['ref', 'refer', 'recom', 'parrain'])) { // réf., referral, référence, recommandation, parrainage
                $acqBuckets['Référ.']++;
            } elseif (Str::contains($v, ['rs', 'social', 'reseau', 'instagram', 'insta', 'facebook', 'fb', 'twitter', ' x ', 'linkedin', 'tiktok', 'youtube', 'yt'])) {
                $acqBuckets['RS']++;
            } else {
                $acqBuckets['Autre']++;
            }
        }

        // Fallback : si 0 données récentes, on calcule sur tout l'historique pour ne pas avoir un graphe vide
        if (array_sum($acqBuckets) === 0) {
            $sourcesAll = Prospect::pluck('source_acquisition');
            foreach (['Marketing' => 0, 'Référ.' => 0, 'RS' => 0, 'Autre' => 0] as $k => $v) {
                $acqBuckets[$k] = 0;
            }
            foreach ($sourcesAll as $raw) {
                $v = $norm($raw);
                if ($v === '') {
                    $acqBuckets['Autre']++;
                    continue;
                }
                if (Str::contains($v, ['market', 'pub', 'publicite', 'sea', 'seo', 'email', 'news', 'campagne', 'landing', 'ad', 'ads'])) {
                    $acqBuckets['Marketing']++;
                } elseif (Str::contains($v, ['ref', 'refer', 'recom', 'parrain'])) {
                    $acqBuckets['Référ.']++;
                } elseif (Str::contains($v, ['rs', 'social', 'reseau', 'instagram', 'insta', 'facebook', 'fb', 'twitter', ' x ', 'linkedin', 'tiktok', 'youtube', 'yt'])) {
                    $acqBuckets['RS']++;
                } else {
                    $acqBuckets['Autre']++;
                }
            }
        }

        // Si malgré tout tout est à 0, on met un placeholder pour éviter un donut invisible
        if (array_sum($acqBuckets) === 0) {
            $acqLabels = ['Aucune donnée'];
            $acqValues = [1];
        } else {
            $acqLabels = array_keys($acqBuckets);
            $acqValues = array_values($acqBuckets);
        }



        // =========================
        // 7) Séries journalières + cumulées (30 jours)
        // =========================
        $dates = collect(range(0, 29))
            ->map(fn($day) => Carbon::now()->subDays($day)->format('Y-m-d'))
            ->reverse();

        // Comptes/jour
        $clientsData = $dates->mapWithKeys(fn($d) => [$d => Client::whereDate('created_at', $d)->count()]);
        $prospectsData = $dates->mapWithKeys(fn($d) => [$d => Prospect::whereDate('created_at', $d)->count()]);

        $clientsDaily = $dates->map(fn($d) => $clientsData[$d] ?? 0)->values();
        $prospectsDaily = $dates->map(fn($d) => $prospectsData[$d] ?? 0)->values();

        // Cumul réel (en partant du total avant la 1re date)
        $startDate = $dates->first();
        $clientsBefore = Client::whereDate('created_at', '<', $startDate)->count();
        $prospectsBefore = Prospect::whereDate('created_at', '<', $startDate)->count();

        $runningClients = $clientsBefore;
        $clientsCumData = $clientsDaily->map(function ($v) use (&$runningClients) {
            $runningClients += (int) $v;
            return $runningClients;
        });

        $runningProspects = $prospectsBefore;
        $prospectsCumData = $prospectsDaily->map(function ($v) use (&$runningProspects) {
            $runningProspects += (int) $v;
            return $runningProspects;
        });

        // =========================
        // 8) Variations 30j vs 30j précédents
        // =========================
        $clients30 = Client::where('created_at', '>=', $since30)->count();
        $clientsPrev30 = Client::whereBetween('created_at', [$since60, $since30])->count();
        $clientsVariation = $clientsPrev30 > 0
            ? round((($clients30 - $clientsPrev30) / $clientsPrev30) * 100, 1)
            : 0.0;

        $prospects30 = Prospect::where('created_at', '>=', $since30)->count();
        $prospectsPrev30 = Prospect::whereBetween('created_at', [$since60, $since30])->count();
        $prospectsVariation = $prospectsPrev30 > 0
            ? round((($prospects30 - $prospectsPrev30) / $prospectsPrev30) * 100, 1)
            : 0.0;

        $activities30 = Activity::where('created_at', '>=', $since30)->count();
        $activitiesPrev30 = Activity::whereBetween('created_at', [$since60, $since30])->count();
        $activitiesVariation = $activitiesPrev30 > 0
            ? round((($activities30 - $activitiesPrev30) / $activitiesPrev30) * 100, 1)
            : 0.0;


        // -------- Pipeline (entonnoir) sur 30 jours --------
        $pipelineDays = 30;
        $sincePipeline = Carbon::now()->subDays($pipelineDays);

        $funnelNums = [
            'top' => \App\Models\Prospect::where('status', 'new')
                ->where('created_at', '>=', $sincePipeline)->count(),          // Nouveau
            'mid1' => \App\Models\Prospect::where('status', 'contacted')
                ->where('created_at', '>=', $sincePipeline)->count(),          // Qualifié
            'mid2' => \App\Models\Prospect::where('status', 'interested')
                ->where('created_at', '>=', $sincePipeline)->count(),          // Proposition
            'bottom' => \App\Models\Client::where('created_at', '>=', $sincePipeline)
                ->count(),                                                   // “Négociation / gagné” (à adapter si besoin)
        ];



        // === Activités à venir (aujourd’hui) ===
        $todayActivities = Activity::whereDate('date', Carbon::today())
            ->orderBy('time')
            ->limit(8)
            ->get(['id', 'description', 'date', 'time']);

        // === Performance collaborateurs (conversions sur 30j) ===
        $since30 = Carbon::now()->copy()->subDays(30); // tu l'as déjà plus haut

        $orgId = Auth::user()->organization_id ?? null;
        $topCollaborators = \App\Models\User::query()
            ->when($orgId, fn($q) => $q->where('organization_id', $orgId))
            ->orderBy('name')
            ->get()
            // si tu n'as pas encore de métrique de conversion, on met 0 pour l'affichage
            ->map(function ($u) {
                $u->conversions = $u->conversions ?? 0;
                return $u;
            });

        // === Activités urgentes (en retard OU dans les 24 prochaines heures) ===
        $now = Carbon::now();
        $urgentUntil = $now->copy()->addHours(24);
        $urgentActivities = Activity::query()
            ->whereDate('date', '<', $now->toDateString())
            ->orWhere(function ($q) use ($now, $urgentUntil) {
                $q->whereBetween('date', [$now->toDateString(), $urgentUntil->toDateString()]);
            })
            ->orderBy('date')->orderBy('time')
            ->limit(8)
            ->get(['id', 'description', 'date', 'time']);

        // =========================
        // 9) Envoi à la vue
        // =========================
        return view('dashboard', compact(
            'totalClients',
            'totalSpaces',
            'totalLists',
            'totalActivities',
            'totalProspects',
            'totalCollaborators',

            // séries courbe
            'dates',
            'clientsData',
            'prospectsData',
            'clientsDaily',
            'prospectsDaily',
            'clientsCumData',
            'prospectsCumData',

            // KPI
            'conversionRate',
            'activeClients',
            'activeClientsPct',
            'clientsVariation',
            'prospectsVariation',
            'activitiesVariation',
            'clients30',
            'prospects30',
            'activities30',

            // (optionnel) funnel si tu l'as gardé
            // 'pipelineLabels',
            // 'pipelineValues',

            // ✅ nouveau camembert Sources d’acquisition
            'acqLabels',
            'acqValues',
            'todayActivities',
            'topCollaborators',
            'urgentActivities',
            'funnelNums'


        ));

    }
}
