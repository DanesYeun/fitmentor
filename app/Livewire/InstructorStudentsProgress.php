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
    public $selectedWeek = 1;
    public $week = 1;

    public function mount()
    {
        $this->classes = Schedule::where('user_id', auth()->user()->id)
                                ->where('status', 'Approved')
                                ->with(['sched_remarks', 'sched_remarks.attendance'])
                                ->get();
        foreach ($this->classes as $class) {

            $this->progressValues[$class->id] = $class->progressing;

            $sched_remarks = ScheduleRemarks::where('schedule_id', $class->id)->get();
    
            foreach ($sched_remarks as $schedule) {
                $this->remarks[$schedule->id] = $schedule->remarks;
            }
        }
    }

    public function updateProgress($classId)
    {
        $class = Schedule::find($classId);

        $scheduleRemarks = ScheduleRemarks::where('schedule_id', $classId)->get();

        if ($class && isset($this->progressValues[$classId])) {
            $daysWithSchedule = 0;
            $daysDone = 0;
        
            foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day) {
                $start = $class->{$day . '_start'};
                $end = $class->{$day . '_end'};
        
                if ($start && $end) {
                    $daysWithSchedule++; 

                    foreach($scheduleRemarks as $sched){
                        $remarkStart = $sched->{$day . '_start'};
                        $remarkEnd = $sched->{$day . '_end'};

                        if ($sched->attendance_id == 2 && $remarkStart && $remarkEnd) { 
                            $daysDone++; 
                        }
                    }
                    
                }
            }

            // calculate progress
            $totalProgress = ($daysWithSchedule > 0) 
                ? ($daysDone / ($daysWithSchedule * $class->numberofweek)) * 100 
                : 0;

            $class->progressing = $totalProgress; 
            $class->save();
        }
        
    }


    public function updateRemarks($scheduleId)
        {
            $scheduleRemark = ScheduleRemarks::find($scheduleId);
            $scheduleRemark->remarks = $this->remarks[$scheduleRemark->id] ?? ''; 
            $scheduleRemark->save();
        }

    public function markAsDone($classId, $schedRemarkID)
    {
        $scheduleRemarks = ScheduleRemarks::where('id', $schedRemarkID)
            ->update(['attendance_id' => 2]);

        $this->updateProgress($classId);
        $this->mount();
    }

    public function markAsCancelled($classId, $schedRemarkID)
    {
        $scheduleRemarks = ScheduleRemarks::where('id', $schedRemarkID)
            ->update(['attendance_id' => 1]);

        $this->updateProgress($classId);
        $this->mount();
    }

    public function markAsAbsent($classId, $schedRemarkID)
    {
        $scheduleRemarks = ScheduleRemarks::where('id', $schedRemarkID)
            ->update(['attendance_id' => 3]);

        $this->updateProgress($classId);
        $this->mount();
    }

    public function render()
    {
        return view('livewire.instructor-students-progress');
    }
}
