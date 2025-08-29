<div>
    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>
    <form wire:submit="save">
        {{-- PRIMER CONTENEDOR --}}
        <div class="form-container">
            <div class="form-container__header">
                Declaraciones
            </div>
            <div class="form-container__content">

                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        La identificación del inmueble coincide con lo señalado en la documentación
                    </div>
                    <div class="radio-input">
                        <flux:radio.group wire:model='dec_idDoc' class="radio-group-horizontal text-label-radio">
                            <label>
                                <flux:radio value="1" />1. Sí coincide
                            </label>
                            <label>
                                <flux:radio value="0" />0. No coincide
                            </label>
                        </flux:radio.group>
                    </div>
                </div>
                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        Las superficies físicas observadas coinciden con las documentación (con la aproximación esperado
                        para el alcance del avalúo)
                    </div>
                    <div class="radio-input">
                        <flux:radio.group wire:model='dec_areaDoc' class="radio-group-horizontal text-label-radio">
                            <label>
                                <flux:radio value="1" />1. Sí coincide
                            </label>
                            <label>
                                <flux:radio value="0" />0. No coincide
                            </label>
                        </flux:radio.group>
                    </div>
                </div>
                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        Se verificó el estado de la construcción y conservación del inmueble (con el alcance esperado
                        para
                        efectos de avalúo)
                    </div>
                    <flux:radio.group wire:model='dec_constState' class="radio-group-horizontal text-label-radio">
                        <label>
                            <flux:radio value="1" />1. Validado
                        </label>
                    </flux:radio.group>
                </div>
                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        El estado de ocupación del inmueble y su uso
                    </div>
                    <flux:radio.group wire:model='dec_occupancy' class="radio-group-horizontal text-label-radio">
                        <label>
                            <flux:radio value="1" />1. Validado
                        </label>
                    </flux:radio.group>
                </div>
                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        La construcción del inmueble según el plan de desarrollo urbano vigente (en su caso)
                    </div>
                    <flux:radio.group wire:model='dec_urbanPlan' class="radio-group-horizontal text-label-radio">
                        <label>
                            <flux:radio value="1" />1. Coincide
                        </label>
                        <label>
                            <flux:radio value="0" />0.No coincide
                        </label>
                    </flux:radio.group>
                </div>
                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        Si el inmueble es considerado monumento histórico por el I.N.A.H.
                    </div>
                    <flux:radio.group wire:model='dec_inahMonument' class="radio-group-horizontal text-label-radio">
                        <label>
                            <flux:radio value="1" />1. Si considerado
                        </label>
                        <label>
                            <flux:radio value="2" />2. No considerado
                        </label>
                        <label>
                            <flux:radio value="0" />0. No se verifico
                        </label>
                    </flux:radio.group>
                </div>
                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        Si es considerado patrimonio arquitectónico por el I.N.B.A
                    </div>
                    <flux:radio.group wire:model='dec_inbaHeritage' class="radio-group-horizontal text-label-radio">
                        <label>
                            <flux:radio value="1" />1. Si considerado
                        </label>
                        <label>
                            <flux:radio value="2" />2. No considerado
                        </label>
                        <label>
                            <flux:radio value="0" />0. No se verifico
                        </label>
                    </flux:radio.group>
                </div>
            </div>
        </div>
















        {{-- SEGUNDO CONTENEDOR --}}
        <div class="form-container">
            <div class="form-container__header">
                Advertencias
            </div>
            <div class="form-container__content">


                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        No se dispuso de documentación relevante
                    </div>
                    <flux:field class="radio-group-horizontal">
                        <flux:checkbox wire:model='war_noRelevantDoc' class="cursor-pointer" />
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        No se encuentran ofertas del mercado en la zona suficientes para considerar el enfoque
                        compartativo
                        de mercado
                    </div>
                    <flux:field class="radio-group-horizontal">
                        <label>
                            <flux:checkbox wire:model='war_InsufficientComparable' class="cursor-pointer" />
                        </label>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        Existe duda sobre el uso del inmueble o de alguna sección del mismo
                    </div>
                    <flux:field class="radio-group-horizontal">
                        <label>
                            <flux:checkbox wire:model='war_UncertainUsage' class="cursor-pointer" />
                        </label>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        Existen obras públicas o privadas que afectan los servicios en la colonia
                    </div>
                    <flux:field class="radio-group-horizontal">
                        <label>
                            <flux:checkbox wire:model='war_serviceImpact' />
                        </label>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        Señalar aquí, otras en su caso
                    </div>
                    <div class="radio-input">
                        <div class="radio-group-horizontal">
                            <flux:textarea wire:model='war_otherNotes' />
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
            <div class="form-container__content">


                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        Valor de conclusión de acuerdo al entorno inmediato<span class="sup-required">*</span>
                    </div>
                    <flux:radio.group wire:model='cyb_conclusionValue' class="radio-group-horizontal text-label-radio">
                        <label>
                            <flux:radio value="1" />Si
                        </label>
                        <label>
                            <flux:radio value="2" />No
                        </label>
                        <div class="flux justify-end">
                            <flux:error name="cyb_conclusionValue" />
                        </div>
                    </flux:radio.group>
                </div>
                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        Tipología de acuerdo al entorno inmediato<span class="sup-required">*</span>
                    </div>
                    <flux:radio.group wire:model='cyb_inmediateTypology' class="radio-group-horizontal text-label-radio">
                        <label>
                            <flux:radio value="1" />Si
                        </label>
                        <label>
                            <flux:radio value="2" />No
                        </label>
                        <div class="flux justify-end">
                            <flux:error name="cyb_inmediateTypology" />
                        </div>
                    </flux:radio.group>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        Comercialización de acuerdo al entorno inmediato<span class="sup-required">*</span>
                    </div>
                    <flux:radio.group wire:model='cyb_immediateMarketing' class="radio-group-horizontal text-label-radio">
                        <label>
                            <flux:radio value="1" />Si
                        </label>
                        <label>
                            <flux:radio value="2" />No
                        </label>
                        <div class="flux justify-end">
                            <flux:error name="cyb_immediateMarketing" />
                        </div>
                    </flux:radio.group>
                </div>

                <div class="form-grid form-grid--3 form-grid-radios border-b-2">
                    <div class="radio-label border-r-2">
                        ¿La superficie vendible incluye: Volados, balcones, terrazas y/o cocheras cubiertas?<span class="sup-required">*</span>
                        <br>
                        <b>(En caso de una respuesta positiva, favor de agregar la nota en el apartado de
                            justificaciones de
                            como está integrada la superficie vendible)</b>
                    </div>
                    <flux:radio.group wire:model='cyb_surfaceIncludesExtras' class="radio-group-horizontal text-label-radio">
                        <label>
                            <flux:radio value="1" />Si
                        </label>
                        <label>
                            <flux:radio value="2" />No
                        </label>
                        <div class="flux justify-end">
                            <flux:error name="cyb_surfaceIncludesExtras" />
                        </div>
                    </flux:radio.group>
                </div>

            </div>
        </div>






















        {{-- CUARTO CONTENEDOR --}}
        <div class="form-container">
            <div class="form-container__header">
                Limitaciones
            </div>
            <div class="form-container__content">

                <div>
                    <p>El presente avalúo constituye un dictamen de valor para uso expreso del propósito expresado en la
                        caratula del mismo, por lo tanto carece de validez si es utilizado para otros fines.</p>
                    <br>
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
                    <br>
                    <p>No se realizaron investigaciones, excepto cuando así se indique en el avalúo, con respecto a la
                        existencia de tuberías o almacenamientos de materiales peligrosos que puedan ser nocivos para la
                        salud de las personas que habitan el inmueble o el estado del mismo, en el bien o en sus
                        cercanías.
                    </p>
                    <br>
                    <p>Los nombres de solicitante, propietario así como los números de cuenta predial y agua y la
                        ubicación
                        del inmueble se señalan según la información proporcionada por el cliente al momento de
                        solicitar el
                        avalúo. Por lo tanto no se asume responsabilidad por errores, omisiones o diferencias con
                        respecto a
                        los datos registrados por autoridades oficiales, como lo puede ser el registro público de la
                        propiedad y el comercio, catastro, u otros.</p>
                    <br>
                    <p>Las superficies utilizadas en el avalúo son obtenidas de las fuentes indicadas en el mismo.
                        Cuando se
                        indica según medidas, corresponde a una medición física para efectos de avalúo, sin que esto
                        represente un levantamiento exacto, considerando las variantes y hábitos de medición existentes,
                        por
                        lo que su resultado únicamente se destina para fines de cálculo del avalúo.</p>
                    <br>
                    <p>La edad del inmueble se considera en base a la información documental existente (licencias de
                        construcción, boleta predial, escrituras u otros) y en su caso, se estima en base a lo apreciado
                        físicamente. Puede contabilizarse a partir del último mantenimiento mayor recibido.</p>
                    <br>
                    <p>Por la metodología de homologación empleada en el presente avalúo, los factores de homologación
                        de
                        comparables no se multiplican para obtener el FRE (factor resultante de homologación), favor de
                        consultar la totalidad del avalúo para obtener conclusiones.</p>
                    <br>
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
                <div>

                </div>
                <br><br>
                <div>
                    <label class="text-sm">Limitaciones adicionales</label>
                    <flux:textarea class="h-64" />
                </div>
            </div>
        </div>
        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
    </form>
</div>
