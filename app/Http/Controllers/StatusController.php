<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use App\Models\Status;

class StatusController extends Controller
{
    public function index($spaceId)
    {
        $space = Space::findOrFail($spaceId);

        // Récupérer les statuts liés à cet espace
        $statuses = $space->statuses;

        return view('statuses.index', compact('statuses', 'space'));
    }

    public function create(Space $space)
    {
        return view('statuses.create', compact('space'));
    }

    public function store(Request $request, Space $space)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7', // Optionnel, pour la couleur
        ]);

        $space->statuses()->create($validated);

        return redirect()->route('statuses.index', $space->id)->with('success', 'Statut créé avec succès.');
    }

    public function edit(Space $space, Status $status)
    {
        return view('statuses.edit', compact('space', 'status'));
    }

    public function update(Request $request, Space $space, Status $status)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'color' => 'nullable|string|max:7',
        ]);

        $status->update($validated);

        return redirect()->route('statuses.index', $space->id)->with('success', 'Statut mis à jour avec succès.');
    }

    public function destroy(Space $space, Status $status)
    {
        $status->delete();
        return redirect()->route('statuses.index', $space->id)->with('success', 'Statut supprimé avec succès.');
    }
}
