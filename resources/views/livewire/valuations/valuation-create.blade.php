<div>
    <flux:heading size="xl" level="1">{{ __('Crear avalúo') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Formulario de creación de nuevo avalúo') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>

           <div class="w-150">
            <form wire:submit='save' class="mt-6 space-y-6">
                {{-- <flux:input type="date" max="2999-12-31" label="Fecha de avalúo"  id="fecha_actual" class="flux-input" wire:model="date" readonly/> --}}
                <flux:field class="flux:field">
                    <flux:label>Fecha actual</flux:label>
                    <flux:input type="date" wire:model='date' max="2999-12-31" id="fecha_actual" readonly />
                    <div class="error-container">
                        <flux:error name="date" />
                    </div>
                </flux:field>
                <flux:field class="flux-field">
                    <flux:label>Tipo de avalúo</flux:label>
                    <flux:select wire:model="type" class="text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="Fiscal">Fiscal</flux:select.option>
                        <flux:select.option value="Comercial">Comercial</flux:select.option>
                    </flux:select>
                    <div class="error-container">
                        <flux:error name="type"/>
                    </div>
                </flux:field>
                   {{--  <flux:input wire:model='folio' label="Folio" placeholder="El folio solo puede contener numeros, letras y guiones" /> --}}
                   <flux:field class="flux:field">
                    <flux:label>Folio</flux:label>
                    <flux:input type="text" wire:model='folio' placeholer="El folio solo puede contener numeros, letras y guiones" />
                    <div class="error-container">
                        <flux:error name="folio" />
                    </div>
                </flux:field>
                    <flux:field class="flux:field">
                        <flux:label>Tipo de inmueble</flux:label>
                        <flux:select wire:model.live="property_type" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            @foreach ($propertiesTypes_input as $value => $label)
                            <flux:select.option value="{{ $label }}">
                                {{ $label }}
                            </flux:select.option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="property_type" />
                        </div>
                    </flux:field>
                <flux:button class="mt-10 cursor-pointer btn-primary" type="submit" variant="primary">Crear avalúo</flux:button>
            </form>
           </div>
    </div>

</div>



