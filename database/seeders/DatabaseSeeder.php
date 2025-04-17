<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {        // User::factory(10)->create();
// Création des rôles
        $adminRole = Role::create(['name' => 'Admin', 'description' => 'Administrateur complet']);
        $managerRole = Role::create(['name' => 'Manager', 'description' => 'Gestionnaire des listes']);
        $collaboratorRole = Role::create(['name' => 'Collaborateur', 'description' => 'Gère ses listes']);
        $pendingValidationRole = Role::create(['name' => 'En attente', 'description' => 'Doit être validé par un Admin']);

        // création des permissions
        $manageUsers = Permission::create(['name' => 'manage users', 'description' => 'Gérer les utilisateurs']);
        $assignRoles = Permission::create(['name' => 'assign roles', 'description' => 'Attribuer des rôles']);
        $validateUsers = Permission::create(['name' => 'validate users', 'description' => 'Valider les nouveaux utilisateurs']);
        $manageSpaces = Permission::create(['name' => 'manage spaces', 'description' => 'Gérer les espaces']);
        $createLists = Permission::create(['name' => 'create lists', 'description' => 'Créer des listes']);
        $assignLists = Permission::create(['name' => 'assign lists', 'description' => 'Attribuer des listes']);
        $manageAssignedLists = Permission::create(['name' => 'manage assigned lists', 'description' => 'Gérer ses listes assignées']);

        // Attribution des permissions aux rôles
        $adminRole->permissions()->attach([$manageUsers->id, $assignRoles->id, $validateUsers->id, $manageSpaces->id]);
        $managerRole->permissions()->attach([$createLists->id, $assignLists->id, $manageAssignedLists->id]);
        $collaboratorRole->permissions()->attach($manageAssignedLists->id);

        // assigner le rôle "Admin" au premier utilisateur
        $admin = User::first();
        if ($admin) {
            $admin->roles()->attach($adminRole->id);
        }
    }
}
