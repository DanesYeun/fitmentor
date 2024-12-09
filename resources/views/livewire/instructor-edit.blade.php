<div>
    <div class="text-black mt-5 ml-20">
        <a href="javascript:history.back()"><i class="fa-solid fa-rotate-left">Back</i></a>
    </div>

<div class="w-full max-w-4xl mx-auto p-5 mt-10">
    @if (session()->has('message'))
        <div class="bg-green-500 text-white p-3 mb-4">
            {{ session('message') }}
        </div>
    @endif
    <div class="w-3/4 mx-auto bg-gray-300 rounded-lg p-3 shadow-lg text-black">
    <form wire:submit.prevent="updateUser">
        <div class="mb-4">
            <label for="profile_photo" class="block text-sm font-medium">Profile Photo</label>
            @if ($this->user->profile_photo)
                <div class="mb-2">
                    <img src="{{ asset('storage/' . $this->user->profile_photo) }}" alt="Profile Photo" class="w-32 h-32 object-cover rounded-full">
                </div>
            @endif
            <input type="file" id="profile_photo" wire:model="profile_photo" class="w-full p-2 border rounded-md" />
            @error('profile_photo') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        <div class="mb-4">
            <label for="name" class="block text-sm font-medium">Name</label>
            <input type="text" id="name" wire:model="name" class="w-full p-2 border rounded-md" />
            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" id="email" wire:model="email" class="w-full p-2 border rounded-md" />
            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mb-4">
            <label for="expertise" class="block text-sm font-medium">Expertise</label>
            {{-- <input type="text" id="expertise" wire:model="expertise" class="w-full p-2 border rounded-md" /> --}}
            <select wire:model="specialization_id" class="mt-1 w-full text-black rounded-lg bg-white-500 hover:border-black border-slate-300 inline-flex items-center justify-between" required>
                <option class="inline-flex items-center justify-between" value="" selected>Select Expertise</option>
                @foreach ($specializations as $specialization)
                    <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                @endforeach
            </select>
            @error('expertise') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>
        
        <div class="mb-4">
            <label for="role" class="block text-sm font-mediumm">Role</label>
            <input type="text" wire:model="role" class="w-full p-2 border rounded-md bg-gray-400" disabled>
            @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
        </div>

        <div class="mx-auto w-1/3">
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md">Update User</button>
        </div>
    </form>
    </div>
</div>
</div>
