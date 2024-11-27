<div>
    @if (session()->has('success'))
        <div class="p-4 bg-green-100 border border-green-200 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center">
            {{ session('success') }}
        </div>
    @endif
    <div>
    <div x-data="{ open: false }" class="w-full p-5">
        <!-- <button @click="open = !open" class="text-black rounded hover:text-sky-500">
            <i class="fa-solid fa-plus">Show Form</i> 
        </button> -->
        <div x-transition>
        <form wire:submit.prevent="profiling" enctype="multipart/form-data" class="bg-sky-300 mt-5 mx-auto w-4/6 p-3 shadow-md rounded-lg">
        @csrf
            <span class="text-black"><strong><i class="fa-solid fa-user mx-2"></i>Personal Information</strong></span>
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="mt-4 w-full sm:w-1/4">
                    <label for="name" class="block text-sm font-medium text-black">Name</label>
                    <x-input wire:model="name" class="block mt-1 w-full text-black" type="text" required autofocus/>
                </div>
                <div class="mt-4 w-full sm:w-1/4">
                    <label for="age" class="block text-sm font-medium text-black">Age</label>
                    <x-input wire:model="age" class="block mt-1 w-full text-black" type="number" required autofocus/>
                </div>
                <div class="mt-4 w-full sm:w-1/4">
                    <label for="gender" class="block text-sm font-medium text-black">Sex</label>
                    <select wire:model="gender" class="mt-1 w-full text-black rounded-lg bg-white-500 hover:border-black border-slate-300 inline-flex items-center justify-between" required>
                        <option class="inline-flex items-center justify-between" value="" selected>Select a Gender</option>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                    </select>
                    <x-input-error for="gender" class="mt-2" />
                </div>
                <div class="mt-4 w-full sm:w-1/4">
                    <label for="height" class="block text-sm font-medium text-black">Height(cm)</label>
                    <x-input wire:model="height" class="block mt-1 w-full text-black" type="number" :value="old('height')" required autofocus/>
                    <x-input-error for="height" class="mt-2" />
                </div>
                <div class="mt-4 w-full sm:w-1/4">  
                    <label for="weight" class="block text-sm font-medium text-black">Weight(kg)</label>
                    <x-input wire:model="weight" class="block mt-1 w-full text-black" type="number" :value="old('weight')" required autofocus/>
                    <x-input-error for="weight" class="mt-2" />
                </div>
            </div>
            <div class="flex flex-col sm:flex-row gap-4 mb-6">
                <div class="mt-4 w-full sm:w-1/3">
                    <label for="address" class="block text-sm font-medium text-black">Address</label>
                    <x-input wire:model="address" class="block mt-1 w-full text-black" type="text" required autofocus/>
                </div>
                <div class="mt-4 w-full sm:w-1/3">
                    <label for="cell" class="block text-sm font-medium text-black">Cell No.:</label>
                    <x-input wire:model="cell" class="block mt-1 w-full text-black" type="tel" pattern="[0-9]{11}" placeholder="09XXXXXXXXX" required autofocus/>
                </div>
                <div class="mt-4 w-full sm:w-1/3">
                    <label for="emergency" class="block text-sm font-medium text-black">In case of Emergency Call:</label>
                    <x-input wire:model="emergency" class="block mt-1 w-full text-black" type="tel" pattern="[0-9]{11}" placeholder="09XXXXXXXXX" required autofocus/>
                </div>   
            </div>
            <span class="text-black"><strong>Fitness Information</strong></span>
            <div class="flex flex-col sm:flex-row gap-4">
                <div class="mt-4 w-full sm:w-1/3">
                    <label for="goal" class="block text-sm font-medium text-black">Goal</label>
                        <select wire:model="goal" class="mt-1 w-full text-black rounded-lg bg-white-500 hover:border-black border-slate-300 inline-flex items-center justify-between" required>
                            <option class="inline-flex items-center justify-between" value="" selected>Select a Goal</option>
                            <option value="Improve Fitness/Overall Health">Improve Fitness/Overall Health</option>
                            <option value="Lose Weight">Lose Weight</option>
                            <option value="Increase Strength">Increase Strength</option>
                            <option value="Improve Endurance">Improve Endurance</option>
                            <option value="Build Muscle Mass">Build Muscle Mass</option>
                            <option value="Boost Cardiovascular Fitness">Boost Cardiovascular Fitness</option>
                            <option value="Enhance Flexibility">Enhance Flexibility</option>   
                        </select>   
                </div>
                <div class="mt-4 w-full sm:w-1/3">  
                    <label for="area" class="block text-sm font-medium text-black">Focus Area</label>
                    <select wire:model="area" class="mt-1 w-full text-black rounded-lg bg-white-500 hover:border-black border-slate-300 inline-flex items-center justify-between" required>
                        <option class="inline-flex items-center justify-between" value="" selected>Select a Goal</option>
                        @foreach ($focus_areas as $focus_area)
                            <option value="{{ $focus_area->name }}">{{ $focus_area->name }}</option>
                        @endforeach
                    </select> 
                </div>
                <div class="mt-4 w-full sm:w-1/3">
                    <label for="level" class="block text-sm font-medium text-black">Level</label>
                        <select wire:model="level" class="mt-1 w-full text-black rounded-lg bg-white-500 hover:border-black border-slate-300 inline-flex items-center justify-between" required>
                            <option class="inline-flex items-center justify-between" value="" selected>Select Level</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Expert">Expert</option> 
                        </select>   
                </div>
            </div>
            <div class="mt-10 flex justify-center">
                <x-button class="bg-blue-900 shadow-lg">{{ $profileId ? 'Update' : 'Submit' }}</x-button>
            </div>
            </div>
        </form>
        </div>
    </div>
</div>
