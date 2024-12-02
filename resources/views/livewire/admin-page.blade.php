<div class="bg-gray-200 py-8">
    <div class="sm:m-8 lg:m-3 rounded grid grid-cols-1 sm:grid-cols-3 gap-4 flex justify-center">
        <div class="flex justify-center">
            <div class="max-w-sm rounded overflow-hidden shadow-lg bg-gray-50">
              <img class="w-1/2 mx-auto mt-5" src="{{ asset('staff.png') }}" alt="instructor">
              <div class="px-6 py-4">
                <div class="font-bold text-black text-xl mb-2">Staffs</div>
                <p class="text-black text-base">
                  Number of Staff: {{$staffs}}
                </p>
                <div class="flex justify-end">
                  <a href="{{ route ('staff-manager') }}" wire:navigate><x-button class="mt-5 text-black bg-rose-900 hover:bg-rose-950" >Manage</x-button></a>
                </div>
              </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="max-w-sm rounded overflow-hidden shadow-lg bg-gray-50">
              <img class="w-1/2 mx-auto mt-5" src="{{ asset('instructor.png') }}" alt="instructor">
              <div class="px-6 py-4">
                <div class="font-bold text-black text-xl mb-2">Instructors</div>
                <p class="text-black text-base">
                  Number of Active Instructors: {{$instructors}}
                </p>
                <div class="flex justify-end">
                  <a href="{{ route ('instructor-manager') }}" wire:navigate><x-button class="mt-5 text-black bg-rose-900 hover:bg-rose-950" >Manage</x-button></a>
                </div>
              </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="max-w-sm rounded overflow-hidden shadow-lg bg-gray-50">
              <img class="w-1/2 mx-auto mt-5" src="{{ asset('trainee.png') }}" alt="instructor">
              <div class="px-6 py-4">
                <div class="font-bold text-black text-xl mb-2">Trainees</div>
                <p class="text-black text-base">
                  Number of Active Members: {{$trainees}}
                </p>
                <div class="flex justify-end">
                  <a href="{{ route ('student-manager') }}" wire:navigate><x-button class="mt-5 text-black bg-rose-900 hover:bg-rose-950" >Manage</x-button></a>
                </div>
              </div>
            </div>
        </div>
    </div>
</div>


