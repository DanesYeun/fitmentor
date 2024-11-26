<nav class="bg-transparent border-gray-200 dark:bg-transparent">
  <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
    <div class="inline-flex">
    <img class="w-15 h-15" src="{{ asset('bg1.png') }}">
    <p class="mt-10 text-white text-xl font-bold hidden w-full md:block md:w-auto" id="navbar-default"><span class="text-orange-500">Fit Mentor</span> : Personalized Virtual Gym Assistant</p>
    </div>
    <button id="hamburger-button" data-collapse-toggle="navbar-default" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="navbar-default" aria-expanded="false">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
        </svg>
    </button>

    <div class="hidden w-full md:block md:w-auto" id="navbar-default">
      <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-transparent md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-transparent dark:bg-transparent md:dark:bg-transparent dark:border-gray-700">
        <li>
          <a href="{{ route ('home') }}" class="block py-2 px-3 text-white bg-transparent rounded md:bg-transparent md:text-blue-700 md:p-0 dark:text-white md:dark:text-blue-500" aria-current="page" wire:navigate>Home</a>
        </li>
        <li>
          <a href="{{route('login')}}" class="block py-2 px-3 text-white rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent" wire:navigate>Sign In</a>
        </li>
        <li>
          <a href="{{route('register')}}" class="block py-2 px-3 text-orange-600 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-orange-500 md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent animate-bounce" wire:navigate>Sign Up</a>
        </li>
      </ul>
    </div>
    <div id="mobile-menu"  class="top-20 justify-center absolute hidden w-full origin-top animate-open-menu flex-col bg-black text-xl  z-50">
    <nav class="flex min-h-screen flex-col items-center py-8" aria-label="mobile">
        <a href="{{route('home')}}" class="w-full py-6 text-center text-blue-300 hover:text-blue-700">Home</a>
        <a href="{{route('login')}}" class="w-full py-6 text-center text-blue-300 hover:text-blue-700">Sign In</a>
        <a href="{{route('register')}}" class="w-full py-6 text-center text-blue-300 hover:text-blue-700">Sign Up</a>
      </nav>
    </div>
  </div>
</nav>
<script>
  const initApp = () => {
    const hamburgerBtn = document.getElementById('hamburger-button')
    const mobileMenu = document.getElementById('mobile-menu')

    const toggleMenu = () => {
        mobileMenu.classList.toggle('hidden')
        mobileMenu.classList.toggle('flex')
        hamburgerBtn.classList.toggle('toggle-btn')
    }

    hamburgerBtn.addEventListener('click', toggleMenu)
    mobileMenu.addEventListener('click', toggleMenu)
}

document.addEventListener('DOMContentLoaded', initApp)
</script>