<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'email', 'phone', 'description'];
    public function activities()
    {
        return $this->belongsToMany(\App\Models\Activity::class, 'activity_client', 'client_id', 'activity_id');
    }

    public function convertedBy()
    {
        return $this->belongsTo(User::class, 'converted_by_user_id');
    }

}

