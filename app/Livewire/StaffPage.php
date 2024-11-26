<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\User;

class StaffPage extends Component
{
    public function render()
    {
        $programs = Schedule::count();
        $enrollees = Schedule::where('status', 'Approved')->count();
        return view('livewire.staff-page', compact('programs','enrollees'));
    }
}
