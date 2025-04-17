<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Interaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'prospect_id',
        'user_id',
        'description',
        'interaction_date',
    ];

    public function prospect()
    {
        return $this->belongsTo(Prospect::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}