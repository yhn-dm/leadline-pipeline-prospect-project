<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Space;
use App\Models\Lists;
use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;

class SpaceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = auth()->user();

        if ($user->hasRole('Admin') || $user->hasRole('Manager')) {
            $spaces = Space::withCount(['collaborators', 'lists']);
        } else {
            // 🔐 Collaborateur : accès seulement à ses espaces
            $spaces = $user->spaces()->withCount(['collaborators', 'lists']);
        }

        // 🔍 Filtrage actif / archivé
        if ($request->has('filter') && $request->filter !== 'all') {
            if ($request->filter === 'active') {
                $spaces = $spaces->having('lists_count', '>', 0);
            } elseif ($request->filter === 'archived') {
                $spaces = $spaces->having('lists_count', '=', 0);
            }
        }

        $spaces = $spaces->orderBy('created_at', 'desc')->get();

        return view('spaces.index', compact('spaces'));
    }


    public function create()
    {
        return view('spaces.create'); // Affiche une vue vide pour créer un nouvel espace
    }


    public function show($id)
    {
        $space = Space::with(['collaborators', 'lists'])->findOrFail($id);
        $users = User::all();
        $spaces = Space::all(); // Ajoute cette ligne pour avoir la liste complète des espaces
        $lists = $space->lists; // Récupérer toutes les listes liées à cet espace


        return view('lists.index', compact('space', 'users', 'spaces'));
    }


    public function store(Request $request)
    {
        $user = auth()->user();
        if (!$user->hasRole('Admin') && !$user->hasRole('Manager')) {
            abort(403, 'Vous n’avez pas la permission de créer un espace.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,archived',
        ]);

        $space = Space::create([
            'name' => $validated['name'],
            'description' => $validated['description'],
            'status' => $validated['status'],
        ]);

        $space->collaborators()->attach(auth()->id());

        return redirect()->route('spaces.index')->with('success', 'Espace créé avec succès.');
    }



    public function assignCollaboratorSpace($spaceId)
    {
        $space = Space::findOrFail($spaceId);
        $users = User::all()->except($space->collaborators->pluck('id')); // Exclure les collaborateurs déjà assignés
        return view('spaces.assign-collaborator', compact('space', 'users'));
    }

    public function storeCollaboratorSpace(Request $request, $spaceId)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $space = Space::findOrFail($spaceId);
        $space->collaborators()->attach($validated['user_id']);

        return redirect()->route('lists.index', $spaceId)->with('success', 'Collaborateur affilié avec succès.');
    }

    public function destroy(Space $space)
    {
        $space->delete();

        if (request()->expectsJson()) {
            return response()->json(['message' => 'Espace supprimé avec succès.']);
        }

        return redirect()->route('spaces.index')->with('success', 'Espace supprimé avec succès.');
    }



    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:active,archived',
        ]);

        $space = Space::findOrFail($id);
        $space->update($validated);

        return redirect()->route('spaces.index')->with('success', 'Espace mis à jour avec succès.');
    }

    public function edit($id)
    {
        $space = Space::findOrFail($id);
        return response()->json($space);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'space_user', 'space_id', 'user_id');
    }

    public function lists()
    {
        return $this->hasMany(Lists::class, 'space_id');
    }
}
