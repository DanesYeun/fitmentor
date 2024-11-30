<div class="w-full">
@if (session()->has('message'))
    <div class="p-4 bg-green-500 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center mx-auto w-1/3">
        {{ session('message') }}
    </div>
@endif
@if($showDeleteModal)
                <x-modal>
                    <div class="p-6 bg-gray-200 text-black">
                        <h2 class="text-lg font-semibold mb-4">Are you sure you want to delete this program?</h2>
                        <p class="mb-6">This action cannot be undone.</p>

                        <div class="flex justify-end">
                            <x-button wire:click="$set('showDeleteModal', false)" class="bg-gray-300 mr-2">Cancel</x-button>
                            <x-button wire:click="deleteUser" class="bg-red-600 text-white">Delete</x-button>
                        </div>
                    </div>
                </x-modal>
        @endif
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
                <div>
                    <a href="{{ route ('program') }}"><x-button class="bg-gray-400"><i class="fa-solid fa-plus"></i>Create Schedule</x-button></a>
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
                                <th class="py-2 w-64">Student</th>
                                <th class="py-2 w-64">Enrolled Program</th>
                                <th class="py-2 w-64">Instructor</th>
                                <th class="py-2 w-64">Status</th>
                                <th class="py-2 w-64">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allscheds as $allsched)
                            <tr class="bg-gray-100 text-black rounded-lg">
                                <th class="py-2">{{ $allsched->student->name ?? ''}}</th>
                                <th class="py-2">{{ $allsched->program }}</th>
                                <th class="py-2">{{ $allsched->user->name }}</th>
                                <th class="py-2">{{ $allsched->status }}</th>
                                <th class="py-2">                                   
                                    <div class="inline-block text-left">
                                        <button id="dropdownButton-{{ $allsched->id }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" onclick="toggleDropdown({{ $allsched->id }})">
                                            <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                            </svg>
                                        </button>
                                        <div id="dropdownMenu-{{ $allsched->id }}" class="z-10 hidden bg-white rounded-lg shadow dark:bg-gray-700 absolute transform -translate-x-1/3 mt-2">
                                            <div class="bg-gray-300 p-3">
                                                <x-button class="bg-gray-400" wire:click="viewProgram({{ $allsched->id }})">View</x-button>
                                                <x-button class="bg-gray-400" onclick="window.location='{{ route('schedule.edit', $allsched->id) }}'">Edit</x-button>
                                                <x-button class="bg-gray-400" wire:click="confirmDelete({{ $allsched->id }})">Delete</x-button>
                                            </div>
                                        </div>
                                    </div>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                        <tr>
                            <th colspan="5" class="pagination-links text-black bg-gray-300 mt-3 rounded-lg">
                                {{ $allscheds->links() }}
                            </th>
                        </tr>
                    </table>
                        @if($showModal)
                            <x-modal>  
                                <div class="allsched-item w-full max-w-4xl p-4 border rounded-lg shadow bg-gray-100 text-black">
                                    <div class="grid grid-cols-2">
                                        <div>
                                            <p class="text-lg font-bold">Program: {{ $schedule->program }}</p>
                                            <p class="text-lg">Goal: {{$schedule->goal}}</p>
                                            <p class="text-lg">Focus Area: {{ $schedule->focusAreas->isNotEmpty() ? $schedule->focusAreas[0]->name : 'No focus area' }}</p>
                                            <p class="text-lg">Instructor: {{$schedule->user->name}}</p>
                                            <p class="text-lg">Student: {{$schedule->student->name ?? ''}}</p>
                                            <p class="text-lg">Exercises</p>
                                        </div>
                                        <div class="flex flex-col items-end">
                                            <p class="text-lg">Status: {{$schedule->status ?? 'Available'}}</p>
                                        </div>
                                    </div>

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

                                    <table class="w-full border border-black mt-4">
                                        <thead>
                                            <tr>
                                                <th class="p-2 text-center border border-black h-10 w-1/3">Day</th>
                                                <th class="p-2 text-center border border-black h-10 w-1/3">Start</th>
                                                <th class="p-2 text-center border border-black h-10 w-1/3">End</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($schedule->sunday_start || $schedule->sunday_end)
                                            <tr>
                                                <td class="p-2 text-center border border-black">Sunday</td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->sunday_start)
                                                        {{ \Carbon\Carbon::parse($schedule->sunday_start)->format('g:i A') }}
                                                    @endif
                                                </td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->sunday_end)
                                                        {{ \Carbon\Carbon::parse($schedule->sunday_end)->format('g:i A') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif

                                            @if($schedule->monday_start || $schedule->monday_end)
                                            <tr>
                                                <td class="p-2 text-center border border-black">Monday</td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->monday_start)
                                                        {{ \Carbon\Carbon::parse($schedule->monday_start)->format('g:i A') }}
                                                    @endif
                                                </td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->monday_end)
                                                        {{ \Carbon\Carbon::parse($schedule->monday_end)->format('g:i A') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif

                                            @if($schedule->tuesday_start || $schedule->tuesday_end)
                                            <tr>
                                                <td class="p-2 text-center border border-black">Tuesday</td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->tuesday_start)
                                                        {{ \Carbon\Carbon::parse($schedule->tuesday_start)->format('g:i A') }}
                                                    @endif
                                                </td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->tuesday_end)
                                                        {{ \Carbon\Carbon::parse($schedule->tuesday_end)->format('g:i A') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif

                                            @if($schedule->wednesday_start || $schedule->wednesday_end)
                                            <tr>
                                                <td class="p-2 text-center border border-black">Wednesday</td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->wednesday_start)
                                                        {{ \Carbon\Carbon::parse($schedule->wednesday_start)->format('g:i A') }}
                                                    @endif
                                                </td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->wednesday_end)
                                                        {{ \Carbon\Carbon::parse($schedule->wednesday_end)->format('g:i A') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif

                                            @if($schedule->thursday_start || $schedule->thursday_end)
                                            <tr>
                                                <td class="p-2 text-center border border-black">Thursday</td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->thursday_start)
                                                        {{ \Carbon\Carbon::parse($schedule->thursday_start)->format('g:i A') }}
                                                    @endif
                                                </td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->thursday_end)
                                                        {{ \Carbon\Carbon::parse($schedule->thursday_end)->format('g:i A') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif

                                            @if($schedule->friday_start || $schedule->friday_end)
                                            <tr>
                                                <td class="p-2 text-center border border-black">Friday</td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->friday_start)
                                                        {{ \Carbon\Carbon::parse($schedule->friday_start)->format('g:i A') }}
                                                    @endif
                                                </td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->friday_end)
                                                        {{ \Carbon\Carbon::parse($schedule->friday_end)->format('g:i A') }}
                                                    @endif
                                                </td>
                                            </tr>
                                            @endif

                                            @if($schedule->saturday_start || $schedule->saturday_end)
                                            <tr>
                                                <td class="p-2 text-center border border-black">Saturday</td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->saturday_start)
                                                        {{ \Carbon\Carbon::parse($schedule->saturday_start)->format('g:i A') }}
                                                    @endif
                                                </td>
                                                <td class="p-2 text-center border border-black">
                                                    @if($schedule->saturday_end)
                                                        {{ \Carbon\Carbon::parse($schedule->saturday_end)->format('g:i A') }}
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
