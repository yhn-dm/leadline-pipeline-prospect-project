<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Lists;
use App\Models\Organization;


class Space extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'status'];

    
    /*public function users()
    {
        return $this->belongsToMany(User::class, 'space_user', 'space_id', 'user_id');
    } */

    public function lists()
    {
        return $this->hasMany(Lists::class, 'space_id');
    }
    public function statuses()
    {
        return $this->hasMany(Status::class);
    }


    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function collaborators()
{
    return $this->belongsToMany(User::class, 'space_user', 'space_id', 'user_id')
                ->withPivot('id', 'created_at', 'updated_at');
}



}


