<?php

namespace App\Livewire;

use App\Models\Profile;
use App\Models\Schedule;
use Livewire\Component;

class StudentProgress extends Component
{
    public function render()
    {
        $profile = Profile::where('user_id', auth()->user()->id)->first();

        if(!is_null($profile))
        {
            $classes = Schedule::all()->where('student_id', $profile->user_id);
        } else{
            $classes = null;
        }
        

        // dd($classes);
        return view('livewire.student-progress', compact('classes'));
    }
}
