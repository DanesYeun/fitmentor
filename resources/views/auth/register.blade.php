<x-guest-layout>
    <div class="bg-center bg-cover bg-no-repeat" style="background-image: url('{{ asset('bg.jpg') }}');">
        <x-home-nav/>
    <!-- Main Content -->
        <div class="flex flex-col items-center justify-center min-h-screen -mt-12 bg-transparent"> 
            <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" class="w-full max-w-lg p-8 bg-orange-100 shadow-md rounded-lg">
            @csrf
            <!-- Profile Picture -->
            <div class="mt-4">
                <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" class="block mt-1 w-full" accept="image/*" />
                <x-input-error for="profile_picture" class="mt-2" />

                <!-- Preview Image -->
                <div class="mt-4">
                    <img id="profile_picture_preview" src="" alt="Profile Picture Preview" class="hidden w-32 h-32 object-cover border border-gray-300 rounded" />
                </div>
            </div>

            <!-- Name -->
            <div class="mt-4">
                <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
                <x-input name="name" class="block mt-1 w-full" type="text" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error for="name" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <x-input name="email" class="block mt-1 w-full" type="email" :value="old('email')" required autocomplete="username" />
                <x-input-error for="email" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <x-input name="password" class="block mt-1 w-full" type="password" required autocomplete="new-password" />
                <x-input-error for="password" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <x-input name="password_confirmation" class="block mt-1 w-full" type="password" required autocomplete="new-password" />
                <x-input-error for="password_confirmation" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ms-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </div>
</div>
    <!-- JavaScript for Preview -->
    <script>
        document.getElementById('profile_picture').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('profile_picture_preview');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            } else {
                preview.src = '';
                preview.classList.add('hidden');
            }
        });
    </script>
</x-guest-layout>
