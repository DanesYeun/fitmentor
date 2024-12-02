<nav x-data="{ open: false }" class="bg-sky-400 border-b border-gray-100 shadow-md">
    <!-- Primary Navigation Menu -->
    <div class="ml-5 mr-5">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="shrink-0 flex items-center text-black">
                    <i class="fas fa-bars text-2xl mr-4 cursor-pointer hidden sm:block" onclick="toggleMenu()"></i>
                    <div class="shrink-0 flex items-center">
                        <img src="{{ asset ('bg1.png') }}" class="block h-12 w-auto" alt="">
                    </div>
                    <span class="text-xl font-semibold">Fit Mentor</span>

                </div>

                <!-- Navigation Links -->
                <div class="hidden sm:-my-px sm:ms-10 sm:flex">
                    <script>
                        function toggleMenu() {
                           var menu = document.getElementById("mobile-menu");
                           menu.classList.toggle("-translate-x-full"); // Slide it in/out
                           menu.classList.toggle("translate-x-0");
                           menu.classList.toggle("translate-y-0"); // Show it
                        }
                    </script>

                    <div id="mobile-menu" class="fixed top-16 left-0 w-64 h-full bg-sky-300 shadow-md transform -translate-x-full transition-transform duration-300 z-50">
                        <ul class="p-4 ml-10">
                            @if (auth()->user()->role == 'admin')
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" wire:navigate>
                                        {{ __('Dashboard') }}
                                    </x-responsive-nav-link>
                                </li>

                                <li x-data="{ open: false }" class="py-2">
                                    <button @click="open = !open" class="flex items-center justify-between w-full">
                                        <span class="text-black ml-3">{{ __('Users') }}</span>
                                        <svg x-show="!open" class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        <svg x-show="open" class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7-7-7 7"></path>
                                        </svg>
                                    </button>

                                        <ul x-show="open" x-cloak class="ml-4 mt-2 space-y-2">
                                            <li class="py-2">
                                                <x-responsive-nav-link href="{{ route('staff-manager') }}" :active="request()->routeIs('staff-manager')" wire:navigate>
                                                    {{ __('Staff') }}
                                                </x-responsive-nav-link>
                                            </li>
                                            <li class="py-2">
                                                <x-responsive-nav-link href="{{ route('instructor-manager') }}" :active="request()->routeIs('instructor-manager')" wire:navigate>
                                                    {{ __('Instructors') }}
                                                </x-responsive-nav-link>
                                            </li>
                                            <li class="py-2">
                                                <x-responsive-nav-link href="{{ route('student-manager') }}" :active="request()->routeIs('student-manager')" wire:navigate>
                                                    {{ __('Students') }}
                                                </x-responsive-nav-link>
                                            </li>
                                        </ul>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('records')}}" :active="request()->routeIs('records')" wire:navigate>
                                        {{ __('Enrolment Records') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('admin-program') }}" :active="request()->routeIs('admin-program')" wire:navigate>
                                        {{ __('Programs') }}
                                    </x-responsive-nav-link>
                                </li>
                            @elseif(auth()->user()->role == 'staff')
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" wire:navigate>
                                        {{ __('Dashboard') }}
                                    </x-responsive-nav-link>
                                </li>
                                {{-- <li class="py-2">
                                    <x-responsive-nav-link href="{{ route ('staff-profiling')}}" :active="request()->routeIs('profiling')" wire:navigate>
                                        {{ __('Profile') }}
                                    </x-responsive-nav-link>
                                </li> --}}
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('staff-program') }}" :active="request()->routeIs('staff-program')" wire:navigate>
                                        {{ __('Manage Program') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('exercise') }}" :active="request()->routeIs('exercise')" wire:navigate>
                                        {{ __('Manage Exercise') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('focus-area') }}" :active="request()->routeIs('focus-area')" wire:navigate>
                                        {{ __('Manage Focus Area') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('records')}}" :active="request()->routeIs('records')" wire:navigate>
                                        {{ __('Enrollment Records') }}
                                    </x-responsive-nav-link>
                                </li>
                            @elseif(auth()->user()->role == 'instructor')
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" wire:navigate>
                                        {{ __('Dashboard') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route ('instructor-profiling')}}" :active="request()->routeIs('profiling')" wire:navigate>
                                        {{ __('Profile') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li x-data="{ open: false }" class="py-2">
                                    <button @click="open = !open" class="flex items-center justify-between w-full">
                                        <span class="text-black ml-3">{{ __('Classes') }}</span>
                                        <svg x-show="!open" class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                        </svg>
                                        <svg x-show="open" class="w-4 h-4 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 15l-7-7-7 7"></path>
                                        </svg>
                                    </button>

                                        <ul x-show="open" x-cloak class="ml-4 mt-2 space-y-2">
                                            <li class="py-2">
                                                <x-responsive-nav-link href="{{ route('available') }}" :active="request()->routeIs('available')" wire:navigate>
                                                    {{ __('Available') }}
                                                </x-responsive-nav-link>
                                            </li>
                                            <li class="py-2">
                                                <x-responsive-nav-link href="{{ route('approved') }}" :active="request()->routeIs('approved')" wire:navigate>
                                                    {{ __('Approved') }}
                                                </x-responsive-nav-link>
                                            </li>
                                            <li class="py-2">
                                                <x-responsive-nav-link href="{{ route('pending') }}" :active="request()->routeIs('pending')" wire:navigate>
                                                    {{ __('Pending') }}
                                                </x-responsive-nav-link>
                                            </li>
                                        </ul>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route ('instructor-schedule')}}" :active="request()->routeIs('instructor-schedule')" wire:navigate>
                                        {{ __('Schedule') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route ('instructor-students-progress')}}" :active="request()->routeIs('instructor-students-progress')" wire:navigate>
                                        {{ __('Progress') }}
                                    </x-responsive-nav-link>
                                </li>

                            @elseif(auth()->user()->role == 'student')
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')" wire:navigate>
                                        {{ __('Dashboard') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route ('profiling')}}" :active="request()->routeIs('profiling')" wire:navigate>
                                        {{ __('Personal Information') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route ('recommend')}}" :active="request()->routeIs('recommend')" wire:navigate>
                                        {{ __('Available Classes') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route ('student-program')}}" :active="request()->routeIs('student-program')" wire:navigate>
                                        {{ __('View Classes') }}
                                    </x-responsive-nav-link>
                                </li>
                                <li class="py-2">
                                    <x-responsive-nav-link href="{{ route('student-progress') }}" :active="request()->routeIs('student-progress')" wire:navigate>
                                        {{ __('Progress') }}
                                    </x-responsive-nav-link>
                                </li>
                            @endif
                        </ul> 
                    </div>

                </div>
                    
            </div>



                <div class="hidden sm:flex sm:items-center sm:ms-6" x-data="{ openTeamDropdown: false, openSettingsDropdown: false }">
    <!-- Settings Dropdown -->
    <div class="ms-3 relative">
        <button @click="openSettingsDropdown = !openSettingsDropdown" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-sky-300 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
            @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <img class="h-8 w-8 rounded-full object-cover" src="{{ asset(Auth::user()->profile_photo_url) }}"
     alt="{{ Auth::user()->name }}" />
            @else
                {{ Auth::user()->firstname }} {{ Auth::user()->middlename }} {{ Auth::user()->lastname }}
            @endif
            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
            </svg>
        </button>

        <!-- Settings Dropdown Content -->
        <div x-show="openSettingsDropdown" @click.away="openSettingsDropdown = false" class="absolute z-50 mt-2 -ml-24 w-48 bg-white shadow-lg rounded-md py-1">
            <!-- Account Management -->
            <div class="block px-4 py-2 text-xs text-gray-400">
                {{ __('Manage Account') }}
            </div>
            <x-dropdown-link href="{{ route('profile.show') }}" wire:navigate>
                {{ __('Profile') }}
            </x-dropdown-link>
            @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                <x-dropdown-link href="{{ route('api-tokens.index') }}">
                    {{ __('API Tokens') }}
                </x-dropdown-link>
            @endif
            <div class="border-t border-gray-200"></div>
            <!-- Authentication -->
            <form method="POST" action="{{ route('logout') }}" x-data>
                @csrf
                <x-dropdown-link href="{{ route('logout') }}" @click.prevent="$root.submit();">
                    {{ __('Log Out') }}
                </x-dropdown-link>
            </form>
        </div>
    </div>
            </div>

            

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 me-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                   @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
