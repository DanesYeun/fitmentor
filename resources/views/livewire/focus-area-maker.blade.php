<div class="bg-transparent min-h-screen">
    <div class="text-black mt-5 ml-20">
        <a href="javascript:history.back()"><i class="fa-solid fa-rotate-left">Back</i></a>
    </div>
    @if (session()->has('message'))
                <div class="p-4 bg-green-500 rounded-lg text-green-800 text-lg font-semibold shadow-md flex justify-center mx-auto w-1/3">
                    {{ session('message') }}
                </div>
            @endif
    <div class="bg-sky-300 text-black rounded-lg mx-auto w-1/3 mt-10 p-3">
        @error('name')<span class="p-4 bg-red-500 rounded-lg text-red-800 text-lg font-semibold shadow-md flex justify-center mx-auto w-1/3">{{ $message }}</span> @enderror
            
                    <form wire:submit.prevent="create" enctype="multipart/form-data">
                        @csrf
                        <div class="block mt-4">
                            <x-label for="name" value="{{ __('Focus Area Name') }}" />
                            <x-input class="block mt-1 w-full bg-transparent text-black" type="text" placeholder="Name" wire:model="name" required />
                        </div>

                        <div class="flex flex-wrap justify-center mt-5 ml-8">
                            <div x-data="{ hover: false }" class="flex-1">
                                <button 
                                    x-on:mouseover="hover = true" 
                                    x-on:mouseout="hover = false" 
                                    class="btn min-w-[10rem] min-h-[3rem] bg-green-600 font-medium text-black hover:bg-green-700 focus:bg-green-700 active:bg-primary-focus/90 rounded-full" 
                                    type="submit" 
                                    aria-label="Save changes"
                                    :class="{ 'bg-green-700': hover }"
                                >
                                    <i class="fa fa-save" aria-hidden="true"></i>
                                    <span x-show="hover" class="ml-2">Save</span>
                                </button>
                            </div>

                            <div x-data="{ hover: false }" class="flex-1">
                                <button x-on:mouseover="hover = true" x-on:mouseout="hover = false" type="button" wire:click="resetPage" class="btn min-w-[10rem] min-h-[3rem] bg-red-600 font-medium text-black hover:bg-red-700 focus:bg-red-700 active:bg-primary-focus/90 rounded-full">
                                    <i class="fa fa-refresh"></i>
                                    <span x-show="hover">Reset</span>
                                </button>
                            </div>
                        </div>
                    </form>
    </div>
</div>
    