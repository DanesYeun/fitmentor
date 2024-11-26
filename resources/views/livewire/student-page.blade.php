<div class="sm:m-8 lg:m-3 rounded grid grid-cols-1 sm:grid-cols-3 gap-4 flex justify-center text-black">
    @if(!$profile)
    <div class="mx-auto w-3/4 flex items-center">
        <h1>Set your Profile first</h1>
    </div>
    @else
  @foreach($recommends as $recommend)
        <div class="flex justify-center mt-5 mb-5">
            <div class="w-80 h-48 rounded overflow-hidden shadow-lg bg-sky-200 p-3">
              <div class="flex justify-center">
              <span class="font-xl text-xl font-bold uppercase"><strong>{{$recommend->program}}</strong></span>
              </div>
              <div class="mt-2">
              <p><strong>Goal: {{$recommend->goal}}</strong></p>
              <p><strong>Level: {{$recommend->level}}</strong></p>
              <p><strong>Instructor: {{$recommend->user->name}}</strong></p>
              <p><strong>Expertise: {{ucwords($recommend->user->expertise)}}</strong></p>
              </div>
              <div class="mx-auto w-1/2 flex items-center gap-2 mt-2">
                <x-button class="bg-sky-500 shadow-lg" wire:click="viewRecommend ({{$recommend->id}})">View</x-button>
                <x-button class="bg-sky-500 shadow-lg" wire:click="enrollConfirm({{ $recommend->id }})">Enroll</x-button>
              </div>                  
            </div>
        </div>
  @endforeach
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




