<div class="w-full">
    @if (session()->has('message'))
        <div class="p-4 bg-green-500 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center mx-auto w-1/3">
            {{ session('message') }}
        </div>
    @endif
        @if($showDeleteModal)
                <x-modal>
                    <div class="p-6 bg-gray-200 text-black">
                        <h2 class="text-lg font-semibold mb-4">Are you sure you want to delete this program?</h2>
                        <p class="mb-6">This action cannot be undone.</p>

                        <div class="flex justify-end">
                            <x-button wire:click="$set('showDeleteModal', false)" class="bg-gray-300 mr-2">Cancel</x-button>
                            <x-button wire:click="deleteprogram" class="bg-red-600 text-white">Delete</x-button>
                        </div>
                    </div>
                </x-modal>
        @endif
    <div class="w-3/4 flex justify-between mx-auto mt-10">
        <div>
            <span class="text-black">Show</span>
            <select wire:model.live="page" class="text-black bg-gray-300 w-16 h-10">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
            <span class="text-black">entries</span>
        </div>
        <div>
            <a href="{{ route ('program-maker') }}"><x-button class="bg-gray-400"><i class="fa-solid fa-plus"></i>Add Program</x-button></a>
        </div>
    </div>

    <div class="w-full flex justify-end">
        <div class="w-1/3 mr-5">   
            <x-input type="search" autofocus wire:model.live.debounce.1000ms="search" class="w-full md:w-3/4 lg:w-2/3 text-black mt-10 mb-3 focus:border-gray-400 bg-gray-300" placeholder="Search here ..."/>
        </div>
    </div>

    <div class="overflow-x-auto">
    <div class="w-3/4 mx-auto rounded-lg bg-gray-300 p-2 mb-10">
    <table class="w-full mx-auto rounded-lg">
            <thead>
                <tr class="bg-gray-200 text-black rounded-lg">
                    <th class="py-2 w-64">Program Name</th>
                    <th class="py-2 w-64">Goal</th>
                    <th class="py-2 w-64">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($programs as $program)
                <tr class="bg-gray-100 text-black rounded-lg">
                    <th class="py-2">{{$program->name}}</th>
                    <th class="py-2">{{$program->goal}}</th>
                    <th class="py-2">
                        <div class="inline-block text-left">
                            <button id="dropdownButton-{{ $program->id }}" class="text-white bg-gray-700 hover:bg-gray-800 focus:ring-4 focus:outline-none focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center" onclick="toggleDropdown({{ $program->id }})">
                                <svg class="w-5 h-5" aria-hidden="true" fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M6 10a2 2 0 11-4 0 2 2 0 014 0zM12 10a2 2 0 11-4 0 2 2 0 014 0zM16 12a2 2 0 100-4 2 2 0 000 4z" />
                                </svg>
                            </button>
                            <div id="dropdownMenu-{{ $program->id }}" class="z-10 hidden bg-white rounded-lg shadow dark:bg-gray-700 absolute transform -translate-x-1/3 mt-2">
                                <div class="bg-gray-300 p-3">
                                    <x-button class="bg-gray-500 shadow-lg" wire:click="viewProgram ({{$program->id}})">View</x-button>
                                    <x-button class="bg-gray-500 shadow-lg" onclick="window.location='{{ route('program.edit', $program->id) }}'">Edit</x-button>
                                    <x-button class="bg-gray-500 shadow-lg" wire:click="confirmDelete({{ $program->id }})">Delete</x-button>
                                </div>
                            </div>
                        </div>
                    </th>
                </tr>
                @endforeach
            </tbody>
                <tr>
                    <th colspan="4" class="pagination-links text-black bg-gray-300 mt-3 rounded-lg">
                        {{ $programs->links() }}
                    </th>
                </tr>
        </table>
    </div>
        @if($showModal)
                <x-modal>
                    <div class="w-full mx-auto p-5 bg-gray-100 rounded-lg shadow-lg text-black">
                        <div class="mx-auto w-1/3">
                            <h1 class="text-xl font-bold mb-5">Program Details</h1>
                        </div>
                        <div class="mt-5">
                            <p><strong>Name:</strong> {{ $program->name }}</p>
                            <p><strong>Goal:</strong> {{ $program->goal }}</p>
                        </div>

                        <div class="flex justify-end mt-4">
                            <x-button wire:click="refreshPage" class="bg-gray-300">Close</x-button>
                        </div>

                    </div>
                </x-modal>
        @endif
    </div>
</div>

<script>
    function toggleDropdown(programId) {
        const dropdownMenu = document.getElementById(`dropdownMenu-${programId}`);
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
