<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exercise extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'name',
        'preparation',
        'execution',
        'focus_area'
    ];

    public function schedules()
    {
        return $this->belongsToMany(Schedule::class, 'program_schedules');
    }

    public function program()
    {
        return $this->hasMany(Programschedule::class, 'exercise_id');
    }
    public function focusArea()
    {
        return $this->belongsTo(FocusArea::class, 'focus_area');
    }
}
