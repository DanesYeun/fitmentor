<x-guest-layout>
    <div class="bg-center bg-cover bg-no-repeat" style="background-image: url('{{ asset('bg.jpg') }}');">
        <x-home-nav/>
            
       <!-- Hero Section -->
        <div class="flex flex-col items-center justify-center text-xl bg-center bg-no-repeat bg-cover rounded-full shadow-lg mx-4 sm:mx-8 md:mx-16 lg:mx-72" style="background-image: url('{{ asset('stronger.jpg') }}'); height: 60vh;">
            <div class="bg-gray-300 rounded shadow-lg p-4 md:p-6" style="max-height: 20vh; min-height: 10vh;">
                <p class="text-xl sm:text-2xl md:text-3xl lg:text-4xl font-serif text-center text-clip overflow-hidden">
                    It never gets <span class="text-orange-700 font-bold line-through"> EASIER</span>. You just get <span class="text-orange-700 font-bold underline">STRONGER</span>.
                </p>
            </div>
        </div>


       <!-- Information Section -->
        <div class="bg-gray-500 shadow-small rounded-full mx-4 sm:mx-8 md:mx-16 lg:mx-72 -mt-24 p-4 sm:p-6 md:p-8 lg:p-10" style="height: auto; min-height: 21vh;">
            <span class="block text-xl sm:text-2xl md:text-3xl lg:text-xl overflow-hidden text-clip">
                Together, we can make health a reality. 
                That's why we provide individualized coaching in the gym as well as the tools you need to stay on track while on the go. 
                Our pleasant and skilled Coaches are trained to assist you with your fitness journey, no matter where it leads you.
            </span>
            <p class="mt-3 text-xl sm:text-2xl md:text-3xl lg:text-xl">
                Push harder than yesterday if you want a different tomorrow.
            </p>
        </div>


        <!-- Services and Image Section -->
        <div class="m-4 sm:m-8 lg:m-20 border-4 border-gray-700 rounded grid grid-cols-1 sm:grid-cols-2 gap-4 bg-gray-500" style="height: auto">
            <div class="m-4 sm:m-10 bg-no-repeat bg-cover flex flex-col items-center">
                <span class="text-orange-700 font-bold text-2xl sm:text-3xl flex justify-center animate-pulse mb-4 sm:mb-5">SERVICES</span>
                <p class="text-base sm:text-lg text-justify px-4 sm:px-0">Understanding the needs of our members is essential before recommending our services. If a member is new to exercise, we offer a personal training session to get them started. Alternatively, if a member wants to reduce weight, we recommend a group exercise session tailored to their body objectives. By taking the time to understand the members' requirements, we can establish confidence and support with them. This increases their likelihood of listening to our advice and purchasing the gym services that are best suited to them.</p>
            </div>
            <div class="flex justify-center items-center">
                <img src="{{ asset('pciture4.avif') }}" class="w-full rounded-full border-4 border-gray-900" alt="">
            </div>
        </div>
        <!-- Footer -->
        <div class="mt-48 flex justify-center">
            <p><span class="text-orange-700">FIT MENTOR</span>© 2024 All rights reserved.</p>
        </div>

    </div>
</x-guest-layout>
