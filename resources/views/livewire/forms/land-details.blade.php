<div>
<div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>

    {{-- CONTENEDOR 1 --}}
    <div class="form-container">
        <div class="form-container__header">
            Fuente de información legal
        </div>
        <div class="form-container__content">

            <div class="form-grid form-grid--3">
                <flux:field class="flux:field">
                    <label for="tipo" class="flux-label text-sm">Fuente de información legal<span
                            class="sup-required">*</span></label>
                    <flux:select wire:model.live="sli_sourceLegalInformation"
                        class="text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="Escritura">Escritura</flux:select.option>
                        <flux:select.option value="Sentencia">Sentencia</flux:select.option>
                        <flux:select.option value="Contrato privado">Contrato privado</flux:select.option>
                        <flux:select.option value="Alineamiento y numero oficial">Alineamiento y numero oficial
                        </flux:select.option>
                        <flux:select.option value="Titulo de propiedad">Titulo de propiedad</flux:select.option>
                        <flux:select.option value="Otro">Otro</flux:select.option>
                    </flux:select>
                    <div class="error-container">
                        <flux:error name="gi_ownerShipRegime" />
                    </div>
                </flux:field>
            </div>

            {{-- INPUTS PARA ESCRITURA --}}
            @if($sli_sourceLegalInformation === 'Escritura')
            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Escritura</h2>
            </div>
            <div class="form-grid form-grid--3">
                <flux:field class="flux:field">
                    <flux:label>Notaría<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_notaryOffice' />
                    <div class="error-container">
                        <flux:error name="sli_notaryOffice" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Escritura<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_deed' />
                    <div class="error-container">
                        <flux:error name="sli_deed" />
                    </div>
                </flux:field>
               <flux:field class="flux:field">
                    <flux:label>Volumen<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_volume' />
                    <div class="error-container">
                        <flux:error name="sli_volume" />
                    </div>
                </flux:field>
            </div>

            <div class="form-grid form-grid--3">
                <flux:field class="flux:field">
                    <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                    <flux:input type="date" wire:model='sli_date' />
                    <div class="error-container">
                        <flux:error name="sli_date" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Notario<span class="sup-required">*</span></flux:label>
                    <flux:input type="date" wire:model='sli_notary' />
                    <div class="error-container">
                        <flux:error name="sli_notary" />
                    </div>
                </flux:field>
               <flux:field class="flux:field">
                <flux:label>Distrito judicial<span class="sup-required">*</span></flux:label>
                <flux:input type="date" wire:model='sli_judicialDistric' />
                <div class="error-container">
                    <flux:error name="sli_judicialDistric" />
                </div>
            </flux:field>
            </div>
            @endif

            {{-- INPUTS PARA SENTENCIA --}}
            @if($sli_sourceLegalInformation === 'Sentencia')
            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Sentencia</h2>
            </div>
            <div class="form-grid form-grid--3">
                <flux:field class="flux:field">
                    <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_fileJudgment' />
                    <div class="error-container">
                        <flux:error name="sli_fileJudgment" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Nombre<span class="sup-required">*</span></flux:label>
                    <flux:input type="date" wire:model='sli_dateJudgment' />
                    <div class="error-container">
                        <flux:error name="sli_dateJudgment" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Apellido paterno<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_courtJudgment' />
                    <div class="error-container">
                        <flux:error name="sli_courtJudgment" />
                    </div>
                </flux:field>
            </div>
            <div class="form-grid form-grid--3">
                <flux:field class="flux:field">
                    <flux:label>Municipio/alcaldia<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_municipalityJudgment' />
                    <div class="error-container">
                        <flux:error name="sli_municipalityJudgment" />
                    </div>
                </flux:field>
            </div>
            @endif

            {{-- INPUTS PARA CONTRATO PRIVADO --}}
            @if($sli_sourceLegalInformation === 'Contrato privado')
            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Contrato privado</h2>
            </div>
            <div class="form-grid form-grid--3">
                <flux:field class="flux:field">
                    <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                    <flux:input type="date" wire:model='sli_datePrivCont' />
                    <div class="error-container">
                        <flux:error name="sli_datePrivCont" />
                    </div>
                </flux:field>
            </div>
            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Datos del adquiriente</h2>
            </div>
            <div class="form-grid form-grid--3">
                <flux:field class="flux:field">
                    <flux:label>Nombre<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_namePrivContAcq' />
                    <div class="error-container">
                        <flux:error name="sli_namePrivContAcq" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Apellido paterno<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_firstNamePrivContAcq' />
                    <div class="error-container">
                        <flux:error name="sli_firstNamePrivContAcq" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Apellido materno<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_secondNamePrivContAcq' />
                    <div class="error-container">
                        <flux:error name="sli_secondNamePrivContAcq" />
                    </div>
                </flux:field>
            </div>

            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Datos del enajenante</h2>
            </div>
            <div class="form-grid form-grid--3">
                <flux:field class="flux:field">
                    <flux:label>Nombre<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_namePrivContAlt' />
                    <div class="error-container">
                        <flux:error name="sli_namePrivContAlt" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Apellido paterno<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_firstNamePrivContAlt' />
                    <div class="error-container">
                        <flux:error name="sli_firstNamePrivContAlt" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Apellido materno<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_secondNamePrivContAlt' />
                    <div class="error-container">
                        <flux:error name="sli_secondNamePrivContAlt" />
                    </div>
                </flux:field>
            </div>
            @endif

            {{-- INPUTS PARA ALINEAMIENTO Y NUMERO OFICIAL --}}
                @if($sli_sourceLegalInformation === 'Alineamiento y numero oficial')
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Alineamiento y número oficial</h2>
                </div>
                <div class="form-grid form-grid--3">
                   <flux:field class="flux:field">
                        <flux:label>Folio<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_folioAon' />
                        <div class="error-container">
                            <flux:error name="sli_folioAon" />
                        </div>
                    </flux:field>
                    <flux:field class="flux:field">
                        <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                        <flux:input type="date" wire:model='sli_dateAon' />
                        <div class="error-container">
                            <flux:error name="sli_dateAon" />
                        </div>
                    </flux:field>
                    <flux:field class="flux:field">
                        <flux:label>Municipio/alcaldia<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_municipalityAon' />
                        <div class="error-container">
                            <flux:error name="sli_municipalityAon" />
                        </div>
                    </flux:field>
                </div>
                @endif

                {{-- INPUTS PARA TITULO DE PROPIEDAD --}}
                @if($sli_sourceLegalInformation === 'Alineamiento y numero oficial')
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Régimen de propiedad</h2>
                </div>
                <div class="form-grid form-grid--3">
                   <flux:field class="flux:field">
                    <flux:label>Expediente<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_recordPropReg' />
                    <div class="error-container">
                        <flux:error name="sli_recordPropReg" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                    <flux:input type="date" wire:model='sli_datePropReg' />
                    <div class="error-container">
                        <flux:error name="sli_datePropReg" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label># Instrumento<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_instrumentPropReg' />
                    <div class="error-container">
                        <flux:error name="sli_instrumentPropReg" />
                    </div>
                </flux:field>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux:field">
                        <flux:label>Lugar<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_placePropReg' />
                        <div class="error-container">
                            <flux:error name="sli_placePropReg" />
                        </div>
                    </flux:field>
                </div>
                @endif

                {{-- INPUTS PARA OTRA FUENTE DE INFORMACION LEGAL --}}
                @if($sli_sourceLegalInformation === 'Alineamiento y numero oficial')
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Otra fuente de información legal</h2>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux:field">
                        <flux:label>Especifique<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_especifyAsli' />
                        <div class="error-container">
                            <flux:error name="sli_especifyAsli" />
                        </div>
                    </flux:field>
                    <flux:field class="flux:field">
                        <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                        <flux:input type="date" wire:model='sli_dateAsli' />
                        <div class="error-container">
                            <flux:error name="sli_dateAsli" />
                        </div>
                    </flux:field>
                    <flux:field class="flux:field">
                        <flux:label>Emitido por<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_emittedByAsli' />
                        <div class="error-container">
                            <flux:error name="sli_emittedByAsli" />
                        </div>
                    </flux:field>
                </div>
                <div class="form-grid form-grid--3">
                   <flux:field class="flux:field">
                        <flux:label>Folio<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_folioAsli' />
                        <div class="error-container">
                            <flux:error name="sli_folioAsli" />
                        </div>
                    </flux:field>
                </div>
                @endif
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
                <flux:field class="flux:field">
                    <flux:label>Calle con frente<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_notaryOffice' />
                    <div class="error-container">
                        <flux:error name="sli_notaryOffice" />
                    </div>
                </flux:field>
            </div>

            <div class="form-grid form-grid--2">
                <flux:field class="flux:field">
                    <flux:label>Calle transversal<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_notaryOffice' />
                    <div class="error-container">
                        <flux:error name="sli_notaryOffice" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Orientación calle transversal<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_notaryOffice' />
                    <div class="error-container">
                        <flux:error name="sli_notaryOffice" />
                    </div>
                </flux:field>
            </div>

            <div class="form-grid form-grid--2">
              <flux:field class="flux:field">
                <flux:label>Calle transversal<span class="sup-required">*</span></flux:label>
                <flux:input type="text" wire:model='sli_notaryOffice' />
                <div class="error-container">
                    <flux:error name="sli_notaryOffice" />
                </div>
            </flux:field>
            <flux:field class="flux:field">
                <flux:label>orientación calle transversal<span class="sup-required">*</span></flux:label>
                <flux:input type="text" wire:model='sli_notaryOffice' />
                <div class="error-container">
                    <flux:error name="sli_notaryOffice" />
                </div>
            </flux:field>
            </div>

            <div class="form-grid form-grid--2">
               <flux:field class="flux:field">
                <flux:label>Calle limíetrofe<span class="sup-required">*</span></flux:label>
                <flux:input type="text" wire:model='sli_notaryOffice' />
                <div class="error-container">
                    <flux:error name="sli_notaryOffice" />
                </div>
            </flux:field>
            <flux:field class="flux:field">
                <flux:label>Orientación calle limítrofe<span class="sup-required">*</span></flux:label>
                <flux:input type="text" wire:model='sli_notaryOffice' />
                <div class="error-container">
                    <flux:error name="sli_notaryOffice" />
                </div>
            </flux:field>
            </div>

            <div class="form-grid form-grid--2">
              <flux:field class="flux:field">
                <flux:label>Calle limíetrofe<span class="sup-required">*</span></flux:label>
                <flux:input type="text" wire:model='sli_notaryOffice' />
                <div class="error-container">
                    <flux:error name="sli_notaryOffice" />
                </div>
            </flux:field>
            <flux:field class="flux:field">
                <flux:label>Orientación calle limítrofe<span class="sup-required">*</span></flux:label>
                <flux:input type="text" wire:model='sli_notaryOffice' />
                <div class="error-container">
                    <flux:error name="sli_notaryOffice" />
                </div>
            </flux:field>
            </div>

            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Configuración</h2>
            </div>

            <div class="form-grid form-grid--2">
                <flux:field class="flux:field">
                    <flux:label>Ubicación<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_notaryOffice' />
                    <div class="error-container">
                        <flux:error name="sli_notaryOffice" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Configuración<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_notaryOffice' />
                    <div class="error-container">
                        <flux:error name="sli_notaryOffice" />
                    </div>
                </flux:field>
            </div>

            <div class="form-grid form-grid--2">
                <flux:field class="flux:field">
                    <flux:label>Topografía<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_notaryOffice' />
                    <div class="error-container">
                        <flux:error name="sli_notaryOffice" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Tipo de vialidad<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_notaryOffice' />
                    <div class="error-container">
                        <flux:error name="sli_notaryOffice" />
                    </div>
                </flux:field>
            </div>

            <div class="form-grid form-grid--2">
                <flux:field class="flux:field">
                    <flux:label>Características panorámicas<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_notaryOffice' />
                    <div class="error-container">
                        <flux:error name="sli_notaryOffice" />
                    </div>
                </flux:field>
                <flux:field class="flux:field">
                    <flux:label>Servimbre y/o restricciones<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='sli_notaryOffice' />
                    <div class="error-container">
                        <flux:error name="sli_notaryOffice" />
                    </div>
                </flux:field>
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
