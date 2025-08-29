<div>
    <form wire:submit='save'>
        <div class="form-container">
            <div class="form-container__header">
                Localización del inmueble
            </div>
            <div class="form-container__content">

                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <flux:field>
                        <flux:label>Latitud</flux:label>
                        <flux:input type="number" wire:model='latitud' />
                        <div class="error-container">
                            <flux:error name="gi_ownerShipRegime" />
                        </div>
                    </flux:field>
                    <flux:field>
                        <flux:label>Longitud</flux:label>
                        <flux:input type="number" wire:model='longitud' />
                        <div class="error-container">
                            <flux:error name="gi_ownerShipRegime" />
                        </div>
                    </flux:field>
                    <flux:field>
                        <flux:label>Altitud</flux:label>
                        <flux:input type="number" wire:model='altitud' />
                        <div class="error-container">
                            <flux:error name="gi_ownerShipRegime" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Croquis macro localización</h2>
                    <h2 class="border-b-2 border-gray-300">Croquis micro localización</h2>
                    <h2 class="border-b-2 border-gray-300">Polígono del inmueble</h2>
                </div>


                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-4">Map</h2>
                    <h2 class="border-b-4">Map</h2>
                    <h2 class="border-b-4">Map</h2>
                </div>
                <flux:button class="mt-4 cursor-pointer btn-intermediary" variant="primary">Localizar
                    inmueble en mapa</flux:button>
            </div>
        </div>

        <div class="form-container">
            <div class="form-container__header">
                Localización geográfica del inmueble
            </div>
            <div class="form-container__content">
                <flux:button class="mt-4 cursor-pointer btn-primary" variant="primary" type="submit">Guardar datos</flux:button>
            </div>
        </div>


    </form>
</div>
