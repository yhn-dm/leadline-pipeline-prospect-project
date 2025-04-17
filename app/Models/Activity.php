<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = ['date', 'time', 'description'];

    public function prospects()
    {
        return $this->belongsToMany(Prospect::class, 'activity_prospect', 'activity_id', 'prospect_id');
    }
    public function participants()
    {
        return $this->belongsToMany(User::class, 'activity_user', 'activity_id', 'user_id');
    }
}
