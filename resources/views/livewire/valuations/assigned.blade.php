<div>
    <div class="p-3">
        <h1 class="text-2xl font-bold mb-4">Pendientes de asignar</h1>

        {{-- Aquí tus botones o mensajes --}}
        {{-- <div class="flex justify-end mb-4">
            <button wire:click="save" class="btn btn-primary">
                Asignar Seleccionados
            </button>
        </div> --}}

        {{-- Renderizado del componente anidado --}}
         <livewire:valuations.assigned-table />
         <livewire:valuations.status-modal />
         <livewire:valuations.assigned-modal />
    </div>


    {{--    <livewire:valuations.assigned-table /> --}}
</div>
