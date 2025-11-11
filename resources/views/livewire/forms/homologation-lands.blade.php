<div>

    @if($comparablesCount >= 4)










    <!-- 1. SECCIÓN SUJETO (CORREGIDO: Uso de flux:label y Alineación) -->
    <div class="form-container">
        <div class="form-container__header">
            Sujeto
        </div>

        <!-- Contenido Adaptativo -->
        <div class="form-container__content">

            <!-- Header Limpio (Info de Propiedad) -->
            <div class="p-4 bg-white border border-gray-300 rounded-lg mb-6">
                <p class="font-bold text-md flex items-center text-gray-800">
                    <!-- Icono de Mapa Simple -->
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                        stroke="currentColor" class="w-6 h-6 mr-2 text-gray-600">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z" />
                    </svg>
                    Dirección: {{ $valuation->property_street ?? 'N/A' }} Ext. {{ $valuation->property_abroad_number ??
                    'N/A' }}
                </p>
                <p class="text-sm text-gray-600 ml-8">
                    <!-- Lógica de Colonia 'no-listada' -->
                    Colonia: @if($valuation->property_colony === 'no-listada')
                    {{ $valuation->property_other_colony ?? 'N/A (No listada)' }}
                    @else
                    {{ $valuation->property_colony ?? 'N/A' }}
                    @endif
                    (CP {{ $valuation->property_cp ?? 'N/A' }}, {{ $valuation->property_locality_name ?? 'N/A' }})
                </p>
            </div>

            <!-- Grid de 2 Columnas (Ajuste de Ancho: Columna 1 más pequeña) -->
            <div class="flex flex-col md:flex-row gap-x-6 gap-y-8">

                <!-- Columna 1: Inputs Sujeto (Wider on mobile, smaller on desktop: ~1/3) -->
                <div class="space-y-4 md:w-1/3 w-full">
                    <flux:select label="Superficie aplicable" wire:model.live="subject_surface_type">
                        <flux:select.option value="total">Superficie total del terreno</flux:select.option>
                        <flux:select.option value="otro">Otro</flux:select.option>
                    </flux:select>

                    <!-- Campos Readonly (CUS y COS) -->
                    <flux:input type="text" label="C.U.S." wire:model.live="subject_cus" readonly />
                    <flux:input type="text" label="C.O.S." wire:model.live="subject_cos" readonly />
                    <flux:input type="text" label="Lote moda" wire:model.live="subject_lote_moda"
                        placeholder="100.00" />
                </div>

                <!-- Columna 2: Factores Base Sujeto (Wider on mobile, larger on desktop: ~2/3) -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:w-2/3 w-full">
                    <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-300 pb-2">Factores base del sujeto
                    </h4>

                    <!-- Contenedor de tabla con bordes -->
                    <div class="overflow-x-auto border border-gray-300 rounded-md">
                        <table class="w-full text-md table-fixed">
                            <thead>
                                <tr class="bg-gray-100 text-md font-semibold text-gray-500 border-b border-gray-300">
                                    <th class="text-left py-2 px-3 w-1/2">Descripción</th>
                                    <th class="text-left py-2 px-2 w-20">Siglas</th>
                                    <th class="text-left py-2 px-3 w-32">Calificación</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">

                                {{-- F. ZONA --}}
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:label for="subject_factor_zona"
                                            class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">F. Zona
                                        </flux:label>
                                    </td>
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        <flux:label class="font-mono text-md text-gray-700">FZO</flux:label>
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:input type="number" step="0.0001" id="subject_factor_zona"
                                            wire:model.live="subject_factor_zona" placeholder="1.0000"
                                            class="text-right h-9 text-sm w-full" />
                                    </td>
                                </tr>

                                {{-- F. UBICACION --}}
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:label for="subject_factor_ubicacion"
                                            class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">F. Ubicación
                                        </flux:label>
                                    </td>
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        <flux:label class="font-mono text-md text-gray-700">FUB</flux:label>
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:input type="number" step="0.0001" id="subject_factor_ubicacion"
                                            wire:model.live="subject_factor_ubicacion" placeholder="1.0000"
                                            class="text-right h-9 text-sm w-full" />
                                    </td>
                                </tr>

                                {{-- F. TOPOGRAFIA (EDITABLE) --}}
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle">
                                        <!-- Usamos un input normal ya que flux:label+input no funcionan bien juntos en este diseño -->
                                        <flux:input type="text" id="subject_factor_topografia_desc"
                                            wire:model.live="subject_factor_topografia_desc" placeholder="F. Topografía"
                                            class="h-9 text-sm  -ml-2" />
                                    </td>
                                    <td class="py-1.5 px-2 text-center align-middle">
                                        <flux:input type="text" id="subject_factor_topografia_siglas"
                                            wire:model.live="subject_factor_topografia_siglas" placeholder="FTOP"
                                            class="font-mono text-xs h-9 w-16 -ml-2 mx-auto" />
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:input type="number" step="0.0001" id="subject_factor_topografia_valor"
                                            wire:model.live="subject_factor_topografia_valor" placeholder="1.0000"
                                            class="text-right h-9 text-sm w-full" />
                                    </td>
                                </tr>

                                {{-- F. FORMA --}}
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:label for="subject_factor_forma"
                                            class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">F. Forma
                                        </flux:label>
                                    </td>
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        <flux:label class="font-mono text-md text-gray-700">FFO</flux:label>
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:input type="number" step="0.0001" id="subject_factor_forma"
                                            wire:model.live="subject_factor_forma" placeholder="1.0000"
                                            class="text-right h-9 text-sm w-full" />
                                    </td>
                                </tr>

                                {{-- F. SUPERFICIE (READONLY) --}}
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:label for="subject_factor_superficie"
                                            class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">F. Superficie
                                        </flux:label>
                                    </td>
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        <flux:label class="font-mono text-md text-gray-700">FSU</flux:label>
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:input type="number" step="0.0001" id="subject_factor_superficie"
                                            wire:model.live="subject_factor_superficie" placeholder="1.0000"
                                            class="text-right h-9 text-sm w-full" readonly />
                                    </td>
                                </tr>

                                {{-- F. USO DE SUELO (READONLY) --}}
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:label for="subject_factor_uso_suelo"
                                            class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">F. Uso de suelo
                                        </flux:label>
                                    </td>
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        <flux:label class="font-mono text-md text-gray-700">FCUS</flux:label>
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:input type="number" step="0.0001" id="subject_factor_uso_suelo"
                                            wire:model.live="subject_factor_uso_suelo" placeholder="0.0000"
                                            class="text-right h-9 text-sm w-full" readonly />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>














































































    <div class="form-container">
        <div class="form-container__header">
            Comparables
        </div>
        <div class="form-container__content">



            <!-- Paginación y Botones (Corregido a tu estilo) -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b pb-4">

                <!-- Paginación Numérica (Izquierda) -->
                <div class="flex items-center space-x-2">
                    <span class="text-md font-semibold text-gray-600 mr-2">Comparable:</span>
                    @for ($i = 1; $i <= $comparablesCount; $i++) <button type="button" wire:click="gotoPage({{ $i }})"
                        class="px-3 py-1 text-sm rounded-full transition-colors cursor-pointer
                                    @if($currentPage === $i)
                                        bg-teal-600 text-white font-bold shadow-md
                                    @else
                                        bg-gray-200 text-gray-700 hover:bg-blue-100
                                    @endif">
                        {{ $i }}
                        </button>
                        @endfor
                </div>

                <!-- Botones de Acción (Derecha) -->
                <div class="flex items-center space-x-3 mt-3 md:mt-0">
                    <flux:button class="btn-primary cursor-pointer" type="button"
                       wire:click="$dispatch('openSummary', { id: {{ $selectedComparableId }}, comparableType: 'land' })" size="sm">
                        Resumen
                    </flux:button>
                    <flux:button class="btn-primary cursor-pointer" type="button"
                       wire:click='openComparablesLand' size="sm">
                        Cambiar Comparables
                    </flux:button>
                </div>
            </div>

            <!-- Contenedor Relativo para el Loader (Punto 3) -->
            <div class="relative">

                <!-- Loader (Solo cubre esta sección) -->
                <div wire:loading.flex wire:target="gotoPage"
                    class="transition-all duration-200 ease-in-out absolute inset-0 bg-white bg-opacity-75 z-20 flex items-center justify-center rounded-lg">
                    <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                        </circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>

                <!-- Grid de 2 Columnas (Ficha vs. Factores) - El loader se pondrá encima de esto -->
                <div class="flex flex-col md:flex-row gap-x-6 gap-y-8" wire:loading.class="opacity-50">

                    <!-- Columna 1: Ficha Limpia -->
                    <div class="md:w-1/3 w-full space-y-3" wire:key="ficha-{{ $selectedComparableId }}">

                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-md">

                            <!-- Columna Izquierda -->
                            <div>
                                <dt class="font-semibold text-gray-800">Ciudad:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_locality_name ?? 'N/A' }}
                                </dd>

                                <dt class="font-semibold text-gray-800 mt-2">Calle y núm:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_street ?? 'N/A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Alc./Mpio:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_municipality_name ?? 'N/A'
                                    }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Colonia:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_colony ?? 'N/A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Fuente:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_source ?? 'N/A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Oferta:</dt>
                                <dd class="text-gray-600">${{ number_format($selectedComparable->comparable_offers, 2)
                                    }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Superficie:</dt>
                                <dd class="text-gray-600">{{ number_format($selectedComparable->comparable_land_area, 2)
                                    }} m²
                                </dd>

                                <dt class="font-semibold text-gray-800 mt-2">Valor Unitario:</dt>
                                <dd class="text-gray-600">${{ number_format($selectedComparable->comparable_unit_value,
                                    2) }}
                                </dd>

                                <dt class="font-semibold text-gray-800 mt-2">Vigencia/Fecha:</dt>
                                <dd class="text-gray-600">
                                    {{ $selectedComparable->comparable_date ?
                                    \Carbon\Carbon::parse($selectedComparable->comparable_date)->format('d/m/Y') : 'N/A'
                                    }}
                                </dd>

                                <dt class="font-semibold text-gray-800 mt-2">Características:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_features ?? 'N/A' }}</dd>
                            </div>

                            <!-- Columna Derecha -->
                            <div>
                                <dt class="font-semibold text-gray-800">Área libre:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_free_area ?? 'N/A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Niv. max:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_max_levels ?? 'N/A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Uso de Suelo:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_land_use ?? 'N/A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">CUS:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_cus ?? 'N/A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Diferencia:</dt>
                                <dd class="text-gray-600">% 0.00</dd>
                            </div>
                        </div>
                    </div>

                    <!-- Columna 2: Factores de Ajuste -->
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:w-2/3 w-full"
                        wire:key="factores-{{ $selectedComparableId }}">
                        <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-300 pb-2">Factores de Ajuste
                            Aplicados
                        </h4>

                        <div class="overflow-x-auto border border-gray-300 rounded-md">
                            <table class="w-full text-md table-fixed">
                                <thead>
                                    <tr
                                        class="bg-gray-100 text-md font-semibold text-gray-500 border-b border-gray-300">
                                        <th class="text-left py-2 px-3 w-20">Factor</th>
                                        <th class="text-left py-2 px-2 w-24">Cal. Sujeto</th>
                                        <th class="text-left py-2 px-2 w-24">Cal. Comp.</th>
                                        <th class="text-left py-2 px-3 w-24">Dif.</th>
                                        <th class="text-left py-2 px-3 w-24">Aplicable</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach ($masterFactors as $factor)
                                    <tr class="hover:bg-gray-50">
                                        <td class="py-1.5 px-3 align-middle">
                                            <flux:label class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">
                                                {{ $factor['label'] }}
                                            </flux:label>
                                        </td>
                                        <td class="py-1.5 px-2 text-left align-middle">
                                            <flux:label class="font-mono text-md text-gray-700">
                                                @if($factor['code'] === 'FNEG')
                                                1.0000
                                                @else
                                                {{ $this->{$factor['subject_model']} ?? '1.0000' }}
                                                @endif
                                            </flux:label>
                                        </td>
                                        <td class="py-1.5 px-2 text-left align-middle">
                                            @if($factor['type'] === 'select')
                                            <flux:select class="text-left h-9 text-sm w-full"
                                                wire:model.live="comparableFactors.{{ $selectedComparable->id }}.{{ $factor['code'] }}.calificacion">
                                                <flux:select.option value="0.80">0.80</flux:select.option>
                                                <flux:select.option value="1.00">1.00</flux:select.option>
                                                <flux:select.option value="1.20">1.20</flux:select.option>
                                            </flux:select>
                                            @elseif($factor['type'] === 'number')
                                            <flux:input type="number" step="0.0001" placeholder="1.0000"
                                                wire:model.live="comparableFactors.{{ $selectedComparable->id }}.{{ $factor['code'] }}.calificacion"
                                                class="text-left h-9 text-sm w-full" />
                                            @else
                                            <flux:label class="font-mono text-md text-gray-700">
                                                {{
                                                $comparableFactors[$selectedComparable->id][$factor['code']]['calificacion']
                                                }}
                                            </flux:label>
                                            @endif
                                        </td>
                                        <td class="py-1.5 px-3 text-left align-middle">
                                            <flux:label class="font-semibold text-gray-900">0.0000</flux:label>
                                        </td>
                                        <td class="py-1.5 px-3 text-left align-middle">
                                            @if($factor['type'] === 'number_aplicable')
                                            <flux:input type="number" step="0.0001" placeholder="0.9000"
                                                wire:model.live="comparableFactors.{{ $selectedComparable->id }}.{{ $factor['code'] }}.aplicable"
                                                class="text-left h-9 text-sm w-full" />
                                            @else
                                            <flux:label class="font-semibold text-gray-900">1.0000</flux:label>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-100 border-t-2 border-gray-300">
                                    <tr class="font-extrabold text-md">
                                        <td colspan="4" class="py-2 px-3 text-right">FACTOR RESULTANTE (FRE):</td>
                                        <td class="py-2 px-3 text-left text-gray-900">
                                            {{ $comparableFactors[$selectedComparable->id]['FRE']['factor_ajuste'] }}
                                        </td>
                                    </tr>
                                    <tr class="font-extrabold text-md">
                                        <td colspan="4" class="py-2 px-3 text-right">Valor Unitario Homologado:</td>
                                        <td class="py-2 px-3 text-left text-gray-900">
                                            ${{
                                            number_format($comparableFactors[$selectedComparable->id]['FRE']['valor_homologado'],
                                            2)
                                            }}
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>



        </div>

    </div>
















































    <div class="form-container">
        <div class="form-container__header">
            Justificaciones
        </div>
        <div class="form-container__content">

            {{-- <div class="form-grid form-grid--1">


            </div> --}}

            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>F. Zona<span class="sup-required">*</span></flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:input type='text' wire:model="justificationZone" />
                        </div>
                        <div>
                            <flux:error name="justificationZone" />
                        </div>
                    </flux:field>
                </div>
            </div>

            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>F. Uso de suelo<span class="sup-required">*</span></flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:input type='text' wire:model="justificactionLandUse" />
                        </div>
                        <div>
                            <flux:error name="justificactionLandUse" />
                        </div>
                    </flux:field>
                </div>
            </div>

            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>Negociación<span class="sup-required">*</span></flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:input type='text' wire:model="justificationNegotiation" />
                        </div>
                        <div>
                            <flux:error name="justificationNegotiation" />
                        </div>
                    </flux:field>
                </div>
            </div>

            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>Resultante<span class="sup-required">*</span></flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:input type='text' wire:model="justificationResulting" />
                        </div>
                        <div>
                            <flux:error name="justificationResulting" />
                        </div>
                    </flux:field>
                </div>
            </div>

        </div>

    </div>























