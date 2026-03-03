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
    <form wire:submit="save">
        <fieldset @disabled($isReadOnly)>
        {{-- PRIMER CONTENEDOR --}}
<div class="form-container">
    <div class="form-container__header">
        Declaraciones
    </div>
    <div class="form-container__content p-4">

        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                La identificación del inmueble coincide con lo señalado en la documentación
            </div>
            <div class="radio-input">
                <flux:radio.group wire:model='dec_idDoc'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="1" /> <span>1. Sí coincide</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="0" /> <span>0. No coincide</span>
                    </label>
                </flux:radio.group>
            </div>
        </div>

        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                Las superficies físicas observadas coinciden con la documentación (con la aproximación esperada para el
                alcance del avalúo)
            </div>
            <div class="radio-input">
                <flux:radio.group wire:model='dec_areaDoc'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="1" /> <span>1. Sí coincide</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="0" /> <span>0. No coincide</span>
                    </label>
                </flux:radio.group>
            </div>
        </div>

        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                Se verificó el estado de la construcción y conservación del inmueble (con el alcance esperado para
                efectos de avalúo)
            </div>
            <div class="radio-input">
                <flux:radio.group wire:model='dec_constState'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="1" /> <span>1. Validado</span>
                    </label>
                </flux:radio.group>
            </div>
        </div>

        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                El estado de ocupación del inmueble y su uso
            </div>
            <div class="radio-input">
                <flux:radio.group wire:model='dec_occupancy'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="1" /> <span>1. Validado</span>
                    </label>
                </flux:radio.group>
            </div>
        </div>

        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                La construcción del inmueble según el plan de desarrollo urbano vigente (en su caso)
            </div>
            <div class="radio-input">
                <flux:radio.group wire:model='dec_urbanPlan'
                    class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="1" /> <span>1. Coincide</span>
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="0" /> <span>0. No coincide</span>
                    </label>
                </flux:radio.group>
            </div>
        </div>

        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                Si el inmueble es considerado monumento histórico por el I.N.A.H.
            </div>
            <div class="radio-input">
                <flux:radio.group wire:model='dec_inahMonument'
                    class="flex flex-wrap justify-center md:justify-start gap-x-6 gap-y-2 text-label-radio">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="1" /> 1. Sí considerado
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="2" /> 2. No considerado
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="0" /> 0. No se verificó
                    </label>
                </flux:radio.group>
            </div>
        </div>

        {{-- El último se va limpiecito, sin borde inferior --}}
        <div class="form-grid form-grid-radios">
            <div class="radio-label border-r-custom">
                Si es considerado patrimonio arquitectónico por el I.N.B.A.
            </div>
            <div class="radio-input">
                <flux:radio.group wire:model='dec_inbaHeritage'
                    class="flex flex-wrap justify-center md:justify-start gap-x-6 gap-y-2 text-label-radio">
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="1" /> 1. Sí considerado
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="2" /> 2. No considerado
                    </label>
                    <label class="flex items-center gap-2 cursor-pointer">
                        <flux:radio value="0" /> 0. No se verificó
                    </label>
                </flux:radio.group>
            </div>
        </div>

    </div>
</div>




{{-- SEGUNDO CONTENEDOR --}}
<div class="form-container">
    <div class="form-container__header">
        Advertencias
    </div>
    <div class="form-container__content p-4">

        {{-- 1. Documentación relevante --}}
        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                No se dispuso de documentación relevante
            </div>
            <div class="radio-input justify-center md:justify-start">
                <flux:field>
                    <flux:checkbox wire:model='war_noRelevantDoc' class="cursor-pointer" />
                </flux:field>
            </div>
        </div>

        {{-- 2. Ofertas de mercado --}}
        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                No se encuentran ofertas del mercado en la zona suficientes para considerar el enfoque comparativo de
                mercado
            </div>
            <div class="radio-input justify-center md:justify-start">
                <flux:field>
                    <label class="cursor-pointer">
                        <flux:checkbox wire:model='war_InsufficientComparable' />
                    </label>
                </flux:field>
            </div>
        </div>

        {{-- 3. Duda sobre uso --}}
        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                Existe duda sobre el uso del inmueble o de alguna sección del mismo
            </div>
            <div class="radio-input justify-center md:justify-start">
                <flux:field>
                    <label class="cursor-pointer">
                        <flux:checkbox wire:model='war_UncertainUsage' />
                    </label>
                </flux:field>
            </div>
        </div>

        {{-- 4. Obras públicas/privadas --}}
        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                Existen obras públicas o privadas que afectan los servicios en la colonia
            </div>
            <div class="radio-input justify-center md:justify-start">
                <flux:field>
                    <label class="cursor-pointer">
                        <flux:checkbox wire:model='war_serviceImpact' />
                    </label>
                </flux:field>
            </div>
        </div>

        {{-- 5. Otras notas (Textarea) - Se va sin borde inferior para cerrar limpio --}}
        <div class="form-grid form-grid-radios">
            <div class="radio-label border-r-custom">
                Señalar aquí, otras en su caso
            </div>
            <div class="radio-input">
                {{-- En el caso del textarea, le damos todo el ancho del contenedor --}}
                <div class="w-full">
                    <flux:textarea wire:model='war_otherNotes'
                        placeholder="Escriba aquí las advertencias adicionales..." />
                </div>
            </div>
        </div>

    </div>
