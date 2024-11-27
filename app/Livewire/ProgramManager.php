<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Programschedule;
use App\Models\Schedule;
use Livewire\WithPagination;
use Illuminate\Http\Request;

class ProgramManager extends Component
{

    use WithPagination;

    public $name,$program,$preparation,$execution,$instructor,$goal;
    public $selectedprogram;
    public $selects = [];
    public $selectedItems = [];
    public $sunday_start,$monday_start,$tuesday_start,$wednesday_start,$thursday_start,$friday_start,$saturday_start,$sunday_end,$monday_end,$tuesday_end,$wednesday_end,$thursday_end,$friday_end,$saturday_end;
    public $dropdownVisible = false;
    public $selectedSchedule;
    public $showModal = false;
    public $schedule;
    public $page = '5';
    public $search;



    public function refreshPage()
    {
        return redirect()->to(request()->header('Referer'));
    }

    public function viewProgram($scheduleID)
    {
        $this->schedule = Schedule::find($scheduleID);
        $this->showModal = true;
    }
 
    public function toggleDropdown()
    {
        $this->dropdownVisible = !$this->dropdownVisible;
    }
    public function closeDropdown()
    {
        $this->dropdownVisible = false;
    }
    public function render()
    {
        $exercises = Programschedule::get();
        $schedules = Schedule::where('user_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(3);
        $studentscheds = Schedule::where('student_id', auth()->user()->id)->orderBy('created_at', 'desc')->paginate(3);
        $allscheds = Schedule::when($this->search, function ($query) {
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
        return view('livewire.program-manager', compact('schedules', 'exercises','studentscheds', 'allscheds'));
    }

    public function create()
    {
        $this->validate([
        'name' => 'required|unique:programs',
        'preparation' => 'required|string',
        'execution' => 'required|string',
        ],[
            'name.unique' => 'Exercise is already created.',
        ]); // Ensure validation is done
    
            Exercise::create([
                'name' => ucwords($this->name),
                'preparation' => $this->preparation,
                'execution' => $this->execution,
            ]);
        
            // Flash a success message to the session
            session()->flash('message', 'Exercise created successfully!');

            // Reset the form fields
            $this->reset();
    }

    public function cancelEnroll($scheduleID)
    {
        $cancelEnroll = Schedule::find($scheduleID);
            if ($cancelEnroll) {
                $cancelEnroll->update([
                    'status' => Null,
                    'student_id' => Null,
                ]);
            }
        session()->flash('message', 'Enrollment cancelled.');
        $this->reset();
    }

    public function completeMon($progressId)
    {
    $progress = Schedule::find($progressId);
    if ($progress) { // Check if the record exists
        $progress->update([
            $progress->increment('progressing'),
            'm' => 1
        ]);
    }
    }
    public function completeTue($progressId)
    {
    $progress = Schedule::find($progressId);
    if ($progress) { // Check if the record exists
        $progress->update([
            $progress->increment('progressing'),
            't' => 1
        ]);
    }
    }
    public function completeWed($progressId)
    {
    $progress = Schedule::find($progressId);
    if ($progress) { // Check if the record exists
        $progress->update([
            $progress->increment('progressing'),
            'w' => 1
        ]);
    }
    }
    public function completeThu($progressId)
    {
    $progress = Schedule::find($progressId);
    if ($progress) { // Check if the record exists
        $progress->update([
            $progress->increment('progressing'),
            'th' => 1
        ]);
    }
    }
    public function completeFri($progressId)
    {
    $progress = Schedule::find($progressId);
    if ($progress) { // Check if the record exists
        $progress->update([
            $progress->increment('progressing'),
            'f' => 1
        ]);
    }
    }
    public function completeSat($progressId)
    {
    $progress = Schedule::find($progressId);
    if ($progress) { // Check if the record exists
        $progress->update([
            $progress->increment('progressing'),
            'sat' => 1
        ]);
    }
    }
    public function completeSun($progressId)
    {
    $progress = Schedule::find($progressId);
    if ($progress) { // Check if the record exists
        $progress->update([
            $progress->increment('progressing'),
            'sun' => 1
        ]);
    }
    }
    public function resetPage(){
        $this->reset();
    }

}