<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Schedule;
use App\Models\Exercise;
use App\Models\Program;
use App\Models\FocusArea;
use App\Models\Programschedule;
use Livewire\WithPagination;
use Illuminate\Http\Request;

class ScheduleEdit extends Component
{
    use WithPagination;

    public $scheduleId, $selectedprogram, $focus, $level, $goal, $program, $selectedItems = [];
    public $sunday_start, $sunday_end, $monday_start, $monday_end, $tuesday_start, $tuesday_end, $wednesday_start, $wednesday_end, $thursday_start, $thursday_end, $friday_start, $friday_end, $saturday_start, $saturday_end;
    public $dropdownVisible = false;

    // Initialize the schedule data
    public function mount($scheduleId)
    {
        $this->scheduleId = $scheduleId;
        $this->loadSchedule();
    }

    public function toggleDropdown()
    {
        $this->dropdownVisible = !$this->dropdownVisible;
    }

    public function closeDropdown()
    {
        $this->dropdownVisible = false;
    }

    public function loadSchedule()
    {
        // Load the schedule from the database
        $schedule = Schedule::findOrFail($this->scheduleId);
        $this->program = $schedule->program;
        $this->goal = $schedule->goal;
        $this->level = $schedule->level;
        $this->sunday_start = $schedule->sunday_start;
        $this->sunday_end = $schedule->sunday_end;
        $this->monday_start = $schedule->monday_start;
        $this->monday_end = $schedule->monday_end;
        $this->tuesday_start = $schedule->tuesday_start;
        $this->tuesday_end = $schedule->tuesday_end;
        $this->wednesday_start = $schedule->wednesday_start;
        $this->wednesday_end = $schedule->wednesday_end;
        $this->thursday_start = $schedule->thursday_start;
        $this->thursday_end = $schedule->thursday_end;
        $this->friday_start = $schedule->friday_start;
        $this->friday_end = $schedule->friday_end;
        $this->saturday_start = $schedule->saturday_start;
        $this->saturday_end = $schedule->saturday_end;
        
        // Load the selected exercises for the schedule
        $programSchedules = Programschedule::where('schedule_id', $this->scheduleId)->get();
        $this->selectedItems = $programSchedules->pluck('exercise_id')->toArray();
        $this->focus = $programSchedules->first()->focus_area_id;
    }

    public function updateSchedule()
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

        if ($validDay) {
            // Update the schedule
            $schedule = Schedule::findOrFail($this->scheduleId);
            $schedule->update([
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
                'progress' => $nonNullDayCount,
                'status' => 'Available',
                'progressing' => 0,
            ]);

            // Remove old exercises and attach selected ones
            Programschedule::where('schedule_id', $this->scheduleId)->delete();

            foreach ($this->selectedItems as $selectedItem) {
                Programschedule::create([
                    'exercise_id' => $selectedItem,
                    'schedule_id' => $schedule->id,
                    'focus_area_id' => $this->focus,
                ]);
            }

            session()->flash('message', 'Schedule updated successfully!');
            $this->reset();
        }
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
        $programs = Program::get();
        $exercises = Exercise::get();
        $focusAreas = FocusArea::get();

        return view('livewire.schedule-edit', compact('exercises', 'programs', 'focusAreas'));
    }
}
