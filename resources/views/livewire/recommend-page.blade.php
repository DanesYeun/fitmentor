<div class="w-full">
            <div class="w-3/4 flex justify-between mx-auto mt-10">
                <div>
                    <span class="text-black">Show</span>
                    <select wire:model.live="page" class="text-black bg-gray-300 w-16 h-10">
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                    <span class="text-black">entries</span>
                </div>
            </div>

            <div class="w-full flex justify-end">
                <div class="w-1/3 mr-5">   
                    <x-input type="search" autofocus wire:model.live.debounce.1000ms="search" class="w-full md:w-3/4 lg:w-2/3 text-black mt-10 mb-3 focus:border-gray-400 bg-gray-300" placeholder="Search here ..."/>
                </div>
            </div>

            <div>
                <div class="w-3/4 mx-auto rounded-lg bg-gray-300 p-2 mb-10">
                    <table class="w-full mx-auto rounded-lg">
                        <thead>
                            <tr class="bg-gray-200 text-black rounded-lg">
                                <th class="py-2 w-64">Program Name</th>
                                <th class="py-2 w-64">Instructor</th>
                                <th class="py-2 w-64">Status</th>
                                <th class="py-2 w-64">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($recommends as $recommend)
                            <tr class="bg-gray-100 text-black rounded-lg">
                                <th class="py-2">{{ $recommend->program }}</th>
                                <th class="py-2">{{ $recommend->user->name }}</th>
                                <th class="py-2">{{ $recommend->status }}</th>
                                <th class="py-2">                                   
                                    <div class="inline-block text-left">
                                        <button id="dropdownButton-{{ $recommend->id }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" onclick="toggleDropdown({{ $recommend->id }})">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="dropdownMenu-{{ $recommend->id }}" class="z-10 hidden bg-white rounded-lg shadow dark:bg-gray-700 absolute transform -translate-x-1/3 mt-2">
                                            <div class="bg-gray-300 p-3">
                                                <x-button wire:click="viewProgram({{ $recommend->id }})">View</x-button>
                                                <x-button wire:click="enroll({{ $recommend->id }})">Enroll</x-button>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                        <tr>
                            <th colspan="5" class="pagination-links text-black bg-gray-300 mt-3 rounded-lg">
                                {{ $recommends->links() }}
                            </th>
                        </tr>
                    </table>
                        @if($showModal)
                            <x-modal>  
                                <div class="recommend-item w-full max-w-4xl p-4 border rounded-lg shadow bg-gray-100 text-black">
                                    <div class="col-span-1 grid grid-cols-2">
                                        <div class="col-span-2">
                                            <div class="flex justify-between mb-2">
                                                <p class="text-lg font-bold">Program: {{ $schedule->program }}</p>
                                                <p class="text-lg">Status: {{$schedule->status ?? 'Available'}}</p>
                                            </div> 
                                            <p class="text-lg">Goal: {{$schedule->goal}}</p>
                                            <p class="text-lg">Instructor: {{$schedule->user->name}}</p>
                                            <p class="text-lg">Student: {{$schedule->student->name ?? ''}}</p>
                                            <p class="text-lg">Level: {{ $schedule->level }}</p>
                                        </div>
                                    </div>
                                    <div class="col-span-1 mt-6">
                                    <p class="text-lg">Exercises</p>
                                    <table class="w-full">
                                        <tr>
                                            <th class="border border-black h-10 w-1/3">Exercise</th>
                                            <th class="border border-black h-10 w-1/3">Preparation</th>
                                            <th class="border border-black h-10 w-1/3">Execution</th>
                                        </tr>
                                        @foreach ($exercises as $exercise)
                                            @if($exercise->schedule_id === $schedule->id)
                                                <tr>
                                                    <td class="border border-black p-2 text-center">{{ $exercise->exercise->name }}</td>
                                                    <td class="border border-black p-2 text-center">{{ $exercise->exercise->preparation }}</td>
                                                    <td class="border border-black p-2 text-center">{{ $exercise->exercise->execution }}</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                    </table>
                                    <p class="text-lg mt-4">Schedule</p>
                                    <table class="w-full border border-black">
                                        <thead>
                                            <tr>
                                                <th class="p-2 text-center border border-black h-10 w-1/3">Day</th>
                                                <th class="p-2 text-center border border-black h-10 w-1/3">Start</th>
                                                <th class="p-2 text-center border border-black h-10 w-1/3">End</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                                                @php
                                                    $start = $schedule->{$day . '_start'};
                                                    $end = $schedule->{$day . '_end'};
                                                @endphp
                                        
                                                @if(($start || $end))
                                                    <tr>
                                                        <td class="p-2 text-center border border-black">{{ ucfirst($day) }}</td>
                                                        <td class="p-2 text-center border border-black">
                                                            @if($start)
                                                                {{ \Carbon\Carbon::parse($start)->format('g:i A') }}
                                                            @endif
                                                        </td>
                                                        <td class="p-2 text-center border border-black">
                                                            @if($end)
                                                                {{ \Carbon\Carbon::parse($end)->format('g:i A') }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                    </div>
        
                                    <div class="flex justify-end mt-4">
                                        <x-button wire:click="refreshPage" class="bg-gray-300">Close</x-button>
                                    </div>

                                </div>
                            </x-modal>
                        @endif
            </div>
            </div>
        </div>
</div>
<script>
    function toggleExercises(id) {
        // Get the table and button elements by ID
        const exercisesDiv = document.getElementById(`exercises-${id}`);
        const showMoreBtn = document.getElementById(`showMoreBtn-${id}`);

        // Toggle visibility
        if (exercisesDiv.classList.contains('hidden')) {
            exercisesDiv.classList.remove('hidden');
            showMoreBtn.textContent = "Show Less"; // Change the button text
        } else {
            exercisesDiv.classList.add('hidden');
            showMoreBtn.textContent = "Show More"; // Revert the button text
        }
    }

    function toggleDropdown(scheduleId) {
        const dropdownMenu = document.getElementById(`dropdownMenu-${scheduleId}`);
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
