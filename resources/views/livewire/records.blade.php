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
                    <th class="py-2 w-64">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($schedules as $schedule)
                <tr class="bg-sky-100 text-black rounded-lg">
                    <th class="py-2">{{ $schedule->student->name }}</th>
                    <th class="py-2">{{ $schedule->program }}</th>
                    <th class="py-2">{{ $schedule->user->name }}</th>
                    <th class="py-2">
                        <x-button wire:click="viewUser({{ $schedule->id }})">View</x-button>
                    </th>
                </tr>
                @endforeach
            </tbody>
        </table>
        @if($showModal)
            <x-modal>
                <div class="p-6 bg-blue-200 text-black">
                    <p><strong>Name:</strong> {{ $selectedSchedule->student->name }}</p>
                    <p><strong>Enrolled Program:</strong> {{ $selectedSchedule->program }}</p>
                    <p><strong>Goal:</strong> {{ $selectedSchedule->goal }}</p>
                    <p><strong>Types of Exercises:</strong></p>
                        @foreach ($exercises as $exercise)
                            @if($exercise->schedule_id === $schedule->id)
                                <p>{{ $exercise->program->name }}</p>
                            @endif
                        @endforeach
                    <p><strong>Instructor:</strong> {{ $selectedSchedule->user->name }}</p>
                    <div class="flex justify-end mt-4">
                        <x-button wire:click="refreshPage" class="bg-gray-300">Close</x-button>
                    </div>
                </div>
            </x-modal>
        @endif
    </div>
    </div>
</div>