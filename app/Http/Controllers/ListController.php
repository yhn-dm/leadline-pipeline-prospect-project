<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use App\Models\Lists;
use App\Models\User;
use App\Models\Organization;
use App\Models\Collaborator;
use Illuminate\Support\Facades\Auth;

class ListController extends Controller
{
    public function index($spaceId)
    {
        $user = auth()->user();

        // Admins/Managers ont accès à tout
        if ($user->hasRole('Admin') || $user->hasRole('Manager')) {
            $space = Space::with(['lists.prospects', 'lists.collaborators'])->findOrFail($spaceId);
        } else {
            // Sinon, on vérifie l'appartenance du user à cet espace
            $space = $user->spaces()->with(['lists.prospects', 'lists.collaborators'])->findOrFail($spaceId);
        }

        $users = User::all();

        return view('lists.index', compact('space', 'users'));
    }



    public function create($id)
    {
        $space = auth()->user()->spaces()->findOrFail($id);

        return view('lists.create', compact('space'));
    }

    public function store(Request $request, $spaceId)
    {
        $user = auth()->user();
        if (!$user->hasRole('Admin') && !$user->hasRole('Manager')) {
            abort(403, 'Vous n’avez pas la permission de créer une liste.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,archived'
        ]);

        $space = Space::find($spaceId);

        if (!$space) {
            return redirect()->back()->with('error', 'L\'espace sélectionné n\'existe pas.');
        }

        $list = Lists::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
            'space_id' => $space->id,
        ]);

        return redirect()->route('lists.index', ['space' => $space->id])
            ->with('success', 'Liste créée avec succès.');
    }



    public function assignCollaboratorList($listId)
    {
        $list = Lists::findOrFail($listId);

        // Récupère les collaborateurs de l'organisation de l'utilisateur connecté
        $users = Collaborator::where('organization_id', auth()->user()->organization_id)->get();

        return view('lists.assign-collaboratorList', compact('list', 'users'));
    }


    public function storeCollaboratorList(Request $request, $listId)
    {
             // Validation sur la table `users` et non `collaborators`
    $validated = $request->validate([
        'user_id' => 'required|exists:users,id',
    ]);

    // Récupère la liste
    $list = Lists::findOrFail($listId);

    // Vérifie que l'utilisateur appartient à la même organisation
    $user = User::where('id', $validated['user_id'])
        ->where('organization_id', auth()->user()->organization_id)
        ->first();

    if (!$user) {
        return redirect()->back()->with('error', 'Le collaborateur ne fait pas partie de votre organisation.');
    }

    try {
        // Ajoute l'utilisateur à la liste sans créer de doublon
        $list->users()->syncWithoutDetaching([$user->id]);
    } catch (\Exception $e) {
        return redirect()->back()->with('error', 'Une erreur est survenue : ' . $e->getMessage());
    }

    return redirect()->route('lists.index', ['space' => $list->space_id, 'list' => $list->id])
        ->with('success', 'Collaborateur ajouté avec succès.');
    }



    public function show($spaceId, $listId)
    {
        $list = Lists::with('prospects')->findOrFail($listId);
        $users = User::all();
        return view('lists.show', compact('list', 'users'));
    }


    public function update(Request $request, $spaceId, $listId)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,archived'
        ]);

        $list = Lists::findOrFail($listId);

        $list->update([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status']
        ]);

        // Si AJAX, on retourne JSON
        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Liste mise à jour avec succès.']);
        }

        // Sinon, redirection normale
        return redirect()->route('lists.index', $spaceId)
            ->with('success', 'Liste mise à jour avec succès.');
    }


    public function edit($id)
    {
        $list = Lists::findOrFail($id);

        return view('lists.edit', compact('list'));
    }

    public function destroy($spaceId, $listId)
    {
        $list = Lists::findOrFail($listId);
        $list->delete();

        return redirect()->route('lists.index', $spaceId)
            ->with('success', 'Liste supprimée avec succès.');
    }
}