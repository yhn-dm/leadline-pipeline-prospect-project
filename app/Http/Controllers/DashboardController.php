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

class DashboardController extends Controller
{
    public function index()
    {
        // Comptes globaux
        $totalClients = Client::count();
        $totalSpaces = Space::count();
        $totalLists = Lists::count();
        $totalActivities = Activity::count();
        $totalProspects = Prospect::count();
        $totalCollaborators = User::count(); 


        // evolution des clients par mois 
        $clientsByMonth = Client::selectRaw('MONTH(created_at) as month, COUNT(id) as total')
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('total', 'month');

        // Répartition Collaborateurs / Clients / Prospects
        $totalUsers = User::count();
        $totalProspects = \DB::table('prospects')->count();
        $repartition = [
            'Collaborateurs' => $totalUsers,
            'Clients' => $totalClients,
            'Prospects' => $totalProspects,
        ];

        // génère les 30 derniers jours au format 'YYYY-MM-DD'
        $dates = collect(range(0, 29))->map(function ($day) {
            return Carbon::now()->subDays($day)->format('Y-m-d');
        })->reverse(); 

        // Compter les clients et prospects créés chaque jour
        $clientsData = $dates->mapWithKeys(function ($date) {
            return [$date => Client::whereDate('created_at', $date)->count()];
        });

        $prospectsData = $dates->mapWithKeys(function ($date) {
            return [$date => Prospect::whereDate('created_at', $date)->count()];
        });

        // Envoi à la vue
        return view('dashboard', compact(
            'totalClients',
            'totalSpaces',
            'totalLists',
            'totalActivities',
            'clientsByMonth',
            'repartition',
            'totalProspects',
            'totalCollaborators',
            'dates', 
            'clientsData', 
            'prospectsData' 
        ));



    }
}
