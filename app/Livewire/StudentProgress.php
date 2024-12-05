<?php

namespace App\Livewire;

use App\Models\Profile;
use App\Models\Programschedule;
use App\Models\Schedule;
use Livewire\Component;

class StudentProgress extends Component
{
    public $showModal = false;
    public $selectedClass;
    public function render()
    {
        $profile = Profile::where('user_id', auth()->user()->id)->first();

        if(!is_null($profile))
        {
            $classes = Schedule::all()->where('student_id', $profile->user_id);
        } else{
            $classes = null;
        }
        

        $exercises = Programschedule::get();
        return view('livewire.student-progress', compact('classes', 'exercises'));
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
