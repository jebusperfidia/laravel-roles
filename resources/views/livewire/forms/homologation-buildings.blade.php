<div>
    {{-- Mínimo 2 para pruebas, mensaje de 6 para producción --}}
    @if($comparablesCount >= 2)

    <!-- 1. SECCIÓN SUJETO -->
    <div class="form-container">
        <div class="form-container__header">
            Sujeto
        </div>

        <div class="form-container__content">
            <!-- Header Limpio (Info de Propiedad) -->
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
                    Colonia: @if($valuation->property_colony === 'no-listada')
                    {{ $valuation->property_other_colony ?? 'N/A (No listada)' }}
                    @else
                    {{ $valuation->property_colony ?? 'N/A' }}
                    @endif
                    (CP {{ $valuation->property_cp ?? 'N/A' }}, {{ $valuation->property_locality_name ?? 'N/A' }})
                </p>
            </div>

            <!-- Nuevo encabezado de Características -->
            <div class="text-lg font-bold text-gray-800 mb-4 text-center">
                Características: <span class="font-normal">{{ $valuation->building_description_placeholder ?? 'Prueba'
                    }}</span>
            </div>

            <!-- Grid de 2 Columnas (Campos Sujeto + Factores Sujeto) -->
            <div class="flex flex-col md:flex-row gap-x-8 gap-y-8">

                <!-- Columna 1: Valores Base (Mismos campos, sin inputs manuales) -->
                <div class="space-y-4 md:w-1/3 w-full p-2">

                    <dl class="grid grid-cols-2 gap-x-6 gap-y-4 text-base">
                        <dt class="text-gray-500 font-semibold">Superficie:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ $valuation->building_surface_placeholder ??
                            '0.00' }}</dd>

                        <dt class="text-gray-500 font-semibold">Construcción:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ $valuation->building_construction_placeholder
                            ?? '23212' }}</dd>

                        <dt class="text-gray-500 font-semibold">Rel. Ter/Const:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ $valuation->building_rel_tc_placeholder ?? '0'
                            }}</dd>

                        <dt class="text-gray-500 font-semibold">Avance de obra:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ $valuation->building_avance_placeholder ??
                            '97.00 %' }}</dd>

                        <dt class="text-gray-500 font-semibold">Edad:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ $valuation->building_age_placeholder ?? '9.00'
                            }}</dd>

                        <dt class="text-gray-500 font-semibold">V.U.R.:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ $valuation->building_vur_placeholder ?? '63' }}
                        </dd>

                        <dt class="text-gray-500 font-semibold">V.U.T.:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ $valuation->building_vut_placeholder ?? '54' }}
                        </dd>
                    </dl>

                    {{-- **NOTA:** Se eliminaron los inputs manuales (Área de Avalúo, Valor M² Avalúo, M² Rentable y el
                    botón Guardar) --}}

                </div>

                <!-- Columna 2: Factores Base Sujeto -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:w-2/3 w-full">

                    <div class="overflow-x-auto border border-gray-300 rounded-md">
                        <table class="w-full text-md table-fixed">
                            <thead>
                                <tr class="bg-gray-100 text-md font-semibold text-gray-500 border-b border-gray-300">
                                    <th class="text-left py-2 px-3 w-1/2">Descripción</th>
                                    <th class="text-left py-2 px-2 w-20">Siglas</th>
                                    <th class="text-left py-2 px-3 w-32">Calificación</th>
                                    <th class="text-left py-2 px-3 w-16">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach (['FSU' => 'SUP. VENDIBLE', 'FIC' => 'F. INTENSIDAD DE CONST.', 'FEQ' =>
                                'EQUIPAMIENTO', 'FEDAC' => 'EDAD Y
                                CONSERVACIÓN', 'FLOC' => 'F. LOCALIZACIÓN', 'AVANC' => 'AVANCE OBRA'] as $code =>
                                $label)
                                @php $modelName = "subject_factor_".strtolower($code); @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:label class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">{{ $label
                                            }}</flux:label>
                                    </td>
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        <flux:label class="font-mono text-md text-gray-700">{{ $code }}</flux:label>
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        {{-- CORRECCIÓN APLICADA AQUÍ para usar $modelName correctamente --}}
                                        <flux:input type="text" wire:model.live="{{ $modelName }}"
                                            class="text-right h-9 text-sm w-full transition-colors font-semibold"
                                            readonly="{{ $editing_factor_sujeto !== $code }}" placeholder="1.0000"
                                            x-bind:class="{ 'bg-white border-blue-500 shadow-inner': '{{ $editing_factor_sujeto }}' === '{{ $code }}' }" />
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        {{-- Botón de edición solo para FEQ y FLOC --}}
                                        @if($code === 'FEQ' || $code === 'FLOC')
                                        @php $isEditing = $editing_factor_sujeto === $code; @endphp
                                        <flux:button type="button" icon-leading="{{ $isEditing ? 'check' : 'pencil' }}"
                                            class="{{ $isEditing ? 'btn-primary' : 'btn-intermediary' }} btn-table cursor-pointer"
                                            wire:click="toggleEditFactor('{{ $code }}')" />
                                        @endif
                                    </td>
                                </tr>
                                @endforeach

                                {{-- Fila para añadir factores --}}
                                <tr class="bg-gray-100 border-t border-gray-300">
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:input type="text" wire:model.live="new_factor_name"
                                            placeholder="Nueva Descripción" class="h-9 text-sm w-full" />
                                    </td>
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        <flux:input type="text" wire:model.live="new_factor_siglas" placeholder="SIGLA"
                                            class="h-9 text-sm w-full" />
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:input type="number" wire:model.live="new_factor_value"
                                            placeholder="1.0000" class="h-9 text-sm w-full text-right" />
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:button type="button" icon-leading="plus"
                                            class="btn-primary btn-table cursor-pointer" wire:click="saveNewFactor" />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>





































