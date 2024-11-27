<div> 
    @if (session()->has('success'))
        <div class="p-4 bg-green-100 border border-green-200 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="staffProfiling" enctype="multipart/form-data" class="bg-sky-300 mt-5 mx-auto w-4/6 p-5 shadow-md rounded-lg">
        @csrf
        <span class="text-black text-lg font-bold block mb-4">User Information</span>
        
        <!-- Image Section -->
        <div class="flex flex-col items-center mb-6">
            @if ($image)
                <div class="mb-4">
                    <img src="{{ asset('storage/' . $image) }}" alt="Profile Image" class="w-32 h-32 object-cover rounded-full border">
                </div>  
            @endif
            <input wire:model="image" type="file" class="block mt-1 w-full text-black text-sm">
        </div>
        
        <!-- User Info Section -->
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label for="name" class="block text-sm font-medium text-black">Name</label>
                <x-input wire:model="name" class="block mt-1 w-full text-black" type="text" required autofocus/>
            </div>
            <div>
                <label for="email" class="block text-sm font-medium text-black">Email</label>
                <x-input wire:model="email" class="block mt-1 w-full text-black" type="email" required/>
            </div>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 flex justify-center">
            <x-button class="bg-blue-900 shadow-lg px-6 py-2">{{ $userId ? 'Update' : 'Submit' }}</x-button>
        </div>
    </form>
</div>
