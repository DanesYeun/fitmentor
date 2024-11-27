<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;

class StaffProfiling extends Component
{

    use WithFileUploads;

    public $userId;
    public $image;
    public $name;
    public $email;

    protected $rules = [
        'image' => 'nullable|image|max:1024', // Optional image, max 1MB
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ];

    public function mount()
    {
        $user = Auth::user();

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;

        $this->image = $user->profile_photo_path;
    }

    public function staffProfiling()
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
            'profile_photo_path' => $imagePath,
        ]);

        // Flash success message
        session()->flash('success', 'Profile updated successfully!');

        // Optionally reset form fields
        $this->reset(['image', 'name', 'email']);
    }

    public function render()
    {
        return view('livewire.staff-profiling');
    }
}