{{-- <div wire:ignore class="w-full h-full">
    <canvas id="chartHomologationLands" class="w-full h-64"></canvas>
</div>

<div wire:ignore class="w-full h-full mt-6">
    <canvas id="chartHomologationStats" class="w-full h-64"></canvas>
</div>







 --}}




    <div class="form-container">
        <div class="form-container__header">
            Conclusiones
        </div>
        <div class="form-container__content">

            <!-- TABLA DE COMPARABLES Y GRÁFICO SUPERIOR -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <!-- Tabla de Resumen de Comparables (Lado Izquierdo) -->
                <div>
                    <div class="overflow-x-auto border border-gray-300 rounded-md shadow-sm">
                        <table class="w-full text-md">
                            <thead>
                                <tr class="bg-gray-100 text-md font-semibold text-gray-500 border-b border-gray-300">
                                    <!-- CAMBIO: 7 columnas + cabecera de Factor de Ajuste -->
                                    <th class="py-2 px-3 text-left min-w-[150px]" rowspan="2">N. Comparable</th>
                                    <th class="py-2 px-3 text-center min-w-[120px]" rowspan="2">Valor Oferta</th>
                                    <th class="py-2 px-3 text-center min-w-[120px]" rowspan="2">Val Unit Hom</th>
                                    <th class="py-2 px-3 text-center" colspan="2">Factor de Ajuste</th>
                                    <th class="py-2 px-3 text-center min-w-[100px]" rowspan="2">Ajuste %</th>
                                    <th class="py-2 px-3 text-center min-w-[120px]" rowspan="2">Valor Final</th>
                                </tr>
                                <tr class="bg-gray-100 text-sm font-semibold text-gray-500 border-b border-gray-300">
                                    <th class="py-1 px-3 text-center min-w-[100px]">(FRE)</th>
                                    <th class="py-1 px-3 text-center min-w-[100px]">(F. Aj. 2)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">

                                <!-- Loop sobre todos los comparables -->
                                @if($comparables && $comparables->count() > 0)
                                @foreach ($comparables as $index => $comparable)
                                @php
                                // Asegurarnos que las claves existan antes de leerlas
                                $factorFRE = $comparableFactors[$comparable->id]['FRE']['factor_ajuste'] ?? 0.0;
                                $valorHomologado = $comparableFactors[$comparable->id]['FRE']['valor_homologado'] ?? 0.0;
                                $factor2 = $comparableFactors[$comparable->id]['COL_FACTOR_2_PLACEHOLDER'] ?? '0.00';
                                $ajustePct = $comparableFactors[$comparable->id]['COL_AJUSTE_PCT_PLACEHOLDER'] ?? '0.00%';
                                $valorFinal = $comparableFactors[$comparable->id]['COL_VALOR_FINAL_PLACEHOLDER'] ?? '0.00';
                                $isOutOfRange = ((float)$factorFRE < 0.8 || (float)$factorFRE> 1.2);
                                    @endphp

                                    <tr class="hover:bg-gray-50 {{ $isOutOfRange ? 'bg-red-50' : '' }}">
                                        <td class="py-1.5 px-3 align-middle text-sm">
                                            <input type="checkbox" wire:model.live='selectedForStats' value="{{ $comparable->id }}"
                                                class="rounded text-blue-600 focus:ring-blue-500 mr-2">
                                            <!-- CAMBIO: Mostrando ID real -->
                                            {{ $comparable->id }}
                                        </td>
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">${{
                                            number_format($comparable->comparable_offers, 2) }}</td>
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">${{ number_format($valorHomologado,
                                            2) }}</td>
                                        <!-- CAMBIO: Añadidas las celdas de las nuevas columnas -->
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">{{ number_format($factorFRE, 4) }}
                                        </td>
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $factor2 }}</td>
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $ajustePct }}</td>
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">${{ $valorFinal }}</td>
                                    </tr>
                                    @endforeach
                                    @else
                                    <tr>
                                        <td colspan="7" class="py-4 px-3 text-center text-gray-500">No hay comparables cargados.
                                        </td>
                                    </tr>
                                    @endif

                                    <!-- Fila de Promedio -->
                                    <tr class="font-bold bg-gray-100">
                                        <td class="py-1.5 px-3 align-middle text-sm">Promedio</td>
                                        <!-- CAMBIO: Añadidos los promedios calculados -->
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">${{ $conclusion_promedio_oferta }}
                                        </td>
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">${{
                                            $conclusion_valor_unitario_homologado_promedio }}</td>
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $conclusion_factor_promedio }}
                                        </td>
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                            $conclusion_promedio_factor2_placeholder }}</td>
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                            $conclusion_promedio_ajuste_pct_placeholder }}</td>
                                        <td class="py-1.5 px-3 align-middle text-sm text-center">${{
                                            $conclusion_promedio_valor_final_placeholder }}</td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gráfico Superior (Chart.js + Alpine.js) -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm flex items-center justify-center min-h-[300px]">
                    <div x-data="chartHomologationLands()" wire:ignore class="w-full h-full">
                        <canvas x-ref="chartCanvas"></canvas>
                    </div>
                </div>
            </div>

            <!-- TABLA DE ESTADÍSTICAS Y GRÁFICO INFERIOR -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                <!-- Tabla de Desviación (Lado Izquierdo) -->
                <div>
                    <div class="overflow-x-auto border border-gray-300 rounded-md shadow-sm">
                        <table class="w-full text-md">
                            <thead>
                                <tr class="bg-gray-100 text-md font-semibold text-gray-500 border-b border-gray-300">
                                    <th class="text-left py-2 px-3 w-1/3"></th>
                                    <th class="text-center py-2 px-3 w-1/3">Valor Oferta</th>
                                    <th class="text-center py-2 px-3 w-1/3">Valor Unit. Hom.</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                <!-- CAMBIO: Añadida Media Aritmética -->
                           {{--      <tr>
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Media aritmética</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">${{ $conclusion_media_aritmetica_oferta
                                        }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">${{
                                        $conclusion_media_aritmetica_homologado }}</td>
                                </tr> --}}
                                <tr>
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Desviación Estándar</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_desviacion_estandar_oferta }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_desviacion_estandar_homologado }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Coeficiente de Variación</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_coeficiente_variacion_oferta }} %</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_coeficiente_variacion_homologado }} %</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Dispersión</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $conclusion_dispersion_oferta }} %
                                    </td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $conclusion_dispersion_homologado }}
                                        %</td>
                                </tr>
                                <tr class="font-bold bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Máximo</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $conclusion_maximo_oferta }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $conclusion_maximo_homologado }}
                                    </td>
                                </tr>
                                <tr class="font-bold bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Mínimo</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $conclusion_minimo_oferta }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $conclusion_minimo_homologado }}
                                    </td>
                                </tr>
                                <tr class="font-bold bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Diferencia</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $conclusion_diferencia_oferta }}
                                    </td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $conclusion_diferencia_homologado }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Gráfico Inferior (Chart.js + Alpine.js) -->
             <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm flex items-center justify-center min-h-[300px]">
                <div x-data="chartHomologationLands()" wire:ignore class="w-full h-full">
                    <canvas x-ref="chartCanvas"></canvas>
                </div>
            </div>
            </div>

            <!-- VALOR UNITARIO LOTE TIPO Y REDONDEO -->
            <!-- CAMBIO: Re-maquetado con Grid para layout de imagen y responsividad -->
           <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
            <!-- Contenedor principal que apila las dos filas verticalmente con un espacio -->
            <div class="flex flex-col space-y-4">

                <!--
                  FILA 1: VALOR UNITARIO LOTE TIPO
                  - Móvil (default): flex-col (label arriba, valor abajo)
                  - Desktop (md:): flex-row (label izquierda, valor derecha), alineados y justificados.
                -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <!-- Izquierda: Label -->
                    <span class="text-xl font-bold text-gray-800">VALOR UNITARIO LOTE TIPO:</span>

                    <!-- Derecha: Valor -->
                    <!-- 'mt-1' para dar espacio en móvil, 'md:mt-0' lo resetea en desktop -->
                    <span class="text-3xl font-extrabold text-gray-900 mt-1 md:mt-0">
                        {{ $conclusion_valor_unitario_lote_tipo }}
                    </span>
                </div>

                <!--
                  FILA 2: TIPO DE REDONDEO
                  - Misma lógica: flex-col en móvil, flex-row en desktop.
                -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <!-- Izquierda: Label -->
                    <label for="tipo_redondeo" class="block text-sm font-medium text-gray-700 whitespace-nowrap mb-1 md:mb-0">
                        TIPO DE REDONDEO SOBRE EL VALOR UNITARIO LOTE TIPO:
                    </label>

                    <!-- Derecha: Select -->
                    <!-- 'w-full' para móvil, 'md:w-40' para desktop. 'mt-1' para espacio en móvil -->
                    <flux:select wire:model.live="conclusion_tipo_redondeo" id="tipo_redondeo"
                        class="w-full md:w-40 text-sm mt-1 md:mt-0">
                        <flux:select.option value="UNIDADES">UNIDADES</flux:select.option>
                        <flux:select.option value="DECENAS">DECENAS</flux:select.option>
                        <flux:select.option value="CENTENAS">CENTENAS</flux:select.option>
                        <flux:select.option value="MILLARES">MILLARES</flux:select.option>
                    </flux:select>
                </div>

            </div>
        </div>

        </div>

    </div>






    @else
    <div>
        <h2 class="text-xl font-semibold">
            Necesitas tener al menos 4 comparables asignados en el apartado terrenos para ver esta sección</h2>
    </div>
    @endif




    {{-- Añadimos el componente del modal para el resumen del comparable --}}
    <livewire:forms.comparables.comparable-summary />


    <!-- CÓDIGO ALPINE.JS PARA LOS GRÁFICOS (DEBE IR AL FINAL DE TU VISTA) -->
