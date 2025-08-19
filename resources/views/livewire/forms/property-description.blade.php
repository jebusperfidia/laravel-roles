<div>
   <div class="form-container">
        <div class="form-container__header">
            Descripción del inmueble
        </div>
        <div class="form-container__content">


            <div class="form-grid form-grid--1">
                <flux:input id="field1" label="Campo A" type="text" wire:model="fieldA" placeholder="Escribe aquí" />
            </div>


            <div class="form-grid form-grid--1">
                <flux:input id="field2" label="Campo B" type="email" wire:model="fieldB"
                    placeholder="correo@ejemplo.com" />
            </div>

        </div>
    </div>
    <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
</div>
