<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\ScheduleRemarks;

class InstructorStudentsProgress extends Component
{
    public $classes; 
    public $progressValues = []; 
    public $remarks = [];

    public function mount()
    {
        $this->classes = Schedule::where('user_id', auth()->user()->id)
                                 ->where('status', 'Approved')
                                 ->with('remarks')
                                 ->get();


        foreach ($this->classes as $class) {
            $this->progressValues[$class->id] = $class->progressing;

            foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day) {
                $this->remarks[$class->id][$day] = $class->remarks->where('day', $day)->first()->remarks ?? '';
            }
        }
    }

    public function updateProgress($classId)
    {
        $class = Schedule::find($classId);

        if ($class && isset($this->progressValues[$classId])) {
            $daysWithSchedule = 0;
            $daysDone = 0;
        
            // check each day and count days with schedules and "Done" status
            foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day) {
                $start = $class->{$day . '_start'};
                $end = $class->{$day . '_end'};
        
                if ($start && $end) {
                    $daysWithSchedule++; 
        
                    if ($class->{$day} == 1) { 
                        $daysDone++; 
                    }
                }
            }
        
            // calculate progress
            $totalProgress = ($daysWithSchedule > 0) 
                ? ($daysDone / $daysWithSchedule) * 100 
                : 0;
        
            $class->progressing = $totalProgress; 
            $class->save();
        }
        
    }


    public function updateRemarks($classId, $day)
    {

        $class = Schedule::find($classId);

        if ($class && isset($this->remarks[$classId][$day])) {
            $remark = ScheduleRemarks::where('schedule_id', $classId)
                                    ->where('day', $day)
                                    ->first();

            if ($remark) {
                $remark->remarks = $this->remarks[$classId][$day];
                $remark->save();
            } else {
                ScheduleRemarks::create([
                    'schedule_id' => $classId,
                    'day' => $day,
                    'remarks' => $this->remarks[$classId][$day]
                ]);
            }
        }
    }

    public function markAsDone($classId, $day)
    {
        Schedule::where('id', $classId)
            ->update([$day => 1]);

        $this->updateProgress($classId);
        $this->mount();
    }

    public function markAsCancelled($classId, $day)
    {
        Schedule::where('id', $classId)
            ->update([$day => 0]);

        $this->updateProgress($classId);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.instructor-students-progress');
    }
}
