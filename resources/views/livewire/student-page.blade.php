<div class="sm:m-8 lg:m-3 rounded grid grid-cols-1 sm:grid-cols-3 flex justify-center text-black gap-2">
    @if(!$profile)
        <div class="col-span-3 w-full flex items-center justify-between">
            <h1 class="col-span-5 text-black">Set your Profile first</h1>
            <a class="col-span-1" href="{{ route('profiling') }}">
                <x-button class="bg-gray-100 shadow-lg">Setup Profile</x-button>
            </a>
        </div>
    @else
        {{-- Recommended Classes Section --}}
        <div class="sm:col-span-2 col-span-3">
            <h1 class="font-xl text-xl font-bold uppercase">Matched Programs</h1>
            @if (!$recommends->isEmpty())
                @foreach($recommends as $recommend)           
                    <div class="flex justify-center mt-2 mb-5">
                        <div class="w-full rounded overflow-hidden shadow-lg bg-gray-100 p-3">
                            <div class="flex justify-center">
                                <span class="font-xl text-xl font-bold uppercase"><strong>{{$recommend->program}}</strong></span>
                            </div>
                            <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="">
                                    <p><strong>Goal: {{$recommend->goal}}</strong></p>
                                    <p><strong>Level: {{$recommend->level}}</strong></p>
                                    <p><strong>Instructor: {{$recommend->user->name}}</strong></p>
                                    <p><strong>Focus Area/s: <br>
                                    @php
                                        $uniqueFocusAreas = $recommend->program_schedule->pluck('focus_area.name')->unique();
                                    @endphp

                                    @foreach($uniqueFocusAreas as $focusArea)
                                        {{ $focusArea }}
                                        @if (!$loop->last), @endif
                                    @endforeach
                                    </strong></p>
                                </div>
                                <div class="flex gap-2 justify-end py-10 px-2">
                                    <x-button class="bg-gray-500 shadow-lg h-10" wire:click="viewRecommend ({{$recommend->id}})">View</x-button>
                                    <x-button class="bg-gray-500 shadow-lg h-10" wire:click="enrollConfirm({{ $recommend->id }})">Enroll</x-button>
                                </div>  
                            </div>                
                        </div>
                    </div>
                @endforeach

                {{-- Pagination Links --}}
                <div class="mt-4">
                    {{ $recommends->links() }}
                </div>
            @else
                <div class="flex justify-center mt-2 mb-5">
                    <div class="w-full rounded overflow-hidden shadow-lg bg-gray-100 p-3">
                        <div class="flex justify-center">
                            <span class="font-xl text-xl font-bold uppercase"><strong>No Matched Programs</strong></span>
                        </div>               
                    </div>
                </div>
            @endif
        </div>
        <!-- matched coaches -->
        <div class="col-span-1">
            <h1 class="font-xl text-xl font-bold uppercase sm:col-span-2">
                Matched Coaches
            </h1>
            @if (!is_null($suggestedCoaches))   
                @foreach($suggestedCoaches as $coach)
                    <div x-data="{ open: false }" class="flex justify-center mt-2 mb-5">
                        <div @click="open = !open" class="w-full rounded overflow-hidden shadow-lg bg-gray-100 p-3">
                            <div class=" text-start flex flex-cols content-center gap-2">
                                <img class="h-8 w-8 rounded-full object-cover"  
                                    src="{{ is_null($coach->profile_photo_path) ? asset($coach->profile_photo_url) : Storage::url('profile-photos/' . basename($coach->profile_photo_path))  }}"
                                    alt="{{ $coach->name }}" />
                                <span class="font-xl text-xl pt-1 font-bold uppercase">
                                    <strong>{{ $coach->name }}</strong>
                                </span>
                            </div>
                            <div x-show="open" class="mt-4 p-4 border-t border-gray-300">
                                <div>
                                    <p><strong>Expertise: {{ $coach->specialization->name }}</strong></p>
                                    <p><strong>Email: {{ $coach->email }}</strong></p>
                                    @if (!is_null($recommendedClasses->where('user_id', $coach->id)))
                                    <p class="px-2 m-1"><strong>Program</strong></p>
                                        @foreach ($recommendedClasses->where('user_id', $coach->id) as $class)
                                            <div class="flex gap-2 justify-between px-2 m-1">
                                                <span class="font-sm text-sm font-bold uppercase">
                                                    <strong>{{ $class->program }}</strong>
                                                </span>
                                                <x-button class="bg-gray-500 shadow-lg h-6" wire:click="enrollConfirm({{ $class->id }})">Enroll</x-button>
                                            </div>
                                        @endforeach 
                                    @else
                                        <span>No classes</span>
                                    @endif         
                                </div>
                            </div>              
                        </div>
                    </div>
                @endforeach
                {{-- Pagination Links --}}
                <div class="mt-4">
                    {{ $suggestedCoaches->links() }}
                </div>
            @else
                <div class="flex justify-center mt-2 mb-5">
                    <div class="w-full rounded overflow-hidden shadow-lg bg-gray-100 p-3">
                        <div class="flex justify-center">
                            <span class="font-xl text-xl font-bold uppercase"><strong>No Matched Coaches</strong></span>
                        </div>               
                    </div>
                </div>
            @endif
        </div>
        

        {{-- Suggested Classes Section --}}
        <div class="col-span-3">
            <h1 class="font-xl text-xl font-bold uppercase sm:col-span-2 mt-10">
                Recommended Exercises
            </h1>
            @if (!$suggestions->isEmpty())
                <div class="grid grid-cols-3 gap-2">
                    @foreach($suggestions as $suggestion)
                        <div class="flex col-span-3 sm:col-span-1 justify-center mt-2 mb-5">
                            <div class="w-full rounded overflow-hidden shadow-lg bg-gray-100 p-3">
                                <div class="flex justify-center">
                                    <span class="font-xl text-xl font-bold uppercase">
                                        <strong>{{ $suggestion['exercise']->name }}</strong>
                                    </span>
                                </div>
                                <div class="mt-2 grid grid-cols-1 gap-4">
                                    <div>
                                        <p><strong>Focus Area: {{ $suggestion['exercise']->focusArea->name}}</strong></p>
                                        <p><strong>Reps: {{ $suggestion['reps'] }}</strong></p>
                                        <p><strong>Sets: {{ $suggestion['sets'] }}</strong></p>
                                        <p><strong>Intensity: {{ $suggestion['intensity'] }}</strong></p>
                                        <p><strong>Preparation: {{ $suggestion['exercise']->preparation }}</strong></p>
                                        <p><strong>Execution: {{ $suggestion['exercise']->execution }}</strong></p>
                                    </div>
                                </div>                
                            </div>
                        </div>
                    @endforeach
                </div>
                {{-- Pagination Links --}}
                <div class="mt-4">
                    {{ $suggestions->links() }}
                </div>
            @else
                <div class="flex justify-center mt-2 mb-5">
                    <div class="w-full rounded overflow-hidden shadow-lg bg-gray-100 p-3">
                        <div class="flex justify-center">
                            <span class="font-xl text-xl font-bold uppercase"><strong>No Exercises Compatible</strong></span>
                        </div>               
                    </div>
                </div>
            @endif
        </div>
    @endif

    {{-- Modal for Recommended or Suggested --}}
    @if($showModal)
        <x-modal>
            <div class="allsched-item w-full max-w-4xl p-4 rounded-lg shadow bg-white text-black">
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
                            <td class="p-2 text-center border border-black">Teusday</td>
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
                        <!-- Repeat for other days similarly -->
                    </tbody>
                </table>
                <div class="flex justify-end mt-4">
                    <x-button wire:click="refreshPage" class="bg-gray-300">Close</x-button>
                </div>
            </div>
        </x-modal>
    @endif

    {{-- Confirmation Modal for Enrollment --}}
    @if($confirmingEnrollment)
        <x-modal>
            <div class="p-6 bg-gray-200 text-black">
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
        allDropdowns.forEach(menu => menu.classList.add('hidden')); // Hide all dropdowns
        
        if (isVisible) {
            dropdownMenu.classList.remove('hidden'); // Show the clicked dropdown
        } else {
            dropdownMenu.classList.add('hidden');
        }
    }
</script>
