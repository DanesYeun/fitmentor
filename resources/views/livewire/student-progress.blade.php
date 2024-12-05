<div class="p-10">
    <h1 class="lg:m-3 font-xl text-xl font-bold uppercase">Progress Tracker</h1>

    @if(!is_null($classes) && $classes->where('status', 'Approved')->isNotEmpty())
        @foreach ($classes->where('status', 'Approved') as $class)
            <div class="lg:m-3 rounded border text-black p-4">
                <div x-data="{ open: false }" class="w-full">
                    <!-- Accordion Header -->
                    <div 
                        @click="open = !open" 
                        class="flex justify-between items-center cursor-pointer p-4 bg-gray-100 hover:bg-gray-200 rounded-md"
                    >
                        <div>
                            <h1 class="font-bold uppercase">Program: {{ $class->program }}</h1>
                            <span>Goal: {{ $class->goal }}</span>
                            <h5>Level: {{ $class->level }}</h5>
                            <h3>Instructor: {{ $class->user->name }}</h3>
                        </div>
                        <div>
                            <x-button class="bg-teal-400 shadow-lg h-4" wire:click="viewClass ({{$class->id}})">View Class</x-button>
                            <!-- Progress Slider -->
                            <div class="relative pt-1">
                                <div class="flex mb-2 items-center justify-between">
                                    <div>
                                        <span class="font-semibold text-xs uppercase">Progress</span>
                                    </div>
                                    <div>
                                        <span class="text-xs font-semibold inline-block py-1 px-2 uppercase rounded-full text-teal-600 bg-teal-200">
                                            {{ $class->progressing }}%
                                        </span>
                                    </div>
                                </div>
                                <div class="flex mb-2">
                                    <div class="w-full bg-gray-300 rounded-full h-2 w-96">
                                        <!-- Dynamic Progress Bar -->
                                        <div class="bg-sky-500 h-2 rounded-full" style="width: {{ $class->progressing }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Accordion Content -->
                    <div x-show="open" class="mt-4 p-4 border-t border-gray-300">
                        <table class="table-auto w-full text-center">
                            <thead>
                                <tr class="bg-gray-200">
                                    <th class="p-2">Day</th>
                                    <th class="p-2">Start</th>
                                    <th class="p-2">End</th>
                                    <th class="p-2">Remarks</th>
                                    <th class="p-2">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                                    @php
                                        $start = $class->{$day . '_start'};
                                        $end = $class->{$day . '_end'};
                                        $remark = $class->remarks->firstWhere('day', $day);
                                    @endphp
                                    @if ($start && $end)
                                        <tr>
                                            <td class="p-2 capitalize">{{ ucfirst($day) }}</td>
                                            <td class="p-2">{{ $start }}</td>
                                            <td class="p-2">{{ $end }}</td>
                                            <td class="p-2">
                                                {{ $remark ? $remark->remarks : 'N/A' }}
                                            </td>
                                            <td class="p-2">{{ $class->{$day} == 1 ? 'Done' : 'Pending' }}</td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="lg:m-3 rounded grid grid-cols-1 flex justify-center text-black gap-2 p-4 border">
            <div class="mx-auto w-full grid grid-cols-1 flex items-center justify-between">
                <div class="">
                    No progress to track!
                </div>
            </div>
        </div>
    @endif
    @if($showModal)
        <x-modal>
            <div class="allsched-item w-full max-w-4xl p-4 rounded-lg shadow bg-white text-black">
                <div class="grid grid-cols-2">
                    <div>
                        <p class="text-lg font-bold">Program: {{ $selectedClass->program }}</p>
                        <p class="text-lg">Goal: {{$selectedClass->goal}}</p>
                        <p class="text-lg">Instructor: {{$selectedClass->user->name}}</p>
                        <p class="text-lg">Student: {{$selectedClass->student->name ?? ''}}</p>
                        <p class="text-lg">Exercises</p>
                    </div>
                    <div class="flex flex-col items-end">
                        <p class="text-lg">Status: {{$selectedClass->status ?? 'Available'}}</p>
                    </div>
                </div>
                <table class="w-full">
                    <tr>
                        <th class="border border-black h-10 w-1/3">Exercise</th>
                        <th class="border border-black h-10 w-1/3">Preparation</th>
                        <th class="border border-black h-10 w-1/3">Execution</th>
                    </tr>
                    @foreach ($exercises as $exercise)
                        @if($exercise->schedule_id === $selectedClass->id)
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
                        @if($selectedClass->sunday_start || $selectedClass->sunday_end)
                        <tr>
                            <td class="p-2 text-center border border-black">Sunday</td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->sunday_start)
                                    {{ \Carbon\Carbon::parse($selectedClass->sunday_start)->format('g:i A') }}
                                @endif
                            </td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->sunday_end)
                                    {{ \Carbon\Carbon::parse($selectedClass->sunday_end)->format('g:i A') }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @if($selectedClass->monday_start || $selectedClass->monday_end)
                        <tr>
                            <td class="p-2 text-center border border-black">Monday</td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->monday_start)
                                    {{ \Carbon\Carbon::parse($selectedClass->monday_start)->format('g:i A') }}
                                @endif
                            </td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->monday_end)
                                    {{ \Carbon\Carbon::parse($selectedClass->monday_end)->format('g:i A') }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @if($selectedClass->tuesday_start || $selectedClass->tuesday_end)
                        <tr>
                            <td class="p-2 text-center border border-black">Teusday</td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->tuesday_start)
                                    {{ \Carbon\Carbon::parse($selectedClass->tuesday_start)->format('g:i A') }}
                                @endif
                            </td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->tuesday_end)
                                    {{ \Carbon\Carbon::parse($selectedClass->tuesday_end)->format('g:i A') }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @if($selectedClass->wednesday_start || $selectedClass->wednesday_end)
                        <tr>
                            <td class="p-2 text-center border border-black">Wednesday</td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->wednesday_start)
                                    {{ \Carbon\Carbon::parse($selectedClass->wednesday_start)->format('g:i A') }}
                                @endif
                            </td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->wednesday_end)
                                    {{ \Carbon\Carbon::parse($selectedClass->wednesday_end)->format('g:i A') }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @if($selectedClass->thursday_start || $selectedClass->thursday_end)
                        <tr>
                            <td class="p-2 text-center border border-black">Thursday</td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->thursday_start)
                                    {{ \Carbon\Carbon::parse($selectedClass->thursday_start)->format('g:i A') }}
                                @endif
                            </td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->thursday_end)
                                    {{ \Carbon\Carbon::parse($selectedClass->thursday_end)->format('g:i A') }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @if($selectedClass->friday_start || $selectedClass->friday_end)
                        <tr>
                            <td class="p-2 text-center border border-black">Friday</td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->friday_start)
                                    {{ \Carbon\Carbon::parse($selectedClass->friday_start)->format('g:i A') }}
                                @endif
                            </td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->friday_end)
                                    {{ \Carbon\Carbon::parse($selectedClass->friday_end)->format('g:i A') }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        @if($selectedClass->saturday_start || $selectedClass->saturday_end)
                        <tr>
                            <td class="p-2 text-center border border-black">Saturday</td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->saturday_start)
                                    {{ \Carbon\Carbon::parse($selectedClass->saturday_start)->format('g:i A') }}
                                @endif
                            </td>
                            <td class="p-2 text-center border border-black">
                                @if($selectedClass->saturday_end)
                                    {{ \Carbon\Carbon::parse($selectedClass->saturday_end)->format('g:i A') }}
                                @endif
                            </td>
                        </tr>
                        @endif
                        <!-- Repeat for other days similarly -->
                    </tbody>
                </table>
                <div class="flex justify-end mt-4">
                    <x-button wire:click="refreshPage" class="bg-gray-300">Close</x-button>
                </div>
            </div>
        </x-modal>
    @endif
</div>
