<div>
    {{-- Mínimo 2 para pruebas, mensaje de 6 para producción --}}
    @if($comparablesCount >= 6)

    <div class="form-container" wire:init="recalculateConclusions">
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
                    Colonia: @if($valuation->property_colony === 'no-listada')
                    {{ $valuation->property_other_colony ?? 'N/A (No listada)' }}
                    @else
                    {{ $valuation->property_colony ?? 'N/A' }}
                    @endif
                    (CP {{ $valuation->property_cp ?? 'N/A' }}, {{ $valuation->property_locality_name ?? 'N/A' }})
                </p>
            </div>



            <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                <div @click="open = !open" class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                    <div class="flex items-center gap-2 flex-grow">
                        <span class="text-gray-800 font-medium">Características</span>
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
                         {{ $property_description ?? 'No disponible' }}
                        </div>
                    </div>
                </div>
            </div>



          {{--   <div class="flex flex-start text-lg font-bold text-gray-800 mb-4 text-center">
                Características:
            </div>
 --}}
            <div class="flex flex-col md:flex-row gap-x-8 gap-y-8">
                <div class="space-y-4 md:w-1/3 w-full p-2">
                    <dl class="grid grid-cols-2 gap-x-6 gap-y-4 text-base">
                        {{-- Superficie (Terreno) obtenida de ApplicableSurface->surface_area --}}
                        <dt class="text-gray-500 font-semibold">Superficie:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ number_format($subject_surface_land, 2) ??
                            '0.00'
                            }}</dd>

                        {{-- Construcción obtenida de ApplicableSurface->built_area --}}
                        <dt class="text-gray-500 font-semibold">Construcción:</dt>
                        <dd class="text-gray-900 font-medium text-lg"> {{ number_format($subject_surface_construction,
                            2) ??
                            '0.00' }} </dd>

                        <dt class="text-gray-500 font-semibold">Rel. Ter/Const:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ number_format($subject_rel_tc, 4) ?? '0'
                            }}</dd>

                        <dt class="text-gray-500 font-semibold">Avance de obra:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ number_format($subject_progress_work, 2) ??
                            '0' }} %</dd>

                        <dt class="text-gray-500 font-semibold">Edad:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ number_format($subject_age_weighted, 1) ?? '0'
                            }}</dd>

                        <dt class="text-gray-500 font-semibold">V.U.R.:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ number_format($subject_vur_weighted, 1) ?? '0'
                            }}
                        </dd>

                        <dt class="text-gray-500 font-semibold">V.U.T.:</dt>
                        <dd class="text-gray-900 font-medium text-lg">{{ number_format($subject_vut_weighted, 1) ?? '0'
                            }}
                        </dd>
                    </dl>
                </div>

                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:w-2/3 w-full">
                    <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-300 pb-2 flex justify-between items-center">
                        <span>Factores del sujeto</span>
                        {{-- <span class="text-xs font-normal text-gray-500 bg-gray-200 px-2 py-1 rounded">Building</span> --}}
                    </h4>
                    <div class="overflow-x-auto border border-gray-300 rounded-md">
                        <table class="w-full text-md table-fixed">
                            <thead>
                                <tr class="bg-gray-100 text-md font-semibold text-gray-500 border-b border-gray-300">
                                    <th class="text-left py-2 px-3 w-5/12">Descripción</th>
                                    <th class="text-left py-2 px-2 w-2/12">Siglas</th>
                                    <th class="text-left py-2 px-3 w-3/12">Calificación</th>
                                    <th class="text-left py-2 px-3 w-2/12">Acción</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @foreach($subject_factors_ordered as $index => $factor)
                                @php
                                $acronym = $factor['acronym'];
                                $canEdit = $factor['can_edit'];
                                $isEditing = ($editing_factor_index === $index);
                                $isCustom = $factor['is_custom'];
                                @endphp

                                <tr class="hover:bg-gray-50 transition-colors"
                                    wire:key="row-{{ $factor['id'] ?? $index }}">
                                    <td class="py-1.5 px-3 align-middle">
                                        @if($isEditing)
                                        <flux:input type="text" wire:model.defer="edit_factor_name"
                                            class="h-9 text-sm w-full bg-white font-semibold" />
                                        @else
                                        <flux:label class="!py-0 !px-0 !m-0 font-medium text-gray-700 block truncate">{{
                                            $factor['factor_name'] }}</flux:label>
                                        @endif
                                    </td>
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        @if($isEditing)
                                        <flux:input type="text" wire:model.defer="edit_factor_acronym"
                                            class="h-9 text-sm w-full font-mono uppercase bg-white" />
                                        @else
                                        <flux:label class="font-mono text-md text-gray-700">{{ $acronym }}</flux:label>
                                        @endif
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        @if($canEdit)
                                        @if($isEditing)
                                        <flux:input type="number" step="0.0001" min="0.8" max="1.2"
                                            wire:model.defer="edit_factor_rating" wire:key="edit-rating-{{ $factor['id'] ?? $index }}"
                                            class="text-right h-9 text-sm w-full bg-white border-blue-500 ring-1 ring-blue-200" />
                                        @else
                                        <flux:input type="text" value="{{ $factor['rating'] }}" readonly
                                            class="text-right h-9 text-sm w-full bg-gray-100 text-gray-600 border-gray-300 cursor-not-allowed" />
                                        @endif
                                        @else
                                        <flux:input type="text" value="{{ $factor['rating'] }}" readonly
                                            class="text-right h-9 text-sm w-full bg-transparent border-none shadow-none text-gray-500" />
                                        @endif
                                    </td>
                                    <td class="py-1.5 px-3 align-middle flex items-center gap-2">
                                        @if($canEdit)
                                        @if($isEditing)
                                        <flux:button icon="check" class="btn-primary cursor-pointer"
                                            wire:click="toggleEditFactor('{{ $acronym }}', {{ $index }})" />
                                        <flux:button icon="x-mark" class="btn-deleted cursor-pointer"
                                            wire:click="cancelEdit" />
                                        @else
                                        <flux:button icon="pencil" class="btn-intermediary cursor-pointer"
                                            wire:click="toggleEditFactor('{{ $acronym }}', {{ $index }})" />
                                        @if($isCustom)
                                        <flux:button icon="trash" class="btn-deleted cursor-pointer"
                                            wire:click="deleteCustomFactor({{ $factor['id'] }})"
                                            wire:confirm="¿Eliminar este factor?" />
                                        @endif
                                        @endif
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                                <tr class="bg-gray-50 border-t-2 border-gray-200">
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:input type="text" wire:model="new_factor_name"
                                            placeholder="Nueva Descripción" class="h-9 text-sm w-full bg-white" />
                                    </td>
                                    <td class="py-1.5 px-2 text-left align-middle">
                                        <flux:input type="text" wire:model="new_factor_acronym" placeholder="SIGLA"
                                            class="h-9 text-sm w-full uppercase bg-white" />
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:input type="number" step="0.0001" min="0.8" max="1.2"
                                            wire:model="new_factor_rating" placeholder="1.0000"
                                            class="h-9 text-sm w-full text-right bg-white" />
                                    </td>
                                    <td class="py-1.5 px-3 align-middle">
                                        <flux:button icon="plus" class="btn-primary justify-center cursor-pointer"
                                            wire:click="saveNewFactor" />
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

            {{-- Paginación y Botones --}}
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
                    <flux:modal.trigger name="equipment-modal">
                        <flux:button class="btn-intermediary cursor-pointer mr-3" type="button" size="sm">Equipamiento
                        </flux:button>
                    </flux:modal.trigger>
                    <flux:button class="btn-primary cursor-pointer" type="button"
                        wire:click="$dispatch('openSummary', { id: {{ $selectedComparableId }}, comparableType: 'building' })"
                        size="sm">Resumen</flux:button>
                    <flux:button class="btn-primary cursor-pointer" type="button" wire:click='openComparablesBuilding'
                        size="sm">Cambiar Comparables</flux:button>
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

                <div class="flex flex-col md:flex-row gap-x-6 gap-y-8 items-start">

                    {{-- COLUMNA 1: Ficha Limpia (Datos Estáticos) --}}
                    <div class="md:w-1/3 w-full space-y-4" wire:key="ficha-{{ $selectedComparableId }}">
                        @if($selectedComparable)
                        <div class="p-4 bg-white border border-gray-300 rounded-lg shadow-sm">
                            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                                <div>
                                    <dt class="font-semibold text-gray-800">Dirección:</dt>
                                    <dd class="text-gray-600 truncate"
                                        title="{{ $selectedComparable->comparable_street }}">{{
                                        $selectedComparable->comparable_street ?? 'N/A' }}</dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Colonia:</dt>
                                    <dd class="text-gray-600 truncate"
                                        title="{{ $selectedComparable->comparable_colony }}">{{
                                        $selectedComparable->comparable_colony ?? 'N/A' }}</dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Características:</dt>
                                    <dd class="text-gray-600">{{
                                        $selectedComparable->comparable_characteristics ?? 'N/A' }}</dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Oferta:</dt>
                                    <dd class="text-gray-600">${{ number_format($selectedComparable->comparable_offers,
                                        2) }}</dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Sup. Construida:</dt>
                                    <dd class="text-gray-600">{{
                                        number_format($selectedComparable->comparable_built_area ?? 1.00, 2) }} m²</dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Sup. Terreno:</dt>
                                    <dd class="text-gray-600">{{ number_format($selectedComparable->comparable_land_area
                                        ?? 100.00, 2) }} m²</dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Valor Unitario:</dt>
                                    <dd class="text-gray-600">${{
                                        number_format($selectedComparable->comparable_unit_value ?? 2500.00, 2) }}</dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Relación T/C:</dt>
                                    <dd class="text-gray-600">
                                        @php
                                        // Obtenemos los valores del modelo del comparable seleccionado
                                        $areaTerreno = (float)($selectedComparable->comparable_land_area ?? 0);
                                        $areaConstruccion = (float)($selectedComparable->comparable_built_area ?? 0);

                                        // Evitamos división por cero
                                        $relacionTC_Comp = ($areaConstruccion > 0)
                                        ? ($areaTerreno / $areaConstruccion)
                                        : 0;
                                        @endphp
                                        {{ number_format($relacionTC_Comp, 4) }}
                                    </dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Fecha:</dt>
                                    <dd class="text-gray-600">{{ $selectedComparable->created_at ?
                                        \Carbon\Carbon::parse($selectedComparable->created_at)->format('d/m/Y') :
                                        '23/10/2025' }}</dd>
                                </div>
                                <div>
                                    <dt class="font-semibold text-gray-800">Niveles:</dt>
                                    <dd class="text-gray-600">{{ $selectedComparable->comparable_levels ?? '1' }}</dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Edad:</dt>
                                    <dd class="text-gray-600">{{ $selectedComparable->comparable_age ?? '0' }} año(s)
                                    </dd>

                                    {{-- <dt class="font-semibold text-gray-800 mt-2">VUT:</dt>
                                    <dd class="text-gray-600">{{ $selectedComparable->comparable_vut ?? '0' }}</dd> --}}

                                    <dt class="font-semibold text-gray-800 mt-2">VUT:</dt>
                                    <dd class="text-gray-600">
                                        {{ $selectedComparable->comparable_vut ?? '0' }} años
                                    </dd>


                                    {{-- <dt class="font-semibold text-gray-800 mt-2">VUR:</dt>
                                    <dd class="text-gray-600">{{ ($selectedComparable->comparable_vut -
                                        $selectedComparable->comparable_age) ?? '0.0000' }}</dd> --}}

                                    {{-- VUR (Vida Útil Remanente) --}}
                                    <dt class="font-semibold text-gray-800 mt-2">VUR:</dt>
                                    <dd class="text-gray-600">
                                        @php
                                        $vut = (int)($selectedComparable->comparable_vut ?? 0);
                                        $age = (int)($selectedComparable->comparable_age ?? 0);
                                        $vur = max($vut - $age, 0);
                                        @endphp
                                        {{ $vur }} años
                                    </dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Clasificación:</dt>
                                    <dd class="text-gray-600">{{ $selectedComparable->comparable_clasification ?? '' }}
                                    </dd>

                                    <dt class="font-semibold text-gray-800 mt-2">Vigencia:</dt>
                                    <dd class="text-gray-600">
                                       @php
                                    $dias = $selectedComparable->dias_para_vencer;
                                    @endphp

                                    @if($dias > 0)
                                    <span class="text-teal-700 font-bold">Vigente (Quedan {{ $dias }} días)</span>
                                    @else
                                    <span class="text-red-600 font-bold">Vencido hace {{ abs($dias) }} días</span>
                                    @endif
                                    </dd>
                                </div>
                            </div>
                        </div>

                        <div class="p-3 bg-white rounded-lg shadow-sm space-y-2 border border-gray-300">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="text-gray-500 font-medium">
                                        <th class="text-left w-1/4 pb-1">Variables</th>
                                        <th class="text-left w-2/5 pb-1">Valor</th>
                                        <th class="text-left w-auto pl-3 pb-1">Fact</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    {{-- Clase --}}
                                    <tr>
                                        <td class="py-1.5 align-middle text-gray-800 font-medium">Clase:</td>
                                        <td class="py-1.5 align-middle">
                                            <flux:select wire:model.live="comparableFactors.{{ $selectedComparableId }}.clase" placeholder="-"
                                                class="!text-sm !py-1" disabled>
                                                <flux:select.option value="">-- Selecciona una opción --
                                                </flux:select.option>
                                                <flux:select.option value="Superior a moda">Mínima</flux:select.option>
                                                <flux:select.option value="Economica">Económica</flux:select.option>
                                                <flux:select.option value="Interes social">Interés social
                                                </flux:select.option>
                                                <flux:select.option value="Media">Media</flux:select.option>
                                                <flux:select.option value="Semilujo">Semilujo</flux:select.option>
                                                <flux:select.option value="Residencial">Residencial</flux:select.option>
                                                <flux:select.option value="Residencial plus">Residencial plus
                                                </flux:select.option>
                                                <flux:select.option value="Residencial plus +">Residencial plus +
                                                </flux:select.option>
                                                <flux:select.option value="Unica">Unica</flux:select.option>
                                            </flux:select>
                                        </td>
                                        <td class="py-1.5 pl-3 align-middle text-gray-700 font-semibold">
                                            {{-- {{$comparableFactors[$selectedComparableId]['clase_factor'] ?? '1.7500' }} --}}
                                            -
                                        </td>
                                    </tr>
                                    {{-- Conservación --}}
                                    <tr>
                                        <td class="py-1.5 align-middle text-gray-800 font-medium">Conserv.:</td>
                                        <td class="py-1.5 align-middle">
                                            <flux:select wire:model.live="comparableFactors.{{ $selectedComparableId }}.conservacion" placeholder="[Seleccione]"
                                                class="!text-sm !py-1">
                                                <flux:select.option value="">-- Selecciona una opción --
                                                </flux:select.option>
                                                <flux:select.option value="Bueno">Bueno</flux:select.option>
                                                <flux:select.option value="Malo">Malo</flux:select.option>
                                                <flux:select.option value="Muy bueno">Muy bueno</flux:select.option>
                                                <flux:select.option value="Normal">Normal</flux:select.option>
                                                <flux:select.option value="Nuevo">Nuevo</flux:select.option>
                                                <flux:select.option value="Recientemente remodelado">Recientemente
                                                    remodelado</flux:select.option>
                                                <flux:select.option value="Ruidoso">Ruidoso</flux:select.option>
                                            </flux:select>
                                        </td>
                                        <td class="py-1.5 pl-3 align-middle text-gray-700 font-semibold">{{
                                            $comparableFactors[$selectedComparableId]['conservacion_factor'] ?? '0.0000'
                                            }}</td>
                                    </tr>
                                    {{-- Localización --}}
                                    <tr>
                                        <td class="py-1.5 align-middle text-gray-800 font-medium">Localización:</td>
                                        <td class="py-1.5 align-middle">
                                            <flux:select wire:model.live="comparableFactors.{{ $selectedComparableId }}.localizacion" placeholder="[Seleccione]"
                                                class="!text-sm !py-1">
                                                <flux:select.option value="">-- Selecciona una opción --
                                                </flux:select.option>
                                                <flux:select.option value="Cabecera de manzana">Cabecera de manzana
                                                </flux:select.option>
                                                <flux:select.option value="Lote con dos frentes no continuos">Lote con
                                                    dos frentes no continuos</flux:select.option>
                                                <flux:select.option value="Lote en esquina">Lote en esquina
                                                </flux:select.option>
                                                <flux:select.option value="Lote interior">Lote interior
                                                </flux:select.option>
                                                <flux:select.option value="Manzana completa">Manzana completa
                                                </flux:select.option>
                                                <flux:select.option value="Recientemente remodelado">Recientemente
                                                    remodelado</flux:select.option>
                                            </flux:select>
                                        </td>
                                        <td class="py-1.5 pl-3 align-middle text-gray-700 font-semibold">
                                        {{--     {{$comparableFactors[$selectedComparableId]['localizacion_factor'] ?? '1.0000'}} --}}
                                        -
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="flex items-center pt-2 border-t border-gray-100">
                                <flux:label class="text-sm font-medium pr-2 whitespace-nowrap text-gray-800">URL :
                                </flux:label>
                                <a href="{{ $comparableFactors[$selectedComparableId]['url'] ?? 'http://valua.me/...' }}"
                                    target="_blank" class="text-blue-600 hover:underline text-sm truncate"
                                    title="{{ $comparableFactors[$selectedComparableId]['url'] ?? 'http://valua.me/...' }}">
                                    {{ $comparableFactors[$selectedComparableId]['url'] ?? 'http://valua.me/...' }}
                                </a>
                            </div>
                        </div>
                        @endif
                    </div>

                    {{-- TABLA FACTORES --}}
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-200 shadow-sm md:w-2/3 w-full"
                        wire:key="factores-{{ $selectedComparableId }}">
                        <h4 class="font-semibold text-gray-700 mb-3 border-b border-gray-300 pb-2">Factores de ajuste
                            aplicados</h4>
                        @if (session()->has('info_comparable'))
                        <div class="mb-2 text-sm text-blue-600 font-medium">{{ session('info_comparable') }}</div>
                        @endif
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
                            @foreach ($this->orderedComparableFactorsForView as $factor)
                 @php
                $sigla = $factor['acronym'];

                // BÚSQUEDA MAESTRA DE BANDERAS
                $masterFactor = collect($subject_factors_ordered)->firstWhere('acronym', $sigla);

                $isFNEG = ($sigla === 'FNEG');
                $isFEQ = $masterFactor['is_feq'] ?? false;

                // USAMOS EL FLAG PURO: Si FLOC tiene is_editable=1 en DB, esto es TRUE.
                $isEditableBase = $masterFactor['is_editable'] ?? false;

                $isCustom = $masterFactor['is_custom'] ?? false;

                // Forzar AVANC como editable en el comparable.
                $isAVANCEditable = ($sigla === 'AVANC');

               // El input se muestra si:
            // (Es Editable/Custom PURO) OR (Es AVANC forzado)
            $mustShowInput = ($isEditableBase || $isCustom || $isAVANCEditable);

            // DETERMINACIÓN FINAL: Si debe mostrar INPUT en la columna Calificación Comparable
            $showInputCalificacion = $mustShowInput && !$isFNEG && !$isFEQ;

                @endphp

                            {{-- wire:key robusto para evitar fantasmas --}}
                            <tr class="hover:bg-gray-50" wire:key="row-{{ $selectedComparableId }}-{{ $sigla }}">

                                {{-- 1. FACTOR --}}
                                <td class="py-1.5 px-3 align-middle">
                                    <flux:label class="!py-0 !px-0 !m-0 font-medium text-gray-700 block">
                                        {{ $sigla }}
                                    </flux:label>
                                </td>

                                {{-- 2. CALIFICACIÓN SUJETO --}}
                                <td class="py-1.5 px-2 text-left align-middle text-center">
                                    <flux:label class="text-gray-700">
                                        @if($isFNEG) - @else {{ $masterFactor['rating'] ?? '1.0000' }} @endif
                                    </flux:label>
                                </td>

                                {{-- 3. CALIFICACIÓN COMPARABLE --}}
                                <td class="py-1.5 px-2 text-left align-middle text-center">
                                    @if($showInputCalificacion)
                                    {{-- INPUT HABILITADO PARA FLOC, AVANC Y CUSTOMS --}}
                                    <flux:input type="number" step="0.0001" placeholder="1.0000"
                                        wire:model.blur="comparableFactors.{{ $selectedComparableId }}.{{ $sigla }}.calificacion"
                                        class="text-left h-9 text-sm w-full font-semibold" />

                                    @elseif($isFNEG)
                                    {{-- FNEG: Guion --}}
                                    <flux:label class="text-gray-400 h-9 flex items-center justify-center font-bold">-</flux:label>
                                    @else
                                    {{-- FEQ, FIC, FSU: Texto Plano (Calculado) --}}
                                    <flux:label class="text-gray-700 h-9 flex items-center justify-center px-1">
                                        {{ $comparableFactors[$selectedComparableId][$sigla]['calificacion'] ?? '1.0000' }}
                                    </flux:label>
                                    @endif
                                </td>

                                {{-- 4. DIFERENCIA --}}
                                <td class="py-1.5 px-3 text-left align-middle text-center">
                                    <flux:label class="text-gray-900">
                                        @if($isFNEG) - @else
                                        {{ $comparableFactors[$selectedComparableId][$sigla]['diferencia'] ?? '0.0000' }}
                                        @endif
                                    </flux:label>
                                </td>

                                {{-- 5. APLICABLE --}}
                                <td class="py-1.5 px-3 text-left align-middle">
                                    @if($isFNEG)
                                    {{-- INPUT PARA FNEG --}}
                                    <flux:input type="number" step="0.0001" placeholder="1.0000"
                                        wire:model.blur="comparableFactors.{{ $selectedComparableId }}.{{ $sigla }}.aplicable"
                                        class="text-left h-9 text-sm w-full font-bold text-blue-800 bg-blue-50 border-blue-200" />
                                    @else
                                    {{-- TEXTO PARA LOS DEMÁS --}}
                                    <flux:label class="text-gray-900 font-bold block text-center">
                                        {{ $comparableFactors[$selectedComparableId][$sigla]['aplicable'] ?? '1.0000' }}
                                    </flux:label>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                                <tfoot class="bg-gray-100 border-t-2 border-gray-300">
                                    <tr class="font-extrabold text-md">
                                        <td colspan="4" class="py-2 px-3 text-right">FACTOR RESULTANTE (FRE):</td>
                                        <td class="py-2 px-3 text-left text-gray-900">{{
                                            $comparableFactors[$selectedComparableId]['FRE']['factor_ajuste'] ??
                                            '1.0000' }}</td>
                                    </tr>
                                    <tr class="font-extrabold text-md">
                                        <td colspan="4" class="py-2 px-3 text-right">Valor Unitario Resultante Vendible:
                                        </td>
                                        <td class="py-2 px-3 text-left text-gray-900">${{
                                            number_format($comparableFactors[$selectedComparableId]['FRE']['valor_unitario_vendible']
                                            ?? 0, 2) }}</td>
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
    {{-- SECCIÓN 3: CONCLUSIONES (BUILDING) - CORREGIDO --}}
    {{-- ======================================================================== --}}
    <div class="form-container">
        <div class="form-container__header">
            Conclusiones
        </div>
        <div class="form-container__content">

            {{-- FILA 1: TABLA PRINCIPAL + GRÁFICA 1 --}}
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
                                // Ajusta estas claves si en Building se llaman diferente, pero usualmente son iguales
                                $factor2 = '0.00';
                                $ajustePct = '0.00%';
                                $valorFinal = '0.00';
                                @endphp
                                <tr class="hover:bg-gray-50">
                                    <td class="py-1.5 px-3 align-middle text-sm">
                                        <input type="checkbox" wire:model.live='selectedForStats'
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

                                {{-- FILA PROMEDIO --}}
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

                {{-- Gráfica 1 (MIXTA) --}}
                <div class="relative flex flex-col h-full">
                <div x-data="chartHomologationBuildings()" x-init="init()" wire:ignore
                    class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm w-full relative"
                    style="height: 300px; min-height: 300px;">
                    <canvas x-ref="chart1"></canvas>
                </div>
                </div>
            </div>

            {{-- FILA 2: TABLA ESTADÍSTICAS + GRÁFICA 2 (BARRAS) --}}
            {{-- ¡AQUÍ ES DONDE FALTABAN LAS FILAS! --}}
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

                <div x-data="chartHomologationBuildingStats()" x-init="init()" wire:ignore
                    class="bg-white p-4 rounded-lg border border-gray-200 shadow-sm w-full relative"
                    style="height: 300px; min-height: 300px;">
                    <canvas x-ref="chart2"></canvas>
                </div>
            </div>

            {{-- RESULTADOS FINALES --}}
            <div class="mt-6 p-4 bg-gray-50 border border-gray-200 rounded-lg shadow-sm">
                <div class="flex flex-col space-y-4">
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                        <span class="text-xl font-bold text-gray-800">VALOR UNITARIO DE VENTA:</span>
                        <span class="text-3xl font-extrabold text-gray-900 mt-1 md:mt-0">{{
                            $conclusion_valor_unitario_de_venta }}</span>
                    </div>
                    <div class="flex flex-col md:flex-row md:justify-between md:items-center">
                        <label for="tipo_redondeo_venta"
                            class="block text-sm font-medium text-gray-700 whitespace-nowrap mb-1 md:mb-0">
                            TIPO DE REDONDEO SOBRE EL VALOR UNITARIO:
                        </label>
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
        <h2 class="text-xl font-semibold">Necesitas tener al menos 6 comparables asignados.</h2>
    </div>
    @endif

    <flux:modal name="equipment-modal" variant="flyout" position="left" max-width="max-w-lg">
        <div class="flex flex-col h-full" wire:key="equipment-modal-{{ $selectedComparableId }}">
            <div class="p-6 border-b border-gray-200">
                <flux:heading size="lg" class="text-gray-900">Equipamiento</flux:heading>
                <flux:text class="mt-2">Gestiona el equipamiento para el sujeto y comparables.</flux:text>
            </div>
            <div class="p-6 space-y-6 flex-1 overflow-y-auto">
                <div class="space-y-3">
                    <flux:heading size="md" class="text-gray-800 border-b pb-2">Del Objeto (Sujeto)</flux:heading>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="text-left text-gray-500">
                                <tr>
                                    <th class="py-2 pr-2 font-medium w-3/6">Descripción</th>
                                    <th class="py-2 px-2 font-medium w-1/6">Cant.</th>
                                    <th class="py-2 px-2 font-medium w-1/6">Total ($)</th>
                                    <th class="py-2 pl-2 font-medium w-1/6 text-center"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($subjectEquipments as $eq)
                                @php $isEditingEq = ($editing_eq_id === $eq->id); $isOther =
                                !empty($eq->custom_description); @endphp
                                <tr class="align-middle" wire:key="eq-subject-{{ $eq->id }}">
                                    <td class="py-2 pr-2">
                                        @if($isEditingEq && $isOther)
                                        <flux:input type="text" wire:model.defer="edit_eq_other_description"
                                            class="!text-sm" />
                                        @else <div class="font-medium text-gray-900">{{ $eq->description }}</div> @endif
                                        <div class="text-xs text-gray-500">{{ $eq->unit }}</div>
                                    </td>
                                    <td class="py-2 px-2">@if($isEditingEq)
                                        <flux:input type="number" wire:model.blur="edit_eq_quantity" class="!text-sm"
                                            step="0.01" /> @else {{ number_format($eq->quantity, 2) }} @endif
                                    </td>
                                    <td class="py-2 px-2 font-mono text-gray-700">@if($isEditingEq && $isOther)
                                        <flux:input type="number" wire:model.blur="edit_eq_total_value" class="!text-sm"
                                            step="100" /> @else ${{ number_format($eq->total_value, 2)
                                        }} @endif
                                    </td>
                                    <td class="py-2 pl-2">
                                        <div class="flex justify-center space-x-2">@if($isEditingEq)
                                            <flux:button icon="check" wire:click="saveEditedEquipment"
                                                class="btn-primary btn-table cursor-pointer" />
                                            <flux:button icon="x-mark" wire:click="cancelEditEquipment"
                                                class="btn-deleted btn-table cursor-pointer" /> @else
                                            <flux:button icon="pencil" wire:click="toggleEditEquipment({{ $eq->id }})"
                                                class="btn-intermediary btn-table cursor-pointer" />
                                            <flux:button icon="trash" wire:click="deleteEquipment({{ $eq->id }})"
                                                wire:confirm="¿Seguro?" class="btn-deleted btn-table cursor-pointer" /> @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-400 italic">Sin equipamiento.</td>
                                </tr> @endforelse
                            </tbody>
                            <tfoot class="border-t-2">
                                <tr class="align-middle bg-gray-50">
                                    <td class="py-3 px-2">
                                        {{-- CORRECCIÓN 1: Usamos la computada equipmentOptions --}}
                                        <flux:select wire:model.live="new_eq_description" placeholder="Seleccionar" allow-custom class="text-gray-800 [&_option]:text-gray-900">
                                            @foreach($this->equipmentOptions as $key)
                                            <flux:select.option value="{{ $key }}">{{ $key }}</flux:select.option>
                                            @endforeach
                                        </flux:select>

                                        @if ($new_eq_description === 'Otro')
                                        <flux:input type="text" wire:model.live="new_eq_other_description" placeholder="Nombre"
                                            class="!text-sm w-full mt-2" />
                                        @endif
                                    </td>
                                    <td class="py-3 px-2 align-top">
                                        <flux:input type="number" wire:model.live="new_eq_quantity" placeholder="1" class="!text-sm" step="0.01" />
                                    </td>
                                    <td class="py-3 px-2 align-top">
                                        @if ($new_eq_description === 'Otro')
                                        <flux:input type="number" wire:model="new_eq_total_value" placeholder="$" class="!text-sm" step="100" />
                                        @else
                                        {{-- CORRECCIÓN 2: Usamos la computada selectedEquipmentUnitPrice --}}
                                        <div class="text-gray-500 text-center text-sm pt-2">
                                            ${{ number_format($new_eq_quantity * $this->selectedEquipmentUnitPrice, 2) }}
                                        </div>
                                        @endif
                                    </td>
                                    <td class="py-3 pl-2 text-center align-top">
                                        <flux:button icon="plus" wire:click="saveNewEquipment" class="btn-primary btn-table cursor-pointer" type="button" />
                                    </td>
                                </tr>
                            </tfoot>
                          {{--   <tfoot class="border-t-2">
                                <tr class="align-middle bg-gray-50">
                                    <td class="py-3 px-2">
                                        <flux:select wire:model.live="new_eq_description" placeholder="Seleccionar"
                                            allow-custom>
                                            @foreach(array_keys(\App\Livewire\Forms\HomologationBuildings::EQUIPMENT_MAP)
                                            as $key) <flux:select.option value="{{ $key }}">{{ $key }}
                                            </flux:select.option> @endforeach </flux:select> @if ($new_eq_description
                                        === 'Otro')
                                        <flux:input type="text" wire:model.live="new_eq_other_description"
                                            placeholder="Nombre" class="!text-sm w-full mt-2" /> @endif
                                    </td>
                                    <td class="py-3 px-2 align-top">
                                        <flux:input type="number" wire:model.live="new_eq_quantity" placeholder="1"
                                            class="!text-sm" step="0.01" />
                                    </td>
                                    <td class="py-3 px-2 align-top">@if ($new_eq_description === 'Otro')
                                        <flux:input type="number" wire:model="new_eq_total_value" placeholder="$"
                                            class="!text-sm" step="100" /> @else <div
                                            class="text-gray-500 text-center text-sm pt-2">${{
                                            number_format($new_eq_quantity *
                                            (\App\Livewire\Forms\HomologationBuildings::EQUIPMENT_MAP[$new_eq_description]['value']
                                            ?? 0), 2) }}</div> @endif
                                    </td>
                                    <td class="py-3 pl-2 text-center align-top">
                                        <flux:button icon="plus" wire:click="saveNewEquipment"
                                            class="btn-primary btn-table" />
                                    </td>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>
                </div>
                @if($selectedComparableId)
                <div class="space-y-3 pt-4">
                    <flux:heading size="md" class="text-gray-800 border-b pb-2">Del Comparable (#{{
                        $selectedComparableId }})</flux:heading>
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="bg-gray-100 text-gray-600 font-medium">
                                    <th class="py-2 px-2 text-left w-2/5">Descripción</th>
                                    <th class="py-2 px-2 text-center w-1/5">Unidad</th>
                                    <th class="py-2 px-2 text-center w-1/5">Cant. Comp.</th>
                                    <th class="py-2 px-2 text-right w-1/5">Diferencia ($)</th>
                                    <th class="py-2 px-2 text-right w-1/5">Diferencia (%)</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @forelse($currentComparableEquipments as $compEq)
                                <tr class="align-middle" wire:key="comp-eq-{{ $compEq->id }}">
                                    <td class="py-2 pr-2 font-medium text-gray-800">{{ $compEq->description }}</td>
                                    <td class="py-2 px-2 text-center text-xs text-gray-500">{{ $compEq->unit }}</td>
                                    <td class="py-2 px-2 text-center">
                                        <flux:input type="number" value="{{ $compEq->quantity }}"
                                            wire:change="updateComparableEquipmentQty({{ $compEq->id }}, $event.target.value)"
                                            min="0" step="0.01" class="!text-sm w-20 text-center" />
                                    </td>
                                    <td class="py-2 px-2 font-mono text-right text-gray-900">
                                        ${{ number_format($compEq->difference, 2) }}
                                    </td>
                                    <td class="py-2 px-2 text-right font-mono text-gray-900">
                                        {{ number_format($compEq->percentage, 2) }}%
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="py-4 text-center text-gray-400">Agrega equipamiento al sujeto
                                        primero.</td>
                                </tr>
                                @endforelse
                            </tbody>
                            <tfoot class="bg-gray-50 border-t font-bold">
                                <tr>
                                    <td colspan="4" class="text-right py-2 px-2 text-gray-700">FACTOR RESULTANTE (FEQ):
                                    </td>
                                    <td class="text-right py-2 px-2 text-gray-900">{{
                                        $comparableFactors[$selectedComparableId]['FEQ']['aplicable'] ?? '1.0000' }}
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </flux:modal>


 {{-- MODAL RESUMEN --}}
    <livewire:forms.comparables.comparable-summary />



