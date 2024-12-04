<div>
<div class="text-black mt-5 ml-20">
        <a href="javascript:history.back()"><i class="fa-solid fa-rotate-left">Back</i></a>
    </div>
<div class="md:col-row-1 lg:col-row-1 mt-20">
    @if (session()->has('message'))
        <div class="p-4 bg-green-500 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center mx-auto w-1/3">
            {{ session('message') }}
        </div>
    @endif
    @if (session()->has('message1'))
        <div class="p-4 bg-red-500 rounded-lg text-red-800 text-lg font-semibold shadow-md flex justify-center mx-auto w-2/3">
            {{ session('message1') }}
        </div>
    @endif
    @if (session()->has('error'))
        <div class="p-4 bg-red-500 rounded-lg text-red-800 text-lg font-semibold shadow-md flex justify-center mx-auto w-2/3">
            {{ session('error') }}
        </div>
    @endif
            <div class="items-center sm:pt-0 p-3 mx-auto w-3/4">
                <div class="w-full px-6 py-4 shadow-md sm:rounded-lg bg-gray-300">
                    <form wire:submit.prevent="createschedule" enctype="multipart/form-data">
                        @csrf
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="mt-4 w-full sm:w-1/3">
                                <select wire:model="program" class="mt-1.5 w-full text-black rounded-lg bg-gray-200 hover:border-black border-slate-300 inline-flex items-center justify-between" required>
                                    <option value="" selected>Select a Program</option>
                                    @foreach ($programs as $program)
                                        <option value="{{ $program->name }}">{{ $program->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="mt-4 w-full sm:w-1/3">
                                <select wire:model="goal" class="mt-1.5 w-full text-black rounded-lg bg-gray-200 hover:border-black border-slate-300 inline-flex items-center justify-between" required>
                                    <option class="inline-flex items-center justify-between" value="" selected>Select a Goal</option>
                                    <option value="Improve Fitness/Overall Health">Improve Fitness/Overall Health</option>
                                    <option value="Lose Weight">Lose Weight</option>
                                    <option value="Increase Strength">Increase Strength</option>
                                    <option value="Improve Endurance">Improve Endurance</option>
                                    <option value="Build Muscle Mass">Build Muscle Mass</option>
                                    <option value="Boost Cardiovascular Fitness">Boost Cardiovascular Fitness</option>
                                    <option value="Enhance Flexibility">Enhance Flexibility</option>   
                                </select>   
                            </div>
                            <div class="mt-4 w-full sm:w-1/3">
                                <div id="exercise-dropdown" class="relative mt-1.5">
                                    <button type="button" id="dropdown-toggle" class="bg-gray-200 text-black border border-slate-300 font-medium py-2 px-4 rounded-md inline-flex items-center justify-between w-full">
                                        @if (empty($selectedItems))
                                            <span>Select Exercise</span>
                                        @else
                                            <span>
                                                {{ implode(', ', array_map(function($id) use ($exercises) {
                                                    foreach ($exercises as $exercise) {
                                                        if ($exercise['id'] == $id) {
                                                            return $exercise['name'];
                                                        }
                                                    }
                                                    return '';
                                                }, $selectedItems)) }}
                                            </span>
                                        @endif

                                        <svg class="w-4 h-4" fill="none" stroke="gray" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                    </button>

                                    <div id="dropdown-menu" class="absolute w-full bg-gray-200 shadow-lg rounded-md z-10 hidden">
                                        <ul class="list-disc pl-5 max-h-60 overflow-auto">
                                            @foreach($exercises as $exercise)
                                                <li class="flex items-center p-2">
                                                    <input type="checkbox" wire:model="selectedItems" value="{{ $exercise['id'] }}" class="w-4 h-4 text-gray-600 bg-gray-100 border-gray-300 rounded focus:ring-gray-500">
                                                    <label for="exercise-{{ $exercise['id'] }}" class="ml-2 text-md font-medium text-black">
                                                        {{ $exercise['name'] }}
                                                    </label>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            {{-- focus area --}}
                            
                            {{-- <div class="mt-4 w-full sm:w-1/3">
                                <select wire:model="focus" class="mt-1.5 w-full text-black rounded-lg bg-gray-200 hover:border-black border-slate-300" required>
                                    <option value="" selected>Select Focus Area</option>
                                    @foreach($focusAreas as $focusArea)
                                        <option value="{{ $focusArea->id }}">{{ $focusArea->name }}</option>
                                    @endforeach
                                </select>   
                            </div> --}}

                            {{-- end of focus area --}}
                            <div class="mt-4 w-full sm:w-1/3">
                                <select wire:model="level" class="mt-1.5 w-full text-black rounded-lg bg-gray-200 hover:border-black border-slate-300" required>
                                    <option value="" selected>Select Level</option>
                                    <option value="Beginner">Beginner</option>
                                    <option value="Intermediate">Intermediate</option>
                                    <option value="Expert">Expert</option>
                                </select>   
                            </div>
                        </div>


                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="mt-4 w-full sm:w-1/2 bg-gray-200 shadow-lg p-2 rounded-lg">
                                <div class="text-center items-center">
                                    <span class="text-black">Sunday</span>
                                        <div class="flex justify-center gap-3">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="sunday_start">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="sunday_end">
                                        </div>
                                </div>
                            </div>
                            <div class="mt-4 w-full sm:w-1/2 bg-gray-200 shadow-lg p-2 rounded-lg">
                                <div class="text-center items-center">
                                    <span class="text-black">Monday</span>
                                        <div class="flex justify-center gap-3">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="monday_start">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="monday_end">
                                        </div>
                                </div>
                            </div>
                            <div class="mt-4 w-full sm:w-1/2 bg-gray-200 shadow-lg p-2 rounded-lg">
                                <div class="text-center items-center">
                                    <span class="text-black">Tuesday</span>
                                        <div class="flex justify-center gap-3">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="tuesday_start">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="tuesday_end">
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-4">
                            <div class="mt-4 w-full sm:w-1/2 bg-gray-200 shadow-lg p-2 rounded-lg">
                                <div class="text-center items-center">
                                    <span class="text-black">Wednesday</span>
                                        <div class="flex justify-center gap-3">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="wednesday_start">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="wednesday_end">
                                        </div>
                                </div>
                            </div>
                            <div class="mt-4 w-full sm:w-1/2 bg-gray-200 shadow-lg p-2 rounded-lg">
                                <div class="text-center items-center">
                                    <span class="text-black">Thursday</span>
                                        <div class="flex justify-center gap-3">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="thursday_start">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="thursday_end">
                                        </div>
                                </div>
                            </div>
                            <div class="mt-4 w-full sm:w-1/2 bg-gray-200 shadow-lg p-2 rounded-lg">
                                <div class="text-center items-center">
                                    <span class="text-black">Friday</span>
                                        <div class="flex justify-center gap-3">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="friday_start">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="friday_end">
                                        </div>
                                </div>
                            </div>
                            <div class="mt-4 w-full sm:w-1/2 bg-gray-200 shadow-lg p-2 rounded-lg">
                                <div class="text-center items-center">
                                    <span class="text-black">Saturday</span>
                                        <div class="flex justify-center gap-3">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="saturday_start">
                                            <input type="time" class="p-2 border rounded-lg text-black w-28" wire:model="saturday_end">
                                        </div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-center">
                            <div class="inline-flex mt-5 gap-3">
                                <div x-data="{ hover: false }" class="flex-1">
                                    <button 
                                        x-on:mouseover="hover = true" 
                                        x-on:mouseout="hover = false" 
                                        class="btn min-w-[10rem] min-h-[3rem] bg-green-600 font-medium text-black hover:bg-green-700 focus:bg-green-700 active:bg-primary-focus/90 rounded-full" 
                                        type="submit" 
                                        aria-label="Save changes"
                                        :class="{ 'bg-green-700': hover }">
                                            <i class="fa fa-save" aria-hidden="true"></i>
                                                <span x-show="hover" class="ml-2">Save</span>
                                    </button>
                                </div>
                                <div x-data="{ hover: false }" class="flex-1">
                                    <button 
                                        x-on:mouseover="hover = true" 
                                        x-on:mouseout="hover = false" 
                                        type="button" wire:click="resetPage" 
                                        class="btn min-w-[10rem] min-h-[3rem] bg-red-600 font-medium text-black hover:bg-red-700 focus:bg-red-700 active:bg-primary-focus/90 rounded-full">
                                            <i class="fa fa-refresh"></i>
                                                <span x-show="hover">Reset</span>
                                    </button>
                                </div>  
                            </div>
                        </div>
                </form>
            </div>
        </div>
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownToggle = document.getElementById('dropdown-toggle');
        const dropdownMenu = document.getElementById('dropdown-menu');

        dropdownToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            dropdownMenu.classList.toggle('hidden');
        });

        document.addEventListener('click', function (e) {
            if (!dropdownMenu.contains(e.target) && !dropdownToggle.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
            }
        });
    });
</script>
