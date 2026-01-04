{{--
============================================================
== ARCHIVO BLADE: HOMOLOGACIÓN DE TERRENOS (FINAL MERGED)
== 1. Se recuperó la sección de COMPARABLES completa.
== 2. Se aplicó el FIX de Javascript (evita bucle infinito).
== 3. Se mantiene wire:init para cargar datos iniciales.
============================================================
--}}
<div>

    @if($comparablesCount >= 4)

    {{-- MANTENEMOS wire:init AQUÍ para que dispare el evento al cargar --}}
    <div class="form-container" wire:init="recalculateConclusions">

        {{-- ======================================================================== --}}
        {{-- SECCIÓN 1: SUJETO --}}
        {{-- ======================================================================== --}}
        <div class="form-container__header">
            Sujeto
        </div>

        <div class="form-container__content">
            <div class="p-4 bg-white border border-gray-300 rounded-lg mb-6">
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
                    {{-- DROPDOWN DE SUPERFICIE APLICABLE --}}
                    <flux:field>
                        <flux:label>Superficie aplicable</flux:label>
                        <div class="relative w-full">
                            <flux:dropdown inline position="bottom" align="start" class="w-full">
                                <button @click.stop.prevent
                                    @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                                    , 'border border-gray-300 text-gray-700 hover:border-gray-400'=>
                                    !$errors->has('selectedSurfaceOptionId'),
                                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500
                                    focus:border-red-500' => $errors->has('selectedSurfaceOptionId'),
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

                                <flux:menu
                                    class="absolute left-0 top-full mt-1 w-[400px] bg-white border border-gray-200 rounded-md shadow-lg z-10">
                                    <flux:menu.item disabled>
                                        <div
                                            class="w-full grid grid-cols-[30%_70%] px-2 py-1 text-gray-600 font-medium">
                                            <span>Superficie m²</span>
                                            <span>Descripción</span>
                                        </div>
                                    </flux:menu.item>
                                    <flux:menu.separator />

                                    @foreach($this->surfaceOptions() as $key => $option)
                                    <flux:menu.item wire:click="selectSurfaceOption('{{ $key }}')"
                                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors {{ $selectedSurfaceOptionId === $key ? 'bg-gray-100' : '' }}">
                                        <div class="w-full grid grid-cols-[30%_70%]">
                                            <span class="text-left font-semibold">{{ $option['formatted'] }}</span>
                                            <span class="text-left">{{ $option['description'] }}</span>
                                        </div>
                                    </flux:menu.item>
                                    @endforeach

                                    @if(empty($this->surfaceOptions()))
                                    <div class="px-4 py-2 text-sm text-gray-500 text-center">
                                        No hay superficies calculadas disponibles.
                                    </div>
                                    @endif
                                </flux:menu>
                            </flux:dropdown>
                            <flux:error name="selectedSurfaceOptionId" />
                        </div>
                    </flux:field>

                    {{-- CUS Y COS --}}
                    <flux:field>
                        <flux:label>C.U.S.</flux:label>
                        <div
                            class="px-3 py-2 bg-gray-100 rounded-md border border-gray-300 text-gray-700 font-semibold h-10 flex items-center">
                            {{ $subject_cus }}
                        </div>
                    </flux:field>

                    <flux:field>
                        <flux:label>C.O.S.</flux:label>
                        <div
                            class="px-3 py-2 bg-gray-100 rounded-md border border-gray-300 text-gray-700 font-semibold h-10 flex items-center">
                            {{ $subject_cos }}
                        </div>
                    </flux:field>

                    {{-- LOTE MODA --}}
                    <flux:input type="text" label="Lote moda" wire:model.lazy="subject_lote_moda"
                        placeholder="100.00" />
                </div>

                {{-- TABLA DE FACTORES DEL SUJETO --}}
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:w-2/3 w-full">
                    <h4
                        class="font-semibold text-gray-700 mb-3 border-b border-gray-300 pb-2 flex justify-between items-center">
                        <span>Factores del sujeto</span>
                        {{-- <span
                            class="text-xs font-normal text-gray-500 bg-gray-200 px-2 py-1 rounded">Building</span> --}}
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
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($subject_factors_ordered as $index => $factor)
                                @php
                                $name = $factor['factor_name'] ?? '';
                                $sigla = $factor['acronym'] ?? '';
                                $isEditable = !empty($factor['is_editable']);
                                @endphp

                                <tr class="hover:bg-gray-50" wire:key="subject-factor-{{ $factor['id'] ?? $index }}">
                                    <td class="py-1.5 px-3 align-middle">
                                        @if($isEditable)
                                        <flux:input type="text"
                                            wire:model.lazy="subject_factors_ordered.{{ $index }}.factor_name"
                                            placeholder="Nombre factor" class="h-9 text-sm w-full" />
                                        @else
                                        <flux:label class="font-medium text-gray-700 block">{{ $name }}</flux:label>
                                        @endif
                                    </td>
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        @if($isEditable)
                                        <flux:input type="text"
                                            wire:model.lazy="subject_factors_ordered.{{ $index }}.acronym"
                                            placeholder="SIG" class="font-mono text-xs h-9 w-20" />
                                        @else
                                        <flux:label class="font-mono text-md text-gray-700">{{ $sigla }}</flux:label>
                                        @endif
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        @if(in_array($sigla, ['FSU', 'FCUS']))
                                        <flux:input type="number" step="0.0001"
                                            wire:model.lazy="subject_factors_ordered.{{ $index }}.rating"
                                            placeholder="1.0000" readonly
                                            class="text-right h-9 text-sm w-full bg-gray-50 cursor-not-allowed" />
                                        @else
                                        <flux:input type="number" step="0.0001"
                                            wire:model.lazy="subject_factors_ordered.{{ $index }}.rating"
                                            placeholder="1.0000" class="text-right h-9 text-sm w-full" />
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
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ======================================================================== --}}
    {{-- SECCIÓN 2: COMPARABLES (¡AQUÍ ESTÁN DE VUELTA!) --}}
    {{-- ======================================================================== --}}
    <div class="form-container">
        <div class="form-container__header">
            Comparables
        </div>
        <div class="form-container__content">

            {{-- Paginación y Botones Superiores --}}
            <div class="flex flex-col md:flex-row justify-between items-center mb-6 border-b pb-4">
                <div class="flex items-center space-x-2">
                    <span class="text-md font-semibold text-gray-600 mr-2">Comparable:</span>
                    @for ($i = 1; $i <= $comparablesCount; $i++) <button type="button" wire:click="gotoPage({{ $i }})"
                        class="px-3 py-1 text-sm rounded-full transition-colors cursor-pointer {{ $currentPage === $i ? 'bg-teal-600 text-white font-bold shadow-md' : 'bg-gray-200 text-gray-700 hover:bg-blue-100' }}">
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
                {{-- Loader --}}
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

                {{-- Contenido Principal --}}
                <div class="flex flex-col md:flex-row gap-x-6 gap-y-8" wire:loading.class="opacity-50"
                    wire:target="gotoPage, selectSurfaceOption, openComparablesLand">

                    {{-- FICHA DEL COMPARABLE --}}
                    <div class="md:w-1/3 w-full space-y-3" wire:key="ficha-{{ $selectedComparableId }}">
                        <div class="p-4 bg-white border border-gray-300 rounded-lg shadow-sm">
                            <div class="grid grid-cols-2 gap-x-4 gap-y-2 text-md">
                                <div>
                                    <dt class="font-semibold text-gray-800">Ciudad:</dt>
                                    <dd class="text-gray-600 truncate"
                                        title="{{ $selectedComparable->comparable_locality_name }}">
                                        {{ $selectedComparable->comparable_locality_name ?? '-' }}
                                    </dd>
                                    <dt class="font-semibold text-gray-800 mt-2">Calle y núm:</dt>
                                    <dd class="text-gray-600 truncate"
                                        title="{{ $selectedComparable->comparable_street }}">
                                        {{ $selectedComparable->comparable_street ?? '-' }}
                                    </dd>
                                    <dt class="font-semibold text-gray-800 mt-2">Alc./Mpio:</dt>
                                    <dd class="text-gray-600 truncate"
                                        title="{{ $selectedComparable->comparable_locality_name }}">
                                        {{ $selectedComparable->comparable_locality_name ?? '-' }}
                                    </dd>
                                    <dt class="font-semibold text-gray-800 mt-2">Colonia:</dt>
                                    <dd class="text-gray-600 truncate"
                                        title="{{ $selectedComparable->comparable_colony ?? $selectedComparable->comparable_other_colony }}">
                                        {{ $selectedComparable->comparable_colony ??
                                        $selectedComparable->comparable_other_colony ?? '-'}}
                                    </dd>
                                    <dt class="font-semibold text-gray-800 mt-2">Fuente:</dt>
                                    <dd class="text-gray-600 truncate">
                                        {{ $selectedComparable->comparable_source_inf_images ??
                                        $selectedComparable->comparable_source ?? '-' }}
                                    </dd>
                                    <dt class="font-semibold text-gray-800 mt-2">Oferta:</dt>
                                    <dd class="text-gray-600">${{ number_format($selectedComparable->comparable_offers,
                                        2) }}</dd>
                                    <dt class="font-semibold text-gray-800 mt-2">Superficie:</dt>
                                    <dd class="text-gray-600">{{
                                        number_format($selectedComparable->comparable_land_area, 2) }} m²</dd>
                                    <dt class="font-semibold text-gray-800 mt-2">Valor Unitario:</dt>
                                    {{-- CAMBIO AQUÍ: QUITAMOS text-teal-700 POR text-gray-900 --}}
                                    <dd class="text-gray-900 font-bold">${{
                                        number_format($selectedComparable->comparable_unit_value, 2) }}</dd>


                                    <dt class="font-semibold text-gray-800 mt-2">
                                        Vigencia/Fecha:
                                    </dt>
                                    {{-- 1. Definimos la clase CSS directo en el elemento usando una condicional simple
                                    --}}
                                    <dd
                                        class="{{ $selectedComparable->dias_para_vencer < 0 ? 'text-red-600 font-bold' : 'text-teal-700 font-bold' }}">

                                        @if ($selectedComparable->dias_para_vencer < 0) {{-- CASO VENCIDO: Usamos abs()
                                            para convertir -5 días a "5 días" --}} Vencida (Hace {{
                                            abs($selectedComparable->dias_para_vencer) }} días)

                                            @else
                                            {{-- CASO VIGENTE: Mostramos días restantes y formateamos la fecha ahí mismo
                                            --}}
                                            @php
                                            // Solo para mostrar la fecha bonita entre paréntesis (sin recalcular días)
                                            $fechaMostrar = $selectedComparable->comparable_date
                                            ? \Carbon\Carbon::parse($selectedComparable->comparable_date)
                                            : $selectedComparable->created_at;
                                            @endphp

                                            Quedan {{ $selectedComparable->dias_para_vencer }} Días ({{
                                            $fechaMostrar->format('d/m/Y') }})
                                            @endif
                                    </dd>
                                </div>

                                <div>
                                    <dt class="font-semibold text-gray-800">Uso de Suelo:</dt>
                                    <dd class="text-gray-600 truncate">{{ $selectedComparable->comparable_land_use ??
                                        '-' }}</dd>
                                    <dt class="font-semibold text-gray-800 mt-2">Características:</dt>
                                    <dd class="text-gray-600 text-xs line-clamp-3"
                                        title="{{ $selectedComparable->comparable_characteristics }}">
                                        {{ $selectedComparable->comparable_characteristics ?? '-' }}
                                    </dd>
                                    <div class="my-2 border-t border-gray-100"></div>
                                    @php
                                    $niveles = (float)($selectedComparable->comparable_allowed_levels ??
                                    $selectedComparable->comparable_max_levels ?? 0);
                                    $areaLibre = (float)($selectedComparable->comparable_free_area_required ??
                                    $selectedComparable->comparable_free_area ?? 0);
                                    $areaLibreDec = ($areaLibre > 1) ? ($areaLibre / 100) : $areaLibre;
                                    $cusCalculado = $niveles * (1 - $areaLibreDec);
                                    @endphp
                                    <dt class="font-semibold text-gray-800">Área libre:</dt>
                                    <dd class="text-gray-600">{{ number_format($areaLibre, 0) }}%</dd>
                                    <dt class="font-semibold text-gray-800 mt-2">Niv. Perm.:</dt>
                                    <dd class="text-gray-600">{{ number_format($niveles, 1) }}</dd>
                                    <dt class="font-semibold text-gray-800 mt-2">CUS (Calc):</dt>
                                    <dd class="text-gray-600 font-bold">{{ number_format($cusCalculado, 2) }}</dd>
                                    <dt class="font-semibold text-gray-800 mt-2">Diferencia:</dt>
                                    <dd class="text-gray-600">% 0.00</dd>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- TABLA DE FACTORES DE AJUSTE --}}
                    {{-- TABLA DE FACTORES DE AJUSTE (VERSIÓN BLINDADA) --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:w-2/3 w-full"
                        wire:key="container-factores-{{ $selectedComparableId }}">

                        <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-300 pb-2">
                            Factores de ajuste aplicados
                        </h4>

                        <div class="overflow-x-auto border border-gray-300 rounded-md">
                            <table class="w-full text-md table-fixed">
                                <thead>
                                    <tr class="bg-gray-100 text-md font-semibold text-gray-500 border-b border-gray-300">
                                        <th class="text-left py-2 px-3 w-20">Factor</th>
                                        <th class="text-left py-2 px-2 w-24">Cal. Sujeto</th>
                                        <th class="text-left py-2 px-2 w-24">Cal. Comp.</th>
                                        <th class="text-left py-2 px-3 w-24">Dif.</th>
                                        <th class="text-left py-2 px-3 w-24">Aplicable</th>
                                    </tr>
                                </thead>
                                {{-- AÑADIMOS KEY AL TBODY PARA DAR ESTABILIDAD AL BLOQUE ENTERO --}}
                                <tbody class="divide-y divide-gray-200 bg-white" wire:key="tbody-{{ $selectedComparableId }}">
                                    @foreach ($this->orderedComparableFactorsForView as $index => $factor)
                                    @php
                                    $sigla = $factor['acronym'];
                                    $sujetoRating = $factor['rating'];

                                    $factorData = $comparableFactors[$selectedComparableId][$sigla] ?? [];
                                    $compCalificacion = $factorData['calificacion'] ?? '1.0000';
                                    $diferencia = $factorData['diferencia'] ?? '0.0000';
                                    $aplicableCalc = $factorData['aplicable'] ?? '1.0000';

                                    $isEditable = !in_array($sigla, ['FNEG', 'FSU', 'FCUS']);
                                    @endphp

                                    <tr class="hover:bg-gray-50" wire:key="row-{{ $selectedComparableId }}-{{ $sigla }}">
                                        {{-- 1. FACTOR --}}
                                        <td class="py-1.5 px-3 align-middle">
                                            <flux:label class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">
                                                {{ $sigla }}
                                            </flux:label>
                                        </td>

                                        {{-- 2. CALIFICACIÓN SUJETO --}}
                                        <td class="py-1.5 px-2 text-left align-middle">
                                            <flux:label class="text-gray-700">
                                                @if($sigla === 'FNEG') - @else {{ $sujetoRating }} @endif
                                            </flux:label>
                                        </td>

                                        {{-- 3. CALIFICACIÓN COMPARABLE --}}
                                        <td class="py-1.5 px-2 text-left align-middle">
                                            @if($isEditable)
                                            {{-- AQUÍ ESTÁ EL CAMBIO IMPORTANTE: .blur y wire:key ÚNICO --}}
                                            <flux:input type="number" step="0.0001"
                                                wire:model.blur="comparableFactors.{{ $selectedComparableId }}.{{ $sigla }}.calificacion"
                                                wire:key="input-cal-{{ $selectedComparableId }}-{{ $sigla }}" placeholder="1.0000"
                                                class="text-left h-9 text-sm w-full" />
                                            @elseif($sigla === 'FNEG')
                                            <flux:label class="text-gray-700 h-9 flex items-center px-1">-</flux:label>
                                            @else
                                            <flux:label class="text-gray-700 h-9 flex items-center px-1">
                                                {{ $compCalificacion }}
                                            </flux:label>
                                            @endif
                                        </td>

                                        {{-- 4. DIFERENCIA --}}
                                        <td class="py-1.5 px-3 text-left align-middle">
                                            <flux:label class="text-gray-900">
                                                @if($sigla === 'FNEG') - @else {{ $diferencia }} @endif
                                            </flux:label>
                                        </td>

                                        {{-- 5. APLICABLE --}}
                                        <td class="py-1.5 px-3 text-left align-middle">
                                            @if($sigla === 'FNEG')
                                            {{-- AQUÍ TAMBIÉN: .blur y wire:key ÚNICO --}}
                                            <flux:input type="number" step="0.0001"
                                                wire:model.blur="comparableFactors.{{ $selectedComparableId }}.{{ $sigla }}.aplicable"
                                                wire:key="input-app-{{ $selectedComparableId }}-{{ $sigla }}" placeholder="0.9000"
                                                class="text-left h-9 text-sm w-full" />
                                            @else
                                            <flux:label class="text-gray-900 font-bold">
                                                {{ $aplicableCalc }}
                                            </flux:label>
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot class="bg-gray-100 border-t-2 border-gray-300">
                                    <tr class="font-extrabold text-md">
                                        <td colspan="4" class="py-2 px-3 text-right">FACTOR RESULTANTE (FRE):</td>
                                        <td class="py-2 px-3 text-left text-gray-900">
                                            {{ $comparableFactors[$selectedComparableId]['FRE']['factor_ajuste'] ?? '1.0000' }}
                                        </td>
                                    </tr>
                                    <tr class="font-extrabold text-md">
                                        <td colspan="4" class="py-2 px-3 text-right">Valor Unitario Homologado:</td>
                                        <td class="py-2 px-3 text-left text-gray-900">
                                            ${{ number_format($comparableFactors[$selectedComparableId]['FRE']['valor_homologado'] ?? 0, 2)
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

    {{-- ======================================================================== --}}
    {{-- SECCIÓN 3: CONCLUSIONES (TABLAS Y GRÁFICAS) --}}
    {{-- ======================================================================== --}}
    <div class="form-container">
        <div class="form-container__header">
            Conclusiones
        </div>
        <div class="form-container__content">

            {{-- FILA 1: TABLA PRINCIPAL + GRÁFICA 1 (MIXTA) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Columna Izquierda: Tabla --}}
                <div>
                    <div class="overflow-x-auto border border-gray-300 rounded-md shadow-sm">
                        <table class="w-full text-md">
                            <thead>
                                <tr class="bg-gray-100 text-md font-semibold text-gray-500 border-b border-gray-300">
                                    <th class="py-2 px-3 text-left min-w-[150px]" rowspan="2">N. Comparable</th>
                                    <th class="py-2 px-3 text-center min-w-[120px]" rowspan="2">Valor Unitario</th>
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
                                $factor2 = '0.00';
                                $ajustePct = '0.00%';
                                $valorFinal = '0.00';
                                @endphp
                                <tr class="hover:bg-gray-50 ">
                                    <td class="py-1.5 px-3 align-middle text-sm">
                                        <input type="checkbox" wire:model.blur='selectedForStats'
                                            value="{{ $comparable->id }}"
                                            class="rounded text-blue-600 focus:ring-blue-500 mr-2">
                                        {{ $comparable->id }}
                                    </td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">${{
                                        number_format($comparable->comparable_unit_value, 2) }}</td>
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

                {{-- Gráfica 1 (MIXTA): Comportamiento Oferta vs Homologado --}}
                <div class="relative flex flex-col h-full">
                    {{-- <h4 class="text-sm font-semibold text-gray-500 mb-2 text-center">Comportamiento Oferta vs
                        Homologado
                    </h4> --}}
                   <div x-data="chartHomologationLands()" wire:ignore
                    class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm w-full relative h-[300px]">
                    <canvas x-ref="chart1"></canvas>
                </div>
                </div>
            </div>

            {{-- FILA 2: TABLA ESTADÍSTICAS + GRÁFICA 2 (BARRAS) --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                {{-- Columna Izquierda: Tabla Estadísticas --}}
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

                {{-- Gráfica 2 (BARRAS ROJAS): Dispersión --}}
                <div class="relative flex flex-col h-full">
                    {{-- <h4 class="text-sm font-semibold text-gray-500 mb-2 text-center">Dispersión de Valores
                        Homologados
                    </h4> --}}
                    <div x-data="chartHomologationStats()" wire:ignore
                        class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm w-full relative h-[300px] mt-4">
                        <canvas x-ref="chart2"></canvas>
                    </div>
                </div>
            </div>

            {{-- RESULTADOS FINALES --}}
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
                        <flux:select wire:model.blur="conclusion_tipo_redondeo" id="tipo_redondeo"
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
            Necesitas tener al menos 4 comparables asignados en el apartado terrenos para ver esta sección
        </h2>
    </div>
    @endif

    {{-- MODAL RESUMEN --}}
    <livewire:forms.comparables.comparable-summary />


    {{-- ======================================================================== --}}
    {{-- SCRIPT: LÓGICA DE GRÁFICAS - VERSIÓN "EVENTO NATIVO" --}}
<script>
    if (typeof window.createChartManager === 'undefined') {
        window.createChartManager = function(chartType, eventName, refName) {
            return {
                init() {
                    this.destroyChart();

                    this.$nextTick(() => {
                        this.drawChart({ labels: [], datasets: [] });
                    });

                    window.addEventListener(eventName, (event) => {
                        const payload = event.detail;
                        const dataToUse = (payload && payload.data) ? payload.data : payload;

                        if (dataToUse) {
                            this.$nextTick(() => {
                                this.drawChart(dataToUse);
                            });
                        }
                    });
                },

                destroyChart() {
                    if (this.$el._chartInstance) {
                        this.$el._chartInstance.destroy();
                        this.$el._chartInstance = null;
                    }
                },

                drawChart(data) {
                    try {
                        const canvas = this.$refs[refName];
                        if (!canvas) return;

                        const ctx = canvas.getContext('2d');
                        if (!ctx) return;

                        this.destroyChart();

                        this.$el._chartInstance = new Chart(ctx, {
                            type: chartType,
                            data: data,
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                animation: {
                                    duration: 500, // Regresamos a tus 500ms originales
                                    onComplete: () => {
                                        const instance = this.$el._chartInstance;
                                        if (instance && instance.canvas) {
                                            const base64 = instance.canvas.toDataURL('image/jpeg', 0.8);
                                            this.$wire.saveChartImage(base64, refName);
                                        }
                                    }
                                },
                                plugins: {
                                    legend: { display: false },
                                    tooltip: { mode: 'index', intersect: false } // Regresamos tus tooltips originales
                                },
                                scales: {
                                    y: {
                                        display: false,
                                        beginAtZero: true,
                                        grid: { display: false } // Regresamos configuración original
                                    },
                                    x: {
                                        grid: { display: false },
                                        ticks: { display: true, font: { size: 10 } } // Regresamos tus ticks originales
                                    }
                                }
                            }
                        });
                    } catch (error) {
                        console.error("Error chart:", error);
                    }
                }
            };
        }
    }

    function chartHomologationLands() {
        return window.createChartManager('bar', 'updateLandChart1', 'chart1');
    }

    function chartHomologationStats() {
        return window.createChartManager('bar', 'updateLandChart2', 'chart2');
    }
</script>

</div>
