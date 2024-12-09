<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\User;
use App\Models\Specialization;

class InstructorEdit extends Component
{
    use WithFileUploads;

    public $user;
    public $name, $email, $role,$profile_photo,$expertise;
    public $specialization_id;

    public function mount($user)
    {
        $this->user = User::find($user);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
        $this->expertise = $this->user->expertise;
        $this->specialization_id = $this->user->specialization_id;
        $this->role = $this->user->role;
    }

    public function updateUser()
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'specialization_id' => $this->specialization_id,
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

        $specializations = Specialization::all();
        return view('livewire.instructor-edit', compact('specializations'));
    }
}
