<div>
    <div>
        <a wire:click="backMain" class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                   Regresar al menú principal
       </a>
    </div>
    <br>
    <flux:heading size="xl" level="1">{{ __('Información general') }}</flux:heading>
    {{-- <flux:subheading size="lg" class="mb-6">{{ ('Información General') }}</flux:subheading> --}}
    <flux:separator variant="subtle" />

    <div>

           <div class="w-150">
            <form wire:submit='save' class="mt-6 space-y-6">
               <flux:input wire:model='name' label="Nombre" placeholder="Nombre" />
               <flux:input wire:model='email' label="Email"  type="email" placeholder="Email" />
               <label for="tipo" class="flux-label text-sm">Tipo de usuario</label>
               <flux:select wire:model="type" class="mt-2 text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="Administrador">Administrador</flux:select.option>
                        <flux:select.option value="Operador">Operador</flux:select.option>
                </flux:select>
                 @error('type')
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
                    <span class="text-[#FA2C37]">El campo tipo de usuario es obligatirio.</span>
                    </div>
                    @enderror
               <flux:input wire:model='password' label="Password"  type="password" placeholder="Password" />
               <flux:input wire:model='confirmar_password' label="Confirmar password"  type="password" placeholder="Confirmar Password" />
                <flux:button class="mt-10" type="submit" variant="primary">Guardar usuario</flux:button>
            </form>
           </div>
    </div>

</div>
