<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'organization_id', // Ajout du champ
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted()
    {
        static::created(function ($user) {
            if ($user->organization_id) {
                Collaborator::create([
                    'name' => $user->name,
                    'email' => $user->email,
                    'phone' => null, // Ajouter le champ approprié si nécessaire
                    'organization_id' => $user->organization_id,
                ]);
            }
        });
    }


    public function lists()
    {
        return $this->belongsToMany(Lists::class, 'list_user', 'user_id', 'list_id');
    }

    // Relation avec les espaces
    public function spaces()
    {
        return $this->belongsToMany(Space::class, 'space_user', 'user_id', 'space_id');
    }
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class, 'role_user', 'user_id', 'role_id');
    }



    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function collaborators()
    {
        return $this->hasMany(Collaborator::class, 'organization_id', 'organization_id');
    }

    public function hasPermission($permission)
{
    foreach ($this->roles as $role) {
        if ($role->permissions->contains('name', $permission)) {
            return true;
        }
    }
    return false;
}


    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

}
