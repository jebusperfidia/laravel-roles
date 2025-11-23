{{--
============================================================
== ARCHIVO BLADE COMPLETO Y CORREGIDO FINAL
== - Se corrigió el error de carga de gráficas (Gráficas 1 y 2).
== - Se eliminaron los comentarios de la gráfica y se implementó Alpine x-data.
== - Se añadió el patrón de carga robusta con x-ref y setTimeout/Livewire.on.
============================================================
--}}
<div>

    @if($comparablesCount >= 4)

    <div class="form-container">
        <div class="form-container__header">
            Sujeto
        </div>

        <div class="form-container__content">
            <div class="p-4 bg-white border border-gray-300 rounded-lg mb-6">
                {{-- ... tu código de dirección ... --}}
                <p class="font-bold text-md flex items-center text-gray-800">
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
                    Colonia:
                    @if($valuation->property_colony === 'no-listada')
                    {{ $valuation->property_other_colony ?? 'N/A (No listada)' }}
                    @else
                    {{ $valuation->property_colony ?? 'N/A' }}
                    @endif
                    (CP {{ $valuation->property_cp ?? 'N/A' }}, {{ $valuation->property_locality_name ?? 'N/A' }})
                </p>
            </div>

            <div class="flex flex-col md:flex-row gap-x-6 gap-y-8">

                <div class="space-y-4 md:w-1/3 w-full">

                    <flux:field>
                        <flux:label>SUPERFICIE APLICABLE</flux:label>

                        {{-- Dropdown Personalizado para Superficie Aplicable (CORREGIDO PARA ANCHO Y ALINEACIÓN) --}}
                        <div class="relative w-full">
                            <flux:dropdown inline position="bottom" align="start" class="w-full">

                                {{-- BOTÓN DE DESPLIEGUE --}}
                                <button @click.stop.prevent
                                    @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                                    , 'border border-gray-300 text-gray-700 hover:border-gray-400'=> !
                                    $errors->has('selectedSurfaceOptionId'),
                                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500
                                    focus:border-red-500' =>
                                    $errors->has('selectedSurfaceOptionId'),
                                    ])>
                                    <span class="flex-1 text-left text-gray-700">
                                        {{ $selectedSurfaceDescription }}
                                    </span>
                                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>

                                {{-- MENÚ/TABLA DE OPCIONES (Estático) --}}
                                <flux:menu class="absolute left-0 top-full mt-1 w-[400px] bg-white
                                    border border-gray-200 rounded-md shadow-lg z-10">

                                    <flux:menu.item disabled>
                                        <div
                                            class="w-full grid grid-cols-[30%_70%] px-2 py-1 text-gray-600 font-medium">
                                            <span>Superficie m2</span>
                                            <span>Descripción</span>
                                        </div>
                                    </flux:menu.item>
                                    <flux:menu.separator />

                                    {{-- OPCIÓN 1: Terreno Total (ID 1) --}}
                                    <flux:menu.item
                                        wire:click="$set('selectedSurfaceOptionId', 1); $set('selectedSurfaceDescription', 'Terreno Total (2,000.00 m2)')"
                                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors
                                        {{ $selectedSurfaceOptionId == 1 ? 'bg-gray-100' : '' }}">
                                        <div class="w-full grid grid-cols-[30%_70%]">
                                            <span class="text-left font-semibold">2,000.00</span>
                                            <span class="text-left">Terreno Total</span>
                                        </div>
                                    </flux:menu.item>

                                    {{-- OPCIÓN 2: Lote Privativo (ID 2) --}}
                                    <flux:menu.item
                                        wire:click="$set('selectedSurfaceOptionId', 2); $set('selectedSurfaceDescription', 'Lote Privativo (2,000.00 m2)')"
                                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors
                                        {{ $selectedSurfaceOptionId == 2 ? 'bg-gray-100' : '' }}">
                                        <div class="w-full grid grid-cols-[30%_70%]">
                                            <span class="text-left font-semibold">2,000.00</span>
                                            <span class="text-left">Lote Privativo</span>
                                        </div>
                                    </flux:menu.item>

                                    {{-- OPCIÓN 3: Lote Proporcional (ID 3) --}}
                                    <flux:menu.item
                                        wire:click="$set('selectedSurfaceOptionId', 3); $set('selectedSurfaceDescription', 'Lote Proporcional (1,980.00 m2)')"
                                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors
                                        {{ $selectedSurfaceOptionId == 3 ? 'bg-gray-100' : '' }}">
                                        <div class="w-full grid grid-cols-[30%_70%]">
                                            <span class="text-left font-semibold">1,980.00</span>
                                            <span class="text-left">Lote Proporcional</span>
                                        </div>
                                    </flux:menu.item>

                                </flux:menu>
                            </flux:dropdown>
                            {{-- Mantenemos el error dentro del flux:field --}}
                            <flux:error name="selectedSurfaceOptionId" />
                        </div>
                    </flux:field>

                    <flux:input type="text" label="C.U.S." wire:model.lazy="subject_cus" readonly />
                    <flux:input type="text" label="C.O.S." wire:model.lazy="subject_cos" readonly />
                    <flux:input type="text" label="Lote moda" wire:model.lazy="subject_lote_moda"
                        placeholder="100.00" />
                </div>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:w-2/3 w-full">
                    <h4
                        class="font-semibold text-gray-700 mb-3 border-b border-gray-300 pb-2 flex justify-between items-center">
                        <span>Factores del Sujeto</span>
                        <span class="text-xs font-normal text-gray-500 bg-gray-200 px-2 py-1 rounded">Building</span>
                    </h4>

                    <div class="overflow-x-auto border border-gray-300 rounded-md">
                        <table class="w-full text-md table-fixed">
                            <thead>
                                <tr class="bg-gray-100 text-md font-semibold text-gray-500 border-b border-gray-300">
                                    <th class="text-left py-2 px-3 w-1/2">Descripción</th>
                                    <th class="text-left py-2 px-2 w-20">Siglas</th>
                                    <th class="text-left py-2 px-3 w-32">Calificación</th>
                                </tr>
                            </thead>

                            {{--
                            ============================================================
                            == BLOQUE TBODY DEL SUJETO
                            ============================================================
                            --}}
                            <tbody class="divide-y divide-gray-200 bg-white">

                                @foreach($subject_factors_ordered as $index => $factor)
                                @php
                                $name = $factor['factor_name'] ?? '';
                                $sigla = $factor['acronym'] ?? '';
                                $isEditable = !empty($factor['is_editable']);
                                @endphp

                                <tr class="hover:bg-gray-50" wire:key="subject-factor-{{ $factor['id'] ?? $index }}">

                                    {{-- Descripción / Nombre --}}
                                    <td class="py-1.5 px-3 align-middle">
                                        @if($isEditable)
                                        <flux:input type="text" wire:model.lazy="subject_factors_ordered.{{ $index }}.factor_name"
                                            placeholder="Nombre factor" class="h-9 text-sm w-full" />
                                        @else
                                        <flux:label class="font-medium text-gray-700 block">{{ $name }}</flux:label>
                                        @endif
                                    </td>

                                    {{-- Siglas --}}
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        @if($isEditable)
                                        <flux:input type="text" wire:model.lazy="subject_factors_ordered.{{ $index }}.acronym"
                                            placeholder="SIG" class="font-mono text-xs h-9 w-20" />
                                        @else
                                        <flux:label class="font-mono text-md text-gray-700">{{ $sigla }}</flux:label>
                                        @endif
                                    </td>

                                    {{-- Calificación / Rating --}}
                                    <td class="py-1.5 px-3 align-middle">
                                        @if(in_array($sigla, ['FSU', 'FCUS']))
                                        {{-- VERSIÓN READONLY (GRIS) --}}
                                        <flux:input type="number" step="0.0001"
                                            wire:model.lazy="subject_factors_ordered.{{ $index }}.rating" placeholder="1.0000" readonly
                                            class="text-right h-9 text-sm w-full bg-gray-50 cursor-not-allowed" />
                                        @else
                                        {{-- VERSIÓN EDITABLE (BLANCO) --}}
                                        <flux:input type="number" step="0.0001"
                                            wire:model.lazy="subject_factors_ordered.{{ $index }}.rating" placeholder="1.0000"
                                            class="text-right h-9 text-sm w-full" />
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                @if(empty($subject_factors_ordered) || count($subject_factors_ordered) === 0)
                                <tr>
                                    <td colspan="3" class="py-4 px-3 text-center text-gray-500">
                                        No hay factores de tipo <strong>land</strong> definidos.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                            {{-- FIN DEL TBODY DEL SUJETO --}}
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

            <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b pb-4">
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
                <div class="flex items-center space-x-3 mt-3 md:mt-0">
                    <flux:button class="btn-primary cursor-pointer" type="button"
                        wire:click="$dispatch('openSummary', { id: {{ $selectedComparableId }}, comparableType: 'land' })"
                        size="sm">
                        Resumen
                    </flux:button>
                    <flux:button class="btn-primary cursor-pointer" type="button" wire:click='openComparablesLand'
                        size="sm">
                        Cambiar Comparables
                    </flux:button>
                </div>
            </div>

            <div class="relative">
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

                <div class="flex flex-col md:flex-row gap-x-6 gap-y-8" wire:loading.class="opacity-50">

                    <div class="md:w-1/3 w-full space-y-3" wire:key="ficha-{{ $selectedComparableId }}">
                        <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-md">
                            <div>
                                <dt class="font-semibold text-gray-800">Ciudad:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_locality_name ?? 'N/A' }}
                                </dd>
                                <dt class="font-semibold text-gray-800 mt-2">Calle y núm:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_street ?? 'N/A' }}</dd>
                                <dt class="font-semibold text-gray-800 mt-2">Alc./Mpio:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_locality_name ?? 'N/A'
                                    }}</dd>
                                <dt class="font-semibold text-gray-800 mt-2">Colonia:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_colony ??
                                    $selectedComparable->comparable_other_colony ?? 'N/A'}}</dd>
                                <dt class="font-semibold text-gray-800 mt-2">Fuente:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_source ?? 'N/A' }}</dd>
                                <dt class="font-semibold text-gray-800 mt-2">Oferta:</dt>
                                <dd class="text-gray-600">${{ number_format($selectedComparable->comparable_offers, 2)
                                    }}</dd>
                                <dt class="font-semibold text-gray-800 mt-2">Superficie:</dt>
                                <dd class="text-gray-600">{{ number_format($selectedComparable->comparable_land_area, 2)
                                    }} m²</dd>
                                <dt class="font-semibold text-gray-800 mt-2">Valor Unitario:</dt>
                                <dd class="text-gray-600">${{ number_format($selectedComparable->comparable_unit_value,
                                    2) }}</dd>
                                <dt class="font-semibold text-gray-800 mt-2">Vigencia/Fecha:</dt>
                                <dd class="text-gray-600">
                                    {{ $selectedComparable->comparable_date ?
                                    \Carbon\Carbon::parse($selectedComparable->comparable_date)->format('d/m/Y') : 'N/A'
                                    }}
                                </dd>
                                <dt class="font-semibold text-gray-800 mt-2">Características:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_characteristics ?? 'N/A' }}
                                </dd>
                            </div>
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

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:w-2/3 w-full"
                        wire:key="factores-{{ $selectedComparableId }}">
                        <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-300 pb-2">Factores de Ajuste
                            Aplicados</h4>
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
                                    {{-- ITERA SOBRE LA PROPIEDAD COMPUTADA QUE GARANTIZA EL ORDEN [FNEG, FZO, ..., FSU,
                                    FCUS] --}}
                                    @foreach ($this->orderedComparableFactorsForView as $index => $factor)
                                    @php
                                    $sigla = $factor['acronym'];
                                    $sujetoRating = $factor['rating'];
                                    $inputType = $factor['input_type'] ?? 'number';

                                    // Valores calculados del array (con defaults)
                                    $factorData = $comparableFactors[$selectedComparableId][$sigla] ?? [];
                                    $compCalificacion = $factorData['calificacion'] ?? '1.0000';
                                    $diferencia = $factorData['diferencia'] ?? '0.0000';
                                    $aplicableCalc = $factorData['factor_ajuste'] ?? '1.0000';
                                    $aplicableFNEG = $factorData['aplicable'] ?? '0.9000';
                                    @endphp

                                    <tr class="hover:bg-gray-50"
                                        wire:key="comp-factor-{{ $selectedComparableId }}-{{ $sigla }}">

                                        {{-- Factor (Sigla) --}}
                                        <td class="py-1.5 px-3 align-middle">
                                            <flux:label class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">
                                                {{ $sigla }}
                                            </flux:label>
                                        </td>

                                        {{-- Cal. Sujeto --}}
                                        <td class="py-1.5 px-2 text-left align-middle">
                                            <flux:label class="text-gray-700">
                                                @if($sigla === 'FNEG') - @else {{ $sujetoRating }} @endif
                                            </flux:label>
                                        </td>

                                        {{-- Cal. Comp. (Manejo de Inputs) --}}
                                        <td class="py-1.5 px-2 text-left align-middle">
                                            @if($inputType === 'read_only')
                                            {{-- FSU y FCUS: Readonly (label) --}}
                                            <flux:label class="text-gray-700 h-9 flex items-center px-1">
                                                {{ $compCalificacion }}
                                            </flux:label>

                                            @elseif($inputType === 'select_calificacion')
                                            {{-- FZO y FUB: Select --}}
                                            <flux:select
                                                wire:model.lazy="comparableFactors.{{ $selectedComparableId }}.{{ $sigla }}.calificacion"
                                                class="!text-sm !py-1 w-full">

                                                {{-- Opciones fijas requeridas: 0.8000, 1.0000 y 1.2000 --}}
                                                <flux:select.option value="0.8">0.8000</flux:select.option>
                                                <flux:select.option value="1.0">1.0000</flux:select.option>
                                                <flux:select.option value="1.2">1.2000</flux:select.option>

                                            </flux:select>

                                            @elseif($sigla === 'FNEG')
                                            {{-- FNEG: Sin Calificación. Mostramos un guion. --}}
                                            <flux:label class="text-gray-700 h-9 flex items-center px-1">-</flux:label>

                                            @else
                                            {{-- FFO, FLOC, OTRO (y cualquier otro, por defecto): Input Numérico
                                            editable --}}
                                            <flux:input type="number" step="0.0001"
                                                wire:model.lazy="comparableFactors.{{ $selectedComparableId }}.{{ $sigla }}.calificacion"
                                                placeholder="1.0000" class="text-left h-9 text-sm w-full" />
                                            @endif
                                        </td>

                                        {{-- Dif. (Calculado) --}}
                                        <td class="py-1.5 px-3 text-left align-middle">
                                            <flux:label class="text-gray-900">
                                                @if($sigla === 'FNEG')
                                                -
                                                @else
                                                {{ $diferencia }}
                                                @endif
                                            </flux:label>
                                        </td>

                                        {{-- Aplicable (Factor Ajuste) --}}
                                        <td class="py-1.5 px-3 text-left align-middle">
                                            @if($sigla === 'FNEG')
                                            {{-- FNEG: Editable --}}
                                            <flux:input type="number" step="0.0001"
                                                wire:model.lazy="comparableFactors.{{ $selectedComparableId }}.{{ $sigla }}.aplicable"
                                                placeholder="0.9000" class="text-left h-9 text-sm w-full" />
                                            @else
                                            {{-- Los demás "Aplicable" son el Factor Ajuste calculado (read-only) --}}
                                            <flux:label class="text-gray-900">{{ $aplicableCalc }}
                                            </flux:label>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                {{-- FIN DEL TBODY DEL COMPARABLE --}}

                                <tfoot class="bg-gray-100 border-t-2 border-gray-300">
                                    <tr class="font-extrabold text-md">
                                        <td colspan="4" class="py-2 px-3 text-right">FACTOR RESULTANTE (FRE):</td>
                                        <td class="py-2 px-3 text-left text-gray-900">
                                            {{ $comparableFactors[$selectedComparableId]['FRE']['factor_ajuste'] ??
                                            '1.0000' }}
                                        </td>
                                    </tr>
                                    <tr class="font-extrabold text-md">
                                        <td colspan="4" class="py-2 px-3 text-right">Valor Unitario Homologado:</td>
                                        <td class="py-2 px-3 text-left text-gray-900">
                                            ${{
                                            number_format($comparableFactors[$selectedComparableId]['FRE']['valor_homologado']
                                            ?? 0, 2)
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
            Conclusiones
        </div>
        <div class="form-container__content">

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <div class="overflow-x-auto border border-gray-300 rounded-md shadow-sm">
                        <table class="w-full text-md">
                            <thead>
                                <tr class="bg-gray-100 text-md font-semibold text-gray-500 border-b border-gray-300">
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
                                @if($comparables && $comparables->count() > 0)
                                @foreach ($comparables as $index => $comparable)
                                @php
                                $compData = $comparableFactors[$comparable->id] ?? [];
                                $factorFRE = $compData['FRE']['factor_ajuste'] ?? 0.0;
                                $valorHomologado = $compData['FRE']['valor_homologado'] ?? 0.0;
                                $factor2 = '0.00'; // Placeholder
                                $ajustePct = '0.00%'; // Placeholder
                                $valorFinal = '0.00'; // Placeholder
                                @endphp
                                <tr class="hover:bg-gray-50 ">
                                    <td class="py-1.5 px-3 align-middle text-sm">
                                        <input type="checkbox" wire:model.live='selectedForStats'
                                            value="{{ $comparable->id }}"
                                            class="rounded text-blue-600 focus:ring-blue-500 mr-2">
                                        {{ $comparable->id }}
                                    </td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">${{
                                        number_format($comparable->comparable_offers, 2) }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">${{
                                        number_format($valorHomologado, 2) }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        number_format((float)$factorFRE, 4) }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $factor2 }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{ $ajustePct }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">${{ $valorFinal }}</td>
                                </tr>
                                @endforeach
                                @else
                                <tr>
                                    <td colspan="7" class="py-4 px-3 text-center text-gray-500">No hay comparables
                                        cargados.</td>
                                </tr>
                                @endif
                                <tr class="font-bold bg-gray-100">
                                    <td class="py-1.5 px-3 align-middle text-sm">Promedio</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">${{
                                        $conclusion_promedio_oferta }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">${{
                                        $conclusion_valor_unitario_homologado_promedio }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_factor_promedio }}</td>
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

                {{-- GRÁFICA 1: MIXTA (Arriba a la derecha) --}}
                <div x-data="chartHomologationLands()" x-init="init()" wire:ignore
                    class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm flex items-center justify-center min-h-[300px]">
                    <div class="w-full h-full">
                        <canvas x-ref="chart1"></canvas>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
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
                                <tr>
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Desviación Estándar</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_desviacion_estandar_oferta }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_desviacion_estandar_homologado }}</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Coeficiente de Variación
                                    </td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_coeficiente_variacion_oferta }} %</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_coeficiente_variacion_homologado }} %</td>
                                </tr>
                                <tr class="font-bold bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Máximo</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_maximo_oferta }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_maximo_homologado }}</td>
                                </tr>
                                <tr class="font-bold bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Mínimo</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_minimo_oferta }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_minimo_homologado }}</td>
                                </tr>
                                <tr class="font-bold bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Diferencia</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_diferencia_oferta }}</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_diferencia_homologado }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                {{-- GRÁFICA 2: BARRAS ROJAS (Abajo a la derecha) --}}
                <div x-data="chartHomologationStats()" x-init="init()" wire:ignore
                    class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm flex items-center justify-center min-h-[300px]">
                    <div class="w-full h-full">
                        <canvas x-ref="chart2"></canvas>
                    </div>
                </div>
            </div>

            <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                        <span class="text-xl font-bold text-gray-800">VALOR UNITARIO LOTE TIPO:</span>
                        <span class="text-3xl font-extrabold text-gray-900 mt-1 md:mt-0">
                            {{ $conclusion_valor_unitario_lote_tipo }}
                        </span>
                    </div>
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                        <label for="tipo_redondeo"
                            class="block text-sm font-medium text-gray-700 whitespace-nowrap mb-1 md:mb-0">
                            TIPO DE REDONDEO SOBRE EL VALOR UNITARIO LOTE TIPO:
                        </label>
                        <flux:select wire:model.live="conclusion_tipo_redondeo" id="tipo_redondeo"
                            class="w-full md:w-40 text-sm mt-1 md:mt-0">
                            <flux:select.option value="Unidades">Unidades</flux:select.option>
                            <flux:select.option value="Decenas">Decenas</flux:select.option>
                            <flux:select.option value="Centenas">Centenas</flux:select.option>
                            <flux:select.option value="Miles">Miles</flux:select.option>
                            <flux:select.option value="Sin decimales">Sin decimales</flux:select.option>
                            <flux:select.option value="Sin redondeo">Sin redondeo</flux:select.option>
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


    <script>
        // Función general para crear y actualizar gráficas de manera robusta
        function createChartManager(chartType, eventName, refName) {
            return {
                chart: null,

                init() {
                    // 1. Asegura que el DOM está listo antes de dibujar (Truco del mapManager)
                    setTimeout(() => this.drawInitialChart(), 100);

                    // 2. Escucha el evento Livewire que el controlador despacha
                    Livewire.on(eventName, (event) => {
                        const data = event[0].data;
                        this.createOrUpdateChart(data);
                    });
                },

                drawInitialChart() {
                    // Inicializa con datos vacíos para montar el objeto Chart
                    const initialData = { labels: [], datasets: [] };
                    this.createOrUpdateChart(initialData);
                },

                createOrUpdateChart(data) {
                    const ctx = this.$refs[refName];
                    if (!ctx) return;

                    if (this.chart) {
                        // Si ya existe, solo actualiza los datos y redibuja
                        this.chart.data = data;
                        this.chart.update();
                    } else {
                        // Si no existe, inicializa la gráfica
                        this.chart = new Chart(ctx, {
                            type: chartType,
                            data: data,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: { display: false },
                                    tooltip: { mode: 'index', intersect: false }
                                },
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        // La Gráfica 1 (Mixta, arriba) tiene líneas de cuadrícula más suaves (drawBorder: false)
                                        grid: { display: true, drawBorder: (refName === 'chart2') }
                                    },
                                    x: {
                                        grid: { display: false }
                                    }
                                }
                            }
                        });
                    }
                }
            };
        }

        document.addEventListener('alpine:init', () => {
            // 📊 GRÁFICA 1: MIXTA (Arriba) - Tipo base 'bar' para que la línea se dibuje correctamente
            Alpine.data('chartHomologationLands', () => createChartManager('bar', 'updateLandChart1', 'chart1'));

            // 📊 GRÁFICA 2: BARRAS ROJAS (Abajo) - Tipo base 'bar'
            Alpine.data('chartHomologationStats', () => createChartManager('bar', 'updateLandChart2', 'chart2'));
        });
    </script>
</div>