<script>
    document.addEventListener('alpine:init', () => {

    // 📊 Gráfica de homologación de terrenos
    Alpine.data('chartHomologationLands', () => ({
        chart: null,

        initChart(data) {
            const ctx = this.$root.querySelector('canvas');
            this.chart = new Chart(ctx, {
                type: 'bar',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Homologación de Terrenos'
                        }
                    }
                }
            });
        },

        updateChart(newData) {
            if (this.chart) {
                this.chart.data = newData;
                this.chart.update();
            }
        },

        init() {
            // 👇 Aquí está el cambio: sin paréntesis
            const newData = this.$wire.chartData;
            this.initChart(newData);

            Livewire.hook('element.updated', (el, component) => {
                if (el.contains(this.$root)) {
                    this.updateChart(this.$wire.chartData);
                }
            });
        }
    }));

    // 📈 Gráfica de estadísticas de homologación
    Alpine.data('chartHomologationStats', () => ({
        chart: null,

        initStatsChart(data) {
            const ctx = this.$root.querySelector('canvas');
            this.chart = new Chart(ctx, {
                type: 'line',
                data: data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        title: {
                            display: true,
                            text: 'Estadísticas de Homologación'
                        }
                    }
                }
            });
        },

        updateStatsChart(newData) {
            if (this.chart) {
                this.chart.data = newData;
                this.chart.update();
            }
        },

        init() {
            // 👇 Igual aquí: sin paréntesis
            const newData = this.$wire.chartData;
            this.initStatsChart(newData);

            Livewire.hook('element.updated', (el, component) => {
                if (el.contains(this.$root)) {
                    this.updateStatsChart(this.$wire.chartData);
                }
            });
        }
    }));
});
</script>
</div>