</div>



{{-- TERCER CONTENEDOR --}}
<div class="form-container">
    <div class="form-container__header">
        Cibergestión
    </div>
    <div class="form-container__content p-4">

        {{-- 1. Valor de conclusión --}}
        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                Valor de conclusión de acuerdo al entorno inmediato<span class="sup-required">*</span>
            </div>
            <div class="radio-input">
                <div class="flex flex-col w-full">
                    <flux:radio.group wire:model='cyb_conclusionValue'
                        class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <flux:radio value="1" /> <span>Si</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <flux:radio value="2" /> <span>No</span>
                        </label>
                    </flux:radio.group>
                    <div class="flex justify-center md:justify-start mt-1">
                        <flux:error name="cyb_conclusionValue" />
                    </div>
                </div>
            </div>
        </div>

        {{-- 2. Tipología --}}
        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                Tipología de acuerdo al entorno inmediato<span class="sup-required">*</span>
            </div>
            <div class="radio-input">
                <div class="flex flex-col w-full">
                    <flux:radio.group wire:model='cyb_inmediateTypology'
                        class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <flux:radio value="1" /> <span>Si</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <flux:radio value="2" /> <span>No</span>
                        </label>
                    </flux:radio.group>
                    <div class="flex justify-center md:justify-start mt-1">
                        <flux:error name="cyb_inmediateTypology" />
                    </div>
                </div>
            </div>
        </div>

        {{-- 3. Comercialización --}}
        <div class="form-grid form-grid-radios border-b-subtle">
            <div class="radio-label border-r-custom">
                Comercialización de acuerdo al entorno inmediato<span class="sup-required">*</span>
            </div>
            <div class="radio-input">
                <div class="flex flex-col w-full">
                    <flux:radio.group wire:model='cyb_immediateMarketing'
                        class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <flux:radio value="1" /> <span>Si</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <flux:radio value="2" /> <span>No</span>
                        </label>
                    </flux:radio.group>
                    <div class="flex justify-center md:justify-start mt-1">
                        <flux:error name="cyb_immediateMarketing" />
                    </div>
                </div>
            </div>
        </div>

        {{-- 4. Superficie vendible (El último va SIN border-b-subtle) --}}
        <div class="form-grid form-grid-radios">
            <div class="radio-label border-r-custom">
                <div class="flex flex-col">
                    <span>¿La superficie vendible incluye: Volados, balcones, terrazas y/o cocheras cubiertas?<span
                            class="sup-required">*</span></span>
                    <span class="text-[11px] mt-2 leading-tight">
                        <b>(En caso de una respuesta positiva, favor de agregar la nota en el apartado de
                            justificaciones de como está integrada la superficie vendible)</b>
                    </span>
                </div>
            </div>
            <div class="radio-input">
                <div class="flex flex-col w-full">
                    <flux:radio.group wire:model='cyb_surfaceIncludesExtras'
                        class="flex flex-wrap justify-center md:justify-start gap-4 text-label-radio">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <flux:radio value="1" /> <span>Si</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <flux:radio value="2" /> <span>No</span>
                        </label>
                    </flux:radio.group>
                    <div class="flex justify-center md:justify-start mt-1">
                        <flux:error name="cyb_surfaceIncludesExtras" />
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>




















        {{-- CUARTO CONTENEDOR --}}
       {{-- CUARTO CONTENEDOR --}}
    <div class="form-container">
        <div class="form-container__header">
            Limitaciones
        </div>
        <div class="form-container__content p-4">

            {{-- Contenedor del texto legal --}}
            <div class="text-sm text-gray-700 text-justify space-y-4">
                <p>El presente avalúo constituye un dictamen de valor para uso expreso del propósito expresado en la
                    caratula del mismo, por lo tanto carece de validez si es utilizado para otros fines.</p>

                <p>El presente avalúo no constituye un dictamen estructural, de cimentación o de cualquier otra rama
                    de
                    la ingeniería civil o la arquitectura que no sea la valuación, por lo tanto no puede ser
                    utilizado
                    para fines relacionados con esas ramas ni se asume responsabilidad por vicios ocultos u otras
                    características del inmueble que no puedan ser apreciadas en una visita normal de inspección
                    física
                    para efectos de avalúo. Incluso cuando se aprecien algunas características que puedan constituir
                    anomalías con respecto al estado de conservación normal -según la vida útil consumida- de un
                    inmueble o a su estructura, el valuador no asume mayor responsabilidad que así indicarlo cuando
                    son
                    detectadas, ya que aunque se presenten estados de conservación malos o ruinosos, es obligación
                    del
                    valuador realizar el avalúo según los criterios y normas vigentes y aplicables según el
                    propósito
                    del mismo.</p>

                <p>No se realizaron investigaciones, excepto cuando así se indique en el avalúo, con respecto a la
                    existencia de tuberías o almacenamientos de materiales peligrosos que puedan ser nocivos para la
                    salud de las personas que habitan el inmueble o el estado del mismo, en el bien o en sus
                    cercanías.
                </p>

                <p>Los nombres de solicitante, propietario así como los números de cuenta predial y agua y la
                    ubicación
                    del inmueble se señalan según la información proporcionada por el cliente al momento de
                    solicitar el
                    avalúo. Por lo tanto no se asume responsabilidad por errores, omisiones o diferencias con
                    respecto a
                    los datos registrados por autoridades oficiales, como lo puede ser el registro público de la
                    propiedad y el comercio, catastro, u otros.</p>

                <p>Las superficies utilizadas en el avalúo son obtenidas de las fuentes indicadas en el mismo.
                    Cuando se
                    indica según medidas, corresponde a una medición física para efectos de avalúo, sin que esto
                    represente un levantamiento exacto, considerando las variantes y hábitos de medición existentes,
                    por
                    lo que su resultado únicamente se destina para fines de cálculo del avalúo.</p>

                <p>La edad del inmueble se considera en base a la información documental existente (licencias de
                    construcción, boleta predial, escrituras u otros) y en su caso, se estima en base a lo apreciado
                    físicamente. Puede contabilizarse a partir del último mantenimiento mayor recibido.</p>

                <p>Por la metodología de homologación empleada en el presente avalúo, los factores de homologación
                    de
                    comparables no se multiplican para obtener el FRE (factor resultante de homologación), favor de
                    consultar la totalidad del avalúo para obtener conclusiones.</p>

                <p>“Con base en el requerimiento de SHF, en las Reglas de Carácter General que Establecen la
                    Metodología
                    para la Valuación de Inmuebles Objeto de Créditos Garantizados a la Vivienda, en el numeral
                    4.3.1.5
                    de la Vida Útil Remanente, este se obtiene con base en la metodología de la Vida Mínima
                    Remanente,
                    por ser el método que brinda la obtención de la edad aparente debidamente fundamentada, como lo
                    marca el numeral 4.3.1.4 de las Reglas de Carácter General que Establecen la Metodología para la
                    Valuación de Inmuebles Objeto de Créditos Garantizados a la Vivienda; además de ser el método
                    disponible en la literatura y normado por el Código Fiscal de la CDMX, en el Manual de
                    Procedimientos y Lineamientos Técnicos de Valuación Inmobiliaria, Anexo VII, por lo cual se
                    entenderá a la Vida Útil Remanente equivalente a la Vida Mínima Remanente”.</p>
            </div>

            {{-- Separador y Textarea --}}
            <div class="mt-8 pt-6 border-t border-gray-200">
                <label class="block text-sm font-semibold text-gray-700 mb-2">Limitaciones adicionales</label>
                <flux:textarea class="h-64 w-full" wire:model='additionalLimits' />
            </div>

        </div>
    </div>
        </fieldset>
        @if(!$isReadOnly)
        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
        @endif
    </form>
</div>
