<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Programschedule;
use App\Models\Schedule;
use App\Models\ScheduleRemarks;
use Livewire\WithPagination;

class Pending extends Component
{

    use WithPagination;

    public $name,$program,$preparation,$execution,$instructor,$goal;
    public $selectedprogram;
    public $selects = [];
    public $selectedItems = [];
    public $sunday_start,$monday_start,$tuesday_start,$wednesday_start,$thursday_start,$friday_start,$saturday_start,$sunday_end,$monday_end,$tuesday_end,$wednesday_end,$thursday_end,$friday_end,$saturday_end;
    public $dropdownVisible = false;
    public $selectedSchedule;
    public $showModal = false;
    public $schedule;
    public $page = '5';
    public $search;



    public function refreshPage()
    {
        return redirect()->to(request()->header('Referer'));
    }

    public function viewProgram($scheduleID)
    {
        $this->schedule = Schedule::with('focusAreas')->find($scheduleID);
        $this->showModal = true;
    }
 
    public function toggleDropdown()
    {
        $this->dropdownVisible = !$this->dropdownVisible;
    }
    public function closeDropdown()
    {
        $this->dropdownVisible = false;
    }
    public function render()
    {
        $exercises = Programschedule::get();
        $allscheds = Schedule::where('user_id', auth()->user()->id)->where('status', 'Waiting for Approval')->when($this->search, function ($query) {
                                        $terms = explode(' ', $this->search);
                                            return $query->where(function ($subQuery) use ($terms) {
                                                foreach ($terms as $term) {
                                                    $subQuery->orWhereHas('user', function ($q) use ($term) {
                                                        $q->where('name', 'like', '%' . $term . '%');
                                                    })
                                                    ->orWhereHas('student', function ($q) use ($term) {
                                                        $q->where('name', 'like', '%' . $term . '%');
                                                    })
                                                    ->orWhere('program', 'like', '%' . $term . '%');
                                            }
                                        });
            })->paginate($this->page);
        return view('livewire.pending', compact('exercises','allscheds'));
    }


    public function cancelEnroll($scheduleID)
    {
        $cancelEnroll = Schedule::find($scheduleID);
            if ($cancelEnroll) {
                $cancelEnroll->update([
                    'status' => 'Available',
                    'student_id' => Null,
                ]);
            }
        session()->flash('message', 'Enrollment cancelled.');
        $this->reset();
    }
    public function Enroll($scheduleID)
    {
        $cancelEnroll = Schedule::find($scheduleID);
        
        if ($cancelEnroll) {
            $cancelEnroll->update([
                'status' => 'Approved',
                'student_id' => $cancelEnroll->student->id,
            ]);

            $numberofweek = $cancelEnroll->numberofweek;
            for($i = 1; $i <= $numberofweek; $i++){
                foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day) {
                    $start = $cancelEnroll->{$day . '_start'};
                    $end = $cancelEnroll->{$day . '_end'};
            
                    if ($start && $end) {
                        ScheduleRemarks:: create([
                            'schedule_id' => $cancelEnroll->id,
                            'week' => $i,
                            "{$day}_start" => $start,
                            "{$day}_end" => $end,
                            'remarks' => null,
                            'attendance_id' => 1
                        ]);
                    }
                }
            }

        }

        
        session()->flash('message', 'Enrollment Approved.');
        $this->reset();
    }

    public function completeMon($progressId)
    {
    $progress = Schedule::find($progressId);
    if ($progress) { // Check if the record exists
        $progress->update([
            $progress->increment('progressing'),
            'm' => 1
        ]);
    }
    }
    
    public function resetPage(){
        $this->reset();
    }

}