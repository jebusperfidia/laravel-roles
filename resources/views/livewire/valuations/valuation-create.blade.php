<div>
    <flux:heading size="xl" level="1">{{ __('Crear avalúo') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Formulario de creación de nuevo avalúo') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>
            {{-- <a href={{route('user.index')}} class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                Regresar
            </a> --}}
           <div class="w-150">
            <form wire:submit='save' class="mt-6 space-y-6">
                    <label for="tipo" class="flux-label">Tipo de avalúo:</label>
                    <flux:select wire:model="industry" placeholder="Elija una opción..." class="mt-2  text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option>Fiscal</flux:select.option>
                        <flux:select.option>Comercial</flux:select.option>
                    </flux:select>
                    <flux:input wire:model='folio' label="Folio" placeholder="El folio solo puede contener numeros, letras y guiones" />
                    <flux:input type="date" max="2999-12-31" label="Fecha de avalúo"  id="fecha_actual" class="flux-input" wire:model="fecha_actual" value="{{ now()->format('Y-m-d') }}" readonly/>
                    <label for="tipo" class="flux-label">Tipo de inmueble:</label>
                    <flux:select wire:model="industry" placeholder="Elija una opción..." class="mt-2 text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option>Casa habitación</flux:select.option>
                        <flux:select.option>Casa habitación en condominio</flux:select.option>
                        <flux:select.option>Casas múltiples</flux:select.option>
                        <flux:select.option>Departamento en condominio</flux:select.option>
                        <flux:select.option>Edificio de productos</flux:select.option>
                        <flux:select.option>Local comercial (aislado)</flux:select.option>
                        <flux:select.option>Nave industrial</flux:select.option>
                        <flux:select.option>Oficina</flux:select.option>
                        <flux:select.option>Oficina en condominio</flux:select.option>
                        <flux:select.option>Otro en construcción</flux:select.option>
                        <flux:select.option>Terreno</flux:select.option>
                        <flux:select.option>Terreno en condominio</flux:select.option>
                        <flux:select.option>Vivienda recuperada</flux:select.option>
                    </flux:select>
                <flux:button type="submit" variant="primary">Crear avalúo</flux:button>
            </form>
           </div>
    </div>

</div>
