<div>
    @if ($showModalStatus)
    <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.200ms
        class="fixed inset-0 z-50 bg-slate-900/30 flex justify-center items-center p-4">
        <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
            class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Cambiar estatus</h2>

            <flux:select wire:model="statusChange" class="mt-2 text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="casa_habitacion">-- Selecciona una opción --</flux:select.option>
                <flux:select.option value="fiscal">Pendiente</flux:select.option>
                <flux:select.option value="comercial">Revisado</flux:select.option>
                <flux:select.option value="comercial">Archivado</flux:select.option>
            </flux:select>

            {{-- Mostrar valor de estado seleccionado --}}
            {{ $statusChange }}

            <div class="flex justify-end gap-2 mt-6">
                <button wire:click="saveAssign" class="cursor-pointer btn-primary btn-table">
                    Guardar
                </button>
                <button wire:click="closeModalStatus" class="cursor-pointer btn-deleted btn-table">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
