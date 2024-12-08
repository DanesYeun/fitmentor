<div class="p-10">
    <h1 class="lg:m-3 font-xl text-xl font-bold uppercase">Progress Tracker</h1>

    @if ($classes->isNotEmpty())
        @foreach ($classes as $class)
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
                        @foreach ($class->sched_remarks->groupBy('week') as $week => $remarks)
                            <h3 class="font-semibold text-lg">Week {{ $week }}</h3>
                            <table class="table-auto w-full text-center mb-4">
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
                                            // Find the corresponding schedule for the current day and week
                                            $schedule = $remarks->firstWhere($day . '_start', '!=', null);
                                        @endphp
                                        @if ($schedule)
                                            <tr>
                                                <td class="p-2 capitalize">{{ ucfirst($day) }}</td>
                                                {{-- <td class="p-2">{{ $schedule->{$day . '_start'} }}</td>
                                                <td class="p-2">{{ $schedule->{$day . '_end'} }}</td> --}}
                                                <td class="p-2">{{ \Carbon\Carbon::parse($schedule->{$day . '_start'})->format('h:i A') }}</td>
                                                <td class="p-2">{{ \Carbon\Carbon::parse($schedule->{$day . '_end'})->format('h:i A') }}</td>
                                                <td class="p-2">
                                                    {{ $schedule->remarks ?? '-' }}
                                                </td>
                                                <td class="p-2">{{ $schedule->attendance->description }}</td>
                                            </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        @endforeach
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
</div>
