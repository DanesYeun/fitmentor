<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\Profile;
use App\Models\Programschedule;

class RecommendPage extends Component
{
    public $showModal = false;
    public $showDeleteModal = false;
    public $schedule;
    public $page = '5';
    public $search;

    public function render()
    {
        $schedules = Schedule::where('status', 'Available')->paginate(3);
        $profile = Profile::where('user_id', auth()->user()->id)->first();
        $recommends = Schedule::where('status', 'Available')
        ->when($this->search, function ($query) {
            $terms = explode(' ', $this->search);
            $query->where(function ($subQuery) use ($terms) {
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
        })
        ->paginate($this->page);
       
        $exercises = Programschedule::get();
        $checks = Profile::where('user_id', auth()->user()->id)->count();
        $profiles = Profile::where('user_id', auth()->user()->id)->get();
        return view('livewire.recommend-page', compact('checks', 'profiles','recommends','schedules','exercises'));
    }
    
    public function refreshPage()
    {
        return redirect()->to(request()->header('Referer'));
    }

    public function viewProgram($scheduleID)
    {
        $this->schedule = Schedule::find($scheduleID);
        $this->showModal = true;
    }

    public function enroll($scheduleID)
    {
        $enroll = Schedule::find($scheduleID);
            if ($enroll) {
                $enroll->update([
                    'status' => 'Waiting for Approval',
                    'student_id' => auth()->user()->id,
                ]);
            }
        session()->flash('message', 'Enrolled Successfully.');
    }
}
