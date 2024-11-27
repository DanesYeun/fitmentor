<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FocusArea;

class FocusAreaPage extends Component
{

    public $focusAreas;
    public $search;
    public $page = '5';
    public $showDeleteModal = false;

    public function render()
    {
        $focusAreas = FocusArea::when($this->search, function ($query) {
            $terms = explode(' ', $this->search);
    
            return $query->where(function ($subQuery) use ($terms) {
                foreach ($terms as $term) {
                    $subQuery->orWhere('name', 'like', '%' . $term . '%');
                }
            });
        })
        ->paginate($this->page);
        // dd($focusAreas->toArray());
        // Debug $focusArea before returning the view
        if ($focusAreas->isEmpty()) {
            dd('No data found'); // To check if there's truly no data
        }

        return view('livewire.focus-area-page', compact('focusAreas'));
    }
}
