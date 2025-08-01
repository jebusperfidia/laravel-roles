{{-- <div class="flex flex-row gap-4 flex-wrap justify-start w-full"> --}}
    <!-- Card Azul -->
{{--     <a href=""
       class="flex-1 min-w-[200px] max-w-sm p-6 rounded-xl shadow-md
              bg-gradient-to-br from-blue-700 via-blue-500 to-blue-300
              text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
        <div class="text-4xl font-bold">0</div>
        <div class="mt-4 text-base font-semibold">Por Asignar</div>
    </a> --}}

    <!-- Card Menta -->
 {{--    <a href=""
       class="flex-1 min-w-[200px] max-w-sm p-6 rounded-xl shadow-md
              bg-gradient-to-br from-emerald-600 via-emerald-400 to-green-300
              text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
        <div class="text-4xl font-bold">6</div>
        <div class="mt-4 text-base font-semibold">En Captura</div>
    </a> --}}

    <!-- Card Rojo -->
    {{-- <a href=""
       class="flex-1 min-w-[200px] max-w-sm p-6 rounded-xl shadow-md
              bg-gradient-to-br from-red-700 via-red-500 to-red-300
              text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
        <div class="text-4xl font-bold">0</div>
        <div class="mt-4 text-base font-semibold">En Revisión</div>
    </a> --}}

    <!-- Card Gris Oscuro -->
  {{--   <a href=""
       class="flex-1 min-w-[200px] max-w-sm p-6 rounded-xl shadow-md
              bg-gradient-to-br from-gray-800 via-gray-700 to-gray-600
              text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
        <div class="text-4xl font-bold">38</div>
        <div class="mt-4 text-base font-semibold">Terminados</div>
    </a>
</div>
 --}}
<div>
    <div class="flex flex-row flex-wrap justify-center gap-6 w-full max-w-screen-2xl mx-auto px-4">
    <!-- Card Azul -->
    <button wire:click="setView('assigned')"
       class="flex-1 min-w-[220px] max-w-[320px] p-6 rounded-xl shadow-md
              bg-gradient-to-br from-blue-700 via-blue-500 to-blue-300
              text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
        <div class="text-4xl font-bold">0</div>
        <div class="mt-4 text-base font-semibold">Por Asignar</div>
    </button>

    <!-- Card Menta -->
    <button wire:click="setView('captured')"
       class="flex-1 min-w-[220px] max-w-[320px] p-6 rounded-xl shadow-md
              bg-gradient-to-br from-emerald-600 via-emerald-400 to-green-300
              text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
        <div class="text-4xl font-bold">6</div>
        <div class="mt-4 text-base font-semibold">En Captura</div>
    </button>

    <!-- Card Rojo -->
    <button wire:click="setView('reviewed')"
       class="flex-1 min-w-[220px] max-w-[320px] p-6 rounded-xl shadow-md
              bg-gradient-to-br from-red-700 via-red-500 to-red-300
              text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
        <div class="text-4xl font-bold">0</div>
        <div class="mt-4 text-base font-semibold">En Revisión</div>
    </button>

    <!-- Card Gris Oscuro -->
    <button wire:click="setView('completed')"
       class="flex-1 min-w-[220px] max-w-[320px] p-6 rounded-xl shadow-md
              bg-gradient-to-br from-gray-800 via-gray-700 to-gray-600
              text-white transition-transform hover:scale-105 hover:shadow-lg cursor-pointer">
        <div class="text-4xl font-bold">38</div>
        <div class="mt-4 text-base font-semibold">Terminados</div>
    </button>
    {{-- {{$currentView}} --}}
</div>

   <div class="mt-6">
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

