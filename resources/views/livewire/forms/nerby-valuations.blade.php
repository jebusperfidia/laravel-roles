<div>
    <div class="form-container">
        <div class="form-container__header">
            Inmuebles valuados en la zona de los últimos:
        </div>
        <div class="form-container__content">


            <div class="form-grid form-grid--1">
                <flux:field>
                    <flux:select wire:model="inf_roadways" class=" text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="1. Terraceria">1. Terraceria</flux:select.option>
                        <flux:select.option value="2. Concreto asfaltico">2. Concreto asfaltico
                        </flux:select.option>
                        <flux:select.option value="3. Concreto hidraulico">3. Concreto hidráulico
                        </flux:select.option>
                        <flux:select.option value="4. Empedrado">4. Empedrado</flux:select.option>
                        <flux:select.option value="5. Adoquin">5. Adoquin</flux:select.option>
                        <flux:select.option value="6. Otros">6. Otros</flux:select.option>
                        <flux:select.option value="7. No presenta">7. No presenta</flux:select.option>
                    </flux:select>
                </flux:field>
            </div>
            <div class="flex justify-end">
                <flux:button class="mt-4 cursor-pointer btn-intermediary " type="submit" variant="primary">Ver en mapa</flux:button>
            </div>

        </div>
    </div>

     <div class="form-container">
        <div class="form-container__header">
            Mapa de inmuebles valuados en la zona
        </div>
        <div class="form-container__content">

            <div class="form-grid form-grid--3 form-grid-radios form-grid-urban form-grid-urban border-b-2">
                <div class="radio-label border-r-2">
                   Copiar secciones y/o datos desde el avaluo
                </div>
                <div class="radio-input">
                    <div class="radio-group-horizontal">
                       <flux:field>
                        <flux:input type="text"/>
                       </flux:field>
                    </div>
                </div>
            </div>
            {{-- <div class="form-grid form-grid--1">
                <flux:input id="field1" label="Campo A" type="text" wire:model="fieldA" placeholder="Escribe aquí" />
            </div>
 --}}
{{--
            <div class="form-grid form-grid--1">
                <flux:input id="field2" label="Campo B" type="email" wire:model="fieldB"
                    placeholder="correo@ejemplo.com" />
            </div> --}}

        </div>
    </div>
     <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar cambios</flux:button>
</div>
