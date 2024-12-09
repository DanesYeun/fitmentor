<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Specialization;
use Livewire\WithPagination;


class Instructor extends Component
{

    use WithFileUploads;
    use WithPagination;



    public $name,$email,$password,$expertise,$password_confirmation,$role,$profile_picture;
    public $specialization_id;

    public function render()
    {
        $specializations = Specialization::all();
        return view('livewire.instructor', compact('specializations'));
    }

    public function resetpage()
    {
        $this->reset();
    }

    public function create()
    {
        $validatedData = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'profile_picture' => ['nullable', 'image', 'max:2048'],
        ]);
        
        $imagePath = null;
        if ($this->profile_picture) {
            $imagePath = $this->profile_picture->store('profile-photos', 'public');
        }

        $user = new User();
        $user->name = ucwords($validatedData['name']);
        $user->email = $validatedData['email'];
        $user->role = 'instructor'; 
        $user->password = Hash::make($validatedData['password']);
        $user->specialization_id = $this->specialization_id;
        if ($imagePath) {
            $user->profile_photo_path = $imagePath; 
        }
        $user->save();
        
        session()->flash('message', 'User created successfully.');

        return redirect()->route('instructor-manager');
    }

}