<!-- 2. SECCIÓN COMPARABLES -->
<div class="form-container">
    <div class="form-container__header">
        Comparables
    </div>
    <div class="form-container__content">

        <!-- Paginación y Botones -->
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

                <flux:modal.trigger name="equipment-modal">
               <flux:button class="btn-intermediary cursor-pointer mr-3" type="button" size="sm">
                Equipamiento
                </flux:button>
                </flux:modal.trigger>
                {{-- <flux:button class="btn-secondary cursor-pointer" type="button" wire:click="openEquipmentModal"
                    size="sm">
                    Equipamiento (FEQ)
                </flux:button> --}}
                <flux:button class="btn-primary cursor-pointer" type="button"
                    wire:click="$dispatch('openSummary', { id: {{ $selectedComparableId }}, comparableType: 'building' })"
                    size="sm">
                    Resumen
                </flux:button>


                <flux:button class="btn-primary cursor-pointer" type="button" wire:click='openComparablesBuilding'
                    size="sm">
                    Cambiar Comparables
                </flux:button>
            </div>
        </div>

        {{-- Contenedor principal de la ficha y la tabla de ajuste --}}
        <div class="relative" wire:key="comparable-view-{{ $selectedComparableId }}">

            <!-- Loader -->
            <div wire:loading.flex wire:target="gotoPage"
                class="transition-all duration-200 ease-in-out absolute inset-0 bg-white bg-opacity-75 z-20 flex items-center justify-center rounded-lg">
                <svg class="animate-spin h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

            <!-- Grid de 2 Columnas (Ficha/Inputs vs. Factores) -->
            <div class="flex flex-col md:flex-row gap-x-6 gap-y-8" wire:loading.class="opacity-50">

                <!-- COLUMNA 1: Ficha Limpia (Datos Estáticos) + Inputs Adicionales (1/3) -->
                <div class="md:w-1/3 w-full space-y-4">
                    @if($selectedComparable)

                    <!-- BLOQUE A: Ficha Limpia (Datos Estáticos) - Estilo 'lands' con datos 'buildings' y ORDEN CORRECTO -->
                    <div class="p-4 bg-white border border-gray-300 rounded-lg shadow-sm">
                        <!-- Aplicando el estilo de grid y fuentes de 'lands' -->
                        <div class="grid grid-cols-2 gap-x-4 gap-y-2">

                            <!-- Columna 1 (Orden solicitado) -->
                            <div>
                                <dt class="font-semibold text-gray-800">Dirección:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_street ?? 'N/A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Colonia:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_colony ?? 'N/A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Características:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_features ?? 'N/A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Oferta:</dt>
                                <dd class="text-gray-600">${{ number_format($selectedComparable->comparable_offers ??
                                    250000.00, 2) }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Sup. Construida:</dt>
                                <dd class="text-gray-600">{{ number_format($selectedComparable->comparable_built_area ??
                                    1.00, 2) }} m²</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Sup. Terreno:</dt>
                                <dd class="text-gray-600">{{ number_format($selectedComparable->comparable_land_area ??
                                    100.00, 2) }} m²</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Valor Unitario:</dt>
                                <dd class="text-gray-600">${{ number_format($selectedComparable->comparable_unit_value
                                    ?? 2500.00, 2) }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Relación T/C:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->comparable_tc_ratio_placeholder ??
                                    '1.2500' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Fecha:</dt>
                                <dd class="text-gray-600">
                                    {{ $selectedComparable->comparable_date ?
                                    \Carbon\Carbon::parse($selectedComparable->comparable_date)->format('d/m/Y') :
                                    '23/10/2025' }}
                                </dd>
                            </div>

                            <!-- Columna 2 (Orden solicitado) -->
                            <div>
                                <dt class="font-semibold text-gray-800">Niveles:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->niveles ?? '1' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Edad:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->edad ?? '10' }} años</dd>

                                <dt class="font-semibold text-gray-800 mt-2">VUT:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->vut ?? '0.0000' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">VUR:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->vur ?? '0.0000' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Clasificación:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->clasificacion ?? 'A' }}</dd>

                                <dt class="font-semibold text-gray-800 mt-2">Vigencia:</dt>
                                <dd class="text-gray-600">{{ $selectedComparable->vigencia ?? '164' }} Días</dd>
                            </div>
                        </div>
                    </div>

                    <!-- BLOQUE B: Inputs Adicionales (Clase, Conservación, Localización, URL) - SEPARADO -->
                    <div class="p-3 bg-white rounded-lg shadow-sm space-y-2 border border-gray-300">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="text-gray-500 font-medium">
                                    <th class="text-left w-1/4 pb-1">Variables</th>
                                    <th class="text-left w-2/5 pb-1">Valor</th>
                                    <th class="text-left w-auto  pl-3 pb-1">Fact</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                {{-- Clase --}}
                                <tr>
                                    <td class="py-1.5 align-middle text-gray-800 font-medium">Clase:</td>
                                    <td class="py-1.5 align-middle">
                                        <flux:select
                                            wire:model.live="comparableFactors.{{ $selectedComparableId }}.clase"
                                            placeholder="Precario" class="!text-sm !py-1">
                                            <flux:select.option value="Precario">Precario</flux:select.option>
                                            <flux:select.option value="Clase B">Clase B</flux:select.option>
                                            <flux:select.option value="Clase C">Clase C</flux:select.option>
                                        </flux:select>
                                    </td>
                                    <!-- CAMBIO AQUÍ: Añadido pl-3 -->
                                    <td class="py-1.5 pl-3 align-middle text-gray-700 font-semibold">
                                        {{
                                        $comparableFactors[$selectedComparableId]['clase_factor']
                                        ??
                                        '1.7500' }}
                                    </td>
                                </tr>
                                {{-- Conservación --}}
                                <tr>
                                    <td class="py-1.5 align-middle text-gray-800 font-medium">Conserv.:</td>
                                    <td class="py-1.5 align-middle">
                                        <flux:select
                                            wire:model.live="comparableFactors.{{ $selectedComparableId }}.conservacion"
                                            placeholder="[Seleccione]" class="!text-sm !py-1">
                                            <flux:select.option value="Buena">Buena</flux:select.option>
                                            <flux:select.option value="Regular">Regular</flux:select.option>
                                            <flux:select.option value="Mala">Mala</flux:select.option>
                                        </flux:select>
                                    </td>
                                    <!-- CAMBIO AQUÍ: Añadido pl-3 -->
                                    <td class="py-1.5 pl-3 align-middle text-gray-700 font-semibold">
                                        {{
                                        $comparableFactors[$selectedComparableId]['conservacion_factor']
                                        ??
                                        '0.0000' }}
                                    </td>
                                </tr>
                                {{-- Localización --}}
                                <tr>
                                    <td class="py-1.5 align-middle text-gray-800 font-medium">Localización:</td>
                                    <td class="py-1.5 align-middle">
                                        <flux:select
                                            wire:model.live="comparableFactors.{{ $selectedComparableId }}.localizacion"
                                            placeholder="Lote intermedio" class="!text-sm !py-1">
                                            <flux:select.option value="Lote intermedio">Lote intermedio
                                                </flux:select.select>
                                                <flux:select.option value="Esquina">Esquina</flux:select.option>
                                        </flux:select>
                                    </td>
                                    <!-- CAMBIO AQUÍ: Añadido pl-3 -->
                                    <td class="py-1.5 pl-3 align-middle text-gray-700 font-semibold">
                                        {{
                                        $comparableFactors[$selectedComparableId]['localizacion_factor']
                                        ??
                                        '1.0000' }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <!-- URL (Fuente) - Fila separada para ancho completo -->
                        <div class="flex items-center pt-2 border-t border-gray-100">
                            <flux:label class="text-sm font-medium pr-2 whitespace-nowrap text-gray-800">URL :
                            </flux:label>
                            <a href="{{ $comparableFactors[$selectedComparableId]['url'] ?? 'http://valua.me/5ASd' }}"
                                target="_blank" class="text-blue-600 hover:underline text-sm truncate"
                                title="{{ $comparableFactors[$selectedComparableId]['url'] ?? 'http://valua.me/5ASd' }}">
                                {{ $comparableFactors[$selectedComparableId]['url'] ?? 'http://valua.me/5ASd' }}
                            </a>
                        </div>
                    </div>
                    @endif
                </div>

                <!-- COLUMNA 2: Factores de Ajuste (2/3) - Estilo 'lands' -->
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:w-2/3 w-full h-fit">
                    <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-300 pb-2">Factores de Ajuste
                        Aplicados</h4>
                    @if (session()->has('info_comparable'))
                    <div class="mb-2 text-sm text-blue-600 font-medium">
                        {{ session('info_comparable') }}
                    </div>
                    @endif
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
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach ($masterFactors as $factor)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:label class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">
                                            {{ $factor['label'] }}
                                        </flux:label>
                                    </td>
                                    {{-- Cal. Sujeto (READONLY) --}}
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        <flux:label class="font-mono text-md text-gray-700">
                                            <!-- Mono aquí está bien para números -->
                                            {{ $this->{$factor['subject_model']} ?? '1.0000' }}
                                        </flux:label>
                                    </td>
                                    {{-- Cal. Comp. (Editable: FLOC y AVANC) --}}
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        @if($factor['code'] === 'FLOC' || $factor['code'] === 'AVANC')
                                        <flux:input type="number" step="0.0001" placeholder="1.0000"
                                            wire:model.live="comparableFactors.{{ $selectedComparableId }}.{{ $factor['code'] }}.calificacion"
                                            class="text-left h-9 text-sm w-full font-semibold" />
                                        @else
                                        <flux:label
                                            class="text-left h-9 text-sm w-full flex items-center px-1 font-semibold font-mono text-gray-700">
                                            {{
                                            $comparableFactors[$selectedComparableId][$factor['code']]['calificacion']
                                            ?? '1.0000' }}
                                        </flux:label>
                                        @endif
                                    </td>
                                    {{-- Dif. (READONLY) --}}
                                    <td class="py-1.5 px-3 text-left align-middle">
                                        <flux:label
                                            class="text-left h-9 text-sm w-full flex items-center px-1 font-mono text-gray-700">
                                            0.0000
                                        </flux:label>
                                    </td>
                                    {{-- Aplicable (Editable: FNEG) --}}
                                    <td class="py-1.5 px-3 text-left align-middle">
                                        @if($factor['code'] === 'FNEG')
                                        <flux:input type="number" step="0.0001" placeholder="0.9000"
                                            wire:model.live="comparableFactors.{{ $selectedComparableId }}.{{ $factor['code'] }}.aplicable"
                                            class="text-left h-9 text-sm w-full font-semibold" />
                                        @else
                                        <flux:label
                                            class="text-left h-9 text-sm w-full flex items-center px-1 font-semibold font-mono text-gray-700">
                                            {{ $comparableFactors[$selectedComparableId][$factor['code']]['aplicable']
                                            ?? '1.0000' }}
                                        </flux:label>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            {{-- tfoot completo --}}
                            <tfoot class="bg-gray-100 border-t-2 border-gray-300">
                                <tr class="font-extrabold text-md">
                                    <td colspan="4" class="py-2 px-3 text-right">FACTOR RESULTANTE (FRE):</td>
                                    <td class="py-2 px-3 text-left text-gray-900">
                                        {{ $comparableFactors[$selectedComparableId]['FRE']['factor_ajuste'] ?? '1.6200'
                                        }}
                                    </td>
                                </tr>
                                <tr class="font-extrabold text-md">
                                    <td colspan="4" class="py-2 px-3 text-right">Valor Unitario Resultante Vendible:
                                    </td>
                                    <td class="py-2 px-3 text-left text-gray-900">
                                        ${{
                                        number_format($comparableFactors[$selectedComparableId]['FRE']['valor_unitario_vendible']
                                        ?? 2120.60, 2) }}
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
























    <!-- 3. SECCIÓN JUSTIFICACIONES (Simplificada) -->
    <div class="form-container">
        <div class="form-container__header">
            Justificaciones
        </div>
        <div class="form-container__content">
            <div class="form-grid form-grid--3 form-grid-3-variation">
                <div class="label-variation">
                    <flux:label>SUP. VENDIBLE<span class="sup-required">*</span></flux:label>
                </div>
                <div class="radio-input">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <flux:input type='text' wire:model="justificationSupVendible" />
                        </div>
                        <div>
                            <flux:error name="justificationSupVendible" />
                        </div>
                    </flux:field>
                </div>
            </div>
        </div>
    </div>


    <!-- 4. SECCIÓN CONCLUSIONES (Punto 7 y 8) -->
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
                                $factorFRE = $comparableFactors[$comparable->id]['FRE']['factor_ajuste'] ?? 0.0;
                                $valorHomologado = $comparableFactors[$comparable->id]['FRE']['valor_homologado'] ??
                                0.0;
                                $factor2 = $comparableFactors[$comparable->id]['COL_FACTOR_2_PLACEHOLDER'] ?? '0.00';
                                $ajustePct = $comparableFactors[$comparable->id]['COL_AJUSTE_PCT_PLACEHOLDER'] ??
                                '0.00%';
                                $valorFinal = $comparableFactors[$comparable->id]['COL_VALOR_FINAL_PLACEHOLDER'] ??
                                '0.00';
                                $isOutOfRange = ((float)$factorFRE < 0.8 || (float)$factorFRE> 1.2);
                                    @endphp
                                    <tr class="hover:bg-gray-50 {{ $isOutOfRange ? 'bg-red-50' : '' }}">
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
                                            number_format($factorFRE, 4) }}</td>
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

                <!-- Gráfico Superior -->
                <div
                    class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm flex items-center justify-center min-h-[300px]">
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
                          {{--       <tr>
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Media aritmética</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">${{
                                        $conclusion_media_aritmetica_oferta }}</td>
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
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Coeficiente de Variación
                                    </td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_coeficiente_variacion_oferta }} %</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_coeficiente_variacion_homologado }} %</td>
                                </tr>
                                <tr>
                                    <td class="py-1.5 px-3 align-middle text-sm font-semibold">Dispersión</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_dispersion_oferta }} %</td>
                                    <td class="py-1.5 px-3 align-middle text-sm text-center">{{
                                        $conclusion_dispersion_homologado }} %</td>
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

                <!-- Gráfico Inferior -->
                <div
                    class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm flex items-center justify-center min-h-[300px]">
                    <div x-data="chartHomologationStats()" wire:ignore class="w-full h-full">
                        <canvas x-ref="chartStatsCanvas"></canvas>
                    </div>
                </div>
            </div>

         <!-- VALOR UNITARIO DE VENTA Y REDONDEO (Punto 8) -->
        <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
            <!-- Contenedor principal que apila las dos filas verticalmente con un espacio -->
            <div class="flex flex-col space-y-4">

                <!--
                  FILA 1: VALOR UNITARIO DE VENTA
                  - Móvil (default): flex-col (label arriba, valor abajo)
                  - Desktop (md:): flex-row (label izquierda, valor derecha), alineados y justificados.
                -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <!-- Izquierda: Label -->
                    <span class="text-xl font-bold text-gray-800">VALOR UNITARIO DE VENTA:</span>

                    <!-- Derecha: Valor -->
                    <!-- 'mt-1' para dar espacio en móvil, 'md:mt-0' lo resetea en desktop -->
                    <span class="text-3xl font-extrabold text-gray-900 mt-1 md:mt-0">
                        {{ $conclusion_valor_unitario_de_venta }}
                    </span>
                </div>

                <!--
                  FILA 2: TIPO DE REDONDEO
                  - Misma lógica: flex-col en móvil, flex-row en desktop.
                -->
                <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                    <!-- Izquierda: Label -->
                    <label for="tipo_redondeo_venta"
                        class="block text-sm font-medium text-gray-700 whitespace-nowrap mb-1 md:mb-0">
                        TIPO DE REDONDEO SOBRE EL VALOR UNITARIO:
                    </label>

                    <!-- Derecha: Select -->
                    <!-- 'w-full' para móvil, 'md:w-40' para desktop. 'mt-1' para espacio en móvil -->
                    <!-- NOTA: Cambié el ID a 'tipo_redondeo_venta' para evitar duplicados si ambos están en la misma página -->
                    <flux:select wire:model.live="conclusion_tipo_redondeo" id="tipo_redondeo_venta"
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
            Necesitas tener al menos 6 comparables asignados en el apartado edificios para ver esta sección
        </h2>
    </div>
    @endif


















