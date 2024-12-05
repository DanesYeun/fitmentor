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
        'day',
        'remarks'
    ];

    public function schedule()
    {
        return $this->belongsTo(Schedule::class, 'schedule_id');
    }

}
