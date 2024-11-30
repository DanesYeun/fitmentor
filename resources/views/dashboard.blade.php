<x-app-layout>
    <div class="py-12 bg-gra-200">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
       
            <div class="overflow-hidden bg-blue-950 p-5 shadow-xl sm:rounded-lg">
            @if(Auth::user()->role == "admin")
                @livewire('admin-page')
            @elseif(Auth::user()->role == "student")
                @livewire('student-page')
            @elseif(Auth::user()->role == 'instructor')
                @livewire('instructor-page')
            @elseif(Auth::user()->role == 'staff')
                @livewire('staff-page')
            @endif
            </div>
        </div>
    </div>
</x-app-layout>
