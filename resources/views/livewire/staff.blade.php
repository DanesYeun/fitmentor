<div>
    <div class="text-black mt-5 ml-20">
        <a href="javascript:history.back()"><i class="fa-solid fa-rotate-left">Back</i></a>
    </div>
            @if (session()->has('message'))
                <div class="p-4 mx-auto w-1/3 bg-green-100 border border-green-200 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center">
                    {{ session('message') }}
                </div>
            @endif
    <form wire:submit.prevent="create" enctype="multipart/form-data" class="w-1/3 mx-auto mt-10 bg-gray-200 rounded-lg shadow-lg p-5">
    @csrf
                    
        <div class="block">
            <div class="block mt-4">
                <label for="profile_picture" class="block text-sm font-medium text-gray-700">Profile Picture</label>
                    <input type="file" id="profile_picture" wire:model="profile_picture" class="block mt-1 w-full text-black" accept="image/*" onchange="previewImage(event)"/>
                        <div class="mt-4">
                            <img id="profile_picture_preview" src="" alt="Profile Picture Preview" class="hidden w-32 h-32 object-cover border border-gray-300 rounded"/>
                        </div>
            </div>
        </div>

        <div class="block mt-4">
            <x-label for="name" value="{{ __('Name') }}" />
                <x-input id="name" class="block mt-1 w-full bg-transparent text-black" type="text" wire:model="name" required />
        </div>

        <div class="block mt-4">
            <x-label for="email" value="{{ __('Email') }}" />
                <x-input id="email" class="block mt-1 w-full bg-transparent text-black" type="email" wire:model="email" required />
        </div>
                    
        <div class="block mt-4">
            <x-label for="password" value="{{ __('Password') }}" />
                <x-input id="password" class="block mt-1 w-full bg-transparent text-black" type="password" wire:model="password" required />
        </div>

        <div class="block mt-4">
            <x-label for="password_confirmation" value="{{ __('Confirm Password') }}" />
                <x-input id="password_confirmation" class="block mt-1 w-full bg-transparent text-black" type="password" wire:model="password_confirmation" required />
                    <x-input-error for="password" class="mt-2" />
        </div>

        <div class="flex flex-wrap justify-center mt-5 ml-8">
            <div x-data="{ hover: false }" class="flex-1">
                <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" class="btn min-w-[10rem] min-h-[3rem] bg-green-600 font-medium text-black hover:bg-green-700 focus:bg-green-700 active:bg-primary-focus/90 rounded-full" type="submit" aria-label="Save changes" :class="{ 'bg-green-700': hover }">
                    <i class="fa fa-save" aria-hidden="true"></i>
                        <span x-show="hover" class="ml-2">Save</span>
                </button>
            </div>
            <div x-data="{ hover: false }" class="flex-1">
                <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" type="button" wire:click="resetpage" class="btn min-w-[10rem] min-h-[3rem] bg-red-600 font-medium text-black hover:bg-red-700 focus:bg-red-700 active:bg-primary-focus/90 rounded-full">
                    <i class="fa fa-refresh"></i>
                        <span x-show="hover">Reset</span>
                </button>
            </div>
        </div>
    </form>
</div>