<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FocusArea;

class FocusAreaMaker extends Component
{

    public $name;

    public function create()
    {
        $this->validate([
        'name' => 'required|unique:programs',
        ],[
            'name.unique' => 'Exercise is already created.',
        ]); 
    
        FocusArea::create([
            'name' => ucwords($this->name)
        ]);
        
        session()->flash('message', 'Focus Area created successfully!');  
        $this->reset();    
    }

    public function resetPage(){
        $this->reset();
    }

    public function render()
    {
        return view('livewire.focus-area-maker');
    }
}
