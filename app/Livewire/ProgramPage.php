<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exercise;
use App\Models\User;
use App\Models\Program;
use App\Models\Programschedule;
use App\Models\Schedule;
use App\Models\FocusArea;
use Livewire\WithPagination;
use Illuminate\Http\Request;

class ProgramPage extends Component
{
    use WithPagination;

    public $selectedprogram, $focus, $level,$goal,$program, $selectedItems = [];
    public $sunday_start, $sunday_end, $monday_start, $monday_end, $tuesday_start, $tuesday_end, $wednesday_start, $wednesday_end, $thursday_start, $thursday_end, $friday_start, $friday_end, $saturday_start, $saturday_end;
    public $dropdownVisible = false;

    
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
        if (!auth()->check() || !in_array(auth()->user()->role, ['staff','instructor'])) {
            abort(403, 'Unauthorized');
        }
        $programs = Program::get();
        $exercises = Exercise::get();
        $focusAreas = FocusArea::get();

        return view('livewire.program-page', compact( 'exercises','programs', 'focusAreas'));
    }

    public function createschedule()
    {
        $counts = [
            'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'
        ];
        $nonNullDayCount = 0;
        foreach ($counts as $count) {
            if (!empty($this->{$count . '_start'}) || !empty($this->{$count . '_end'})) {
                $nonNullDayCount++;
            }
        }

    $validDay = false;
        $days = [
            ['start' => $this->sunday_start, 'end' => $this->sunday_end],
            ['start' => $this->monday_start, 'end' => $this->monday_end],
            ['start' => $this->tuesday_start, 'end' => $this->tuesday_end],
            ['start' => $this->wednesday_start, 'end' => $this->wednesday_end],
            ['start' => $this->thursday_start, 'end' => $this->thursday_end],
            ['start' => $this->friday_start, 'end' => $this->friday_end],
            ['start' => $this->saturday_start, 'end' => $this->saturday_end],
        ];
        foreach ($days as $day) {
            if (!is_null($day['start']) && !is_null($day['end'])) {
                $validDay = true;
                break;     
            }
        }
        if (!$validDay) {
            session()->flash('message1', 'Please set at least one start time and one end time for the same day!');
            return;
        }

        if ($validDay){
            // Create a new schedule
            $schedule = Schedule::create([
                'user_id' => auth()->user()->id,
                'program' => $this->program,
                'goal' => $this->goal,
                'level' => $this->level,
                'sunday_start' => $this->sunday_start ?? null,
                'sunday_end' => $this->sunday_end ?? null,
                'monday_start' => $this->monday_start ?? null,
                'monday_end' => $this->monday_end ?? null,
                'tuesday_start' => $this->tuesday_start ?? null,
                'tuesday_end' => $this->tuesday_end ?? null,
                'wednesday_start' => $this->wednesday_start ?? null,
                'wednesday_end' => $this->wednesday_end ?? null,
                'thursday_start' => $this->thursday_start ?? null,
                'thursday_end' => $this->thursday_end ?? null,
                'friday_start' => $this->friday_start ?? null,
                'friday_end' => $this->friday_end ?? null,
                'saturday_start' => $this->saturday_start ?? null,
                'saturday_end' => $this->saturday_end ?? null,
                'student_id' => null,
                'progress' => $nonNullDayCount,
                'status' => 'Available',
                'progressing' => 0,

            ]);


                // Attach selected programs to the schedule
                foreach ($this->selectedItems as $selectedItems) {

                    $focus_area = Exercise::where('id', $selectedItems)->pluck('focus_area');

                    Programschedule::create([
                        'exercise_id' => $selectedItems,
                        'schedule_id' => $schedule->id,
                        'focus_area_id' => $focus_area[0],
                    ]);
            }


            session()->flash('message', 'Program created successfully!');
            // Optionally reset the form
            $this->reset();

        }
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

    public function resetPage(){
        $this->reset();
    }
}
