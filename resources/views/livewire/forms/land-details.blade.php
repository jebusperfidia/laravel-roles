<div>
    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>
    <form wire:submit="save">
        {{-- CONTENEDOR 1 --}}
        <div class="form-container">
            <div class="form-container__header">
                Fuente de información legal
            </div>
            <div class="form-container__content">

                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
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
                            <flux:select.option value="Otra fuente de informacion legal">Otra fuente de información
                                legal</flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="sli_sourceLegalInformation" />
                        </div>
                    </flux:field>
                </div>

                {{-- INPUTS PARA ESCRITURA --}}
                @if($sli_sourceLegalInformation === 'Escritura')
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Escritura</h2>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Notaría<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_notaryOfficeDeed' />
                        <div class="error-container">
                            <flux:error name="sli_notaryOfficeDeed" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Escritura<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_deedDeed' />
                        <div class="error-container">
                            <flux:error name="sli_deedDeed" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Volumen<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_volumeDeed' />
                        <div class="error-container">
                            <flux:error name="sli_volumeDeed" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                        <flux:input type="date" wire:model='sli_dateDeed' />
                        <div class="error-container">
                            <flux:error name="sli_dateDeed" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Notario<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_notaryDeed' />
                        <div class="error-container">
                            <flux:error name="sli_notaryDeed" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Distrito judicial<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_judicialDistricDeed' />
                        <div class="error-container">
                            <flux:error name="sli_judicialDistricDeed" />
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
                    <flux:field class="flux-field">
                        <flux:label>Expediente<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_fileJudgment' />
                        <div class="error-container">
                            <flux:error name="sli_fileJudgment" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                        <flux:input type="date" wire:model='sli_dateJudgment' />
                        <div class="error-container">
                            <flux:error name="sli_dateJudgment" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Juzgado<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_courtJudgment' />
                        <div class="error-container">
                            <flux:error name="sli_courtJudgment" />
                        </div>
                    </flux:field>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
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
                    <flux:field class="flux-field">
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
                    <flux:field class="flux-field">
                        <flux:label>Nombre<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_namePrivContAcq' />
                        <div class="error-container">
                            <flux:error name="sli_namePrivContAcq" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Apellido paterno<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_firstNamePrivContAcq' />
                        <div class="error-container">
                            <flux:error name="sli_firstNamePrivContAcq" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
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
                    <flux:field class="flux-field">
                        <flux:label>Nombre<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_namePrivContAlt' />
                        <div class="error-container">
                            <flux:error name="sli_namePrivContAlt" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Apellido paterno<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_firstNamePrivContAlt' />
                        <div class="error-container">
                            <flux:error name="sli_firstNamePrivContAlt" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
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
                    <flux:field class="flux-field">
                        <flux:label>Folio<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_folioAon' />
                        <div class="error-container">
                            <flux:error name="sli_folioAon" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                        <flux:input type="date" wire:model='sli_dateAon' />
                        <div class="error-container">
                            <flux:error name="sli_dateAon" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Municipio/alcaldia<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_municipalityAon' />
                        <div class="error-container">
                            <flux:error name="sli_municipalityAon" />
                        </div>
                    </flux:field>
                </div>
                @endif

                {{-- INPUTS PARA TITULO DE PROPIEDAD --}}
                @if($sli_sourceLegalInformation === 'Titulo de propiedad')
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Título de propiedad</h2>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Expediente<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_recordPropReg' />
                        <div class="error-container">
                            <flux:error name="sli_recordPropReg" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                        <flux:input type="date" wire:model='sli_datePropReg' />
                        <div class="error-container">
                            <flux:error name="sli_datePropReg" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label># Instrumento<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_instrumentPropReg' />
                        <div class="error-container">
                            <flux:error name="sli_instrumentPropReg" />
                        </div>
                    </flux:field>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Lugar<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_placePropReg' />
                        <div class="error-container">
                            <flux:error name="sli_placePropReg" />
                        </div>
                    </flux:field>
                </div>
                @endif

                {{-- INPUTS PARA OTRA FUENTE DE INFORMACION LEGAL --}}
                @if($sli_sourceLegalInformation === 'Otra fuente de informacion legal')
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Otra fuente de información legal</h2>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Especifique<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_especifyAsli' />
                        <div class="error-container">
                            <flux:error name="sli_especifyAsli" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Fecha<span class="sup-required">*</span></flux:label>
                        <flux:input type="date" wire:model='sli_dateAsli' />
                        <div class="error-container">
                            <flux:error name="sli_dateAsli" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Emitido por<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='sli_emittedByAsli' />
                        <div class="error-container">
                            <flux:error name="sli_emittedByAsli" />
                        </div>
                    </flux:field>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
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


                <div class="form-grid form-grid--3 form-grid-3-variation">
                    <flux:label class="label-variation">Anexo de colindancias</flux:label>
                    <flux:input type="text" wire:model="state" placeholder="Guanajuato" />
                </div>

                <div class="form-grid form-grid--3 form-grid-3-variation">
                    <flux:label class="label-variation">Anexo de colindancias</flux:label>
                    <flux:input type="text" wire:model="state" placeholder="Guanajuato" />
                </div>

                <div class="form-grid form-grid--3 form-grid-3-variation">
                    <flux:label class="label-variation">Imágenes cargadas</flux:label>
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
                    <flux:field class="flux-field">
                        <flux:label>Calle con frente<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_streetWithFront' />
                        <div class="error-container">
                            <flux:error name="ct_streetWithFront" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--2">
                    <flux:field class="flux-field">
                        <flux:label>Calle transversal<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_CrossStreet1' />
                        <div class="error-container">
                            <flux:error name="ct_CrossStreet1" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Orientación calle transversal<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_crossStreetOrientation1' />
                        <div class="error-container">
                            <flux:error name="ct_crossStreetOrientation1" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--2">
                    <flux:field class="flux-field">
                        <flux:label>Calle transversal<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_CrossStreet2' />
                        <div class="error-container">
                            <flux:error name="ct_CrossStreet2" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>orientación calle transversal<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_crossStreetOrientation2' />
                        <div class="error-container">
                            <flux:error name="ct_crossStreetOrientation2" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--2">
                    <flux:field class="flux-field">
                        <flux:label>Calle limítrofe<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_borderStreet1' />
                        <div class="error-container">
                            <flux:error name="ct_borderStreet1" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Orientación calle limítrofe<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_borderStreetOrientation1' />
                        <div class="error-container">
                            <flux:error name="ct_borderStreetOrientation1" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--2">
                    <flux:field class="flux-field">
                        <flux:label>Calle limítrofe<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_borderStreet2' />
                        <div class="error-container">
                            <flux:error name="ct_borderStreet2" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Orientación calle limítrofe<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_borderStreetOrientation2' />
                        <div class="error-container">
                            <flux:error name="ct_borderStreetOrientation2" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Configuración</h2>
                </div>

                <div class="form-grid form-grid--2">
                    <div class="relative inline-block w-full">
                        <flux:label>Ubicación<span class="sup-required">*</span></flux:label>
                        <flux:dropdown inline position="bottom" align="start" class="w-full">

                            {{-- Botón que muestra la selección --}}
                            <button @click.stop.prevent
                                @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                                , !$errors->has('ct_location')
                                ? 'border border-gray-300 text-gray-700 hover:border-gray-400'
                                : 'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500',
                                ])
                                >
                                <span class="flex-1 text-left text-gray-700">
                                    @switch($ct_location)
                                    @case('')
                                    -- Selecciona una opción --
                                    @break

                                    @case('1')
                                    1. Cabecera de manzana
                                    @break

                                    @case('2')
                                    2. Lote con dos frentes no contiguos
                                    @break

                                    @case('3')
                                    3. Lote en esquina
                                    @break

                                    @case('4')
                                    4. Lote interior
                                    @break

                                    @case('5')
                                    5. Lote intermedio
                                    @break

                                    @case('6')
                                    6. Manzana completa
                                    @break

                                 {{--    @default
                                   3 - Centrica - Campo --}}
                                    @endswitch
                                </span>
                                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Menú con ítems manuales --}}
                            <flux:menu
                                class="absolute left-0 top-full mt-1 w-3/5 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                                {{-- Cabecera fija --}}
                                <flux:menu.item disabled>
                                    <div class="w-full grid grid-cols-[20%_30%_50%] px-2 py-1 text-gray-600 font-medium">
                                        <span>Clave</span>
                                        <span>Nombre</span>
                                        <span>Frentes</span>
                                    </div>
                                </flux:menu.item>
                                <flux:menu.separator />

                                {{-- Opción “vacía” --}}
                                <flux:menu.item wire:click="$set('ct_location','')" value=""
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>0</span>
                                        <span>Ninguna</span>
                                        <span>.</span>
                                    </div>
                                </flux:menu.item>

                                {{-- Opción 1 --}}
                                <flux:menu.item wire:click="$set('ct_location','1')" value="1"
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>1</span>
                                        <span>Cabecera de manzana</span>
                                        <span>3</span>
                                    </div>
                                </flux:menu.item>

                                {{-- Opción 2 --}}
                                <flux:menu.item wire:click="$set('ct_location','2')" value="2"
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>2</span>
                                        <span>Lote con dos frentes no contiguos</span>
                                        <span>2</span>
                                    </div>
                                </flux:menu.item>

                                {{-- Opción 3 --}}
                                <flux:menu.item wire:click="$set('ct_location','3')" value="3"
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>3</span>
                                        <span>Lote con esquina</span>
                                        <span>2</span>
                                    </div>
                                </flux:menu.item>

                                {{-- Opción 4 --}}
                                <flux:menu.item wire:click="$set('ct_location','4')" value="4"
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>4</span>
                                        <span>Lote interior</span>
                                        <span>0</span>
                                    </div>
                                </flux:menu.item>

                                {{-- Opción 5 --}}
                                <flux:menu.item wire:click="$set('ct_location','5')" value="5"
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>5</span>
                                        <span>Lote intermedio</span>
                                        <span>1</span>
                                    </div>
                                </flux:menu.item>

                                {{-- Opción 6 --}}
                                <flux:menu.item wire:click="$set('ct_location','6')" value="6"
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>6</span>
                                        <span>Manzana completa</span>
                                        <span>4</span>
                                    </div>
                                </flux:menu.item>

                            </flux:menu>
                        </flux:dropdown>

                        {{-- Mensaje de error --}}
                        <div class="mt-1">
                            <flux:error name="ct_location" />
                        </div>
                    </div>
                    <flux:field class="flux-field">
                            <flux:label>Configuracion<span class="sup-required">*</span></flux:label>
                            <flux:select wire:model="ct_configuration" class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                <flux:select.option value="1. Regular">1.Regular</flux:select.option>
                                <flux:select.option value="2. Irregular">2. Irregular</flux:select.option>
                            </flux:select>
                        <div>
                            <flux:error name="ct_configuration" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--2">
                    <flux:field class="flux-field">
                        <flux:label>Topografía<span class="sup-required">*</span></flux:label>
                       <flux:select wire:model="ct_topography" class=" text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="1. Plano">1. Plano</flux:select.option>
                        <flux:select.option value="2. Accidentado">2. Accidentado</flux:select.option>
                        <flux:select.option value="3. Con pendiente ascendente">3. Con pendiente ascendente</flux:select.option>
                        <flux:select.option value="4. Con pendiente descendente">4. Con pendiente descendente</flux:select.option>
                    </flux:select>
                        <div class="error-container">
                            <flux:error name="ct_topography" />
                        </div>
                    </flux:field>
                    <div class="relative inline-block w-full">
                        <flux:label>Tipo de vialidad<span class="sup-required">*</span></flux:label>
                        <flux:dropdown inline position="bottom" align="start" class="w-full">

                            {{-- Botón que muestra la selección --}}
                            <button @click.stop.prevent
                                @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                                , !$errors->has('ct_typeOfRoad')
                                ? 'border border-gray-300 text-gray-700 hover:border-gray-400'
                                : 'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500',
                                ])
                                >
                                <span class="flex-1 text-left text-gray-700">
                                    @switch($ct_typeOfRoad)
                                    @case('')
                                    -- Selecciona una opción --
                                    @break

                                    @case('1')
                                    1. Calle inferior a la moda
                                    @break

                                    @case('2')
                                    2. Calle moda
                                    @break

                                    @case('3')
                                    3. Calle superior a la moda
                                    @break

                                    @case('4')
                                    4. Calle con frente a parque, plaza o jardin
                                    @break

                                    {{-- @default
                                    3 - Centrica - Campo --}}
                                    @endswitch
                                </span>
                                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Menú con ítems manuales --}}
                            <flux:menu
                                class="absolute left-0 top-full mt-1 w-3/5 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                                {{-- Cabecera fija --}}
                                <flux:menu.item disabled>
                                    <div class="w-full grid grid-cols-[20%_30%_50%] px-2 py-1 text-gray-600 font-medium">
                                        <span>Clave</span>
                                        <span>Nombre</span>
                                        <span>Frentes</span>
                                    </div>
                                </flux:menu.item>
                                <flux:menu.separator />

                                {{-- Opción “vacía” --}}
                                <flux:menu.item wire:click="$set('ct_typeOfRoad','')" value=""
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>0</span>
                                        <span>Ninguna</span>
                                        <span>.</span>
                                    </div>
                                </flux:menu.item>

                                {{-- Opción 1 --}}
                                <flux:menu.item wire:click="$set('ct_typeOfRoad','1')" value="1"
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>1</span>
                                        <span>Calle inferior a la moda</span>
                                        <span>3</span>
                                    </div>
                                </flux:menu.item>

                                {{-- Opción 2 --}}
                                <flux:menu.item wire:click="$set('ct_typeOfRoad','2')" value="2"
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>2</span>
                                        <span>Calle moda</span>
                                        <span>2</span>
                                    </div>
                                </flux:menu.item>

                                {{-- Opción 3 --}}
                                <flux:menu.item wire:click="$set('ct_typeOfRoad','3')" value="3"
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>3</span>
                                        <span>Calle superior a la moda</span>
                                        <span>2</span>
                                    </div>
                                </flux:menu.item>

                                {{-- Opción 4 --}}
                                <flux:menu.item wire:click="$set('ct_typeOfRoad','4')" value="4"
                                    class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 menu-item-personalized">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span>4</span>
                                        <span>Calle con frente a parque, plaza o jardin</span>
                                        <span>0</span>
                                    </div>
                                </flux:menu.item>


                            </flux:menu>
                        </flux:dropdown>

                        {{-- Mensaje de error --}}
                        <div class="mt-1">
                            <flux:error name="ct_location" />
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--2">
                    <flux:field class="flux-field">
                        <flux:label>Características panorámicas<span class="sup-required">*</span></flux:label>
                        <flux:textarea wire:model='ct_panoramicFeatures' />
                        <div class="error-container">
                            <flux:error name="ct_panoramicFeatures" />
                        </div>
                    </flux:field>
                    {{-- <flux:field class="flux-field">
                        <flux:label>Servimbre y/o restricciones<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_EasementRestrictions' />
                        <div class="error-container">
                            <flux:error name="ct_EasementRestrictions" />
                        </div>
                    </flux:field> --}}
                    <flux:field class="flux-field">
                        <flux:label>Servimbre y/o restricciones<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model="ct_EasementRestrictions" class=" text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="No existen restricciones de construccion en el terreno">No existen restricciones de construccion en el terreno</flux:select.option>
                            <flux:select.option value="Las propias del reglamento de construccion vigente">Las propias del reglamento de construccion vigente</flux:select.option>
                            <flux:select.option value="Las propias del programa delegacional de desarrollo urbano, en cuanto a numero de niveles, altura de las construcciones, porcentaje de area libre y area de vivienda minima">Las propias del programa delegacional de desarrollo urbano, en cuanto a numero de niveles, altura de las construcciones, porcentaje de area libre y area de vivienda minima</flux:select.option>
                            <flux:select.option value="Otras">Otras</flux:select.option>
                        </flux:select>

                        <div>
                            <flux:error name="ct_EasementRestrictions" />
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
    </form>
</div>