<script>
    // 1. La Fábrica (Global)
    // La definimos en window para asegurar que esté disponible siempre
    window.createChartManager = function(chartType, eventName, refName) {
        let chartInstance = null;

        return {
            init() {
                // BLINDAJE: Si el elemento no existe, abortar misión
                if (!this.$refs[refName]) return;

                this.drawChart({ labels: [], datasets: [] });

                // Escucha de eventos
                window.addEventListener(eventName, (event) => {
                    // Doble chequeo por si el usuario cambió de página rápido
                    if (!this.$refs[refName]) return;

                    let payload = event.detail;
                    const dataToUse = (payload && payload.data) ? payload.data : payload;

                    if (dataToUse) {
                        this.drawChart(dataToUse);
                    }
                });
            },

            drawChart(data) {
                try {
                    const ctx = this.$refs[refName];
                    if (!ctx) return;

                    if (chartInstance) {
                        chartInstance.destroy();
                        chartInstance = null;
                    }

                    chartInstance = new Chart(ctx, {
                        type: chartType,
                        data: data,
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            animation: { duration: 500 },
                            plugins: {
                                legend: { display: false },
                                tooltip: { mode: 'index', intersect: false }
                            },
                            scales: {
                                y: { display: false, beginAtZero: true, grid: { display: false } },
                                x: { grid: { display: false }, ticks: { display: true, font: { size: 10 } } }
                            }
                        }
                    });
                } catch (error) {
                    console.error("Error chart:", error);
                }
            }
        };
    }

    // 2. Funciones Específicas (Globales)
    // Al ser funciones normales, Alpine las encuentra siempre, sin importar la navegación.
    function chartHomologationBuildings() {
        return createChartManager('bar', 'updateBuildingChart1', 'chart1');
    }

    function chartHomologationBuildingStats() {
        return createChartManager('bar', 'updateBuildingChart2', 'chart2');
    }
</script>
</div>
