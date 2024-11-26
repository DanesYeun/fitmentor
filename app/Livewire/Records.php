<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use App\Models\Schedule;
use App\Models\Programschedule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class Records extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search;
    public $user_id;
    public $page = '5';
    public $showModal = false;
    public $selectedSchedule;

    public function viewUser($scheduleId)
    {
        $this->selectedSchedule = Schedule::with(['user', 'student'])->find($scheduleId);
        $this->showModal = true;
    }
    public function refreshPage()
{
    return redirect()->to(request()->header('Referer'));
}

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin', 'staff'])) {
            abort(403, 'Unauthorized');
        }

            
            $schedules = Schedule::where('status', 'Approved')
                                    ->when($this->search, function ($query) {
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
            $exercises = Programschedule::get();
        return view('livewire.records', compact('schedules','exercises'));
    }
}
