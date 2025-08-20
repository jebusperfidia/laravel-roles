<div>
    <div class="form-container">
        <div class="form-container__header">
            Descripción del inmueble
        </div>
        <div class="form-container__content">


            <div class="form-grid form-grid--3 form-grid-1-center">
                <div class="flex justify-end items-center pr-2">Referencia de proximidad urbana</div>
                <flux:input type="text" wire:model="state" placeholder="Guanajuato" />
            </div>

            <div class="form-grid form-grid--3 form-grid-1-center">
                <div class="flex justify-end items-center pr-2">Uso actual</div>
                <flux:input type="text" wire:model="state" placeholder="Guanajuato" />
            </div>

            <div class="form-grid form-grid--3 form-grid-1-center">
                <div class="flex justify-end items-center pr-2">Espacio de uso múltiple</div>
            </div>

             <div class="form-grid form-grid--3 form-grid-1-center">
                <div class="flex justify-end items-center pr-2">Calidad del proyecto</div>
            </div>

        </div>
    </div>
    <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
</div>
