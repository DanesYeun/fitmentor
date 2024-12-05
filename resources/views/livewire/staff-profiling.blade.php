<div> 
    @if (session()->has('success'))
        <div class="p-4 bg-green-100 border border-green-200 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="staffProfiling" enctype="multipart/form-data" class="bg-gray-200 mt-5 mx-auto w-4/6 p-5 shadow-md rounded-lg">
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
            <div>
                <label for="specialization_id" class="block text-sm font-medium text-black">Expertise</label>
                <select wire:model="specialization_id" class="mt-1 w-full text-black rounded-lg bg-white-500 hover:border-black border-slate-300 inline-flex items-center justify-between" required>
                    <option class="inline-flex items-center justify-between" value="" selected>Select Expertise</option>
                    @foreach ($specializations as $specialization)
                        <option value="{{ $specialization->id }}">{{ $specialization->name }}</option>
                    @endforeach
                </select> 
            </div>
        </div>

        <div class="mt-6">
            <h2 class="text-lg font-semibold text-black">Programs</h2>
            <table class="min-w-full border-collapse border border-gray-200 mt-4">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-center text-sm font-medium text-black">Program</th>
                        <th class="border border-gray-300 px-4 py-2 text-center text-sm font-medium text-black">Goal</th>
                        <th class="border border-gray-300 px-4 py-2 text-center text-sm font-medium text-black">Level</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($programs as $program)
                        <tr class="bg-white">
                            <td class="border border-gray-300 px-4 py-2 text-sm text-black">{{ $program->program }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-black">{{ $program->goal }}</td>
                            <td class="border border-gray-300 px-4 py-2 text-sm text-black">{{ $program->level }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 flex justify-center">
            <x-button class="bg-gray-900 shadow-lg px-6 py-2">{{ $userId ? 'Update' : 'Submit' }}</x-button>
        </div>
    </form>
</div>
