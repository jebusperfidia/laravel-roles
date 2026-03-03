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
    <div class="form-container__content p-4">

        {{-- 1. Clasificación de la zona --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Clasificación de la zona<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:select wire:model="cu_zoneClassification"
                        class="w-full text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        @foreach ($zone_classification_input as $value => $label)
                        <flux:select.option value="{{ $label }}">
                            {{ $label }}
                        </flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="cu_zoneClassification" />
            </div>
        </div>

        {{-- 2. Construcciones predominantes --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Construcciones predominantes en la zona<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:textarea wire:model='cu_predominantBuildings' class="w-full" />
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="cu_predominantBuildings" />
            </div>
        </div>

        {{-- 3. Niveles de construcciones --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                N° de niveles de las construcciones de la zona<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:input type="text" wire:model='cu_zoneBuildingLevels' class="w-full" />
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="cu_zoneBuildingLevels" />
            </div>
        </div>

        {{-- 4. Uso de las construcciones --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Uso de las construcciones<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:select wire:model="cu_buildingUsage" class="w-full text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="1. Habitacional">1. Habitacional</flux:select.option>
                        <flux:select.option value="2. Industrial">2. Industrial</flux:select.option>
                        <flux:select.option value="3. Comercial">3. Comercial</flux:select.option>
                        <flux:select.option value="4. Mixta">4. Mixta</flux:select.option>
                        <flux:select.option value="5. Otro">5. Otro</flux:select.option>
                    </flux:select>
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="cu_buildingUsage" />
            </div>
        </div>

        {{-- 5. Índice de saturación --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Índice de saturación de la zona<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:select wire:model="cu_zoneSaturationIndex"
                        class="w-full text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        @foreach ($zone_saturation_index_input as $value => $label)
                        <flux:select.option value="{{ $label }}">
                            {{ $label }}%
                        </flux:select.option>
                        @endforeach
                    </flux:select>
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="cu_zoneSaturationIndex" />
            </div>
        </div>

        {{-- 6. Densidad de población --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Densidad de población<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:select wire:model="cu_populationDensity"
                        class="w-full text-gray-800 [&_option]:text-gray-900">
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
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="cu_populationDensity" />
            </div>
        </div>

        {{-- 7. Densidad habitacional --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Densidad habitacional (habitantes)<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:select wire:model="cu_housingDensity" class="w-full text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="1. Muy baja, 10 hab/ha una vivienda por lote de 1,000 m¹">1. Muy
                            baja, 10 hab/ha una vivienda por lote de 1,000 m¹</flux:select.option>
                        <flux:select.option value="2. Baja, 50 hab/ha una vivienda por lote de 500 m¹">2. Baja, 50
                            hab/ha una vivienda por lote de 500 m¹</flux:select.option>
                        <flux:select.option value="3. Baja, 100 a 200 hab/ha una vivienda por lote de 250 m¹">3. Baja,
                            100 a 200 hab/ha una vivienda por lote de 250 m¹</flux:select.option>
                        <flux:select.option value="4. Media, 400hab/ha una vivienda por lote de 125 m¹">4. Media,
                            400hab/ha una vivienda por lote de 125 m¹</flux:select.option>
                        <flux:select.option value="5. Alta, 800 hab/ha">5. Alta, 800 hab/ha</flux:select.option>
                    </flux:select>
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="cu_housingDensity" />
            </div>
        </div>

        {{-- 8. Nivel socioeconómico --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Nivel socioeconómico de la zona<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full flex-col items-start">
                <flux:field class="w-full">
                    <flux:select wire:model.live="cu_zoneSocioeconomicLevel"
                        class="w-full text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="1. E Mas bajo">1. E Mas bajo</flux:select.option>
                        <flux:select.option value="2. D bajo">2. D bajo</flux:select.option>
                        <flux:select.option value="3. D+ Medio bajo">3. D+ Medio bajo</flux:select.option>
                        <flux:select.option value="4. C Medio">4. C Medio</flux:select.option>
                        <flux:select.option value="5. C+ Medio alto">5. C+ Medio alto</flux:select.option>
                        <flux:select.option value="6. A/B Alto">6. A/B Alto</flux:select.option>
                    </flux:select>
                </flux:field>
                <div class="mt-3 text-xs text-gray-600 text-justify w-full">
                    @if ($cu_zoneSocioeconomicLevel === '1. E Mas bajo')
                    <p>E: Clase más baja - Es el segmento más bajo de la población. Se le incluye poco en la
                        segmentación de mercados. El perfil del jefe de familia de estos hogares está formado por
                        individuos con un nivel educativo de primaria sin completarla. Estas personas no poseen un lugar
                        propio teniendo que rentar o utilizar otros recursos para conseguirlo. En un solo hogar suele
                        vivir más de una generación y son totalmente austeros</p>
                    @endif
                    @if ($cu_zoneSocioeconomicLevel === '2. D bajo')
                    <p>D: Clase Baja - Este es el segmento medio de las clases bajas. El perfil del jefe de familia de
                        estos hogares está formado por individuos con un nivel educativo de primaria en promedio
                        (completa en la mayoría de los casos). Los hogares pertenecientes a este segmento son propios o
                        rentados (es fácil encontrar tipo vecindades), los cuales son en su mayoría de interés social o
                        de rentas congeladas.</p>
                    @endif
                    @if ($cu_zoneSocioeconomicLevel === '3. D+ Medio bajo')
                    <p>D+: Clase Media Baja – Este segmento incluye a aquellos hogares que sus ingresos y/o estilos de
                        vida son ligeramente menores a los de la clase media. Esto quiere decir, que son los que llevan
                        un mejor estilo de vida dentro de la clase baja. El perfil del jefe de familia de estos hogares
                        está formado por individuos con un nivel educativo de secundaria o primaria completa. Los
                        hogares pertenecientes a este segmento son, en su mayoría, de su propiedad; aunque algunas
                        personas rentan el inmueble y algunas viviendas son de interés social.</p>
                    @endif
                    @if ($cu_zoneSocioeconomicLevel === '4. C Medio')
                    <p>C: Clase Media – Este segmento contiene a lo que típicamente se denomina clase media. El perfil
                        del jefe de familia de estos hogares está formado por individuos con un nivel educativo de
                        preparatoria principalmente. Los hogares pertenecientes a este segmento son casas o
                        departamentos propios o rentados con algunas comodidades.</p>
                    @endif
                    @if ($cu_zoneSocioeconomicLevel === '5. C+ Medio alto')
                    <p>C+: Clase Media Alta – Este segmento incluye a aquellos que sus ingresos y/o estilo de vida es
                        ligeramente superior a los de clase media. El perfil del jefe de familia de estos hogares está
                        formado por individuos con un nivel educativo de Licenciatura. Generalmente viven en casas o
                        departamentos propios algunos de lujo y cuentan con todas las comodidades.</p>
                    @endif
                    @if ($cu_zoneSocioeconomicLevel === '6. A/B Alto')
                    <p>A/B: Clase Alta – Es el segmento con el más alto nivel de vida. El perfil del jefe de familia de
                        estos hogares está formado básicamente por individuos con un nivel educativo de Licenciatura o
                        mayor. Viven en casas o departamentos de lujo con todas las comodidades.</p>
                    @endif
                </div>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="cu_zoneSocioeconomicLevel" />
            </div>
        </div>

        {{-- 9. Vías de acceso e importancia --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Vías de acceso e importancia<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:textarea wire:model='cu_accessRoutesImportance' class="w-full" />
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="cu_accessRoutesImportance" />
            </div>
        </div>

        {{-- 10. Contaminación ambiental (Sin borde al final) --}}
        <div class="form-grid form-grid-radios form-grid-urban">
            <div class="radio-label border-r-custom">
                Contaminación ambiental en la zona<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:select wire:model="cu_environmentalPollution"
                        class="w-full text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option
                            value="Contaminacion del aire y ruido por vehículos automotores e industria vecina">
                            Contaminacion del aire y ruido por vehículos automotores e industria vecina
                        </flux:select.option>
                        <flux:select.option
                            value="Contaminacion del aire y ruido por vehiculos automotores sobre vialidades principales con trafico intenso">
                            Contaminacion del aire y ruido por vehiculos automotores sobre vialidades principales con
                            trafico intenso</flux:select.option>
                        <flux:select.option
                            value="Contaminacion del aire, ruido, visual y fauna nociva por comercio informal de alimentos y bebidas en la via publica y por vehiculos automotores sobre vialidades principales con trafico intenso">
                            Contaminacion del aire, ruido, visual y fauna nociva por comercio informal de alimentos y
                            bebidas en la via publica y por vehiculos automotores sobre vialidades principales con
                            trafico intenso</flux:select.option>
                        <flux:select.option value="No se aprecia contaminación ambiental aparente">No se aprecia
                            contaminación ambiental aparente</flux:select.option>
                        <flux:select.option value="Solo se detecto la provocada por vehiculos automotores en la zona">
                            Solo se detecto la provocada por vehiculos automotores en la zona</flux:select.option>
                    </flux:select>
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
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
    <div class="form-container__content p-4">

        {{-- 1. Todos los servicios --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Cuenta con todos los servicios
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full flex justify-center md:justify-start">
                    <flux:checkbox wire:model.live='inf_allServices' class="cursor-pointer" />
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_allServices" />
            </div>
        </div>

        {{-- 2. Agua potable --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                {{-- AQUÍ ESTÁ LA MAGIA: El span block envuelve todo para que Flexbox no se vuelva loco con el <br> --}}
                <span class="block w-full">Red de distribución de agua potable <br> <b class="text-[11px]">(Para nivel
                        2)</b></span>
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_waterDistribution'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Con suministro al inmueble
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. Sin suministro al inmueble
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_waterDistribution" />
            </div>
        </div>

        {{-- 3. Aguas residuales --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                <span class="block w-full">Red de recolección de aguas residuales <br> <b class="text-[11px]">(Para
                        nivel 2)</b></span>
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_wastewaterCollection'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Con conexión al inmueble
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. Sin conexión al inmueble
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="3" /> 3. Sin red de recolección
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_wastewaterCollection" />
            </div>
        </div>

        {{-- 4. Aguas pluviales en calle --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                <span class="block w-full">Red de drenaje de aguas pluviales en la calle <br> <b
                        class="text-[11px]">(Para nivel 2)</b></span>
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_streetStormDrainage'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Si existe
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_streetStormDrainage" />
            </div>
        </div>

        {{-- 5. Aguas pluviales en zona --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                <span class="block w-full">Red de drenaje de aguas pluviales en la zona <br> <b
                        class="text-[11px]">(Para nivel 2)</b></span>
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_zoneStormDrainage'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Si existe
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_zoneStormDrainage" />
            </div>
        </div>

        {{-- 6. Sistema mixto --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                <span class="block w-full">Sistema mixto (aguas residuales y pluviales) <br> <b
                        class="text-[11px]">(Para nivel 2)</b></span>
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_mixedDrainageSystem'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Si existe
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_mixedDrainageSystem" />
            </div>
        </div>

        {{-- 7. Otro desalojo --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Otro tipo de desalojo de aguas
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_otherWaterDisposal'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Si existe
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_otherWaterDisposal" />
            </div>
        </div>

        {{-- 8. Suministro eléctrico --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                <span class="block w-full">Suministro eléctrico <br> <b class="text-[11px]">(Para nivel 2)</b></span>
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_electricSupply'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Red aérea
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. Red subterránea
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="3" /> 3. Red mixta
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_electricSupply" />
            </div>
        </div>

        {{-- 9. Acometida eléctrica --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Acometida de suministro eléctrico al inmueble
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_electricalConnection'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Si existe
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. No
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_electricalConnection" />
            </div>
        </div>

        {{-- 10. Alumbrado público --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                <span class="block w-full">Alumbrado público <br> <b class="text-[11px]">(Para nivel 3)</b></span>
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_publicLighting'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Sin alumbrado
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. Alumbrado con cable aéreo
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="3" /> 3. Alumbrado con cableado subterraneo
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_publicLighting" />
            </div>
        </div>

        {{-- 11. Gas natural --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                <span class="block w-full">Gas natural <br> <b class="text-[11px]">(Para nivel 4)</b></span>
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_naturalGas'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Con acometida al inmueble
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. Existe en la zona sin acometida al inmueble
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="3" /> 3. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_naturalGas" />
            </div>
        </div>

        {{-- 12. Vigilancia --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                <span class="block w-full">Vigilancia <br> <b class="text-[11px]">(Para nivel 4)</b></span>
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_security'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Municipal
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. Autónoma privada
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="3" /> 3. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_security" />
            </div>
        </div>

        {{-- 13. Recolección de basura --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Recolección de basura
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model.live.debounce.150ms='inf_garbageCollection'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Si existe
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_garbageCollection" />
            </div>
        </div>

        {{-- 14. VALOR CONDICIONAL (Frecuencia basura) --}}
        @if ($inf_garbageCollection === "1")
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle bg-gray-50">
            <div class="radio-label border-r-custom">
                Frecuencia de recolección de basura<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <div class="flex items-center gap-3 w-full justify-center md:justify-start">
                    <flux:input type="text" wire:model='inf_garbageCollectionFrecuency' class="w-24" />
                    <span class="text-sm font-medium text-gray-800">Cada x número de días</span>
                </div>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_garbageCollectionFrecuency" />
            </div>
        </div>
        @endif

        {{-- 15. Suministro telefónico --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Suministro telefónico, por medio de
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_telephoneService'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Red aérea
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. Red subterránea
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="3" /> 3. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_telephoneService" />
            </div>
        </div>

        {{-- 16. Acometida telefónica --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Acometida telefónica al inmueble
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_telephoneConnection'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Si existe
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_telephoneConnection" />
            </div>
        </div>

        {{-- 17. Señalización de vías --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Señalización de vías
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_roadSignage'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Si existe
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_roadSignage" />
            </div>
        </div>

        {{-- 18. Nomenclatura de calles --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Nomenclatura de calles
            </div>
            <div class="radio-input w-full">
                <flux:radio.group wire:model='inf_streetNaming'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio w-full">
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="1" /> 1. Si existe
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer font-medium text-gray-800">
                        <flux:radio value="2" /> 2. No existe
                    </label>
                </flux:radio.group>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="inf_streetNaming" />
            </div>
        </div>

        {{-- TABLAS: Vialidades, Banquetas y Guarniciones --}}

        {{-- 19. Vialidades --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                <span class="block w-full">Vialidades<span class="sup-required">*</span><br> <b
                        class="text-[11px]">(Para nivel 3)</b></span>
            </div>
            <div class="radio-input w-full">
                <div class="flex flex-col md:flex-row gap-6 w-full">
                    <div class="flex-1 w-full">
                        <div class="mb-2 text-sm font-semibold text-gray-700 text-center md:text-left">Material</div>
                        <flux:field class="w-full">
                            <flux:select wire:model.live.debounce.150ms="inf_roadways"
                                class="w-full text-gray-800 [&_option]:text-gray-900">
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
                        @if ($inf_roadways === '6. Otros')
                        <flux:field class="mt-3 w-full">
                            <flux:label class="text-[12px]">Indique otro<span class="sup-required">*</span></flux:label>
                            <flux:input type="text" wire:model='inf_roadwaysOthers' class="w-full" />
                            <flux:error name="inf_roadwaysOthers" />
                        </flux:field>
                        @endif
                    </div>
                    <div class="flex-1 w-full">
                        <div class="mb-2 text-sm font-semibold text-gray-700 text-center md:text-left">Ancho</div>
                        <flux:field class="w-full">
                            <flux:input type="number" wire:model='inf_roadwaysMts'
                                :disabled="$inf_roadways === '7. No presenta'" step="any" class="w-full" />
                            <flux:label class="text-[12px] mt-1">Metros</flux:label>
                            <flux:error name="inf_roadwaysMts" />
                        </flux:field>
                    </div>
                </div>
            </div>
            <div class="hidden md:block"></div>
        </div>

        {{-- 20. Banquetas --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                <span class="block w-full">Banquetas<span class="sup-required">*</span><br> <b class="text-[11px]">(Para
                        nivel 3)</b></span>
            </div>
            <div class="radio-input w-full">
                <div class="flex flex-col md:flex-row gap-6 w-full">
                    <div class="flex-1 w-full">
                        <flux:field class="w-full">
                            <flux:select wire:model.live.debounce.150ms="inf_sidewalks"
                                class="w-full text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="1. Concreto">1. Concreto</flux:select.option>
                                <flux:select.option value="2. Empedrado">2. Empedrado</flux:select.option>
                                <flux:select.option value="3. Adoquin">3. Adoquin</flux:select.option>
                                <flux:select.option value="4. Otros">4. Otros</flux:select.option>
                                <flux:select.option value="5. No presenta">5. No presenta</flux:select.option>
                            </flux:select>
                        </flux:field>
                        @if ($inf_sidewalks === '4. Otros')
                        <flux:field class="mt-3 w-full">
                            <flux:label class="text-[12px]">Indique otro<span class="sup-required">*</span></flux:label>
                            <flux:input type="text" wire:model='inf_sidewalksOthers' class="w-full" />
                            <flux:error name="inf_sidewalksOthers" />
                        </flux:field>
                        @endif
                    </div>
                    <div class="flex-1 w-full">
                        <flux:field class="w-full">
                            <flux:input type="number" wire:model='inf_sidewalksMts'
                                :disabled="$inf_sidewalks === '5. No presenta'" step="any" class="w-full" />
                            <flux:label class="text-[12px] mt-1">Metros</flux:label>
                            <flux:error name="inf_sidewalksMts" />
                        </flux:field>
                    </div>
                </div>
            </div>
            <div class="hidden md:block"></div>
        </div>

        {{-- 21. Guarniciones (Último sin borde) --}}
        <div class="form-grid form-grid-radios form-grid-urban">
            <div class="radio-label border-r-custom">
                Guarniciones<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <div class="flex flex-col md:flex-row gap-6 w-full">
                    <div class="flex-1 w-full">
                        <flux:field class="w-full">
                            <flux:select wire:model.live.debounce.150ms="inf_curbs"
                                class="w-full text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="1. Concreto">1. Concreto</flux:select.option>
                                <flux:select.option value="2. Otro">2. Otro</flux:select.option>
                                <flux:select.option value="3. No existe">3. No existe</flux:select.option>
                            </flux:select>
                        </flux:field>
                        @if ($inf_curbs === '2. Otro')
                        <flux:field class="mt-3 w-full">
                            <flux:label class="text-[12px]">Indique otro<span class="sup-required">*</span></flux:label>
                            <flux:input type="text" wire:model='inf_curbsOthers' class="w-full" />
                            <flux:error name="inf_curbsOthers" />
                        </flux:field>
                        @endif
                    </div>
                    <div class="flex-1 w-full">
                        <flux:field class="w-full">
                            <flux:input type="number" wire:model='inf_curbsMts'
                                :disabled="$inf_curbs === '3. No existe'" step="any" class="w-full" />
                            <flux:label class="text-[12px] mt-1">Metros</flux:label>
                            <flux:error name="inf_curbsMts" />
                        </flux:field>
                    </div>
                </div>
            </div>
            <div class="hidden md:block"></div>
        </div>

    </div>
</div>

{{-- TERCER CONTENEDOR --}}
<div class="form-container">
    <div class="form-container__header">
        Uso del suelo
    </div>
    <div class="form-container__content p-4">

        {{-- 1. Uso de suelo --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Uso de suelo<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:input type="text" wire:model='luse_landUse' class="w-full" />
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="luse_landUse" />
            </div>
        </div>

        {{-- 2. Descripción y fuente --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Descripción y fuente donde se obtuvo el uso del suelo<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:textarea wire:model='luse_descriptionSourceLand' class="w-full" />
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="luse_descriptionSourceLand" />
            </div>
        </div>

        {{-- 3. Área libre obligatoria --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Área libre obligatoria %<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:input type="number" wire:model.lazy='luse_mandatoryFreeArea' class="w-full" />
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="luse_mandatoryFreeArea" />
            </div>
        </div>

        {{-- 4. Niveles permitidos --}}
        <div class="form-grid form-grid-radios form-grid-urban border-b-subtle">
            <div class="radio-label border-r-custom">
                Niveles permitidos<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:input type="number" wire:model.lazy='luse_allowedLevels' min="0" max="999" step="any"
                        class="w-full" />
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
                <flux:error name="luse_allowedLevels" />
            </div>
        </div>

        {{-- 5. Coeficiente de uso de suelo (Último sin borde inferior) --}}
        <div class="form-grid form-grid-radios form-grid-urban">
            <div class="radio-label border-r-custom">
                Coeficiente de uso de suelo de la zona<span class="sup-required">*</span>
            </div>
            <div class="radio-input w-full">
                <flux:field class="w-full">
                    <flux:input type="number" wire:model.live='luse_landCoefficientArea' readonly
                        class="w-full bg-gray-50" />
                </flux:field>
            </div>
            <div class="error-container flex items-center justify-center md:justify-start px-4 pb-4 md:p-0 md:pl-4">
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
