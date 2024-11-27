<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exercise;

class ExerciseEdit extends Component
{
    public $exercise;
    public $name, $preparation, $execution;
    


    public function mount($exercise)
    {
        $this->exercise = Exercise::find($exercise);
        $this->name = $this->exercise->name;
        $this->preparation = $this->exercise->preparation;
        $this->execution = $this->exercise->execution;
    }

    public function updateExercise()
    {
        $data = [
            'name' => ucwords($this->name),
            'preparation' => $this->preparation,
            'execution' => $this->execution,
        ];

        $this->exercise->update($data);

        session()->flash('message', 'Exercise updated successfully.');
    }

    public function render()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['staff'])) {
            abort(403, 'Unauthorized');
        }
        return view('livewire.exercise-edit');
    }
}
