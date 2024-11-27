<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FocusArea extends Model
{
    use HasFactory;

    public $timestamps = true; 
    protected $table = 'focus_areas';
    protected $fillable = [
        'name'
    ];

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'program_schedules');
    }

    public function program()
    {
        return $this->hasMany(Programschedule::class, 'focus_area_id');
    }

}
