<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Exercise;

class ExercisePage extends Component
{
    public $exercise;
    public $search;
    public $page = '5';
    public $showDeleteModal = false;
    public $showModal = false;


    public function refreshPage()
    {
        return redirect()->to(request()->header('Referer'));
    }
    public function viewProgram($exerciseId)
    {
        $this->exercise = Exercise::find($exerciseId);
        $this->showModal = true;
    }

    public function confirmDelete($exerciseId)
    {
        $this->exercise = $exerciseId;
        $this->showDeleteModal = true; 
    }

    public function deleteExercise()
    {
        if ($this->exercise) {
            Exercise::find($this->exercise)->delete();
            $this->showDeleteModal = false;
            $this->exercise= null;
        }

        session()->flash('message', 'Excercise deleted successfully!');  

    }

    public function render()
    {
        $exercises = Exercise::when($this->search, function ($query) {
        $terms = explode(' ', $this->search);

        return $query->where(function ($subQuery) use ($terms) {
            $subQuery->where(function ($nestedQuery) use ($terms) {
                foreach ($terms as $term) {
                    $nestedQuery->orWhere(function ($innerQuery) use ($term) {
                        $innerQuery->where('name', 'like', '%' . $term . '%')
                                   ->orWhere('preparation', 'like', '%' . $term . '%')
                                   ->orWhere('execution', 'like', '%' . $term . '%');
                    });
                }
            });
        });
    })
    ->paginate($this->page);
        return view('livewire.exercise-page', compact('exercises'));
    }
}
