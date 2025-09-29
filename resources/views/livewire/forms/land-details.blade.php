<div>
    {{-- AÑADIDO: Estilos CSS de Leaflet. Esencial para que el mapa se vea correctamente. --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <style>
        /* AÑADIDO: Asegura que los contenedores de los mapas tengan una altura definida */
        .map-container {
            height: 350px;
            border-radius: 12px;
            z-index: 1;
            /* Asegura que el mapa se muestre correctamente sobre otros elementos */
        }
    </style>

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

                @if (!$landDetail)
                {{-- <small>Debes guardar los datos principales para poder usar esta opción</small> --}}
                <div class="font-semibold text-sm text-red-600 mb-2"><span>Debes guardar los datos principales para
                        poder usar esta opción</span></div>
                {{-- <br><br> --}}
                @endif
                <div class="form-grid form-grid--3 form-grid-3-variation">

                    {{-- Primer elemento hijo: el label --}}
                    <flux:label class="label-variation">Anexo de colindancias</flux:label>

                    {{-- Segundo elemento hijo: el contenedor de todo el contenido --}}
                    <div>
                        <div class="flex items-center gap-4">
                            {{-- Input de archivo oculto para múltiples selecciones --}}
                            <input type="file" wire:model="photos" class="sr-only" id="file-upload" multiple @if(!$landDetail) disabled @endif>

                            {{-- Botón estilizado para seleccionar archivos --}}
                            <label for="file-upload"
                                class="cursor-pointer inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                <svg class="h-5 w-5 text-gray-500 mr-2" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 4-4z"
                                        clip-rule="evenodd" />
                                </svg>
                                Seleccionar archivo
                            </label>

                            {{-- Muestra la cantidad de archivos seleccionados o un mensaje por defecto --}}
                            @if (count($photos) > 0)
                            <span class="text-sm text-gray-500">
                                {{ count($photos) }} archivo(s) seleccionado(s)
                            </span>
                            @else
                            <span class="text-sm text-gray-500">
                                No se ha seleccionado archivo
                            </span>
                            @endif
                        </div>

                        {{-- El error de validación debe aparecer debajo del input --}}
                        @error('photos.*')
                        {{-- <span class="text-red-500 text-sm mt-1">{{ $message }}</span> --}}
                        <flux:error name="photos" />
                        @enderror
                        @error('photos')
                        {{-- <span class="text-red-500 text-sm mt-1">{{ $message }}</span> --}}
                        <flux:error name="photos" />
                        @enderror

                        {{-- El botón de carga va debajo de todo --}}
                        <div class="mt-4">
                            <flux:button wire:click="uploadFiles" class="btn-primary btn-files cursor-pointer">Cargar
                                archivos
                            </flux:button>
                        </div>

                        {{-- Muestra un mensaje de éxito cuando la carga es correcta --}}
                        {{-- @if (session()->has('message'))
                        <div class="mt-4 text-green-600 text-sm font-semibold">
                            {{ session('message') }}
                        </div>
                        @endif --}}
                        <div wire:loading wire:target="photos"
                            class="mt-2 text-sm text-blue-600 flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                            </svg>
                            Subiendo archivos...
                        </div>
                    </div>
                </div>


                <div class="form-grid form-grid--3 form-grid-3-variation mb-4">
                    <flux:label class="label-variation">Archivos cargados</flux:label>
                    <div class="grid grid-cols-3 gap-4">
                        @forelse ($measureBoundaries as $file)
                        <div class="relative border p-2 rounded shadow bg-white">

                            @if ($file->file_type === 'image')
                            {{-- Miniatura para imagen --}}
                            <img src="{{ asset('storage/' . $file->file_path) }}" alt="{{ $file->original_name }}"
                                class="w-full h-32 object-cover rounded">

                            {{-- Botón para ver en nueva pestaña --}}
                            <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                class="block mt-2 text-xs text-center text-blue-600 hover:underline">
                                Ver imagen completa
                            </a>

                            {{-- @elseif ($file->file_type === 'pdf')

                            <div class="flex flex-col items-center justify-center h-32">

                                <svg class="w-10 h-10 text-red-500 mb-2" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M4 2a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V7.828A2 2 0 0017.414 7L13 2.586A2 2 0 0011.586 2H4z" />
                                </svg>
                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                    class="text-xs text-blue-600 hover:underline text-center">
                                    Ver PDF
                                </a>
                            </div>
                            @endif --}}


                            @elseif ($file->file_type === 'pdf')
                            <div class="w-full">
                                <embed src="{{ asset('storage/' . $file->file_path) }}" type="application/pdf"
                                    width="100%" height="250px" />

                                <a href="{{ asset('storage/' . $file->file_path) }}" target="_blank"
                                    class="text-xs text-blue-600 hover:underline block mt-1 text-center">
                                    Ver en otra pestaña
                                </a>
                            </div>
                            @endif

                            {{-- Botón eliminar --}}
                            <button type="button" wire:click="deleteFile({{ $file->id }})"
                                class="absolute top-1 right-1 text-white bg-red-600 rounded-full w-6 h-6 flex items-center justify-center text-xs hover:bg-red-700 cursor-pointer"
                                onclick="confirm('¿Seguro que deseas eliminar este archivo?') || event.stopImmediatePropagation()">
                                ×
                            </button>
                        </div>
                        @empty
                        <p class="text-sm col-span-3 text-gray-500">No hay archivos cargados aún.</p>
                        @endforelse
                    </div>
                </div>


                @if (!$landDetail)
                <div class="font-semibold text-sm text-red-600"><span>Debes guardar los datos principales para poder
                        usar esta
                        opción</span></div>
                @endif
                <div class="flex justify-between text-lg border-b-2 border-gray-300 mt-8">
                    <h2>Grupos de colindancias</h2>
                    {{-- <flux:modal.trigger name="add-group" class="flex justify-end mb-2"> --}}
                        <flux:button class="btn-primary btn-table cursor-pointer mb-2" wire:click='openAddGroup'>Agregar
                            grupo</flux:button>
                        {{--
                    </flux:modal.trigger> --}}
                </div>
                <br>
                @forelse ($groupsWithNeighbors as $index => $group)
                <div class="border-2 p-4 mt-4">
                    <div class="flex justify-between text-md mt-2">
                        <h3>Grupo {{ $group->name }}</h3>
                        <flux:button
                            onclick="confirm('¿Estás seguro de que deseas eliminar este grupo?') || event.stopImmediatePropagation()"
                            wire:click="deleteGroup({{ $group->id }})" type="button"
                            class="btn-deleted btn-files cursor-pointer mr-2">
                            Eliminar grupo
                        </flux:button>
                    </div>

                    <div class="flex justify-between text-md mb-2">
                        <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"
                            wire:click='openAddElement({{ $group->id }})'>
                        </flux:button>
                    </div>

                    <div class="mt-2">
                        <div class="overflow-x-auto max-w-full">
                            <table class="min-w-[550px] table-fixed w-full border-2">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-2 py-1 border whitespace-nowrap">Orientación</th>
                                        <th class="py-1 border">Medida</th>
                                        <th class="px-2 py-1 border">Colindancia</th>
                                        <th class="w-[100px] py-1 border">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($group->neighbors as $neighbor)
                                    <tr>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $neighbor->orientation }}
                                        </td>
                                        <td class="px-2 py-1 border text-sm text-center">{{ $neighbor->extent }}</td>
                                        <td class="px-2 py-1 border text-sm text-center">{{ $neighbor->adjacent }}</td>
                                        <td class="my-2 flex justify-evenly">
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins"
                                                wire:click='openEditElement({{ $neighbor->id }})' />
                                            <flux:button
                                                onclick="confirm('¿Estás seguro de que deseas eliminar este elemento?') || event.stopImmediatePropagation()"
                                                wire:click="deleteElement({{ $neighbor->id }})" type="button"
                                                icon-leading="trash" class="cursor-pointer btn-deleted btn-buildings" />
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="text-center py-2 text-gray-500">No hay elementos en este
                                            grupo.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-6 text-gray-500 text-sm border border-dashed rounded-md mt-6">
                    No hay grupos registrados.
                </div>
                @endforelse
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

                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg" wire:ignore>

                    <div id="map-macro" class="map-container"></div>

                    <div id="map-micro" class="map-container"></div>
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
                                : 'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500
                                focus:border-red-500',
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

                                    {{-- @default
                                    3 - Centrica - Campo --}}
                                    @endswitch
                                </span>
                                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Menú con ítems manuales --}}
                            <flux:menu
                                class="absolute left-0 top-full mt-1 w-3/5 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                                {{-- Cabecera fija --}}
                                <flux:menu.item disabled>
                                    <div
                                        class="w-full grid grid-cols-[20%_30%_50%] px-2 py-1 text-gray-600 font-medium">
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
                            <flux:select.option value="1. Regular">1. Regular</flux:select.option>
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
                            <flux:select.option value="3. Con pendiente ascendente">3. Con pendiente ascendente
                            </flux:select.option>
                            <flux:select.option value="4. Con pendiente descendente">4. Con pendiente descendente
                            </flux:select.option>
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
                                : 'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500
                                focus:border-red-500',
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
                                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            {{-- Menú con ítems manuales --}}
                            <flux:menu
                                class="absolute left-0 top-full mt-1 w-3/5 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                                {{-- Cabecera fija --}}
                                <flux:menu.item disabled>
                                    <div
                                        class="w-full grid grid-cols-[20%_30%_50%] px-2 py-1 text-gray-600 font-medium">
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

                    <flux:field class="flux-field">
                        <flux:label>Servimbre y/o restricciones<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="ct_EasementRestrictions"
                            class=" text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="No existen restricciones de construccion en el terreno">No
                                existen
                                restricciones de construccion en el terreno</flux:select.option>
                            <flux:select.option value="Las propias del reglamento de construccion vigente">Las propias
                                del
                                reglamento de construccion vigente</flux:select.option>
                            <flux:select.option
                                value="Las propias del programa delegacional de desarrollo urbano, en cuanto a numero de niveles, altura de las construcciones, porcentaje de area libre y area de vivienda minima">
                                Las propias del programa delegacional de desarrollo urbano, en cuanto a numero de
                                niveles,
                                altura de las construcciones, porcentaje de area libre y area de vivienda minima
                            </flux:select.option>
                            <flux:select.option value="Otras">Otras</flux:select.option>
                        </flux:select>

                        <div>
                            <flux:error name="ct_EasementRestrictions" />
                        </div>
                    </flux:field>
                </div>

                @if ($ct_EasementRestrictions === 'Otras')
                <div class="form-grid form-grid--2">
                    <flux:field class="flux-field">
                        <flux:label>Especifique otras (servimbre y/o restricciones)<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='ct_EasementRestrictionsOthers' />
                        <div class="error-container">
                            <flux:error name="ct_EasementRestrictionsOthers" />
                        </div>
                    </flux:field>
                </div>
                @endif

            </div>
        </div>








        {{-- CONTENEDOR 4 --}}
        <div class="form-container">
            <div class="form-container__header">
                Superficie del terreno
            </div>
            <div class="form-container__content">
                @if (!$landDetail)
                <div class="font-semibold text-sm text-red-600"><span>Debes guardar los datos principales para poder
                        usar esta
                        opción</span></div>
                <br><br>
                @endif
                <div class="flex justify-start text-md">
                    {{-- <flux:modal.trigger name="add-item" class="flex justify-end"> --}}
                        <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"
                            wire:click='openAddLandSurface'>
                        </flux:button>
                        {{--
                    </flux:modal.trigger> --}}
                </div>
                <div class="form-grid form-grid--2 pt-4">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 ">Superficie en M²</th>
                                    <th class="px-2 py-1 ">Área de valor</th>
                                    <th class="px-2 py-1 ">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($landSurfaces as $surface)
                                <tr>
                                    <td class="px-2 py-1 text-xs text-center">{{ number_format($surface->surface, 2) }}
                                    </td>
                                    <td class="px-2 py-1 text-xs text-center">{{ number_format($surface->value_area, 2)
                                        }}</td>
                                    <td class="my-2 flex justify-evenly">
                                        <flux:button type="button" icon-leading="pencil"
                                            class="cursor-pointer btn-intermediary btn-buildins"
                                            wire:click="openEditLandSurface({{ $surface->id }})" />
                                        <flux:button
                                            onclick="confirm('¿Estás seguro de que deseas eliminar esto?') || event.stopImmediatePropagation()"
                                            wire:click="deleteLandSurface({{ $surface->id }})" type="button"
                                            icon-leading="trash" class="cursor-pointer btn-deleted btn-buildings" />
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="text-center text-gray-500 py-2">
                                        No hay elementos registrados.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>



                <div class="form-grid form-grid--3 form-grid-3-variation pt-8">
                    <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start">
                        <flux:label>Utilizar cálculo del terreno excedente</flux:label>
                    </div>
                    <div class="radio-input">
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:checkbox wire:model.live="ls_useExcessCalculation" />
                            </div>
                            <div>
                                <flux:error name="ls_useExcessCalculation" />
                            </div>
                        </flux:field>
                    </div>
                </div>

                @if ($ls_useExcessCalculation)
                <div class="form-grid form-grid--3 form-grid-3-variation pt-8">
                    <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start">
                        <flux:label>Superficie del lote privativo</flux:label>
                    </div>
                    <div class="radio-input">
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:input.group>
                                    <flux:input type="text" wire:model='ls_surfacePrivateLot' />
                                    <flux:button disabled><b>m²</b></flux:button>
                                </flux:input.group>
                            </div>
                            <div>
                                <flux:error name="ls_surfacePrivateLot" />
                            </div>
                        </flux:field>
                    </div>
                </div>


                <div class="form-grid form-grid--3 form-grid-3-variation pt-8">
                    <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start">
                        <flux:label>Superficie del lote privativo tipo</flux:label>
                    </div>
                    <div class="radio-input">
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:input.group>
                                    <flux:input type="text" wire:model='ls_surfacePrivateLotType' />
                                    <flux:button disabled><b>m²</b></flux:button>
                                </flux:input.group>
                            </div>
                            <div>
                                <flux:error name="ls_surfacePrivateLotType" />
                            </div>
                        </flux:field>
                    </div>
                </div>
                @endif


                @if (stripos($valuation->property_type, 'condominio') !== false)
                <div class="form-grid form-grid--3 form-grid-3-variation pt-8">
                    <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start">
                        <flux:label>Indiviso (solo en condominio)</flux:label>
                    </div>
                    <div class="radio-input">
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:input.group>
                                    <flux:input type="number" wire:model='ls_undividedOnlyCondominium' />
                                    <flux:button disabled><b>%</b></flux:button>
                                </flux:input.group>
                            </div>
                            <div>
                                <flux:error name="ls_undividedOnlyCondominium" />
                            </div>
                        </flux:field>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-3-variation pt-8">
                    <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start">
                        <flux:label>Superficie indivisa del terreno</flux:label>
                    </div>
                    <div class="radio-input">
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <div>{{$ls_undividedSurfaceLand}} <b>M²</b></div>
                                {{-- 1.98 M² --}}
                            </div>
                            <div>
                                <flux:error name="ls_undividedSurfaceLand" />
                            </div>
                        </flux:field>
                    </div>
                </div>
                @endif

                @if ($ls_useExcessCalculation)
                <div class="form-grid form-grid--3 form-grid-3-variation pt-8">
                    <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start">
                        <flux:label>Superficie de terreno excedente</flux:label>
                    </div>
                    <div class="radio-input">
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <div>{{$ls_surplusLandArea}}<b> M²</b></div>
                                {{-- 2 M² --}}
                            </div>
                            <div>
                                <flux:error name="ls_surplusLandArea" />
                            </div>
                        </flux:field>
                    </div>
                </div>
                @endif

            </div>
        </div>























        {{-- MODALES --}}



        {{-- Agregar grupo --}}
        <flux:modal name="add-group" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Crear grupo</flux:heading>
                </div>
                <flux:field class="flux-field">
                    <flux:label>Nombre del grupo</flux:label>
                    <flux:input type="text" wire:model='group' />
                    <div class="error-container">
                        <flux:error name="group" />
                    </div>
                </flux:field>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="button" wire:click='addGroup' class="btn-primary cursor-pointer">Crear grupo
                    </flux:button>
                </div>
            </div>
        </flux:modal>



        {{-- Agregar elemento --}}

        <flux:modal name="add-element" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Crear elemento</flux:heading>
                    {{-- <flux:text class="mt-2"></flux:text> --}}
                </div>
                <flux:field class="flux-field">
                    <flux:label>Orientación<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='orientation' />
                    <div class="error-container">
                        <flux:error name="orientation" />
                    </div>
                </flux:field>
                <flux:field class="flux-field">
                    <flux:label>Medida<span class="sup-required">*</span></flux:label>
                    <flux:input type="number" wire:model='extent' />
                    <div class="error-container">
                        <flux:error name="extent" />
                    </div>
                </flux:field>
                <flux:field class="flux-field">
                    <flux:label>Colindancia<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='adjacent' />
                    <div class="error-container">
                        <flux:error name="adjacent" />
                    </div>
                </flux:field>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="button" wire:click='addElement' class="btn-primary cursor-pointer">Crear elemento
                    </flux:button>
                </div>
            </div>
        </flux:modal>



        {{-- Editar elemento --}}

        <flux:modal name="edit-element" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Editar elemento</flux:heading>
                    {{-- <flux:text class="mt-2"></flux:text> --}}
                </div>
                <flux:field class="flux-field">
                    <flux:label>Orientación<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='orientation' />
                    <div class="error-container">
                        <flux:error name="orientation" />
                    </div>
                </flux:field>
                <flux:field class="flux-field">
                    <flux:label>Medida<span class="sup-required">*</span></flux:label>
                    <flux:input type="number" wire:model='extent' />
                    <div class="error-container">
                        <flux:error name="extent" />
                    </div>
                </flux:field>
                <flux:field class="flux-field">
                    <flux:label>Colindancia<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='adjacent' />
                    <div class="error-container">
                        <flux:error name="adjacent" />
                    </div>
                </flux:field>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="button" wire:click='editElement' class="btn-primary cursor-pointer">Editar
                        elemento
                    </flux:button>
                </div>
            </div>
        </flux:modal>














        {{-- Agregar elemento --}}

        <flux:modal name="add-LandSurface" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Crear elemento</flux:heading>
                    {{-- <flux:text class="mt-2"></flux:text> --}}
                </div>
                <flux:field class="flux-field">
                    <flux:label>Superficie en M²<span class="sup-required">*</span></flux:label>
                    <flux:input type="number" wire:model='modalSurface' />
                    <div class="error-container">
                        <flux:error name="modalSurface" />
                    </div>
                </flux:field>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="button" wire:click='addLandSurface' class="btn-primary cursor-pointer">Crear
                        elemento
                    </flux:button>
                </div>
            </div>
        </flux:modal>


        {{-- Editar elemento --}}

        <flux:modal name="edit-LandSurface" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Editar elemento</flux:heading>
                    {{-- <flux:text class="mt-2"></flux:text> --}}
                </div>
                <flux:field class="flux-field">
                    <flux:label>Superficie en M²<span class="sup-required">*</span></flux:label>
                    <flux:input type="number" wire:model='modalSurface' />
                    <div class="error-container">
                        <flux:error name="modalSurface" />
                    </div>
                </flux:field>
                <div class="flex">
                    <flux:spacer />
                    <flux:button type="button" wire:click="editLandSurface" class="btn-primary cursor-pointer">Editar
                        elemento
                    </flux:button>
                </div>
            </div>
        </flux:modal>

























        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
    </form>
<script>
    document.addEventListener('livewire:navigated', () => {
    const lat = @js($propertyLocation->latitude);
    const lng = @js($propertyLocation->longitude);
    const alt = @js($propertyLocation->altitude);
    const coords = [lat, lng];

    // Evita reinicializar si los mapas ya están montados
    if (document.getElementById('map-macro').innerHTML.trim() !== '') return;

    // Mapa Macro (vista amplia)
    const mapMacro = L.map('map-macro').setView(coords, 6); // Zoom bajo para vista lejana
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(mapMacro);
    L.marker(coords).addTo(mapMacro)
        .bindPopup(`<strong>Vista general</strong><br>Lat: ${lat}<br>Lng: ${lng}`)
        .openPopup();

    // Mapa Micro (vista cercana)
    const mapMicro = L.map('map-micro').setView(coords, 18); // Zoom alto para vista detallada
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
    }).addTo(mapMicro);
    L.marker(coords).addTo(mapMicro)
        .bindPopup(`<strong>Vista detallada</strong><br>Lat: ${lat}<br>Lng: ${lng}<br>Alt: ${alt} m`)
        .openPopup();
});
</script>
</div>
