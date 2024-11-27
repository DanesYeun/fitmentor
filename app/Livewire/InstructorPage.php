<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;

class InstructorPage extends Component
{
    public function render()
    {
        $totals = Schedule::where('user_id', auth()->user()->id)->count();
        $availables = Schedule::where('status', 'Available')->where('user_id', auth()->user()->id)->count();
        $approves = Schedule::where('status', 'Approved')->where('user_id', auth()->user()->id)->count();
        $pendings = Schedule::where('status', 'Waiting for Approval')->where('user_id', auth()->user()->id)->count();
        return view('livewire.instructor-page', compact('availables','approves','pendings','totals'));
    }
}
