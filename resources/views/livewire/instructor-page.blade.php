<div class="bg-transparent py-8">
    <div class="sm:m-8 lg:m-3 rounded grid grid-cols-1 sm:grid-cols-4 gap-4 flex justify-center">
        <div class="flex justify-center">
            <div class="w-80 h-48 rounded overflow-hidden shadow-lg bg-gray-50"> <!-- Set fixed width and height -->
              <div class="px-6 py-4">
                <div class="font-bold text-black text-xl mb-2">Total number of Programs</div>
                <p class="text-black text-base font-bold text-5xl text-center mt-8">
                    {{ $totals }}
                </p>
                <div class="flex justify-end">
                </div>
              </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="w-80 h-48 rounded overflow-hidden shadow-lg bg-gray-50"> <!-- Set fixed width and height -->
              <div class="px-6 py-4">
                <div class="font-bold text-black text-xl mb-2">Number of Available Schedules</div>
                <p class="text-black text-base font-bold text-5xl font-3xl text-center mt-8">
                  {{$availables}}
                </p>
                <div class="flex justify-end">
                  <a href="{{ route ('available') }}" wire:navigate><x-button class="mt-5 hover:bg-red-950 bg-red-900">Manage</x-button></a>
                </div>
              </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="w-80 h-48 rounded overflow-hidden shadow-lg bg-gray-50"> <!-- Set fixed width and height -->
              <div class="px-6 py-4">
                <div class="font-bold text-black text-xl mb-2">Number of Approved Enrollments</div>
                <p class="text-black text-base font-bold text-5xl font-3xl text-center mt-8">
                  {{$approves}} 
                </p>
                <div class="flex justify-end">
                <a href="{{ route ('approved') }}" wire:navigate><x-button class="mt-5 hover:bg-red-950 bg-red-900">Manage</x-button></a>
                </div>
              </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="w-80 h-48 rounded overflow-hidden shadow-lg @if(!$pendings)bg-gray-50 @else bg-gray-600 animate-pulse @endif"> <!-- Set fixed width and height -->
              <div class="px-6 py-4">
                <div class="font-bold text-black text-xl mb-2">Number of Pending Enrollments</div>
                <p class="text-black text-base font-bold text-5xl font-3xl text-center mt-8">
                  {{$pendings}} 
                </p>
                <div class="flex justify-end">
                  <a href="{{route('pending')}}" wire:navigate><x-button class="mt-5 hover:bg-red-950 bg-red-900">Manage</x-button></a>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>
