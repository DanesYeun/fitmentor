<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FocusArea;

class FocusAreaEdit extends Component
{
    public $focusArea;
    public $name;

    public function mount($id)
    {
        $this->focusArea = FocusArea::find($id);
        $this->name = $this->focusArea->name;
    }

    public function updateFocusArea()
    {
        $data = [
            'name' => ucwords($this->name),
        ];

        $this->focusArea->update($data);

        session()->flash('message', 'Focus Area updated successfully.');
    }
    

    public function render()
    {

        if (!auth()->check() || !in_array(auth()->user()->role, ['staff'])) {
            abort(403, 'Unauthorized');
        }
        
        return view('livewire.focus-area-edit');
    }
}
