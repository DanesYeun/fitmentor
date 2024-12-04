<?php

namespace App\Livewire;
use Illuminate\Support\Facades\Auth;
use Livewire\WithFileUploads;
use Livewire\Component;
use Illuminate\Support\Facades\Storage;
use App\Models\Schedule;

class StaffProfiling extends Component
{

    use WithFileUploads;

    public $userId;
    public $image;
    public $name;
    public $email;
    public $expertise;
    public $programs =  [];

    protected $rules = [
        'image' => 'nullable|image|max:1024', // Optional image, max 1MB
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
    ];

    public function mount()
    {
        $user = Auth::user();
        $this->programs = Schedule::where('user_id', $user->id)->get();        

        $this->userId = $user->id;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->expertise = $user->expertise;

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
            'expertise' => $this->expertise
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
