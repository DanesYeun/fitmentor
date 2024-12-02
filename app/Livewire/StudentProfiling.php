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
    public $goal = [];
    public $area = [];
    public $level;
    public $name;
    public $profileId;


    protected $rules = [
        'cell' => 'required|string',
        'emergency' => 'required|string',
        'age' => 'required|integer|min:1',
        'gender' => 'required|string',
        'address' => 'required|string',
        'height' => 'required|numeric',
        'weight' => 'required|numeric',
        'goal' => 'required|array',
        'goal.*' => 'string',
        'level' => 'required|string',
        'area' => 'required|array',
        'area.*' => 'string',
        'name' => 'required|string'
    ];   
    public function refreshPage()
    {
    return redirect()->to(request()->header('Referer'));
    }


    public function mount()
    {
        $user = auth()->user();
        $profile = Profile::where('user_id', auth()->user()->id)->first();

        if ($profile) {
            $this->profileId = $profile->id;
            $this->cell = $profile->cell;
            $this->emergency = $profile->emergency;
            $this->age = $profile->age;
            $this->gender = $profile->gender;
            $this->address = $profile->address;
            $this->height = $profile->height;
            $this->weight = $profile->weight;
            $this->level = $profile->level;
            $this->name = $profile->name;

            
            // Convert comma-separated strings to arrays
            $this->goal = $profile->goal ? explode(',', $profile->goal) : [];
            $this->area = $profile->area ? explode(',', $profile->area) : []; 

        } else {
            $this->name = $user->name;
        }
    }

    public function profiling()
    {
        $validatedData = $this->validate();
        $validatedData['user_id'] = auth()->user()->id;

        // Convert arrays to comma-separated strings
        $validatedData['goal'] = implode(',', $this->goal); 
        $validatedData['area'] = implode(',', $this->area);

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

        $focus_areas = FocusArea::all();
        return view('livewire.student-profiling', compact('user', 'profile', 'focus_areas'));
    }

}
