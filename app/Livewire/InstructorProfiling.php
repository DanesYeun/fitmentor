<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Storage;

class InstructorProfiling extends Component
{
    use WithFileUploads;

    public $userId;
    public $image;
    public $name;
    public $email;
    public $expertise;

    protected $rules = [
        'image' => 'nullable|image|max:1024',
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'expertise' => 'required|string|max:255',
    ];

    public function mount()
    {
        $user = Auth::user();

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->expertise = $user->expertise;

        $this->image = $user->profile_photo_path;
    }

    public function instructorProfiling()
    {

        $user = Auth::user();

        if ($user->profile_photo_path) {
            Storage::disk('public')->delete($user->profile_photo_path);
        }

        if ($this->image) {
            $imagePath = $this->image->store('profile_photos', 'public');
        } else {
            $imagePath = null; 
        }

        Auth::user()->update([
            'name' => $this->name,
            'email' => $this->email,
            'expertise' => $this->expertise,
            'profile_photo_path' => $imagePath,
        ]);

        // Flash success message
        session()->flash('success', 'Profile updated successfully!');

        // Optionally reset form fields
        $this->reset(['image', 'name', 'email', 'expertise']);
    }

    public function render()
    {
        return view('livewire.instructor-profiling');
    }
}
