<div>
@if(auth()->user()->role == 'instructor')
        <div class="mx-auto flex justify-end mt-5 mr-20">
            <a href="{{route('program')}}" wire:navigate><button class="bg-red-500 rounded-full p-3 shadow-lg">Create Program</button></a>
        </div>
        <div class="bg-transparent min-h-screen">
    <div class="mt-10 mx-auto w-1/2 mb-5"><span>Available Schedules</span></div>
    <!-- Schedules List -->
    <div class="container mx-auto w-1/2">
        @foreach ($schedules as $schedule)
        <div class="schedule-item w-full max-w-4xl p-4 mb-6 border rounded-lg shadow bg-red-600">
            <div class="grid grid-cols-2">
                <div>
                    <p class="text-lg font-bold">Program Name: {{ $schedule->program }}</p>
                    <p class="text-lg">Goal: {{$schedule->goal}}</p>
                    <p class="text-lg">Student: {{$schedule->student->name ?? ''}}</p>
                    <p class="text-lg">Exercises</p>
                </div>
                <div class="flex flex-col items-end">
                    <p class="text-lg">Status: {{$schedule->status}}</p>
                </div>
            </div>
            <!-- Exercises Table -->
            <table class="w-full">
                <tr>
                    <th class="border border-black h-10 w-1/3">Exercise</th>
                    <th class="border border-black h-10 w-1/3">Preparation</th>
                    <th class="border border-black h-10 w-1/3">Execution</th>
                </tr>
                @foreach ($exercises as $exercise)
                    @if($exercise->schedule_id === $schedule->id)
                        <tr>
                            <td class="border border-black p-2 text-center">{{ $exercise->program->name }}</td>
                            <td class="border border-black p-2 text-center">{{ $exercise->program->preparation }}</td>
                            <td class="border border-black p-2 text-center">{{ $exercise->program->execution }}</td>
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
        </div>
        @endforeach
    </div>
    <!-- Pagination Controls -->
    <div class="pagination-links mx-auto w-1/3">
        {{ $schedules->links() }} <!-- This will generate pagination links -->
    </div>
        
    @elseif (auth()->user()->role == 'student')
    <div class="w-full">
            <div class="w-3/4 flex justify-between mx-auto mt-10">
                <div>
                    <span class="text-black">Show</span>
                    <select wire:model.live="page" class="text-black bg-blue-300 w-16 h-10">
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
                    <x-input type="search" autofocus wire:model.live.debounce.1000ms="search" class="w-full md:w-3/4 lg:w-2/3 text-black mt-10 mb-3 focus:border-sky-400 bg-sky-300" placeholder="Search here ..."/>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="w-3/4 mx-auto rounded-lg bg-sky-300 p-2 mb-10">
                    <table class="w-full mx-auto rounded-lg">
                        <thead>
                            <tr class="bg-sky-200 text-black rounded-lg">
                                <th class="py-2 w-64">Name</th>
                                <th class="py-2 w-64">Enrolled Program</th>
                                <th class="py-2 w-64">Instructor</th>
                                <th class="py-2 w-64">Status</th>
                                <th class="py-2 w-64">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allscheds as $allsched)
                            <tr class="bg-sky-100 text-black rounded-lg">
                                <th class="py-2">{{ $allsched->student->name ?? ''}}</th>
                                <th class="py-2">{{ $allsched->program }}</th>
                                <th class="py-2">{{ $allsched->user->name }}</th>
                                <th class="py-2">{{ $allsched->status }}</th>
                                <th class="py-2">                                   
                                    <x-button wire:click="viewProgram({{ $allsched->id }})">View</x-button>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                        <tr>
                            <th colspan="5" class="pagination-links text-black bg-sky-300 mt-3 rounded-lg">
                                {{ $allscheds->links() }}
                            </th>
                        </tr>
                    </table>
                        @if($showModal)
                            <x-modal>  
                                <div class="allsched-item w-full max-w-4xl p-4 border rounded-lg shadow bg-sky-400 text-black">
                                    <div class="grid grid-cols-2">
                                        <div>
                                            <p class="text-lg font-bold">Program: {{ $schedule->program }}</p>
                                            <p class="text-lg">Goal: {{$schedule->goal}}</p>
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
                                                    <td class="border border-black p-2 text-center">{{ $exercise->program->name }}</td>
                                                    <td class="border border-black p-2 text-center">{{ $exercise->program->preparation }}</td>
                                                    <td class="border border-black p-2 text-center">{{ $exercise->program->execution }}</td>
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

        @else
        <div class="w-full">
            <div class="w-3/4 flex justify-between mx-auto mt-10">
                <div>
                    <span class="text-black">Show</span>
                    <select wire:model.live="page" class="text-black bg-blue-300 w-16 h-10">
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
                    <x-input type="search" autofocus wire:model.live.debounce.1000ms="search" class="w-full md:w-3/4 lg:w-2/3 text-black mt-10 mb-3 focus:border-sky-400 bg-sky-300" placeholder="Search here ..."/>
                </div>
            </div>

            <div class="overflow-x-auto">
                <div class="w-3/4 mx-auto rounded-lg bg-sky-300 p-2 mb-10">
                    <table class="w-full mx-auto rounded-lg">
                        <thead>
                            <tr class="bg-sky-200 text-black rounded-lg">
                                <th class="py-2 w-64">Name</th>
                                <th class="py-2 w-64">Enrolled Program</th>
                                <th class="py-2 w-64">Instructor</th>
                                <th class="py-2 w-64">Status</th>
                                <th class="py-2 w-64">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($allscheds as $allsched)
                            <tr class="bg-sky-100 text-black rounded-lg">
                                <th class="py-2">{{ $allsched->student->name ?? ''}}</th>
                                <th class="py-2">{{ $allsched->program }}</th>
                                <th class="py-2">{{ $allsched->user->name }}</th>
                                <th class="py-2">{{ $allsched->status }}</th>
                                <th class="py-2">                                   
                                    <x-button wire:click="viewProgram({{ $allsched->id }})">View</x-button>
                                </th>
                            </tr>
                            @endforeach
                        </tbody>
                        <tr>
                            <th colspan="5" class="pagination-links text-black bg-sky-300 mt-3 rounded-lg">
                                {{ $allscheds->links() }}
                            </th>
                        </tr>
                    </table>
                        @if($showModal)
                            <x-modal>  
                                <div class="allsched-item w-full max-w-4xl p-4 border rounded-lg shadow bg-sky-400 text-black">
                                    <div class="grid grid-cols-2">
                                        <div>
                                            <p class="text-lg font-bold">Program: {{ $schedule->program }}</p>
                                            <p class="text-lg">Goal: {{$schedule->goal}}</p>
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
                                                    <td class="border border-black p-2 text-center">{{ $exercise->program->name }}</td>
                                                    <td class="border border-black p-2 text-center">{{ $exercise->program->preparation }}</td>
                                                    <td class="border border-black p-2 text-center">{{ $exercise->program->execution }}</td>
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
        @endif
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
</script>
