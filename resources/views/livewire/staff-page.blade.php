<div class="bg-sky-300 py-8">
    <div class="sm:m-8 lg:m-3 rounded grid grid-cols-1 sm:grid-cols-2 gap-4 flex justify-center">
        <div class="flex justify-center">
            <div class="w-80 h-48 rounded overflow-hidden shadow-lg bg-sky-200"> 
              <div class="px-6 py-4">
                <div class="font-bold text-black text-xl mb-2">Total Programs</div>
                <p class="text-black text-base font-bold text-3xl font-3xl text-center mt-8">
                    {{$programs}}
                </p>
                <div class="flex justify-end">
                </div>
              </div>
            </div>
        </div>

        <div class="flex justify-center">
            <div class="w-80 h-48 rounded overflow-hidden shadow-lg bg-sky-200">
              <div class="px-6 py-4">
                <div class="font-bold text-black text-xl mb-2">Total Enrollees</div>
                <p class="text-black text-base font-bold text-3xl font-3xl text-center mt-8">
                  {{$enrollees}}
                </p>
              </div>
            </div>
        </div>
       
    </div>
</div>
