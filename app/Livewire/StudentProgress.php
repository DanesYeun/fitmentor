<?php

namespace App\Livewire;

use App\Models\Profile;
use App\Models\Programschedule;
use App\Models\Schedule;
use App\Models\User;
use Livewire\Component;

class StudentProgress extends Component
{
    public $showModal = false;
    public $selectedClass;
    
    public function render()
    {
        $profile = User::where('id', auth()->user()->id)->first();

        if (!is_null($profile)) {
           
            $classes = Schedule::where('student_id', $profile->id)
                                ->where('status', 'Approved')
                                ->with(['sched_remarks', 'sched_remarks.attendance'])
                                ->get();

        } else {
            $classes = collect(); // Empty collection if no profile is found
        }

        return view('livewire.student-progress', compact('classes'));
    }

    public function viewClass($classId)
    {
        $this->selectedClass = Schedule::with(['user', 'student'])->find($classId);
        $this->showModal = true;
    }
    public function refreshPage()
    {
        return redirect()->to(request()->header('Referer'));
    }
}