<!--
  MODAL DE EQUIPAMIENTO (FEQ)
  Ajuste: Se agrega padding vertical (py-3) a la fila <tfoot>
  y padding horizontal (px-2) a la celda del select para que no se vean "apretados".
  Se re-insertan los inputs en la tabla del comparable.
-->
<flux:modal name="equipment-modal" variant="flyout" max-width="max-w-lg">
    <!--
      Usamos un 'flex flex-col h-full' para que el flyout ocupe toda la altura
      y podamos poner el footer fijo abajo.
    -->
    <div class="flex flex-col h-full">

        <!-- 1. CABECERA DEL MODAL (Header Fijo) -->
        <div class="p-6 border-b border-gray-200">
            <flux:heading size="lg" class="text-gray-900">Equipamiento</flux:heading>
            <flux:text class="mt-2">Añade o edita el equipamiento del objeto y comparable.</flux:text>
        </div>

        <!-- 2. CUERPO DEL MODAL (Contenido con Scroll) -->
        <div class="p-6 space-y-6 flex-1 overflow-y-auto">

            <!-- SECCIÓN: DEL OBJETO -->
            <div class="space-y-3">
                <flux:heading size="md" class="text-gray-800 border-b pb-2">
                    Del Objeto
                </flux:heading>

                <!-- Tabla de Equipamiento del Objeto -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-2 font-medium w-3/6">Descripción</th>
                                <th class="py-2 px-2 font-medium w-1/6">Cantidad</th>
                                <th class="py-2 px-2 font-medium w-1/6">Total</th>
                                <th class="py-2 pl-2 font-medium w-1/6 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Fila 1: Medio Baño -->
                            <tr class="align-middle">
                                <td class="py-2 pr-2">Medio baño</td>
                                <td class="py-2 px-2">1.0000</td>
                                <td class="py-2 px-2">9,396.00</td>
                                <td class="py-2 pl-2">
                                    <div class="flex justify-center space-x-2">
                                        <flux:button type="button" icon-leading="pencil"
                                            class="btn-intermediary btn-table" />
                                        <flux:button type="button" icon-leading="trash"
                                            class="btn-deleted btn-table cursor-pointer" />
                                    </div>
                                </td>
                            </tr>
                            <!-- Fila 2: Terraza -->
                            <tr class="align-middle">
                                <td class="py-2 pr-2">Terraza</td>
                                <td class="py-2 px-2">1.0000</td>
                                <td class="py-2 px-2">3,375.00</td>
                                <td class="py-2 pl-2">
                                    <div class="flex justify-center space-x-2">
                                        <flux:button type="button" icon-leading="pencil"
                                            class="btn-intermediary btn-table cursor-pointer" />
                                        <flux:button type="button" icon-leading="trash"
                                            class="btn-deleted btn-table cursor-pointer" />
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                        <!-- Fila para Añadir Nuevo Equipamiento -->
                        <tfoot class="border-t-2">
                            <tr class="align-middle">
                                <!-- CAMBIO: Se usa 'py-3' (para padding vertical) y 'px-2' (para padding horizontal) -->
                                <td class="py-3 px-2">
                                    <flux:select>
                                 <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                        <flux:select.option value="Baño completo">Baño completo (M2)
                                        </flux:select.option>
                                        <flux:select.option value="Medio baño">Medio baño (PZA)</flux:select.option>
                                        <flux:select.option value="Estacionamiento cubierto para departamento">
                                            Estacionamiento cubierto para departamento (CAJON)</flux:select.option>
                                        <flux:select.option value="Estacionamiento descubierto para departamento">
                                            Estacionamiento cubierto para departamento (CAJON)</flux:select.option>
                                        <flux:select.option value="Terraza">Terraza (M2)</flux:select.option>
                                        <flux:select.option value="Balcon">Balcón (M2)</flux:select.option>
                                        <flux:select.option value="Acabados">Acabados (M2)</flux:select.option>
                                        <flux:select.option value="Elevador">Elevador (%)</flux:select.option>
                                        <flux:select.option value="Roof garden">Roof garden (M2)</flux:select.option>
                                        <flux:select.option value="Otro">Otro (M2)</flux:select.option>
                                    </flux:select>
                                </td>
                                <!-- CAMBIO: Se usa 'py-3' (en lugar de 'pt-3') para padding vertical -->
                                <td class="py-3 px-2">
                                    <flux:input type="number" placeholder="1.00" class="!text-sm" />
                                </td>
                                <!-- CAMBIO: Se usa 'py-3' (en lugar de 'pt-3') para padding vertical -->
                                <td class="py-3 px-2 text-gray-700 font-semibold">
                                    ---
                                </td>
                                <!-- CAMBIO: Se usa 'py-3' (en lugar de 'pt-3') para padding vertical -->
                                <td class="py-3 pl-2 text-center">
                                    <flux:button type="button" icon-leading="plus" class="btn-primary btn-table" />
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <!-- SECCIÓN: DEL COMPARABLE -->
            <div class="space-y-3">
                <flux:heading size="md" class="text-gray-800 border-b pb-2">
                    Del Comparable {{ $selectedComparableId ?? '30651' }}
                </flux:heading>

                <!-- Tabla de Equipamiento del Comparable -->
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead class="text-left text-gray-500">
                            <tr>
                                <th class="py-2 pr-2 font-medium w-2/6">Descripción</th>
                                <th class="py-2 px-2 font-medium w-1/6">Unidad</th>
                                <th class="py-2 px-2 font-medium w-1/6">Cantidad</th>
                                <th class="py-2 px-2 font-medium w-1/6">Dif.</th>
                                <th class="py-2 pl-2 font-medium w-1/6">%</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            <!-- Fila 1: Medio Baño -->
                            <tr class="align-middle">
                                <td class="py-2 pr-2">Medio baño</td>
                                <td class="py-2 px-2">PZA</td>
                                <!-- CAMBIO: Re-insertado el input para edición -->
                                <td class="py-2 px-2">
                                    <flux:input type="number" value="1.0000" class="!text-sm" />
                                </td>
                                <td class="py-2 px-2">9,396.00</td>
                                <td class="py-2 pl-2">10.44</td>
                            </tr>
                            <!-- Fila 2: Terraza -->
                            <tr class="align-middle">
                                <td class="py-2 pr-2">Terraza</td>
                                <td class="py-2 px-2">M2</td>
                                <!-- CAMBIO: Re-insertado el input para edición -->
                                <td class="py-2 px-2">
                                    <flux:input type="number" value="1.0000" class="!text-sm" />
                                </td>
                                <td class="py-2 px-2">3,375.00</td>
                                <td class="py-2 pl-2">3.75</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- 3. PIE DEL MODAL (Footer Fijo) -->
        <div class="p-4 bg-gray-100 border-t border-gray-200 sticky bottom-0 z-10">
            <div class="flex justify-between items-center">
                <span class="text-xl font-bold text-gray-800">FACTOR EQUIPAMIENTO:</span>
                <span class="text-3xl font-extrabold text-gray-900">
                    0.8581
                </span>
            </div>
        </div>

    </div>
