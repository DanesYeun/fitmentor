<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Program;

class ProgramMaker extends Component
{
    public $goal, $name;
    public function create()
    {
        $this->validate([
        'name' => 'required|unique:programs',
        'goal' => 'required|string',
        ],[
            'name.unique' => 'Exercise is already created.',
        ]); 
    
            Program::create([
                'name' => ucwords($this->name),
                'goal' => $this->goal,
            ]);
            $this->reset();
            session()->flash('message', 'Program created successfully!');      
    }

    public function resetPage(){
        $this->reset();
    }

    public function render()
    {
        return view('livewire.program-maker');
    }
}
