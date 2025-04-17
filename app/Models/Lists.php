<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lists extends Model
{
    use HasFactory;

    protected $table = 'lists'; // Assurez-vous que la table correcte est utilisée
    protected $fillable = ['name', 'description', 'status', 'space_id'];

    // Relation avec l'espace
    public function space()
    {
        return $this->belongsTo(Space::class, 'space_id');
    }

    // Relation avec les prospects
    public function prospects()
    {
        return $this->hasMany(Prospect::class, 'list_id');
    }

    // Relation avec les utilisateurs (collaborateurs)
    public function users()
    {
        return $this->belongsToMany(User::class, 'list_user', 'list_id', 'user_id');
    }

    // Pour obtenir le nombre de prospects
    public function getProspectsCountAttribute()
    {
        return $this->prospects()->count();
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'list_user', 'list_id', 'user_id');
    }
}
