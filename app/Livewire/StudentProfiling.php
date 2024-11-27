<?php

namespace App\Livewire;

use App\Models\FocusArea;
use Livewire\Component;
use App\Models\Profile;
use App\Models\Schedule;
use App\Models\ProgramSchedule;
use Illuminate\Support\Facades\Auth;
use Livewire\WithPagination;

class StudentProfiling extends Component
{
    use WithPagination;

    public $cell;
    public $emergency;
    public $age;
    public $gender;
    public $address;
    public $height;
    public $weight;
    public $goal;
    public $area;
    public $level;
    public $name;
    public $profileId;
    public $page = '5';
    public $showModal = false;
    public $selectedRecommend;
    public $confirmingEnrollment = false;
    public $selectedProgramId;

    protected $rules = [
        'cell' => 'required|string',
        'emergency' => 'required|string',
        'age' => 'required|integer|min:1',
        'gender' => 'required|string',
        'address' => 'required|string',
        'height' => 'required|numeric',
        'weight' => 'required|numeric',
        'goal' => 'required|string',
        'level' => 'required|string',
        'area' => 'required|string',
        'name' => 'required|string'
    ];

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
    }
    
    public function refreshPage()
    {
    return redirect()->to(request()->header('Referer'));
    }


    public function mount()
    {
        $profile = Profile::where('user_id', auth()->user()->id)->first();

        if ($profile) {
            $this->profileId = $profile->id;
            $this->cell = $profile->cell;
            $this->emergency = $profile->emergency;
            $this->age = $profile->age;
            $this->area= $profile->area;
            $this->gender = $profile->gender;
            $this->address = $profile->address;
            $this->height = $profile->height;
            $this->weight = $profile->weight;
            $this->goal = $profile->goal;
            $this->level = $profile->level;
            $this->name = $profile->name;
        }
    }

    public function profiling()
    {
        $validatedData = $this->validate();
        $validatedData['user_id'] = auth()->user()->id;

        if ($this->profileId) {
            Profile::where('id', $this->profileId)->update($validatedData);
            session()->flash('success', 'Profile updated successfully.');
        } else {
            Profile::create($validatedData);
            session()->flash('success', 'Profile created successfully.');
        }

        $this->resetExcept(['profileId']);
        
        return redirect()->route('dashboard');
    }

    public function render()
    {   
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        
        if (!$profile) {
            $recommends = Schedule::where('status', 'Available')->paginate(6);
        } else {
            $recommends = Schedule::where('status', 'Available')
                ->where('goal', $profile->goal)  // Ensures the goal matches
                ->where(function ($query) use ($profile) {
                    $query->where('level', $profile->level);
                })
                ->paginate(6);
        }

        $exercises = Programschedule::get();
        $focus_areas = FocusArea::all();
        return view('livewire.student-profiling', compact('recommends','exercises','profile', 'focus_areas'));
    }

}
