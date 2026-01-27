<div>
    {{-- Mantenemos el @if para controlar la existencia del modal,
    pero aseguramos que el contenido sea dinámico --}}
    @if ($showModalStatus)
    <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.200ms
        class="fixed inset-0 z-50 bg-slate-900/30 flex justify-center items-center p-4">

        <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
            class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-sm">

            <h2 class="text-xl font-bold text-gray-800 mb-4">Cambiar estatus</h2>

            {{--
            AQUÍ ESTÁ LA CORRECCIÓN:
            Iteramos sobre $availableOptions para mostrar solo lo permitido.
            --}}
            <flux:select wire:model="statusChange" class="mt-2 text-gray-800 [&_option]:text-gray-900"
                placeholder="Selecciona una opción...">

                @if(empty($availableOptions))
                <flux:select.option value="" disabled>No hay cambios disponibles</flux:select.option>
                @else
                @foreach($availableOptions as $option)
                {{-- El value debe coincidir con el ID (0, 1, 2) --}}
                <flux:select.option value="{{ $option['id'] }}">
                    {{ $option['name'] }}
                </flux:select.option>
                @endforeach
                @endif

            </flux:select>

            {{-- Debug visual (opcional, bórralo cuando jale) --}}
            {{-- <div class="text-xs text-gray-400 mt-2">Selected: {{ $statusChange }}</div> --}}

            <div class="flex justify-end gap-2 mt-6">
                <button wire:click="saveAssign" class="cursor-pointer btn-primary btn-table">
                    Guardar
                </button>
                {{-- Importante: Usamos prevent para que no recargue --}}
                <button wire:click.prevent="closeModalStatus" class="cursor-pointer btn-deleted btn-table">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
