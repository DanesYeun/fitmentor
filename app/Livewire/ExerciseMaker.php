<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exercise;
use App\Models\FocusArea;

class ExerciseMaker extends Component
{
    public $name, $preparation, $execution, $focus_area;
    
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
                'focus_area' => $this->focus_area
            ]);
            
            session()->flash('message', 'Exercise created successfully!');  
            $this->reset();    
    }

    public function render()
    {
        $focusAreas = FocusArea::all();
        // dd(json_decode($focusAreas));

        return view('livewire.exercise-maker', compact('focusAreas'));
    }
}
