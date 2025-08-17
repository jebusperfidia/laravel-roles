<div>
    <flux:heading size="xl" level="1">{{ __('Crear avalúo') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Formulario de creación de nuevo avalúo') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>

           <div class="w-150">
            <form wire:submit='save' class="mt-6 space-y-6">
                <flux:input type="date" max="2999-12-31" label="Fecha de avalúo"  id="fecha_actual" class="flux-input" wire:model="date" readonly/>
                    <label for="tipo" class="flux-label text-sm">Tipo de avalúo:</label>
                    <flux:select wire:model="type" class="mt-2  text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="casa_habitacion">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="fiscal">Fiscal</flux:select.option>
                        <flux:select.option value="comercial">Comercial</flux:select.option>
                    </flux:select>
                    @error('type')

                    <div role="alert" aria-live="polite" aria-atomic="true"
                        class="mt-2 text-sm font-medium rounded-md flex items-center gap-2"
                        data-flux-error="">

                    <svg class="shrink-0 size-5 inline" xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 20 20" fill="#FA2C37" aria-hidden="true" data-slot="icon">
                      <path fill-rule="evenodd"
                            d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                            clip-rule="evenodd"></path>
                    </svg>

                    <span class="text-[#FA2C37]">El campo tipo de avalúo es obligatorio.</span>
                    </div>
                    @enderror
                    <flux:input wire:model='folio' label="Folio" placeholder="El folio solo puede contener numeros, letras y guiones" />
                    <label for="tipo" class="flux-label text-sm">Tipo de inmueble:</label>
                    <flux:select wire:model="property_type" class="mt-2 text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="casa_habitacion">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="casa_habitacion">Casa habitación</flux:select.option>
                        <flux:select.option value="casa_habitacion_condominio">Casa habitación en condominio</flux:select.option>
                        <flux:select.option value="casas_multiples">Casas múltiples</flux:select.option>
                        <flux:select.option value="departamento_condominio">Departamento en condominio</flux:select.option>
                        <flux:select.option value="edificio_productos">Edificio de productos</flux:select.option>
                        <flux:select.option value="local_comercial">Local comercial (aislado)</flux:select.option>
                        <flux:select.option value="nave_industrial">Nave industrial</flux:select.option>
                        <flux:select.option value="oficina">Oficina</flux:select.option>
                        <flux:select.option value="oficina_condominio">Oficina en condominio</flux:select.option>
                        <flux:select.option value="otro_construccion">Otro en construcción</flux:select.option>
                        <flux:select.option value="terreno">Terreno</flux:select.option>
                        <flux:select.option value="terreno_condominio">Terreno en condominio</flux:select.option>
                        <flux:select.option value="vivienda_recuperada">Vivienda recuperada</flux:select.option>
                    </flux:select>

                    @error('property_type')

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
                    <span class="text-[#FA2C37]">El campo tipo de inmueble es obligatirio.</span>
                    </div>
                    @enderror
                <flux:button class="mt-10 cursor-pointer btn-primary" type="submit" variant="primary">Crear avalúo</flux:button>
            </form>
           </div>
    </div>

</div>



