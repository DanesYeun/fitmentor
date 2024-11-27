<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;

class AdminPage extends Component
{
    public function render()
    {
        $instructors = User::where('role', 'instructor') -> count();
        $trainees = User::where('role', 'student')->count();
        $staffs = User::where('role', 'staff') ->count();
        return view('livewire.admin-page', compact ('instructors','trainees','staffs'));
    }
}
