<div>
    @if (session()->has('success'))
        <div class="p-4 bg-green-100 border border-green-200 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center">
            {{ session('success') }}
        </div>
    @endif
    <div>
    <div x-data="{ open: false }" class="w-full p-5">
            <button @click="open = !open" class="text-black rounded hover:text-sky-500">
                <i class="fa-solid fa-plus">Show Form</i> 
            </button>
        <div x-show="open" x-transition>
        <form wire:submit.prevent="profiling" enctype="multipart/form-data" class="bg-sky-300 mt-5 mx-auto w-4/6 p-3 shadow-md rounded-lg">
        @csrf
            <span class="text-black"><strong>Personal Information</strong></span>
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
                    <x-input wire:model="area" class="block mt-1 w-full text-black" type="text" :value="old('area')" required autofocus/>
                    <x-input-error for="area" class="mt-2" />
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
        <div class="mt-5 bg-sky-300 mx-auto w-3/4 p-2 rounded-lg">
            @if($profileId)
                <h1>These programs are a good match for you based on your profile.</h1>
            @else
                <h1>No profile details.</h1>
            @endif
        </div>
        @if($profile)
        <div class="mx-auto w-3/4 p-5">
            <table class="w-full mx-auto rounded-lg">
                <thead>
                    <tr class="bg-sky-200 text-black rounded-lg">
                        <th class="py-2 w-64">Program</th>
                        <th class="py-2 w-64">Goal</th>
                        <th class="py-2 w-64">Instructor</th>
                        <th class="py-2 w-64">Expertise</th>
                        <th class="py-2 w-64">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recommends as $recommend)
                    <tr class="bg-sky-100 text-black rounded-lg">
                        <th class="py-2">{{ $recommend->program}}</th>
                        <th class="py-2">{{ $recommend->goal}}</th>
                        <th class="py-2">{{ $recommend->user->name }}</th>
                        <th class="py-2">{{ $recommend->user->expertise }}</th>
                        <th class="py-2">
                            <div class="inline-block text-left">
                                <button id="dropdownButton-{{ $recommend->id }}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" onclick="toggleDropdown({{ $recommend->id }})">
                                    <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                    </svg>
                                </button>
                                <div id="dropdownMenu-{{ $recommend->id }}" class="z-10 hidden bg-white rounded-lg shadow dark:bg-gray-700 absolute transform -translate-x-1/3 mt-2">
                                    <div class="bg-blue-300 p-3">
                                        <x-button class="bg-sky-500 shadow-lg" wire:click="viewRecommend ({{$recommend->id}})">View</x-button>
                                        <x-button class="bg-sky-500 shadow-lg" wire:click="enrollConfirm({{ $recommend->id }})">Enroll</x-button>
                                    </div>
                                </div>
                            </div>
                        </th>
                    </tr>
                    @endforeach
                    <tr class="bg-sky-200">
                        <th colspan="5">{{$recommends->links()}}</th>
                    </tr>
                </tbody>
            </table>
        </div>
        @endif
        @if($showModal)
            <x-modal>
                <div class="allsched-item w-full max-w-4xl p-4 border rounded-lg shadow bg-sky-400 text-black">
                    <div class="grid grid-cols-2">
                        <div>
                            <p class="text-lg font-bold">Program: {{ $selectedRecommend->program }}</p>
                            <p class="text-lg">Goal: {{$selectedRecommend->goal}}</p>
                            <p class="text-lg">Instructor: {{$selectedRecommend->user->name}}</p>
                            <p class="text-lg">Student: {{$selectedRecommend->student->name ?? ''}}</p>
                            <p class="text-lg">Exercises</p>
                        </div>
                        <div class="flex flex-col items-end">
                            <p class="text-lg">Status: {{$selectedRecommend->status ?? 'Available'}}</p>
                        </div>
                    </div>
                    <table class="w-full">
                        <tr>
                            <th class="border border-black h-10 w-1/3">Exercise</th>
                            <th class="border border-black h-10 w-1/3">Preparation</th>
                            <th class="border border-black h-10 w-1/3">Execution</th>
                        </tr>
                        @foreach ($exercises as $exercise)
                            @if($exercise->schedule_id === $selectedRecommend->id)
                                <tr>
                                    <td class="border border-black p-2 text-center">{{ $exercise->exercise->name }}</td>
                                    <td class="border border-black p-2 text-center">{{ $exercise->exercise->preparation }}</td>
                                    <td class="border border-black p-2 text-center">{{ $exercise->exercise->execution }}</td>
                                </tr>
                            @endif
                        @endforeach
                    </table>
                    <table class="w-full border border-black mt-4">
                        <thead>
                            <tr>
                                <th class="p-2 text-center border border-black h-10 w-1/3">Day</th>
                                <th class="p-2 text-center border border-black h-10 w-1/3">Start</th>
                                <th class="p-2 text-center border border-black h-10 w-1/3">End</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($selectedRecommend->sunday_start || $selectedRecommend->sunday_end)
                            <tr>
                                <td class="p-2 text-center border border-black">Sunday</td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->sunday_start)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->sunday_start)->format('g:i A') }}
                                    @endif
                                </td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->sunday_end)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->sunday_end)->format('g:i A') }}
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if($selectedRecommend->monday_start || $selectedRecommend->monday_end)
                            <tr>
                                <td class="p-2 text-center border border-black">Monday</td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->monday_start)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->monday_start)->format('g:i A') }}
                                    @endif
                                </td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->monday_end)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->monday_end)->format('g:i A') }}
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if($selectedRecommend->tuesday_start || $selectedRecommend->tuesday_end)
                            <tr>
                                <td class="p-2 text-center border border-black">Tuesday</td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->tuesday_start)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->tuesday_start)->format('g:i A') }}
                                    @endif
                                </td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->tuesday_end)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->tuesday_end)->format('g:i A') }}
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if($selectedRecommend->wednesday_start || $selectedRecommend->wednesday_end)
                            <tr>
                                <td class="p-2 text-center border border-black">Wednesday</td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->wednesday_start)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->wednesday_start)->format('g:i A') }}
                                    @endif
                                </td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->wednesday_end)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->wednesday_end)->format('g:i A') }}
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if($selectedRecommend->thursday_start || $selectedRecommend->thursday_end)
                            <tr>
                                <td class="p-2 text-center border border-black">Thursday</td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->thursday_start)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->thursday_start)->format('g:i A') }}
                                    @endif
                                </td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->thursday_end)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->thursday_end)->format('g:i A') }}
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if($selectedRecommend->friday_start || $selectedRecommend->friday_end)
                            <tr>
                                <td class="p-2 text-center border border-black">Friday</td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->friday_start)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->friday_start)->format('g:i A') }}
                                    @endif
                                </td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->friday_end)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->friday_end)->format('g:i A') }}
                                    @endif
                                </td>
                            </tr>
                            @endif
                            @if($selectedRecommend->saturday_start || $selectedRecommend->saturday_end)
                            <tr>
                                <td class="p-2 text-center border border-black">Saturday</td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->saturday_start)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->saturday_start)->format('g:i A') }}
                                    @endif
                                </td>
                                <td class="p-2 text-center border border-black">
                                    @if($selectedRecommend->saturday_end)
                                        {{ \Carbon\Carbon::parse($selectedRecommend->saturday_end)->format('g:i A') }}
                                    @endif
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                        <div class="flex justify-end mt-4">
                            <x-button wire:click="refreshPage" class="bg-gray-300">Close</x-button>
                        </div>

                </div>
            </x-modal>
        @endif
        @if($confirmingEnrollment)
            <x-modal>
                <div class="p-6 bg-blue-200 text-black">
                    <h2 class="text-lg font-semibold mb-4">Confirm Enrollment</h2>
                    <p>Are you sure you want to enroll in this program?</p>
                    <div class="flex justify-end mt-4 space-x-2">
                        <x-button wire:click="enroll({{ $selectedProgramId }})" class="bg-green-500">Confirm</x-button>
                        <x-button wire:click="$set('confirmingEnrollment', false)" class="bg-gray-300">Cancel</x-button>
                    </div>
                </div>
            </x-modal>
        @endif
</div>
<script>
    function toggleDropdown(recommendId) {
        const dropdownMenu = document.getElementById(`dropdownMenu-${recommendId}`);
        const isVisible = dropdownMenu.classList.contains('hidden');
        
        const allDropdowns = document.querySelectorAll('[id^="dropdownMenu-"]');
        allDropdowns.forEach(dropdown => dropdown.classList.add('hidden'));
        
        if (isVisible) {
            dropdownMenu.classList.remove('hidden');
        } else {
            dropdownMenu.classList.add('hidden');
        }
    }
</script>
