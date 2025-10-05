<div>
    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>
    <form wire:submit="save">
     <div class="form-container">
        <div class="form-container__header">
            Consideraciones previas al avalúo
        </div>
        <div class="form-container__content">


            <div >
                {{-- INICIA ACORDEÓN --}}
                <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                    <div @click="open = !open" class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                        <div class="flex items-center gap-2 flex-grow">
                            <span class="text-gray-800 font-medium">Enfoque de mercado</span>
                        </div>
                        <svg :class="{ 'rotate-180': open }" class="w-5 h-5 text-gray-500 transform transition-transform duration-300"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
                        x-transition:leave="transition duration-75" x-transition:leave-start="opacity-100 max-h-screen"
                        x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                        <div class="flex w-full">
                            <div>
                                Este enfoque se basa en el uso de información que refleje las transacciones del mercado, se utiliza en los avalúos de
                                bienes que pueden ser analizados con bienes comparables existentes en el mercado abierto, se basa en la investigación de
                                la demanda de dichos bienes, operaciones de compraventa recientes, operaciones de renta o alquiler y que, mediante una
                                homologación de los datos obtenidos, permiten al valuador estimar un valor de mercado. El supuesto que justifica el
                                empleo de este método se basa en que un inversionista no pagará más por una propiedad que lo que estaría dispuesto a
                                pagar por una propiedad de utilidad similar disponible en el mercado.
                            </div>
                        </div>
                    </div>
                </div>
                {{-- TERMINA ACORDEÓN --}}
            </div>


            <div>
                {{-- INICIA ACORDEÓN --}}
                <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                    <div @click="open = !open" class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                        <div class="flex items-center gap-2 flex-grow">
                            <span class="text-gray-800 font-medium">Enfoque de costos</span>
                        </div>
                        <svg :class="{ 'rotate-180': open }"
                            class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </div>

                    <div x-show="open" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-screen"
                        x-transition:leave="transition duration-75" x-transition:leave-start="opacity-100 max-h-screen"
                        x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                        <div class="flex w-full">
                            <div>
                               El valor unitario de reposición nuevo aplicado a cada tipo de construcción se determina tomando como referencia los
                            valores unitarios publicados por empresas especializadas en costos por metro cuadrado de construcción, tales como los
                            catálogos de costos BIMSA y PRISMA, realizando los ajustes necesarios para su adecuación al tipo de construcción
                            valuado. A este valor se le aplican los factores de eficiencia de la construcción por concepto de vida útil consumida y
                            estado de conservación para la conclusión para el valor neto de reposición. La investigación de mercado, así como los
                            criterios utilizados para la aplicación de los factores de eficiencia de terreno y de construcción, se detallan en los
                            apartados correspondientes.
                            </div>
                        </div>
                    </div>
                </div>
                {{-- TERMINA ACORDEÓN --}}
            </div>


          <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
            <h2 class="border-b-2 border-gray-300">Consideraciones adicionales</h2>
        </div>

        <div>
            <label class="text-sm">Señale otras en su caso</label>
            <flux:textarea class="h-64" wire:model='additionalConsiderations' />
        </div>

        <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
            <h2 class="border-b-2 border-gray-300">Memoria técnica exposición de motivos:</h2>
        </div>

        <div>
            <p>Factores aplicados:</p>
            <ul>
                <li>
                    <strong>1. </strong>Homologación de terrenos: F. Zona (FZO): influye en el valor del predio según su ubicación; F.
                    Ubicación (FUB): en función de la posición del predio en la manzana; F. Topografía (FTOP): influye en el valor
                    según su topografía; F. Forma (FFO): influye en el valor según la forma del predio; F. Superficie (FSU): influye
                    en el valor según la superficie del predio; F. Uso de suelo (FCUS): influye en el valor según su edificabilidad
                    (VST).
                </li>
                <li>
                    <strong>2. </strong>Homologación de ventas: Sup. Vendible (FSU): influye en el valor según la superficie
                    construida; F. Intensidad de Const. (FIC): en función de su intensidad de construcción; Equipamiento (FEQ): en
                    función de la existencia de equipamiento; Edad y Conservación (FEDAD): no definido; F. Localización (FLOC):
                    influye en el valor según la localización urbana; Avance obra (AVANC): no definido.
                </li>
                <li>
                    <strong>3. </strong>Homologación de rentas: Sup. Vendible (FSU): influye en el valor según la superficie
                    construida; F. Intensidad de Const. (FIC): en función de su intensidad de construcción; Equipamiento (FEQ): en
                    función de la existencia de equipamiento; Edad y Conservación (FEDAD): no definido; F. Localización (FLOC):
                    influye en el valor según la localización urbana; Avance obra (AVANC): no definido.
                </li>
            </ul>
        </div>

        <br>

        <div>
            <label class="text-sm">Señale otras en su caso</label>
            <flux:textarea class="h-64" wire:model='technicalMemory' />
        </div>


        <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
            <h2 class="border-b-2 border-gray-300">Memoria técnica desglose de información:</h2>
        </div>

        <div>
            <label class="text-sm">Señale otras en su caso</label>
            <flux:textarea class="h-64" wire:model='technicalReportBreakdownInformation'/>
        </div>


        <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
            <h2 class="border-b-2 border-gray-300">Memoria técnica otros para sustento:</h2>
        </div>

        <div>
            <label class="text-sm">Señale otras en su caso</label>
            <flux:textarea class="h-64" wire:model='technicalReportOthersSupport'/>
        </div>

        <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
            <h2 class="border-b-2 border-gray-300">Memoria técnica descripción de cálculos realizados:</h2>
        </div>

        <div>
            <label class="text-sm">Señale otras en su caso</label>
            <flux:textarea class="h-64" wire:model='technicalReportDescriptionCalculations'/>
        </div>

        </div>
    </div>















    <div class="form-container">
        <div class="form-container__header">
           Enfoques a consideras para la homologación
        </div>
        <div class="form-container__content">



            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>Cálculo de terrenos<span class="sup-required">*</span></flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:select wire:model.live="ach_landCalculation" class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                <flux:select.option value="Si se apllica, usando terrenos directos o residual">Si se apllica, usando terrenos directos o residual</flux:select.option>
                                <flux:select.option value="No se aplica, no existen comparables debido a...">No se aplica, no existen comparables debido a...</flux:select.option>
                                <flux:select.option value="No se aplica, no existe muestra suficiente en el mercado">No se aplica, no existe muestra suficiente en el mercado</flux:select.option>
                                <flux:select.option value="No se aplica, no existen comparables ya que el inmueble se encuentra en construccion">No se aplica, no existen comparables ya que el inmueble se encuentra en construccion</flux:select.option>
                            </flux:select>
                        </div>
                        <div>
                            <flux:error name="ach_landCalculation" />
                        </div>
                    </flux:field>
                </div>
            </div>


            @if($ach_landCalculation == 'Si se apllica, usando terrenos directos o residual')
            {{-- Solo si está seleccionado: Si se apllica, usando terrenos directos o residual --}}
            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>Enfoque comparativo
                        <br> de terrenos</flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                         <flux:checkbox wire:model="ach_comparativeApproachLand" />
                        </div>
                        <div>
                            <flux:error name="ach_comparativeApproachLand" />
                        </div>
                    </flux:field>
                </div>
            </div>

            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>Enfoque comparativo
                        <br> de ventas
                    </flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:checkbox wire:model="ach_comparativeSalesApproach" />
                        </div>
                        <div>
                            <flux:error name="ach_comparativeSalesApproach" />
                        </div>
                    </flux:field>
                </div>
            </div>
            @endif



            @if ($ach_landCalculation == 'No se aplica, no existen comparables debido a...')
            {{-- Solo se aplica si está seleccionado: No se aplica, no existen comparables debido a... --}}
            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>Debido a <span class="sup-required">*</span></flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:input type='text' wire:model="ach_dueTo1" />
                        </div>
                        <div>
                            <flux:error name="ach_dueTo1" />
                        </div>
                    </flux:field>
                </div>
            </div>
            @endif





            {{-- ESTOS VALORES SON PARA TODOS LOS INPUT SELECT --}}
            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>Enfoque de costos<span class="sup-required">*</span></flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:select wire:model="ahc_costApproach" class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                <flux:select.option value="Si se aplica">Si se aplica</flux:select.option>
                                <flux:select.option value="No se aplica">No se aplica</flux:select.option>
                            </flux:select>
                        </div>
                        <div>
                            <flux:error name="ahc_costApproach" />
                        </div>
                    </flux:field>
                </div>
            </div>

            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>Enfoque de ingresos<span class="sup-required">*</span></flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:select wire:model.live="ach_incomeApproach" class=" text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                <flux:select.option value="Si se apllica, usando terrenos directos o residual">Si se apllica, usando
                                    terrenos directos o residual</flux:select.option>
                                <flux:select.option value="No se aplica, no existen comparables debido a...">No se aplica, no
                                    existen comparables debido a...</flux:select.option>
                                <flux:select.option value="No se aplica, no existe muestra suficiente en el mercado">No se aplica,
                                    no existe muestra suficiente en el mercado</flux:select.option>
                                <flux:select.option
                                    value="No se aplica, no existen comparables ya que el inmueble se encuentra en construccion">No
                                    se aplica, no existen comparables ya que el inmueble se encuentra en construccion
                                </flux:select.option>
                                <flux:select.option
                                    value="No se aplica, no existen comparables ya que el inmueble se encuentra en construccion">No
                                    se aplica, no se requiere la ejecucion
                                </flux:select.option>
                            </flux:select>
                        </div>
                        <div>
                            <flux:error name="ach_incomeApproach" />
                        </div>
                    </flux:field>
                </div>
            </div>

            @if ($ach_incomeApproach == 'No se aplica, no existen comparables debido a...')
            {{-- Solo se aplica si está seleccionado: No se aplica, no existen comparables debido a... --}}
            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>Debido a <span class="sup-required">*</span></flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:input type='text' wire:model="ach_dueTo2" />
                        </div>
                        <div>
                            <flux:error name="ach_dueTo2" />
                        </div>
                    </flux:field>
                </div>
            </div>
            @endif

            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>Aplicar FIC</flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:checkbox wire:model="applyFIC" />
                        </div>
                        <div>
                            <flux:error name="applyFIC" />
                        </div>
                    </flux:field>
                </div>
            </div>


        </div>
    </div>
    <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
    </form>
</div>
