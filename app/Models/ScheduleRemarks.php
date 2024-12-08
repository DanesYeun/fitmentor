<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduleRemarks extends Model
{
    protected $table = 'schedule_remarks';

    public $timestamps = false;

    protected $fillable = [
        'schedule_id',
        'week',
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
        'remarks',
        'attendance_id'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

    public function attendance()
    {
        return $this->belongsTo(Attendance::class, 'attendance_id', 'id');
    }

}
