<div>
    @if ($showModalStatus)
    <div class="fixed inset-0 z-50 bg-slate-900/30 backdrop-blur-sm flex justify-center items-center p-4">

        <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Cambiar estatus</h2>

                    <flux:select wire:model="statusChange" class="mt-2  text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="casa_habitacion">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="fiscal">Pendiente</flux:select.option>
                        <flux:select.option value="comercial">Revisado</flux:select.option>
                        <flux:select.option value="comercial">Archivado</flux:select.option>
                    </flux:select>
                    {{$statusChange}}
            <div class="flex justify-end gap-2 mt-6">
                <!-- Botón Guardar con estilo azul como el de "Revisar" -->
                <button wire:click="saveAssign"
                    class="cursor-pointer btn-primary btn-table">
                    Guardar
                </button>
                <!-- Botón Cancelar con estilo gris como el de "Cambiar estatus" -->
                <button wire:click="closeModalStatus"
                    class="cursor-pointer btn-deleted btn-table">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
