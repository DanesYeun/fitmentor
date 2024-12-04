<div>
    <div class="text-black mt-5 ml-20">
        <a href="javascript:history.back()"><i class="fa-solid fa-rotate-left">Back</i></a>
    </div>

<div class="w-full max-w-4xl mx-auto p-5 mt-10">
    @if (session()->has('message'))
        <div class="bg-green-500 text-center text-white p-3 mb-4">
            {{ session('message') }}
        </div>
    @endif
    <div class="w-3/4 mx-auto bg-gray-300 rounded-lg p-3 shadow-lg text-black">
    <form wire:submit.prevent="updateProgram">  
        <div class="block mt-4">
            <x-label for="name" value="{{ __('Program Name') }}" />
            <x-input class="block mt-1 w-full bg-transparent text-black" type="text" wire:model="name"/>
        </div>
        <div class="block mt-4">
            <x-label for="goal" value="{{ __('Goal') }}" />
            <textarea class="block mt-1 w-full bg-transparent text-black" row="3" wire:model="goal"></textarea>
        </div>

        <div class="mx-auto w-1/3 mt-10">
            <button type="submit" class="bg-gray-500 text-white px-4 py-2 rounded-md">Update Program</button>
        </div>
    </form>
    </div>
</div>
</div>
