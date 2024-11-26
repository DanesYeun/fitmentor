<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Program;

class ProgramEdit extends Component
{
    public $program;
    public $name, $goal;
    


    public function mount($program)
    {
        $this->program = Program::find($program);
        $this->name = $this->program->name;
        $this->goal = $this->program->goal;
    }

    public function updateProgram()
    {
        $data = [
            'name' => ucwords($this->name),
            'goal' => $this->goal,
        ];

        $this->program->update($data);

        session()->flash('message', 'Program updated successfully.');
    }

    public function render()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['staff'])) {
            abort(403, 'Unauthorized');
        }
        return view('livewire.program-edit');
    }
}
