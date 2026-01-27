<div>
    {{-- CONTENEDOR GRID RESPONSIVO --}}
    {{-- grid-cols-1 (móvil), md:grid-cols-2 (tablet), xl:grid-cols-4 (desktop) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 px-4 w-full">

        {{-- BOTÓN 1: POR ASIGNAR --}}
        <button wire:click="setView('assigned')" class="w-full p-6 rounded-xl shadow-md
            bg-gradient-to-br from-blue-700 via-blue-500 to-blue-300
            text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
            <div class="text-4xl font-bold">{{$unassigned}}</div>
            <div class="mt-4 text-base font-semibold">Por Asignar</div>
        </button>

        {{-- BOTÓN 2: EN CAPTURA --}}
        <button wire:click="setView('captured')" class="w-full p-6 rounded-xl shadow-md
            bg-gradient-to-br from-emerald-600 via-emerald-400 to-green-300
            text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
            <div class="text-4xl font-bold">{{$capturing}}</div>
            <div class="mt-4 text-base font-semibold">En Captura</div>
        </button>

        {{-- BOTÓN 3: EN REVISIÓN --}}
        <button wire:click="setView('reviewed')" class="w-full p-6 rounded-xl shadow-md
            bg-gradient-to-br from-red-700 via-red-500 to-red-300
            text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
            <div class="text-4xl font-bold">{{$reviewing}}</div>
            <div class="mt-4 text-base font-semibold">En Revisión</div>
        </button>

        {{-- BOTÓN 4: TERMINADOS --}}
        <button wire:click="setView('completed')" class="w-full p-6 rounded-xl shadow-md
            bg-gradient-to-br from-gray-800 via-gray-700 to-gray-600
            text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
            <div class="text-4xl font-bold">{{$completed}}</div>
            <div class="mt-4 text-base font-semibold">Terminados</div>
        </button>
    </div>

    {{-- ZONA DE TABLAS --}}
    <div class="mt-6">

        {{-- Loader centrado --}}
        <div wire:loading.flex class="min-h-[300px] flex justify-center items-center w-full">
            <div class="animate-spin rounded-full h-10 w-10 border-t-4 border-b-4 border-blue-500"></div>
        </div>

        {{-- Contenido cargado --}}
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
