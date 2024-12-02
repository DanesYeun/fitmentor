<div class="p-10">
    <h1 class="lg:m-3 font-xl text-xl font-bold uppercase">Progress Tracker</h1>

    @foreach ($classes as $class)
        <div class="lg:m-3 rounded grid grid-cols-1 flex justify-center text-black gap-2 p-4 border">
            <div class="mx-auto w-full grid grid-cols-2 flex items-center justify-between">
                <div>
                    <h1 class="font-bold uppercase">Program: {{ $class->program }}</h1>
                    <span> Goal: {{ $class->goal }}</span>
                    <h5>Level: {{ $class->level }}</h5>
                    <h3>Instructor: {{ $class->user->name }}</h3>
                </div>

                <div class="px-2">
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

                        <!-- Slider for Updating Progress -->
                        <input 
                            type="range" 
                            min="0" 
                            max="100" 
                            step="1" 
                            wire:model="progressValues.{{ $class->id }}" 
                            class="w-full mt-2"
                            wire:change="updateProgress({{ $class->id }})"
                        />
                    </div>

                    <!-- Remarks Text Area -->
                    <div class="mt-4">
                        <label for="remarks-{{ $class->id }}" class="block text-xs font-semibold uppercase mb-2">
                            Remarks
                        </label>
                        <textarea 
                            id="remarks-{{ $class->id }}" 
                            rows="3" 
                            wire:model="remarks.{{ $class->id }}" 
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-teal-500"
                            placeholder="Add your remarks here..."
                            wire:change="updateRemarks({{ $class->id }})"
                        ></textarea>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
