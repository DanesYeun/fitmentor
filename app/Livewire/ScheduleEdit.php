<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\Exercise;
use App\Models\Program;
use App\Models\FocusArea;
use App\Models\Programschedule;
use Livewire\WithPagination;

class ScheduleEdit extends Component
{
    use WithPagination;

    public $schedule;
    public $scheduleId, $selectedprogram, $student, $focus, $level, $goal, $instructor, $program, $exercises = [];
    public $sunday_start, $sunday_end, $monday_start, $monday_end, $tuesday_start, $tuesday_end, $wednesday_start, $wednesday_end;
    public $thursday_start, $thursday_end, $friday_start, $friday_end, $saturday_start, $saturday_end;
    public $dropdownVisible = false;

    public function mount($id)
    {
        $this->scheduleId = $id;
        $this->schedule = Schedule::with(['student', 'focusAreas'])->find($id);
        $this->exercises = Programschedule::with(['exercise'])->where('schedule_id', $id)->get();
        
        $this->program = $this->schedule->program;
        $this->goal = $this->schedule->goal; 
        $this->focus = $this->schedule->focusAreas->isNotEmpty() ? $this->schedule->focusAreas[0]->name : 'No focus area';
        $this->instructor = auth()->user()->name;
        $this->student = !is_null($this->schedule->student) ? $this->schedule->student->name : null;

        $this->level = $this->schedule->level;
        $this->sunday_start = $this->schedule->sunday_start;
        $this->sunday_end = $this->schedule->sunday_end;
        $this->monday_start = $this->schedule->monday_start;
        $this->monday_end = $this->schedule->monday_end;
        $this->tuesday_start = $this->schedule->tuesday_start;
        $this->tuesday_end = $this->schedule->tuesday_end;
        $this->wednesday_start = $this->schedule->wednesday_start;
        $this->wednesday_end = $this->schedule->wednesday_end;
        $this->thursday_start = $this->schedule->thursday_start;
        $this->thursday_end = $this->schedule->thursday_end;
        $this->friday_start = $this->schedule->friday_start;
        $this->friday_end = $this->schedule->friday_end;
        $this->saturday_start = $this->schedule->saturday_start;
        $this->saturday_end = $this->schedule->saturday_end;

        
    }

    public function toggleDropdown()
    {
        $this->dropdownVisible = !$this->dropdownVisible;
    }

    public function closeDropdown()
    {
        $this->dropdownVisible = false;
    }


    public function updateSchedule()
    {

        $nonNullDayCount = 0;
        $days = [
            'sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'
        ];

        foreach ($days as $day) {
            if (!empty($this->{$day . '_start'}) || !empty($this->{$day . '_end'})) {
                $nonNullDayCount++;
            }
        }

        // check at least one start and end time pair is set
        $validDay = false;
        foreach ($days as $day) {
            if (!is_null($this->{$day . '_start'}) && !is_null($this->{$day . '_end'})) {
                $validDay = true;
                break;
            }
        }

        if (!$validDay) {
            session()->flash('message', 'Please set at least one start time and one end time for the same day!');
            return;
        }

        $schedule = Schedule::findOrFail($this->scheduleId);

        $schedule->update([
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
            'saturday_end' => $this->saturday_end ?? null
        ]);

        session()->flash('success', 'Schedule updated successfully!');
    }

    public function resetPage()
    {
        $this->reset();
    }

    public function render()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['staff', 'instructor'])) {
            abort(403, 'Unauthorized');
        }

        $programs = Program::all();
        $exercises = Exercise::all();
        $focusAreas = FocusArea::all();

        return view('livewire.schedule-edit', compact('exercises', 'programs', 'focusAreas'));
    }
}
