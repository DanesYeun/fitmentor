<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;
    protected $fillable = [
        'cell',
        'emergency',
        'age', 
        'gender',
        'address',
        'height', 
        'weight', 
        'goal',
        'level',
        'user_id',
        'area',
        'name'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
