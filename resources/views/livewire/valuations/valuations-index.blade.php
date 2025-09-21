
    {{-- {{dd($unassigned)}} --}}
<div>
    <div class="flex w-full gap-6 px-4">
        <button wire:click="setView('assigned')"
            class="flex-1 w-1/4 p-6 rounded-xl shadow-md
           bg-gradient-to-br from-blue-700 via-blue-500 to-blue-300
           text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
            <div class="text-4xl font-bold">{{$unassigned}}</div>
            <div class="mt-4 text-base font-semibold">Por Asignar</div>
        </button>

        <button wire:click="setView('captured')"
            class="flex-1 w-1/4 p-6 rounded-xl shadow-md
           bg-gradient-to-br from-emerald-600 via-emerald-400 to-green-300
           text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
            <div class="text-4xl font-bold">{{$capturing}}</div>
            <div class="mt-4 text-base font-semibold">En Captura</div>
        </button>

        <button wire:click="setView('reviewed')"
            class="flex-1 w-1/4 p-6 rounded-xl shadow-md
           bg-gradient-to-br from-red-700 via-red-500 to-red-300
           text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
            <div class="text-4xl font-bold">{{$reviewing}}</div>
            <div class="mt-4 text-base font-semibold">En Revisión</div>
        </button>

        <button wire:click="setView('completed')"
            class="flex-1 w-1/4 p-6 rounded-xl shadow-md
           bg-gradient-to-br from-gray-800 via-gray-700 to-gray-600
           text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
            <div class="text-4xl font-bold">{{$completed}}</div>
            <div class="mt-4 text-base font-semibold">Terminados</div>
        </button>
    </div>
    {{-- <div>{{$currentView}}</div> --}}
    <div class="mt-6">

        <div wire:loading.flex class="min-h-[300px] flex justify-center items-center">
            <div class="animate-spin rounded-full h-8 w-8 border-t-2 border-b-2 border-blue-500"></div>
        </div>
        <div wire:loading.remove>
            @if ($currentView === 'assigned')
                <livewire:valuations.assigned />
            @elseif ($currentView === 'captured')
                <livewire:valuations.captured />
            @elseif ($currentView === 'reviewed')
                <livewire:valuations.reviewed />
            @elseif ($currentView === 'completed')
                <livewire:valuations.completed />
            @endif
        </div>
    </div>

</div>
