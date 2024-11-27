<div class="p-10">
    <h1 class="lg:m-3 font-xl text-xl font-bold uppercase">Progress Tracker</h1>
    @foreach ($classes->where('status', 'Approved') as $class)
        <div class="lg:m-3 rounded grid grid-cols-1 flex justify-center text-black gap-2 p-4 border">
            <div class="mx-auto w-full grid grid-cols-2 flex items-center justify-between">
                <div class="">
                    <h1 class="font-bold uppercase">Program: {{ $class->program}}</h1>
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
                                    {{ $class->progressing }}%
                                </span>
                            </div>
                        </div>

                        <!-- Progress Bar Container -->
                        <div class="flex mb-2">
                            <div class="w-full bg-gray-300 rounded-full h-2">
                                <!-- Dynamic Progress Bar -->
                                <div class="bg-sky-500 h-2 rounded-full" style="width: {{ $class->progressing }}%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
