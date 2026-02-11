<div>
  @if($isReadOnly)
    <div class="border-l-4 border-red-600 text-red-600 p-4 mb-4 rounded shadow-sm">
        <p class="font-bold">Modo Lectura</p>
        <p>El avalúo está en revisión. No puedes realizar modificaciones.</p>
    </div>
    @endif
    @if(!$isReadOnly)
    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>
    @endif
    <form wire:submit='save'>
        <fieldset @disabled($isReadOnly)>
        {{-- PRIMER CONTENEDOR --}}
        <div class="form-container">
            <div class="form-container__header">
                Características urbanas
            </div>
            <div class="form-container__content">


                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Clasificación de la zona<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:select wire:model="cu_zoneClassification"
                                class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                @foreach ($zone_classification_input as $value => $label)
                                <flux:select.option value="{{ $label }}">
                                    {{ $label }}
                                </flux:select.option>
                                @endforeach
                            </flux:select>
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="cu_zoneClassification" />
                    </div>
                </div>
                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Construcciones predominantes en la zona<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:textarea wire:model='cu_predominantBuildings' />
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="cu_predominantBuildings" />
                    </div>
                </div>


                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        N° de niveles de las construcciones de la zona<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:input type="text" wire:model='cu_zoneBuildingLevels' />
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="cu_zoneBuildingLevels" />
                    </div>
                </div>


                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Uso de las construcciones<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:select wire:model="cu_buildingUsage" class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                <flux:select.option value="1. Habitacional">1. Habitacional</flux:select.option>
                                <flux:select.option value="2. Industrial">2. Industrial</flux:select.option>
                                <flux:select.option value="3. Comercial">3. Comercial</flux:select.option>
                                <flux:select.option value="4. Mixta">4. Mixta</flux:select.option>
                                <flux:select.option value="5. Otro">5. Otro</flux:select.option>
                            </flux:select>
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="cu_buildingUsage" />
                    </div>
                </div>


                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Índice de saturación de la zona<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:select wire:model="cu_zoneSaturationIndex"
                                class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                <@foreach ($zone_saturation_index_input as $value=> $label)
                                    <flux:select.option value="{{ $label }}">
                                        {{ $label }}%
                                    </flux:select.option>
                                    @endforeach
                            </flux:select>
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="cu_zoneSaturationIndex" />
                    </div>
                </div>


                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Densidad de población<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:select wire:model="cu_populationDensity"
                                class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                <flux:select.option value="1. Nula">1. Nula</flux:select.option>
                                <flux:select.option value="2. Escasa">2. Escasa</flux:select.option>
                                <flux:select.option value="3. Normal">3. Normal</flux:select.option>
                                <flux:select.option value="4. Media">4. Media</flux:select.option>
                                <flux:select.option value="5. Semidensa">5. Semidensa</flux:select.option>
                                <flux:select.option value="6. Densa">6. Densa</flux:select.option>
                                <flux:select.option value="7. Flotante">7. Flotante</flux:select.option>
                            </flux:select>
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="cu_populationDensity" />
                    </div>
                </div>


                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Densidad habitacional (habitantes)<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:select wire:model="cu_housingDensity" class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                <flux:select.option value="1. Muy baja, 10 hab/ha una vivienda por lote de 1,000 m¹">1.
                                    Muy baja, 10 hab/ha una vivienda por lote de 1,000 m¹</flux:select.option>
                                <flux:select.option value="2. Baja, 50 hab/ha una vivienda por lote de 500 m¹">2. Baja,
                                    50 hab/ha una vivienda por lote de 500 m¹</flux:select.option>
                                <flux:select.option value="3. Baja, 100 a 200 hab/ha una vivienda por lote de 250 m¹">3.
                                    Baja, 100 a 200 hab/ha una vivienda por lote de 250 m¹</flux:select.option>
                                <flux:select.option value="4. Media, 400hab/ha una vivienda por lote de 125 m¹">4.
                                    Media, 400hab/ha una vivienda por lote de 125 m¹</flux:select.option>
                                <flux:select.option value="5. 5. Alta, 800 hab/ha">5. Alta, 800 hab/ha
                                </flux:select.option>
                            </flux:select>
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="cu_housingDensity" />
                    </div>
                </div>


                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Nivel socioeconómico de la zona<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:select wire:model.live="cu_zoneSocioeconomicLevel"
                                class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                <flux:select.option value="1. E Mas bajo">1. E Mas bajo</flux:select.option>
                                <flux:select.option value="2. D bajo">2. D bajo</flux:select.option>
                                <flux:select.option value="3. D+ Medio bajo">3. D+ Medio bajo</flux:select.option>
                                <flux:select.option value="4. C Medio">4. C Medio</flux:select.option>
                                <flux:select.option value="5. C+ Medio alto">5. C+ Medio alto</flux:select.option>
                                <flux:select.option value="6. A/B Alto">6. A/B Alto</flux:select.option>
                            </flux:select>
                        </flux:field>
                        <div class="mt-2">
                            @if ($cu_zoneSocioeconomicLevel === '1. E Mas bajo')
                            <p>E: Clase más baja - Es el segmento más bajo de la población. Se le incluye poco en la
                                segmentación de mercados. El
                                perfil del jefe de familia de estos hogares está formado por individuos con un nivel
                                educativo de primaria sin
                                completarla. Estas personas no poseen un lugar propio teniendo que rentar o utilizar
                                otros recursos para conseguirlo. En
                                un solo hogar suele vivir más de una generación y son totalmente austeros</p>
                            @endif
                            @if ($cu_zoneSocioeconomicLevel === '2. D bajo')
                            <p>
                                D: Clase Baja - Este es el segmento medio de las clases bajas. El perfil del jefe de
                                familia de estos hogares está
                                formado por individuos con un nivel educativo de primaria en promedio (completa en la
                                mayoría de los casos). Los hogares
                                pertenecientes a este segmento son propios o rentados (es fácil encontrar tipo
                                vecindades), los cuales son en su mayoría
                                de interés social o de rentas congeladas.
                            </p>
                            @endif
                            @if ($cu_zoneSocioeconomicLevel === '3. D+ Medio bajo')
                            <p>
                                D+: Clase Media Baja – Este segmento incluye a aquellos hogares que sus ingresos y/o
                                estilos de vida son ligeramente
                                menores a los de la clase media. Esto quiere decir, que son los que llevan un mejor
                                estilo de vida dentro de la clase
                                baja. El perfil del jefe de familia de estos hogares está formado por individuos con un
                                nivel educativo de secundaria o
                                primaria completa. Los hogares pertenecientes a este segmento son, en su mayoría, de su
                                propiedad; aunque algunas
                                personas rentan el inmueble y algunas viviendas son de interés social.
                            </p>
                            @endif
                            @if ($cu_zoneSocioeconomicLevel === '4. C Medio')
                            <p>
                                C: Clase Media – Este segmento contiene a lo que típicamente se denomina clase media. El
                                perfil del jefe de familia de
                                estos hogares está formado por individuos con un nivel educativo de preparatoria
                                principalmente. Los hogares
                                pertenecientes a este segmento son casas o departamentos propios o rentados con algunas
                                comodidades.
                            </p>
                            @endif
                            @if ($cu_zoneSocioeconomicLevel === '5. C+ Medio alto')
                            <p>
                                C+: Clase Media Alta – Este segmento incluye a aquellos que sus ingresos y/o estilo de
                                vida es ligeramente superior a
                                los de clase media. El perfil del jefe de familia de estos hogares está formado por
                                individuos con un nivel educativo de
                                Licenciatura. Generalmente viven en casas o departamentos propios algunos de lujo y
                                cuentan con todas las comodidades.
                            </p>
                            @endif
                            @if ($cu_zoneSocioeconomicLevel === '6. A/B Alto')
                            <p>
                                A/B: Clase Alta – Es el segmento con el más alto nivel de vida. El perfil del jefe de
                                familia de estos hogares está
                                formado básicamente por individuos con un nivel educativo de Licenciatura o mayor. Viven
                                en casas o departamentos de
                                lujo con todas las comodidades.
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="error-container">
                        <flux:error name="cu_zoneSocioeconomicLevel" />
                    </div>
                </div>


                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Vías de acceso e importancia<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:textarea wire:model='cu_accessRoutesImportance' />
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="cu_accessRoutesImportance" />
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Contaminación ambiental en la zona<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:select wire:model="cu_environmentalPollution"
                                class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                <flux:select.option value="calculation_false">
                                    Contaminacion del aire y ruido por vehículos automotores e industria vecina
                                </flux:select.option>
                                <flux:select.option value="calculation_false">
                                    Contaminacion del aire y ruido por vehiculos automotores sobre vialidades
                                    principales con trafico intenso
                                </flux:select.option>
                                <flux:select.option value="calculation_false">
                                    Contaminacion del aire, ruido, visual y fauna nociva por comercio informal de
                                    alimentos y bebidas en la via
                                    publica y por vehiculos automotores sobre vialidades principales con trafico intenso
                                </flux:select.option>
                                <flux:select.option value="calculation_false">
                                    No se aprecia contaminación ambiental aparente
                                </flux:select.option>
                                <flux:select.option value="calculation_false">
                                    Solo se detecto la provocada por vehiculos automotores en la zona
                                </flux:select.option>
                            </flux:select>
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="cu_environmentalPollution" />
                    </div>
                </div>


            </div>
        </div>
















        {{-- SEGUNDO CONTENEDOR --}}
        <div class="form-container">
            <div class="form-container__header">
                Infraestructura
            </div>
            <div class="form-container__content">


                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Cuenta con todos los servicios
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:field class="radio-group-horizontal">
                                <flux:checkbox wire:model.live='inf_allServices' class="cursor-pointer" />
                            </flux:field>
                        </div>
                    </div>
                    <div class="flux justify-end">
                        <flux:error name="inf_allServices" />
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Red de distribución de agua potable <br> <b>(Para nivel 2)</b>
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_waterDistribution'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Con suministro al inmueble
                                </label>
                                <label>
                                    <flux:radio value="2" />2. Sin suministro al inmueble
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_waterDistribution" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Red de recolección de aguas residuales <br> <b>(Para nivel 2)</b>
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_wastewaterCollection'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Con conexión al inmueble
                                </label>
                                <label>
                                    <flux:radio value="2" />2. Sin conexión al inmueble
                                </label>
                                <label>
                                    <flux:radio value="3" />3. Sin red de recolección
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_wastewaterCollection" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div
                    class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2 text-label-radio">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Red de drenaje de aguas pluviales en la calle <br> <b>(Para nivel 2)</b>
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_streetStormDrainage'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Si existe
                                </label>
                                <label>
                                    <flux:radio value="2" />2. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_streetStormDrainage" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Red de drenaje de aguas pluviales en la zona <br> (Para nivel 2)
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_zoneStormDrainage'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Si existe
                                </label>
                                <label>
                                    <flux:radio value="2" />2. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_zoneStormDrainage" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Sistema mixto (aguas residuales y pluviales) <br> <b>(Para nivel 2)</b>
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_mixedDrainageSystem'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Si existe
                                </label>
                                <label>
                                    <flux:radio value="2" />2. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_mixedDrainageSystem" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Otro tipo de desalojo de aguas
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_otherWaterDisposal'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Si existe
                                </label>
                                <label>
                                    <flux:radio value="2" />2. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_otherWaterDisposal" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Suministro eléctrico <br> <b>(Para nivel 2)</b>
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_electricSupply'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Red aérea
                                </label>
                                <label>
                                    <flux:radio value="2" />2. Red subterránea
                                </label>
                                <label>
                                    <flux:radio value="3" />3. Red mixta
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_electricSupply" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Acomedita de suministro eléctrico al inmueble
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_electricalConnection'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Si existe
                                </label>
                                <label>
                                    <flux:radio value="2" />2. No
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_electricalConnection" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Alumbrado público <br> (Para nivel 3)
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_publicLighting'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Sin alumbrado
                                </label>
                                <label>
                                    <flux:radio value="2" />2. Alumbrado con cable aéreo
                                </label>
                                <label>
                                    <flux:radio value="3" />3. Alumbrado con cableado subterraneo
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_publicLighting" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Gas natural <br> <b>(Para nivel 4)</b>
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_naturalGas'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Con acometida al inmueble
                                </label>
                                <label>
                                    <flux:radio value="2" />2. Existe en la zona sin acometida al inmueble
                                </label>
                                <label>
                                    <flux:radio value="3" />3. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_naturalGas" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Vigilancia <br> <b>(Para nivel 4)</b>
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_security' class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Municipal
                                </label>
                                <label>
                                    <flux:radio value="2" />2. Autónoma privada
                                </label>
                                <label>
                                    <flux:radio value="3" />3. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_security" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Recolección de basura
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model.live.debounce.150ms='inf_garbageCollection'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Si existe
                                </label>
                                <label>
                                    <flux:radio value="2" />2. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_garbageCollection" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>



                {{-- AÑADIR VALOR CONDICIONAL --}}
                @if ($inf_garbageCollection === "1")
                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Frecuencia de recolección de basura<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_garbageCollectionFrecuency'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:input type="text" wire:model='inf_garbageCollectionFrecuency' />
                                </label>
                                <label>
                                    Cada x número de días
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_garbageCollectionFrecuency" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>
                @endif







                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Suministro telefónico, por medio de
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_telephoneService'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Red aérea
                                </label>
                                <label>
                                    <flux:radio value="2" />2. Red subterránea
                                </label>
                                <label>
                                    <flux:radio value="3" />3. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_telephoneService" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Acometida telefónica al inmueble
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_telephoneConnection'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Si existe
                                </label>
                                <label>
                                    <flux:radio value="2" />2. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_telephoneConnection" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Señalización de vías
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_roadSignage'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Si existe
                                </label>
                                <label>
                                    <flux:radio value="2" />2. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_roadSignage" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Nomenclatura de calles
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:radio.group wire:model='inf_streetNaming'
                                class="radio-group-horizontal text-label-radio">
                                <label>
                                    <flux:radio value="1" />1. Si existe
                                </label>
                                <label>
                                    <flux:radio value="2" />2. No existe
                                </label>
                                <div class="flux justify-end">
                                    <flux:error name="inf_streetNaming" />
                                </div>
                            </flux:radio.group>
                        </div>
                    </div>
                </div>






                {{-- Tabla vialidades, banquetas y guarniciones --}}




                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban urban-infr">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Vialidades<span class="sup-required">*</span><br> (Para nivel 3)
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal flex gap-4">
                            <div class="w-80">
                                <div class="mb-1 text-sm font-medium text-gray-700 flex justify-center">Material</div>
                                <flux:field>
                                    <flux:select wire:model.live.debounce.150ms="inf_roadways"
                                        class=" text-gray-800 [&_option]:text-gray-900">
                                       {{--  <flux:select.option value="">-- Selecciona una opción --</flux:select.option> --}}
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
                                <flux:field class="mt-3 w-26">
                                    @if ($inf_roadways === '6. Otros')
                                    {{-- <label for="Indique otro"></label> --}}
                                    <flux:label class="text-[12px]">Indique otro<span class="sup-required">*</span></flux:label>
                                    <flux:input type="text" wire:model='inf_roadwaysOthers' />
                                    <flux:error name="inf_roadwaysOthers" />
                                    @endif
                                </flux:field>
                            </div>
                            <div class="w-80">
                                <div class="mb-1 text-sm font-medium text-gray-700 flex justify-center">Ancho</div>
                                <flux:field>
                                    <flux:input type="number" wire:model='inf_roadwaysMts' :disabled="$inf_roadways === '7. No presenta'" step="any"/>
                                    <flux:label class="text-[12px]">Metros</flux:label>
                                </flux:field>
                                <flux:error name="inf_roadwaysMts" />
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban urban-infr">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Banquetas<span class="sup-required">*</span><br> (Para nivel 3)
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal flex gap-4">
                            <div class="w-80">
                                <flux:field>
                                    <flux:select wire:model.live.debounce.150ms="inf_sidewalks"
                                        class=" text-gray-800 [&_option]:text-gray-900">
                                        {{-- <flux:select.option value="">-- Selecciona una opción --</flux:select.option> --}}
                                        <flux:select.option class="flex gap-4" value="1. Concreto">1. Concreto
                                        </flux:select.option>
                                        <flux:select.option class="flex gap-4" value="2. Empedrado">2. Empedrado
                                        </flux:select.option>
                                        <flux:select.option class="flex gap-4" value="3. Adoquin">3. Adoquin
                                        </flux:select.option>
                                        <flux:select.option class="flex gap-4" value="4. Otros">4. Otros
                                        </flux:select.option>
                                        <flux:select.option class="flex gap-4" value="5. No presenta">5. No presenta
                                        </flux:select.option>
                                    </flux:select>
                                </flux:field>
                                <flux:field class="mt-3 w-26">
                                    @if ($inf_sidewalks === '4. Otros')
                                    <flux:label class="text-[12px]">Indique otro<span class="sup-required">*</span></flux:label>
                                    <flux:input type="text" wire:model='inf_sidewalksOthers' />
                                    <flux:error name="inf_sidewalksOthers" />
                                    @endif
                                </flux:field>
                            </div>
                            <div class="w-80">
                                <flux:field>
                                    <flux:input type="number" wire:model='inf_sidewalksMts' :disabled="$inf_sidewalks === '5. No presenta'" step="any"/>
                                   <flux:label class="text-[12px]">Metros</flux:label>
                                   <flux:error name="inf_sidewalksMts" />
                                </flux:field>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban urban-infr">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Guarniciones<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <div class="w-80">
                                <flux:field>
                                    <flux:select wire:model.live.debounce.150ms="inf_curbs" class=" text-gray-800 [&_option]:text-gray-900">
                                        {{-- <flux:select.option value="">-- Selecciona una opción --</flux:select.option> --}}
                                        <flux:select.option class="flex gap-4" value="1. Concreto">1. Concreto
                                        </flux:select.option>
                                        <flux:select.option class="flex gap-4" value="2. Otro">2. Otro
                                        </flux:select.option>
                                        <flux:select.option class="flex gap-4" value="3. No existe">3. No existe
                                        </flux:select.option>
                                    </flux:select>
                                </flux:field>
                                <flux:field class="mt-3 w-26">
                                    @if ($inf_curbs === '2. Otro')
                                    <flux:label class="text-[12px]">Indique otro<span class="sup-required">*</span></flux:label>
                                    <flux:input type="text"  wire:model='inf_curbsOthers'/>
                                    <flux:error name="inf_curbsOthers" />
                                    @endif
                                </flux:field>
                            </div>
                            <div class="w-80">
                                <flux:field>
                                    <flux:input type="number" wire:model='inf_curbsMts' :disabled="$inf_curbs === '3. No existe'" step="any"/>
                                    <flux:label class="text-[12px]">Metros</flux:label>
                                    <flux:error name="inf_curbsMts" />
                                </flux:field>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>











        {{-- TERCER CONTENEDOR --}}
        <div class="form-container">
            <div class="form-container__header">
                Uso del suelo
            </div>
            <div class="form-container__content">

                {{--
                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban form-grid-urban border-b-2">
                    <div class="radio-label border-r-2">
                        Uso de suelo
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <label>
                                <input type="radio" value="si"> Si existe
                            </label>
                        </div>
                    </div>
                </div> --}}

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Uso de suelo<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:input type="text" wire:model='luse_landUse' />
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="luse_landUse" />
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Descripción y fuente donde se obtuvo el uso del suelo<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:textarea wire:model='luse_descriptionSourceLand' />
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="luse_descriptionSourceLand" />
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Área libre obligatoria %<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:input type="number" wire:model.lazy='luse_mandatoryFreeArea'/>
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="luse_mandatoryFreeArea" />
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Niveles permitidos<span class="sup-required">*</span>
                    </div>
                    <flux:field class="radio-group-horizontal">
                        <flux:input type="number" wire:model.lazy='luse_allowedLevels' min="0" max="999"  step="any" />
                    </flux:field>
                    <div class="error-container">
                        <flux:error name="luse_allowedLevels" />
                    </div>
                </div>


                <div class="form-grid form-grid--3 form-grid-radios form-grid-urban border-b-2">
                    <div class="min-w-[140px] radio-label border-r-2">
                        Coeficiente de uso de suelo de la zona<span class="sup-required">*</span>
                    </div>
                    <div class="radio-input">
                        <flux:field class="radio-group-horizontal">
                            <flux:input type="number" wire:model.live='luse_landCoefficientArea' readonly/>
                        </flux:field>
                    </div>
                    <div class="error-container">
                        <flux:error name="luse_landCoefficientArea" />
                    </div>
                </div>

            </div>
        </div>
        </fieldset>
        @if(!$isReadOnly)
        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
        @endif
    </form>
</div>
