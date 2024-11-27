<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FocusArea;

class FocusAreaPage extends Component
{

    public $focusArea;
    public $search;
    public $page = '5';
    public $showDeleteModal = false;

    public function confirmDelete($focusID)
    {
        $this->focusArea = $focusID;
        $this->showDeleteModal = true; 
    }

    public function deleteFocus()
    {
        if ($this->focusArea) {
            FocusArea::find($this->focusArea)->delete();
            $this->showDeleteModal = false;
            $this->focusArea= null;
        }

        session()->flash('message', 'Excercise deleted successfully!');  

    }

    public function render()
    {
        // $focusAreas = FocusArea::all();
        // dd(json_decode($focusAreas));
        $focusAreas = FocusArea::when($this->search, function ($query) {
            $terms = explode(' ', $this->search);
    
            return $query->where(function ($subQuery) use ($terms) {
                $subQuery->where(function ($nestedQuery) use ($terms) {
                    foreach ($terms as $term) {
                        $nestedQuery->orWhere(function ($innerQuery) use ($term) {
                            $innerQuery->where('name', 'like', '%' . $term . '%');
                        });
                    }
                });
            });
        })
        
        ->paginate($this->page);
        // dd($focusAreas->items());
        // Debug $focusArea before returning the view
        if ($focusAreas->isEmpty()) {
            dd('No data found'); // To check if there's truly no data
        }

        return view('livewire.focus-area-page', compact('focusAreas'));
    }
}
