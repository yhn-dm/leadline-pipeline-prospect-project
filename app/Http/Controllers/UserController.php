<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Http\Requests\ProfileUpdateRequest;

class UserController extends Controller
{
    /**
     * Afficher les utilisateurs et la gestion des rôles/permissions.
     */
    public function index(): View
    {
        $organization = auth()->user()->organization;
        $collaborators = $organization ? $organization->users : collect();
        $roles = Role::with('permissions')->get();
        $permissions = Permission::all();

        return view('organization.index', compact('organization', 'collaborators', 'roles', 'permissions'));
    }

    /**
     * Assigner un rôle unique à un utilisateur (remplace les anciens rôles).
     */
    public function assignRoleToUser(Request $request, $userId): RedirectResponse
    {
        $request->validate(['role_id' => 'required|exists:roles,id']);
    
        $user = User::findOrFail($userId);
    
        // 💡 Remplace l'attribution directe par sync()
        $user->roles()->sync([$request->role_id]);
    
        return redirect()->back()->with('success', 'Rôle attribué avec succès.');
    }
    

    /**
     * Supprimer un rôle d'un utilisateur.
     */
    public function removeRoleFromUser($userId, $roleId): RedirectResponse
    {
        $user = User::findOrFail($userId);
        $user->roles()->detach($roleId);

        return redirect()->back()->with('success', 'Rôle supprimé avec succès.');
    }

    /**
     * Assigner une permission à un rôle.
     */
    public function assignPermissionToRole(Request $request, $roleId): RedirectResponse
    {
        $request->validate([
            'permission_id' => 'required|exists:permissions,id',
        ]);

        $role = Role::findOrFail($roleId);

        if (!$role->permissions->contains($request->permission_id)) {
            $role->permissions()->attach($request->permission_id);
        }

        return redirect()->back()->with('success', 'Permission assignée avec succès.');
    }

    /**
     * Retirer une permission d'un rôle.
     */
    public function removePermissionFromRole($roleId, $permissionId): RedirectResponse
    {
        $role = Role::findOrFail($roleId);
        $role->permissions()->detach($permissionId);

        return redirect()->back()->with('success', 'Permission retirée avec succès.');
    }

    /**
     * Créer un nouveau rôle avec des permissions.
     */
    public function storeRole(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:roles,name|max:255',
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::create(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->back()->with('success', 'Rôle créé avec succès.');
    }

    /**
     * Mettre à jour un rôle et ses permissions.
     */
    public function updateRole(Request $request, $roleId): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:roles,name,' . $roleId,
            'permissions' => 'nullable|array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $role = Role::findOrFail($roleId);
        $role->update(['name' => $request->name]);

        if ($request->has('permissions')) {
            $role->permissions()->sync($request->permissions);
        }

        return redirect()->back()->with('success', 'Rôle mis à jour avec succès.');
    }

    /**
     * Supprimer un rôle (avec ses permissions liées).
     */
    public function deleteRole($roleId): RedirectResponse
    {
        $role = Role::findOrFail($roleId);
        $role->permissions()->detach();
        $role->delete();

        return redirect()->back()->with('success', 'Rôle supprimé avec succès.');
    }

    /**
     * Créer une nouvelle permission.
     */
    public function storePermission(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|unique:permissions,name|max:255',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->back()->with('success', 'Permission créée avec succès.');
    }

    /**
     * Supprimer une permission.
     */
    public function deletePermission($permissionId): RedirectResponse
    {
        $permission = Permission::findOrFail($permissionId);
        $permission->delete();

        return redirect()->back()->with('success', 'Permission supprimée avec succès.');
    }

    /**
     * Afficher le formulaire de modification du profil.
     */
    public function editProfile(Request $request): View
    {
        return view('profile.edit', ['user' => $request->user()]);
    }

    /**
     * Mettre à jour les informations du profil utilisateur.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->user()->id,
        ]);

        $request->user()->update($request->only(['name', 'email']));

        return redirect()->route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Supprimer un utilisateur.
     */
    public function destroyProfile(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->to('/');
    }

    public function checkPermission($userId, $permission)
    {
        $user = User::findOrFail($userId);

        if ($user->hasPermission($permission)) {
            return response()->json(['message' => 'Permission accordée']);
        }

        return response()->json(['message' => 'Accès refusé'], 403);
    }

    public function validateUser($userId)
    {
        $user = User::findOrFail($userId);

        // Assigner un rôle par défaut après validation
        $defaultRole = Role::where('name', 'Collaborateur')->first();
        if ($defaultRole) {
            $user->roles()->sync([$defaultRole->id]);
        }

        return redirect()->back()->with('success', 'L\'utilisateur a été validé avec succès.');
    }

}