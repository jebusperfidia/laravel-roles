<div>


    {{-- CONTENEDOR 1 --}}
    <div class="form-container">
        <div class="form-container__header">
            Fuente de información legal
        </div>
        <div class="form-container__content">

            <div class="form-grid form-grid--3">
                <flux:input label="Fuente de información legal" type="text" wire:model="ld_legalSourceInfo"
                    placeholder="" />
            </div>

            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Escritura</h2>
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Notaria" type="text" wire:model="city" placeholder="León" />
                <flux:input label="Escritura" type="text" wire:model="state" placeholder="Guanajuato" />
                <flux:input label="Volumen" type="text" wire:model="zipcode" placeholder="37000" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Fecha" type="text" wire:model="city" placeholder="León" />
                <flux:input label="Notario" type="text" wire:model="state" placeholder="Guanajuato" />
                <flux:input label="Distrito judicial" type="text" wire:model="zipcode" placeholder="37000" />
            </div>

        </div>
    </div>






    {{-- CONTENEDOR 2 --}}
    <div class="form-container">
        <div class="form-container__header">
            Medidas y colindancias
        </div>
        <div class="form-container__content">


            <div class="form-grid form-grid--3 form-grid-1-center">
                <div class="flex justify-end items-center pr-2">Anexo de colindancias</div>
                <flux:input type="text" wire:model="state" placeholder="Guanajuato" />
            </div>

            <div class="form-grid form-grid--3 form-grid-1-center">
                <div class="flex justify-end items-center pr-2">Anexo de colindancias</div>
                <flux:input type="text" wire:model="state" placeholder="Guanajuato" />
            </div>

             <div class="form-grid form-grid--3 form-grid-1-center">
                <div class="flex justify-end items-center pr-2">Imágenes cargadas</div>
            </div>

        </div>
    </div>





    {{-- CONTENEDOR 3 --}}
    <div class="form-container">
        <div class="form-container__header">
            Configuración del terreno
        </div>
        <div class="form-container__content">


          <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Croquis - macro</h2>
                <h2 class="border-b-2 border-gray-300">Croquis - micro</h2>
            </div>

            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-4">Map</h2>
                <h2 class="border-b-4">Map</h2>
            </div>


            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Calles transversales, limítrofes y orientación</h2>
            </div>

              <div class="form-grid form-grid--2">
                <flux:input label="Calle transversal" type="text" wire:model="gi_folio" placeholder="" />
                <flux:input label="Orientación calle transversal" type="text" wire:model="gi_date" placeholder="" />
            </div>

              <div class="form-grid form-grid--2">
                <flux:input label="Calle transversal" type="text" wire:model="gi_folio" placeholder="" />
                <flux:input label="Orientación calle transversal" type="text" wire:model="gi_date" placeholder="" />
            </div>

              <div class="form-grid form-grid--2">
                <flux:input label="Calle limítrofe" type="text" wire:model="gi_folio" placeholder="" />
                <flux:input label="Orientación calle limítrofe" type="text" wire:model="gi_date" placeholder="" />
            </div>

               <div class="form-grid form-grid--2">
                <flux:input label="Calle limítrofe" type="text" wire:model="gi_folio" placeholder="" />
                <flux:input label="Orientación calle limítrofe" type="text" wire:model="gi_date" placeholder="" />
            </div>

            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Configuración</h2>
            </div>

             <div class="form-grid form-grid--2">
                <flux:input label="Ubicación" type="text" wire:model="gi_folio" placeholder="" />
                <flux:input label="Configuración" type="text" wire:model="gi_date" placeholder="" />
            </div>

              <div class="form-grid form-grid--2">
                <flux:input label="Topografía" type="text" wire:model="gi_folio" placeholder="" />
                <flux:input label="Tipo de vialidad" type="text" wire:model="gi_date" placeholder="" />
            </div>

               <div class="form-grid form-grid--2">
                <flux:input label="Características panorámicas" type="text" wire:model="gi_folio" placeholder="" />
                <flux:input label="Servidumbre y/o restricciones" type="text" wire:model="gi_date" placeholder="" />
            </div>

        </div>
    </div>








    {{-- CONTENEDOR 4 --}}
    <div class="form-container">
        <div class="form-container__header">
            Superficie del terreno
        </div>
        <div class="form-container__content">


            <div class="form-grid form-grid--1">
               Banner
            </div>
            <div class="form-grid form-grid--1">
               Banner
            </div>
            <div class="form-grid form-grid--1">
               Componente superficie
            </div>


        </div>
    </div>


    <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
</div>
