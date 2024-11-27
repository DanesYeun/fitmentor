<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exercise;

class ExerciseMaker extends Component
{
    public $name, $preparation, $execution;
    
    public function create()
    {
        $this->validate([
        'name' => 'required|unique:programs',
        'preparation' => 'required|string',
        'execution' => 'required|string',
        ],[
            'name.unique' => 'Exercise is already created.',
        ]); 
    
            Exercise::create([
                'name' => ucwords($this->name),
                'preparation' => $this->preparation,
                'execution' => $this->execution,
            ]);
            
            session()->flash('message', 'Exercise created successfully!');  
            $this->reset();    
    }

    public function render()
    {
        return view('livewire.exercise-maker');
    }
}
