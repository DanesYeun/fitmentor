<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;

class InstructorStudentsProgress extends Component
{
    public $classes; 
    public $progressValues = []; 

    public function mount()
    {
        $this->classes = Schedule::where('user_id', auth()->user()->id)
                                 ->where('status', 'Approved')
                                 ->get();

        foreach ($this->classes as $class) {
            $this->progressValues[$class->id] = $class->progressing;
        }
    }

    public function updateProgress($classId)
    {
        $class = Schedule::find($classId);

        if ($class && isset($this->progressValues[$classId])) {
            $class->progressing = $this->progressValues[$classId];
            $class->save();
        }
    }

    public function render()
    {
        return view('livewire.instructor-students-progress');
    }
}
