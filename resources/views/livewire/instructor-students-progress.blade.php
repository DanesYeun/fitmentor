<div class="p-10">
    @if (session()->has('message'))
        <div class="p-4 bg-green-500 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center mx-auto w-1/3">
            {{ session('message') }}
        </div>
    @endif
    <h1 class="lg:m-3 font-xl text-xl font-bold uppercase">Progress Tracker</h1>
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
                                        {{ $progressValues[$class->id] }}%
                                    </span>
                                </div>
                            </div>
                            <input 
                                type="range" 
                                min="0" 
                                max="100" 
                                step="1" 
                                wire:model="progressValues.{{ $class->id }}" 
                                class="w-96 mt-2"
                                wire:change="updateProgress({{ $class->id }})"
                                disabled
                            />
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
                                <th class="p-2">Action</th>
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
                                            <input 
                                                type="text" 
                                                wire:model="remarks.{{ $class->id }}.{{ $day }}" 
                                                class="border border-gray-300 rounded-md p-1 w-full"
                                                placeholder="Add remarks..."
                                                value="{{ $remark ? $remark->remarks : '' }}"
                                                wire:blur="updateRemarks('{{ $class->id }}', '{{ $day }}')"
                                            />
                                        </td>
                                        <td class="p-2">
                                            @if ($class->{$day} === 0)
                                                <button 
                                                    class="bg-gray-500 hover:bg-gray-700 text-white text-sm font-bold py-1 px-3 rounded"
                                                    wire:click="markAsDone('{{ $class->id }}', '{{ $day }}')"
                                                >
                                                    Done
                                                </button>
                                            @else
                                                <button 
                                                    class="bg-red-500 hover:bg-red-700 text-white text-sm font-bold py-1 px-3 rounded"
                                                    wire:click="markAsCancelled('{{ $class->id }}', '{{ $day }}')"
                                                >
                                                    Revert
                                                </button>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        Livewire.on('refreshPage', () => {
            window.location.reload();
        });
    });
</script>
