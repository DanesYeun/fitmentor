<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Schedule extends Model
{
    use HasFactory;
    
    protected $table = 'schedules';

    protected $fillable = [
        'user_id',
        'program',
        'goal',
        'level',
        'sunday_start',
        'monday_start',
        'tuesday_start',
        'wednesday_start',
        'thursday_start',
        'friday_start',
        'saturday_start',
        'sunday_end',
        'monday_end',
        'tuesday_end',
        'wednesday_end',
        'thursday_end',
        'friday_end',
        'saturday_end',
        'status',
        'student_id',
        'progress',
        'progressing',
        'm',
        't',
        'w',
        'th',
        'f',
        'sat',
        'sun'
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    
    public function programs()
    {
        return $this->belongsToMany(Program::class, 'program_schedules');
    }

    public function focusAreas()
    {
        return $this->hasManyThrough(
            FocusArea::class,        
            Programschedule::class, 
            'schedule_id',            // Foreign key on program_schedules
            'id',                     // Foreign key on focus_areas
            'id',                     // Local key on schedules
            'focus_area_id'           // Local key on program_schedules
        );
    }

    public function program_schedule()
    {
        return $this->hasMany(Programschedule::class, 'schedule_id');
    }
}
