

<div>
    @if ($showModalAssign)
    <div class="fixed inset-0 z-50 bg-slate-900/30 backdrop-blur-sm flex justify-center items-center p-4">

        <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Asignar

                {{ $type === 'massive' ? 'Masivamente' : 'Individualmente' }}

            </h2>
            {{-- {{ $Id }} --}}
                   <flux:select wire:model="appraiser">
        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
        @foreach ($users as $user)
            <flux:select.option value="{{ $user->id }}">
                {{-- {{dd($valuationsId)}} --}}
                {{ $user->name }}
            </flux:select.option>
        @endforeach
    </flux:select>
    <br>
      <flux:select wire:model="operator">
            <flux:select.option value="operator">-- Selecciona una opción --</flux:select.option>
            @foreach ($users as $user)
                <flux:select.option value="{{ $user->id }}">

                    {{ $user->name.$user->id }}
                </flux:select.option>
            @endforeach
        </flux:select>

            <div class="flex justify-end gap-2 mt-6">
                <!-- Botón Guardar con estilo azul como el de "Revisar" -->
                <button wire:click="saveAssign"
                    class="cursor-pointer px-4 py-2 text-xs font-medium text-white
                           bg-blue-700 rounded-lg hover:bg-blue-800
                           focus:ring-4 focus:outline-none focus:ring-blue-300">
                    Guardar
                </button>
                <!-- Botón Cancelar con estilo gris como el de "Cambiar estatus" -->
                <button wire:click="closeModalAssign"
                    class="cursor-pointer px-4 py-2 text-xs font-medium text-white
                           bg-slate-600 rounded-lg hover:bg-slate-700
                           focus:ring-4 focus:outline-none focus:ring-slate-300">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
