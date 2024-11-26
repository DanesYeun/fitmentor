<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;

class StaffEdit extends Component
{
    use WithFileUploads;

    public $user;
    public $name, $email, $role,$profile_photo;

    public function mount($user)
    {
        $this->user = User::find($user);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->role = ucwords($this->user->role);
    }

    public function updateUser()
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
        ];

        if ($this->profile_photo) {
            $photoPath = $this->profile_photo->store('profile-photos', 'public');
            $data['profile_photo_path'] = $photoPath;
        }

        $this->user->update($data);

        session()->flash('message', 'User updated successfully.');
    }

    public function render()
    {
        if (!auth()->check() || !in_array(auth()->user()->role, ['staff','admin'])) {
            abort(403, 'Unauthorized');
        }
        return view('livewire.staff-edit');
    }
}
