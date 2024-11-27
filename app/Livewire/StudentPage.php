<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\Programschedule;
use App\Models\Exercise;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;
use Illuminate\Http\Request;


class StudentPage extends Component
{
    use WithPagination;

    public $name,$program,$preparation,$execution,$instructor,$goal;
    public $selectedprogram;
    public $selects = [];
    public $selectedItems = [];
    public $sunday_start,$monday_start,$tuesday_start,$wednesday_start,$thursday_start,$friday_start,$saturday_start,$sunday_end,$monday_end,$tuesday_end,$wednesday_end,$thursday_end,$friday_end,$saturday_end;
    public $dropdownVisible = false;
    public $showModal = false;
    public $selectedRecommend;
    public $confirmingEnrollment = false;
    public $selectedProgramId;

    public function render()
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $suggestions = null;
        if (!$profile) {
            $recommends = Schedule::where('status', 'Available')->paginate(6);
        } else {
            $recommends = Schedule::where('status', 'Available')
                ->where(function ($query) use ($profile) {
                    $query->where('goal', $profile->goal)
                          ->orWhere('level', $profile->level);
                })
                ->orWhere('user_id', function ($query) use ($profile) {
                    $query->select('id')
                          ->from('users')
                          ->where('expertise', $profile->area);
                })
                ->paginate(6);

            $suggestions = $recommends->filter(function ($recommend) use ($profile) {
                // Check if any of the focus areas match the profile's focus area criteria
                foreach ($recommend->program_schedule as $program_schedule) {
                    if ($program_schedule->focus_area->name == $profile->area) {
                        return true;
                    }
                }
                return false;
            });
        }
        // Nag baliktad ang suggestions ug recommendations HAHAH
        
        $exercises = Programschedule::get();
        return view('livewire.student-page', compact('recommends','exercises','profile', 'suggestions'));

    }
    public function viewRecommend($recommendId)
    {
        $this->selectedRecommend = Schedule::with(['user', 'student'])->find($recommendId);
        $this->showModal = true;
    }

    public function enrollConfirm($recommendId)
    {
    $this->selectedProgramId = $recommendId;
    $this->confirmingEnrollment = true;
    }


    public function enroll($recommendId)
    {
        $enroll = Schedule::find($recommendId);
            if ($enroll) {
                $enroll->update([
                    'status' => 'Waiting for Approval',
                    'student_id' => auth()->user()->id,
                ]);
            }
        session()->flash('success', 'You have successfully enrolled!');
        $this->confirmingEnrollment = false;
        $this->selectedProgramId = null;
        return $this->refreshPage();
    }
    
    public function refreshPage()
    {
    return redirect()->to(request()->header('Referer'));
    }
    
}
