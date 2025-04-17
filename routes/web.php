<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Http\Controllers\{
    ProfileController,
    SpaceController,
    ProspectController,
    ListController,
    OrganizationController,
    ClientController,
    Auth\RegisteredUserController,
    StatusController,
    UserController,
    ActivityController,
    DashboardController
};
use App\Models\Invitation;

Route::get('/', function () {
    return view('auth.landing');
})->name('landing');

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::post('/logout', function () {
    Auth::logout();
    return redirect('/login');
})->name('logout');

// Authentification
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// Profil
Route::prefix('profile')->middleware('auth')->name('profile.')->group(function () {
    Route::get('/', [ProfileController::class, 'edit'])->name('edit');
    Route::patch('/', [ProfileController::class, 'update'])->name('update');
    Route::delete('/', [ProfileController::class, 'destroy'])->name('destroy');
});

require __DIR__ . '/auth.php';

// Organisation & gestion
Route::resource('organizations', OrganizationController::class)->middleware('auth');
Route::post('/organizations/invite', function () {
    $organization = auth()->user()->organization;
    if (!$organization) {
        return redirect()->back()->with('error', 'Aucune organisation trouvée.');
    }

    $token = Str::random(40);
    $invitation = Invitation::create([
        'organization_id' => $organization->id,
        'token' => $token,
    ]);

    $invitationLink = route('register', ['invitation' => $token]);
    return redirect()->back()->with('success', 'Lien d’invitation généré : ' . $invitationLink);
})->middleware('auth')->name('organizations.invite');

// Gestion des utilisateurs et rôles dans une organisation
Route::prefix('organization')->group(function () {
    Route::get('/', [UserController::class, 'index'])
        ->middleware('permission:manage users')
        ->name('organization.index');

    Route::post('/organization/users/{user}/assign-role', [UserController::class, 'assignRoleToUser'])
        ->middleware('auth')
        ->name('organization.users.assign-role');


    Route::post('/roles/{role}/assign-permission', [UserController::class, 'assignPermissionToRole'])
        ->middleware('permission:assign roles')
        ->name('organization.roles.assign-permission');

    Route::post('/roles', [UserController::class, 'storeRole'])
        ->middleware('permission:assign roles')
        ->name('organization.roles.store');

    Route::post('/permissions', [UserController::class, 'storePermission'])
        ->middleware('permission:assign roles')
        ->name('organization.permissions.store');

    Route::post('/roles_permissions/createOrUpdate', [UserController::class, 'createOrUpdateRole'])
        ->middleware('permission:assign roles')
        ->name('roles_permissions.createOrUpdate');
});

// Utilisateurs (hors organisation mais liés à des actions globales)
Route::get('/users', [UserController::class, 'index'])
    ->middleware('permission:manage users');

Route::post('/users/{user}/assign-role', [UserController::class, 'assignRole'])
    ->middleware('permission:assign roles');

Route::post('/users/{user}/validate', [UserController::class, 'validateUser'])
    ->middleware('permission:validate users');

Route::prefix('lists')->name('lists.')->group(function () {
    Route::get('/{space}', [ListController::class, 'index'])->name('index');
    Route::get('/{list}/prospects', [ProspectController::class, 'index'])->name('prospects.index');

    Route::post('/{space}', [ListController::class, 'store'])->name('store');
    Route::get('/{space}/{list}', [ListController::class, 'show'])->name('show');
    Route::put('/{space}/{list}', [ListController::class, 'update'])->name('update');
    Route::delete('/{space}/{list}', [ListController::class, 'destroy'])->name('destroy');
});

Route::prefix('lists/{list}/prospects')->name('lists.prospects.')->group(function () {
    Route::get('/', [ProspectController::class, 'index'])->name('index');
    Route::get('/create', [ProspectController::class, 'create'])->name('create');
    Route::post('/', [ProspectController::class, 'store'])->name('store');
    Route::get('/{prospect}', [ProspectController::class, 'show'])->name('show');
    Route::get('/{prospect}/edit', [ProspectController::class, 'edit'])->name('edit');
    Route::put('/{prospect}', [ProspectController::class, 'update'])->name('update');
    Route::delete('/{prospect}', [ProspectController::class, 'destroy'])->name('destroy');
    Route::post('/{prospect}/convert', [ProspectController::class, 'convertToClient'])->name('convert');
});

Route::put('/lists/{list}/prospects/{prospect}', [ProspectController::class, 'update'])->name('lists.prospects.update');
Route::get('/lists/{list}/prospects/{prospect}/edit', [ProspectController::class, 'edit'])->name('lists.prospects.edit');
Route::post('/lists/{list}/prospects/{prospect}/convert', [ProspectController::class, 'convertToClient'])->name('lists.prospects.convert');
Route::post('/prospects/{prospect}/convert-to-client', [ProspectController::class, 'convertToClient'])->name('prospects.convertToClient');
Route::post('/lists/{list}/store-collaborator', [ListController::class, 'storeCollaboratorList'])->name(
    'lists.storeCollaboratorList'
);


Route::prefix('spaces')->name('spaces.')->group(function () {
    Route::post('/{space}/assign-collaborator', [SpaceController::class, 'storeCollaboratorSpace'])->name('storeCollaboratorSpace');


    Route::get('/', [SpaceController::class, 'index'])->name('index');
    Route::get('/create', [SpaceController::class, 'create'])->name('create');
    Route::post('/', [SpaceController::class, 'store'])->name('store');
    Route::get('/{space}', [SpaceController::class, 'show'])->name('show');
    Route::get('/{space}/edit', [SpaceController::class, 'edit'])->name('edit');
    Route::put('/{space}', [SpaceController::class, 'update'])->name('update');
    Route::delete('/{space}', [SpaceController::class, 'destroy'])->name('destroy');

    // Statuses dans un espace
    Route::prefix('{space}/statuses')->name('statuses.')->group(function () {
        Route::get('/', [StatusController::class, 'index'])->name('index');
        Route::get('/create', [StatusController::class, 'create'])->name('create');
        Route::post('/', [StatusController::class, 'store'])->name('store');
        Route::get('/{status}/edit', [StatusController::class, 'edit'])->name('edit');
        Route::put('/{status}', [StatusController::class, 'update'])->name('update');
        Route::delete('/{status}', [StatusController::class, 'destroy'])->name('destroy');
    });
});


// Clients
Route::resource('clients', ClientController::class)->middleware('auth');
Route::delete('/clients/{client}', [ClientController::class, 'destroy'])->name('clients.destroy');
Route::get('/clients/{client}/edit', [ClientController::class, 'edit'])->name('clients.edit');

// Prospects

//Route::resource('activities', ActivityController::class)->middleware('auth');
Route::post('/activities', [ActivityController::class, 'store'])->name('activities.store');
Route::put('/activities/{id}', [ActivityController::class, 'update'])->name('activities.update');

