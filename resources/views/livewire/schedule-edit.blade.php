<div> 
    @if (session()->has('success'))
        <div class="p-4 bg-green-100 border border-green-200 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center">
            {{ session('success') }}
        </div>
    @endif
    <div class="text-black mt-5 ml-20">
        <a href="javascript:history.back()"><i class="fa-solid fa-rotate-left">Back</i></a>
    </div>
    <form wire:submit.prevent="updateSchedule" enctype="multipart/form-data" class="bg-sky-300 mt-5 mx-auto w-4/6 p-5 shadow-md rounded-lg">
        @csrf
        <div class="grid grid-cols-2">
            <div>
                <p class="text-lg font-bold">Program: {{ $program }}</p>
                <p class="text-lg">Goal: {{$goal}}</p>
                <p class="text-lg">Focus Area: {{ $focus }}</p>
                <p class="text-lg">Instructor: {{$instructor}}</p>
                <p class="text-lg">Student: {{$student ?? ''}}</p>
            </div>
        </div>

        <div class="mt-4">
            <label class="text-lg font-bold">Exercises:</label>
            <table class="w-full mt-2 border border-black">
                <thead>
                    <tr>
                        <th class="border border-black p-2 text-center">Exercise</th>
                        <th class="border border-black p-2 text-center">Preparation</th>
                        <th class="border border-black p-2 text-center">Execution</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($exercises as $exercise)
                        @if($exercise->schedule_id === $schedule->id)
                            <tr>
                                <td class="border border-black p-2 text-center">
                                    {{$exercise->exercise->name}}
                                </td>
                                <td class="border border-black p-2 text-center">
                                    {{ $exercise->exercise->preparation }}
                                </td>
                                <td class="border border-black p-2 text-center">
                                    {{ $exercise->exercise->execution }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            <label class="text-lg font-bold">Schedule:</label>
            <table class="w-full mt-2 border border-black">
                <thead>
                    <tr>
                        <th class="border border-black p-2 text-center">Day</th>
                        <th class="border border-black p-2 text-center">Start</th>
                        <th class="border border-black p-2 text-center">End</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach (['sunday', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday'] as $day)
                        @if($schedule->{$day.'_start'} || $schedule->{$day.'_end'})
                            <tr>
                                <td class="border border-black p-2 text-center capitalize">{{ $day }}</td>
                                <td class="border border-black p-2 text-center">
                                    <input type="time" wire:model="{{ $day }}_start" name="{{ $day }}_start" class="w-full p-2 border rounded">
                                </td>
                                <td class="border border-black p-2 text-center">
                                    <input type="time" wire:model="{{ $day }}_end" name="{{ $day }}_end" class="w-full p-2 border rounded">
                                </td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Submit Button -->
        <div class="mt-6 flex justify-center">
            <x-button class="bg-blue-900 shadow-lg px-6 py-2">{{ $schedule->id ? 'Update' : 'Submit' }}</x-button>
        </div>
    </form>
</div>
