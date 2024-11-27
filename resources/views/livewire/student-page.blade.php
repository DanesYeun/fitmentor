<div class="sm:m-8 lg:m-3 rounded grid grid-cols-1 sm:grid-cols-2 flex justify-center text-black gap-2">
    @if(!$profile)
        <div class="mx-auto w-full flex items-center justify-between">
            <h1>Set your Profile first</h1>
            <a href="{{ route('profiling') }}">
                <x-button class="bg-sky-500 shadow-lg">Edit Profile</x-button>
            </a>
        </div>
    @else
        {{-- Recommended Classes Section --}}
        @if (!$recommends->isEmpty())
            <h1 class="font-xl text-xl font-bold uppercase sm:col-span-2">Matched Classes</h1>
            <span class="font-sm text-sm text-red-700 sm:col-span-2">Matched program/s based on your data.</span>
            @foreach($recommends->where('goal', $profile->goal) as $recommend)           
                <div class="flex justify-center mt-2 mb-5">
                    <div class="w-full rounded overflow-hidden shadow-lg bg-sky-200 p-3">
                    <div class="flex justify-center">
                        <span class="font-xl text-xl font-bold uppercase"><strong>{{$recommend->program}}</strong></span>
                    </div>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="">
                            <p><strong>Goal: {{$recommend->goal}}</strong></p>
                            <p><strong>Level: {{$recommend->level}}</strong></p>
                            <p><strong>Instructor: {{$recommend->user->name}}</strong></p>
                            <p><strong>Focus Area/s: <br>
                            @foreach($recommend->program_schedule as $program_schedule)
                                {{ $program_schedule->focus_area->name }}
                                @if (!$loop->last), @endif
                            @endforeach
                            </strong></p>
                        </div>
                        <div class="flex gap-2 justify-end py-10 px-2">
                            <x-button class="bg-sky-500 shadow-lg h-10" wire:click="viewRecommend ({{$recommend->id}})">View</x-button>
                            <x-button class="bg-sky-500 shadow-lg h-10" wire:click="enrollConfirm({{ $recommend->id }})">Enroll</x-button>
                        </div>  
                    </div>                
                    </div>
                </div>
            @endforeach
        @endif

        {{-- Suggested Classes Section --}}
        @if (!$suggestions->isEmpty())
            <h1 class="font-xl text-xl font-bold uppercase sm:col-span-2 mt-10">Recommended Classes</h1>
            <span class="font-sm text-sm text-red-700 sm:col-span-2">Classes shown below are based on your preferences and activity.</span>
            @foreach($suggestions as $suggestion)
                <div class="flex justify-center mt-2 mb-5">
                    <div class="w-full rounded overflow-hidden shadow-lg bg-sky-200 p-3">
                    <div class="flex justify-center">
                        <span class="font-xl text-xl font-bold uppercase"><strong>{{$suggestion->program}}</strong></span>
                    </div>
                    <div class="mt-2 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div class="">
                            <p><strong>Goal: {{$suggestion->goal}}</strong></p>
                            <p><strong>Level: {{$suggestion->level}}</strong></p>
                            <p><strong>Instructor: {{$suggestion->user->name}}</strong></p>
                            <p><strong>Focus Area/s: <br>
                                @foreach($suggestion->program_schedule as $program_schedule)
                                    {{ $program_schedule->focus_area->name }}
                                    @if (!$loop->last), @endif
                                @endforeach
                            </strong></p>
                        </div>
                        <div class="flex gap-2 justify-end py-10 px-2">
                            <x-button class="bg-sky-500 shadow-lg h-10" wire:click="viewRecommend ({{$suggestion->id}})">View</x-button>
                            <x-button class="bg-sky-500 shadow-lg h-10" wire:click="enrollConfirm({{ $suggestion->id }})">Enroll</x-button>
                        </div>  
                    </div>                
                    </div>
                </div>
            @endforeach
        @endif
    @endif

    {{-- Modal for Recommended or Suggested --}}
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
        allDropdowns.forEach(menu => menu.classList.add('hidden')); // Hide all dropdowns
        
        if (isVisible) {
            dropdownMenu.classList.remove('hidden'); // Show the clicked dropdown
        } else {
            dropdownMenu.classList.add('hidden');
        }
    }
</script>
