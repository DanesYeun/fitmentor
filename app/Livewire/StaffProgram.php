<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Program;

class StaffProgram extends Component
{
    public $program;
    public $search;
    public $page = '5';
    public $showDeleteModal = false;
    public $showModal = false;


    public function refreshPage()
    {
        return redirect()->to(request()->header('Referer'));
    }
    public function viewProgram($programId)
    {
        $this->program = Program::find($programId);
        $this->showModal = true;
    }

    public function confirmDelete($programId)
    {
        $this->program = $programId;
        $this->showDeleteModal = true; 
    }

    public function deleteprogram()
    {
        if ($this->program) {
            Program::find($this->program)->delete();
            $this->showDeleteModal = false;
            $this->program= null;

            session()->flash('message', 'Program deleted successfully!');    
    
        }
    }

    public function render()
    {
        $programs = Program::when($this->search, function ($query) {
        $terms = explode(' ', $this->search);

        return $query->where(function ($subQuery) use ($terms) {
            $subQuery->where(function ($nestedQuery) use ($terms) {
                foreach ($terms as $term) {
                    $nestedQuery->orWhere(function ($innerQuery) use ($term) {
                        $innerQuery->where('name', 'like', '%' . $term . '%')
                                   ->orWhere('goal', 'like', '%' . $term . '%');
                    });
                }
            });
        });
    })
    ->paginate($this->page);
        return view('livewire.staff-program', compact('programs'));
    }
}