</flux:modal>



















    <!-- RESUMEN DE COMPARABLES -->
    <livewire:forms.comparables.comparable-summary />

    <!-- CÓDIGO ALPINE.JS PARA GRÁFICAS -->
    <script>
        document.addEventListener('alpine:init', () => {

        // 📊 Gráfica de homologación
        Alpine.data('chartHomologationLands', () => ({
            chart: null,
            chartColors: { // Definición local de colores
                bar: 'rgba(20, 184, 166, 0.6)',
                barBorder: 'rgba(13, 148, 136, 1)',
                line: 'rgba(239, 68, 68, 0.6)',
                lineBorder: 'rgba(220, 38, 38, 1)',
            },
            initChart(data) {
                const ctx = this.$root.querySelector('canvas');
                if (!ctx) return;

                // Destruir gráfica anterior si existe
                if (this.chart) {
                    this.chart.destroy();
                }

                const chartData = this.formatChartData(data);

                if (typeof window.Chart === 'undefined') {
                    console.error('Chart.js no está cargado en window.Chart.');
                    return;
                }

                this.chart = new window.Chart(ctx, {
                    type: 'bar', data: chartData,
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        scales: {
                            y: { beginAtZero: true, type: 'linear', position: 'left', title: { display: true, text: 'Valor Homologado ($)' }},
                            y1: { beginAtZero: false, type: 'linear', position: 'right', title: { display: true, text: 'Factor (FRE)' }, grid: { drawOnChartArea: false }}
                        },
                        plugins: {
                            legend: { position: 'top' },
                            title: { display: true, text: 'Valor Homologado vs Factor Resultante (FRE)' },
                            tooltip: { mode: 'index', intersect: false }
                        }
                    }
                });
            },
            formatChartData(data) {
                return {
                    labels: data.labels,
                    datasets: [
                        { label: 'Valor Unit. Homologado ($)', data: data.homologated, backgroundColor: this.chartColors.bar, borderColor: this.chartColors.barBorder, borderWidth: 1, yAxisID: 'y' },
                        { label: 'Factor (FRE)', data: data.factors, backgroundColor: this.chartColors.line, borderColor: this.chartColors.lineBorder, borderWidth: 1, type: 'line', fill: false, tension: 0.1, yAxisID: 'y1' }
                    ]
                };
            },
            updateChart(newData) {
                if (this.chart) {
                    this.chart.data = this.formatChartData(newData);
                    this.chart.update();
                }
            },
            init() {
                this.$nextTick(() => {
                    const newData = @json($this->chartData);
                    this.initChart(newData);
                });

                // Escucha directa del evento Livewire para actualizar
                this.$wire.on('updateChart', (event) => {
                     this.updateChart(event.data);
                });
            }
        }));

        // 📈 Gráfica de estadísticas
        Alpine.data('chartHomologationStats', () => ({
            chart: null,
            chartColorsStats: { // Definición local de colores para estadísticas
                barStats1: 'rgba(59, 130, 246, 0.6)', // blue-500
                barStats1Border: 'rgba(37, 99, 235, 1)', // blue-600
                barStats2: 'rgba(16, 185, 129, 0.6)', // green-500
                barStats2Border: 'rgba(5, 150, 105, 1)', // green-600
            },
            initStatsChart(data) {
                const ctx = this.$root.querySelector('canvas');
                if (!ctx) return;

                // Destruir gráfica anterior si existe
                if (this.chart) {
                    this.chart.destroy();
                }

                const chartData = this.formatStatsData(data);

                if (typeof window.Chart === 'undefined') {
                    console.error('Chart.js no está cargado en window.Chart.');
                    return;
                }

                this.chart = new window.Chart(ctx, {
                    type: 'bar', data: chartData,
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        scales: { y: { beginAtZero: true, title: { display: true, text: 'Porcentaje (%)' }}},
                        plugins: { legend: { display: false }, title: { display: true, text: 'Coeficiente de Variación (Oferta vs Homologado)' }}
                    }
                });
            },
            formatStatsData(data) {
                return {
                    labels: ['Oferta', 'Homologado'],
                    datasets: [
                        {
                            label: 'Coeficiente de Variación (%)',
                            data: [ data.coeficiente_variacion_oferta, data.coeficiente_variacion_homologado ],
                            backgroundColor: [this.chartColorsStats.barStats1, this.chartColorsStats.barStats2],
                            borderColor: [this.chartColorsStats.barStats1Border, this.chartColorsStats.barStats2Border],
                            borderWidth: 1
                        }
                    ]
                };
            },
            updateStatsChart(newData) {
                if (this.chart) {
                    this.chart.data = this.formatStatsData(newData);
                    this.chart.update();
                }
            },
            init() {
                this.$nextTick(() => {
                    const newData = @json($this->chartData);
                    this.initStatsChart(newData);
                });

                // Escucha directa del evento Livewire para actualizar
                this.$wire.on('updateChart', (event) => {
                     this.updateStatsChart(event.data);
                });
            }
        }));
    });
    </script>
</div>
