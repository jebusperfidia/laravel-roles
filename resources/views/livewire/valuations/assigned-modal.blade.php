<div>
    @if ($showModalAssign)
        <div class="fixed inset-0 z-50 bg-slate-900/30 backdrop-blur-sm flex justify-center items-center p-4">

            <div class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-sm">
                <h2 class="text-xl font-bold text-gray-800 mb-4">Asignar

                    {{ $type === 'massive' ? 'Masivamente' : 'Individualmente' }}

                </h2>
                {{-- {{ $Id }} --}}
                <flux:select wire:model="appraiser">
                    <flux:select.option value="">-- Selecciona un perito --</flux:select.option>
                    @foreach ($users as $user)
                        <flux:select.option value="{{ $user->id }}">
                            {{-- {{dd($valuationsId)}} --}}
                            {{ $user->name }}
                        </flux:select.option>
                    @endforeach
                </flux:select>
                 @error('appraiser')
                   {{--  <p class="text-sm text-red-600">El campo tipo de avalúo es obligatorio.</p> --}}
                    <div role="alert" aria-live="polite" aria-atomic="true"
                        class="text-sm font-medium rounded-md flex items-center gap-2"
                        data-flux-error="">
                    <!-- Ícono triangular de advertencia -->
                    <svg class="shrink-0 size-5 inline" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20" fill="#FA2C37" aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <!-- Mensaje -->
                    <span class="text-[#FA2C37]">El campo tipo de usuario es obligatorio.</span>
                    </div>
                    @enderror
                <br>
                <flux:select wire:model="operator">
                    <flux:select.option value="operator">-- Selecciona una operador --</flux:select.option>
                    @foreach ($users as $user)
                        <flux:select.option value="{{ $user->id }}">

                            {{ $user->name}}
                        </flux:select.option>
                    @endforeach
                </flux:select>
                 @error('operator')
                   {{--  <p class="text-sm text-red-600">El campo tipo de avalúo es obligatorio.</p> --}}
                    <div role="alert" aria-live="polite" aria-atomic="true"
                        class="text-sm font-medium rounded-md flex items-center gap-2"
                        data-flux-error="">
                    <!-- Ícono triangular de advertencia -->
                    <svg class="shrink-0 size-5 inline" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20" fill="#FA2C37" aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <!-- Mensaje -->
                    <span class="text-[#FA2C37]">El campo tipo de usuario es obligatorio.</span>
                    </div>
                    @enderror
                    <br>
                <div class="flex justify-end gap-2 mt-6">
                    <!-- Botón Guardar con estilo azul como el de "Revisar" -->
                    <button wire:click="saveAssign"
                        class="cursor-pointer btn-primary btn-table">
                        Guardar
                    </button>
                    <!-- Botón Cancelar con estilo gris como el de "Cambiar estatus" -->
                    <button wire:click="closeModalAssign"
                        class="cursor-pointer btn-deleted btn-table">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
