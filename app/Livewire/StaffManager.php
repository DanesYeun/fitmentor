<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Validator;

class StaffManager extends Component
{
    use WithFileUploads;
    use WithPagination;

    public $search;
    public $user_id;
    public $user;
    public $page = '5';
    public $showDeleteModal = false;
    public $showModal = false;


    public function refreshPage()
    {
        return redirect()->to(request()->header('Referer'));
    }
    public function viewStaff($userId)
    {
        $this->user = User::find($userId);
        $this->showModal = true;
    }

    public function confirmDelete($userId)
    {
        $this->user_id = $userId;
        $this->showDeleteModal = true; 
    }

    public function deleteUser()
    {
        if ($this->user_id) {
            User::find($this->user_id)->delete();
            $this->showDeleteModal = false;
            $this->user_id = null;
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function render()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['admin'])) {
            abort(403, 'Unauthorized');
        }

            
        $users = User::where('role', 'staff')
        ->when($this->search, function ($query) {
        $terms = explode(' ', $this->search);

        return $query->where(function ($subQuery) use ($terms) {
            $subQuery->where(function ($nestedQuery) use ($terms) {
                foreach ($terms as $term) {
                    $nestedQuery->orWhere(function ($innerQuery) use ($term) {
                        $innerQuery->where('name', 'like', '%' . $term . '%')
                                   ->orWhere('email', 'like', '%' . $term . '%')
                                   ->orWhere('role', 'like', '%' . $term . '%');
                    });
                }
            });
        });
    })
    ->paginate($this->page);

        return view('livewire.staff-manager', compact('users'));
    }
}
