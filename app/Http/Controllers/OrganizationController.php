<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\Invitation;

class OrganizationController extends Controller
{
    public function index()
    {
        $organization = auth()->user()->organization;

        if (!$organization) {
            return redirect()->route('dashboard')->with('error', 'Aucune organisation trouvée.');
        }

        // On récupère les collaborateurs de l'organisation avec leurs rôles
        $collaborators = User::where('organization_id', $organization->id)
            ->with('roles')
            ->orderBy('created_at', 'asc') // ✅ Trie les collaborateurs par date d'ajout
            ->get();

        // Récupération des rôles et permissions
        $roles = Role::all();
        $permissions = \App\Models\Permission::all();

        return view('organization.index', compact('organization', 'collaborators', 'roles', 'permissions'));
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'invitation' => 'nullable|string',
        ]);
    
        $organization_id = null;
    
        // Si une invitation est présente dans l’URL ou le form
        if ($request->filled('invitation')) {
            $invitation = Invitation::where('token', $request->invitation)->first();
    
            if ($invitation) {
                $organization_id = $invitation->organization_id;
    
                // Optionnel : supprimer le token après usage
                $invitation->delete();
            }
        }
    
        // Créer l’utilisateur avec l’organisation récupérée ou nulle
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $organization_id,
        ]);
    
        Auth::login($user);
    
        return redirect()->route('dashboard');
    }


    public function create()
    {
        // Retourne la vue pour créer une organisation
        return view('organizations.create');
    }

    public function store(Request $request)
    {
        // Valide les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        // Crée l'organisation
        Organization::create($validated);

        return redirect()->route('organizations.index')->with('success', 'Organisation créée avec succès.');
    }

    public function show($id)
    {
        // Récupère une organisation spécifique
        $organization = Organization::findOrFail($id);

        return view('organizations.show', compact('organization'));
    }

    public function edit($id)
    {
        // Récupère une organisation pour l'édition
        $organization = Organization::findOrFail($id);

        return view('organizations.edit', compact('organization'));
    }

    public function update(Request $request, $id)
    {
        // Valide les données
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:255',
        ]);

        // Met à jour l'organisation
        $organization = Organization::findOrFail($id);
        $organization->update($validated);

        return redirect()->route('organizations.index')->with('success', 'Organisation mise à jour avec succès.');
    }

    public function destroy($id)
    {
        // Supprime l'organisation
        $organization = Organization::findOrFail($id);
        $organization->delete();

        return redirect()->route('organizations.index')->with('success', 'Organisation supprimée avec succès.');
    }

    public function invite()
    {
        $organization = auth()->user()->organization;

        if (!$organization) {
            return redirect()->back()->with('error', 'Aucune organisation trouvée.');
        }

        // Générer un token unique pour l'invitation
        $token = Str::random(40);

        // Créer une invitation associée à l'organisation
        $invitation = Invitation::create([
            'organization_id' => $organization->id,
            'token' => $token,
        ]);

        // Générer le lien d'inscription
        $invitationLink = route('register', ['invitation' => $token]);

        // Ajouter le lien au message flash
        return redirect()->back()->with('success', "Lien d'invitation généré : <a href=\"$invitationLink\">$invitationLink</a>");
    }


}
