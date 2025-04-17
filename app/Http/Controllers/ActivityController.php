<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\User;

class ActivityController extends Controller
{
    public function index()
    {
        // Charger les participants et les prospects (avec leur liste)
        $activities = Activity::with(['participants', 'prospects.list'])->get();
        $users = User::all();

        return view('activity.index', compact('activities', 'users'));
    }


    public function store(Request $request)
{
    $validated = $request->validate([
        'date' => 'required|date',
        'time' => 'required',
        'description' => 'nullable|string',
        'participants.*' => 'exists:users,id',
        'prospect_id' => 'nullable|exists:prospects,id',
        'collaborator_id' => 'nullable|exists:users,id',
    ]);

    $activity = Activity::create([
        'date' => $validated['date'],
        'time' => $validated['time'],
        'description' => $validated['description'] ?? null,
        'collaborator_id' => $validated['collaborator_id'] ?? null,
    ]);

    // Participants explicitement définis + utilisateur connecté
    $participantIds = $validated['participants'] ?? [];
    $participantIds[] = Auth::id(); // Ajoute le créateur

    // Supprimer les doublons au cas où
    $participantIds = array_unique($participantIds);

    // Attacher tous les participants
    $activity->participants()->sync($participantIds);

    // Attacher le prospect
    if (!empty($validated['prospect_id'])) {
        $activity->prospects()->attach($validated['prospect_id']);
    }

    return redirect()->route('activities.index')->with('success', 'Activité planifiée avec succès.');
}





    public function edit($id)
    {
        // Récupérer une activité spécifique pour modification
        $activity = Activity::with('participants')->findOrFail($id);
        $users = User::all();

        return view('activity.edit', compact('activity', 'users'));
    }

    public function update(Request $request, $id)
    {
        // Valider les données
        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'description' => 'nullable|string',
            'participants' => 'nullable|array',
            'participants.*' => 'exists:users,id',
        ]);

        // Récupérer et mettre à jour l'activité
        $activity = Activity::findOrFail($id);
        $activity->update([
            'date' => $validated['date'],
            'time' => $validated['time'],
            'description' => $validated['description'] ?? null,
        ]);

        // Mettre à jour les participants
        $activity->participants()->sync($validated['participants'] ?? []);

        return redirect()->route('activities.index')->with('success', 'Rendez-vous mis à jour avec succès.');
    }

    public function destroy($id)
    {
        // Supprimer une activité
        $activity = Activity::findOrFail($id);
        $activity->delete();

        return redirect()->route('activities.index')->with('success', 'Rendez-vous supprimé avec succès.');
    }
}
