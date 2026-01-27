<div>
    <div class="p-3">
        <h1 class="text-2xl font-bold mb-4">Avalúos finalizados</h1>

        {{-- Loader opcional mientras hace el match --}}
        <div wire:loading wire:target="mount" class="w-full text-center py-4">
            <span class="text-blue-600 font-bold animate-pulse">Cargando catálogo de estados...</span>
        </div>

        @if(count($statesList) > 0)
        @foreach($statesList as $stateData)
        {{-- ACORDEÓN --}}
        <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4 bg-white shadow-sm">

            {{-- HEADER: Nombre de la API --}}
            <button @click="open = !open" type="button"
                class="group w-full flex justify-between items-center px-6 py-4 bg-white hover:bg-gray-50 border-b border-gray-200 focus:outline-none transition-colors cursor-pointer rounded-t-lg">
                <span class="text-lg font-semibold text-gray-800 uppercase">{{ $stateData['name'] }}</span>

                <svg class="w-5 h-5 transform transition-transform duration-200 text-gray-500"
                    :class="{'rotate-180': open}" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- BODY: Tabla filtrada por el ID de BD --}}
            <div x-show="open" x-collapse x-cloak class="p-4 bg-gray-50">
                <livewire:valuations.completed-table :state="$stateData['id']"
                    :tableName="'completed-'.$stateData['id']" wire:key="table-{{ $stateData['id'] }}" />
            </div>
        </div>
        @endforeach
        @else
        <div wire:loading.remove class="p-6 text-center text-gray-500 border border-dashed border-gray-300 rounded-lg">
            No hay avalúos completados o no se pudo cargar el catálogo.
        </div>
        @endif
    </div>

    <livewire:valuations.status-modal />
</div>
