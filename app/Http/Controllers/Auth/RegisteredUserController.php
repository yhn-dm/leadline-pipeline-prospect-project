<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Organization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\Events\Registered;
use App\Models\Invitation;
use App\Models\Role;
use App\Models\Collaborator;

class RegisteredUserController extends Controller
{
    /**
     * Affiche le formulaire d'inscription.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        $organizationId = null;
        $isCreator = false; // On initialise à false

        // Vérifier si c'est une inscription via invitation
        if ($request->filled('invitation')) {
            $invitation = Invitation::where('token', $request->input('invitation'))->first();
            if ($invitation) {
                $organizationId = $invitation->organization_id;
                $invitation->delete(); // Supprimer l'invitation après utilisation
            } else {
                return redirect()->back()->withErrors(['invitation' => 'Le token d\'invitation est invalide ou expiré.']);
            }
        } else {
            // Si l'utilisateur n'a pas d'invitation, il crée une organisation
            $organization = Organization::create([
                'name' => $validated['name'] . "'s Organization",
                'email' => $validated['email'],
                'phone' => null,
            ]);
            $organizationId = $organization->id;
            $isCreator = true;
        }

        // Création de l'utilisateur
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'organization_id' => $organizationId,
        ]);

        // 🔍 Vérification des rôles existants
        $adminRole = Role::where('name', 'Admin')->first();
        $pendingRole = Role::where('name', 'En attente')->first();

        if (!$adminRole) {
            $adminRole = Role::create(['name' => 'Admin', 'description' => 'Administrateur complet']);
        }
        if (!$pendingRole) {
            $pendingRole = Role::create(['name' => 'En attente', 'description' => 'En attente de validation']);
        }

        // 🏆 Attribution du bon rôle
        if ($isCreator) {
            $user->roles()->attach($adminRole->id); // Admin si créateur
        } else {
            $user->roles()->attach($pendingRole->id); // En attente sinon
        }

        // Création d'un collaborateur
        Collaborator::create([
            'name' => $user->name,
            'email' => $user->email,
            'phone' => null,
            'organization_id' => $organizationId,
        ]);

        // 🔥 Connexion automatique après inscription
        Auth::login($user);

        return redirect()->route('organizations.index')->with('success', 'Inscription réussie.');
    }


    public function create(Request $request)
    {
        // Récupérer l'ID de l'organisation depuis le token d'invitation ou l'URL
        $invitationToken = $request->get('invitation');
        $organizationId = null;

        if ($invitationToken) {
            $invitation = Invitation::where('token', $invitationToken)->first();
            if ($invitation) {
                $organizationId = $invitation->organization_id;
            }
        }

        return view('auth.register', compact('organizationId', 'invitationToken'));
    }



}
