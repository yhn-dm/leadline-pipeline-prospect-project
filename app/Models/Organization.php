<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    use HasFactory;

    /**
     * Les attributs qui peuvent être assignés en masse.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'phone'];

    /**
     * Relation avec les utilisateurs (si applicable).
     * Exemple : Une organisation peut avoir plusieurs utilisateurs.
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }


    /**
     * Relation avec d'autres entités (exemple : projets ou clients).
     * Vous pouvez ajouter d'autres relations si nécessaire.
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    public function collaborators()
    {
        return $this->hasMany(User::class, 'organization_id'); // Relation avec le modèle User
    }

    public function spaces()
    {
        return $this->hasMany(Space::class);
    }
}
