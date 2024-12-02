<div class="w-full">
    @if (session()->has('message'))
        <div class="p-4 bg-green-500 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center mx-auto w-1/3">
            {{ session('message') }}
        </div>
    @endif

    @if($showDeleteModal)
        <x-modal>
            <div class="p-6 bg-gray-200 text-black">
                <h2 class="text-lg font-semibold mb-4">Are you sure you want to delete this enrollment?</h2>
                <p class="mb-6">This action cannot be undone.</p>

                <div class="flex justify-end">
                    <x-button wire:click="$set('showDeleteModal', false)" class="bg-gray-300 mr-2">Cancel</x-button>
                    <x-button wire:click="deleteEnrollment" class="bg-red-600 text-white">Delete</x-button>
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
    </div>

    <div class="w-full flex justify-end">
        <div class="w-1/3 mr-5">   
            <x-input type="search" autofocus wire:model.live.debounce.1000ms="search" class="w-full md:w-3/4 lg:w-2/3 text-black mt-10 mb-3 focus:border-gray-400 bg-gray-300" placeholder="Search here ..."/>
        </div>
    </div>

    <div class="overflow-x-auto">
    <div class="w-3/4 mx-auto rounded-lg bg-gray-300 p-2 mb-10">
    <table class="w-full mx-auto rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-black rounded-lg">
                    <th class="py-2 w-64">Name</th>
                    <th class="py-2 w-64">Enrolled Program</th>
                    <th class="py-2 w-64">Instructor</th>
                    <th class="py-2 w-64">Status</th>
                    <th class="py-2 w-64">Action</th>
                    
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                    @if($schedule->student_id)
                        <tr class="bg-gray-100 text-black rounded-lg">
                            <th class="py-2">{{ $schedule->student->name }}</th>
                            <th class="py-2">{{ $schedule->program }}</th>
                            <th class="py-2">{{ $schedule->user->name }}</th>
                            <th class="py-2">{{ $schedule->status }}</th>
                            <th class="py-2">
                                <x-button class="bg-gray-500 shadow-lg" wire:click="viewUser({{ $schedule->id }})">View</x-button>
                                <x-button :disabled="$schedule->status == 'Approved'" class="bg-red-500 shadow-lg" wire:click="confirmDelete({{ $schedule->id }})">Delete</x-button>

                            </th>
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>
        @if($showModal)
                <x-modal>  
                    <div class="allsched-item w-full max-w-4xl p-4 border rounded-lg shadow bg-gray-100 text-black">
                        <div class="grid grid-cols-2">
                            <div>
                                <p class="text-lg font-bold">Program: {{ $selectedSchedule->program }}</p>
                                <p class="text-lg">Goal: {{$selectedSchedule->goal}}</p>
                                <p class="text-lg">Instructor: {{$selectedSchedule->user->name}}</p>
                                <p class="text-lg">Student: {{$selectedSchedule->student->name ?? ''}}</p>
                                <p class="text-lg">Exercises</p>
                            </div>
                            <div class="flex flex-col items-end">
                                <p class="text-lg">Status: {{$selectedSchedule->status ?? 'Available'}}</p>
                            </div>
                        </div>

                        <table class="w-full">
                            <tr>
                                <th class="border border-black h-10 w-1/3">Exercise</th>
                                <th class="border border-black h-10 w-1/3">Preparation</th>
                                <th class="border border-black h-10 w-1/3">Execution</th>
                            </tr>
                            @if($exercises)
                                @foreach ($exercises as $exercise)
                                    @if($exercise->schedule_id === $schedule->id)
                                        <tr>
                                            <td class="border border-black p-2 text-center">{{ $exercise->exercise->name }}</td>
                                            <td class="border border-black p-2 text-center">{{ $exercise->exercise->preparation }}</td>
                                            <td class="border border-black p-2 text-center">{{ $exercise->exercise->execution }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            @endif
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
                                @if($selectedSchedule->sunday_start || $selectedSchedule->sunday_end)
                                <tr>
                                    <td class="p-2 text-center border border-black">Sunday</td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->sunday_start)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->sunday_start)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->sunday_end)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->sunday_end)->format('g:i A') }}
                                        @endif
                                    </td>
                                </tr>
                                @endif

                                @if($selectedSchedule->monday_start || $selectedSchedule->monday_end)
                                <tr>
                                    <td class="p-2 text-center border border-black">Monday</td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->monday_start)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->monday_start)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->monday_end)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->monday_end)->format('g:i A') }}
                                        @endif
                                    </td>
                                </tr>
                                @endif

                                @if($selectedSchedule->tuesday_start || $selectedSchedule->tuesday_end)
                                <tr>
                                    <td class="p-2 text-center border border-black">Tuesday</td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->tuesday_start)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->tuesday_start)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->tuesday_end)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->tuesday_end)->format('g:i A') }}
                                        @endif
                                    </td>
                                </tr>
                                @endif

                                @if($selectedSchedule->wednesday_start || $selectedSchedule->wednesday_end)
                                <tr>
                                    <td class="p-2 text-center border border-black">Wednesday</td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->wednesday_start)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->wednesday_start)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->wednesday_end)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->wednesday_end)->format('g:i A') }}
                                        @endif
                                    </td>
                                </tr>
                                @endif

                                @if($selectedSchedule->thursday_start || $selectedSchedule->thursday_end)
                                <tr>
                                    <td class="p-2 text-center border border-black">Thursday</td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->thursday_start)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->thursday_start)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->thursday_end)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->thursday_end)->format('g:i A') }}
                                        @endif
                                    </td>
                                </tr>
                                @endif

                                @if($selectedSchedule->friday_start || $selectedSchedule->friday_end)
                                <tr>
                                    <td class="p-2 text-center border border-black">Friday</td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->friday_start)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->friday_start)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->friday_end)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->friday_end)->format('g:i A') }}
                                        @endif
                                    </td>
                                </tr>
                                @endif

                                @if($selectedSchedule->saturday_start || $selectedSchedule->saturday_end)
                                <tr>
                                    <td class="p-2 text-center border border-black">Saturday</td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->saturday_start)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->saturday_start)->format('g:i A') }}
                                        @endif
                                    </td>
                                    <td class="p-2 text-center border border-black">
                                        @if($selectedSchedule->saturday_end)
                                            {{ \Carbon\Carbon::parse($selectedSchedule->saturday_end)->format('g:i A') }}
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