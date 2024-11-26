<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Programschedule extends Model
{
    use HasFactory;

    protected $table = 'program_schedules';

    protected $fillable = [
        'schedule_id',
        'exercise_id',
    ];



    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }
    public function exercise()
    {
        return $this->belongsTo(Exercise::class, 'exercise_id');
    }
}

