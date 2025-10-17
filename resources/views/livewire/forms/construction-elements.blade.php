<div>
    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>
    <form wire:submit="save">
        <div class="form-container">
            <div class="form-container__header">
                Elementos de la construcción
            </div>


            @unless ($preValuation)

            <div class="form-container__content">
                <div class="flex flex-col w-full h-full">

                    {{-- Navbar responsivo con hamburguesa --}}
                    <div x-data="{ open: false }" class="w-full">
                      @php
                   $tabs = [
                'obra_negra' => [
                'label' => 'Obra negra',
                'fields' => [
                'sc_structure',
                'sc_shallowFoundation',
                'sc_intermediateFloor',
                'sc_ceiling',
                'sc_walls',
                'sc_beamsColumns',
                'sc_roof',
                'sc_fences',
                ],
                ],

                'acabados1' => [
                'label' => 'Acabados 1',
                'fields' => [
                // Áreas comunes
                'fn1_hallFlats', 'fn1_hallWalls', 'fn1_hallCeilings',
                'fn1_stdrFlats', 'fn1_stdrWalls', 'fn1_stdrCeilings',
                'fn1_kitchenFlats', 'fn1_kitchenWalls', 'fn1_kitchenCeilings',

                // Dormitorios y Baños (incluyendo números y acabados)
                'fn1_bedroomsNumber', 'fn1_bedroomsFlats', 'fn1_bedroomsWalls', 'fn1_bedroomsCeilings',
                'fn1_bathroomsNumber', 'fn1_bathroomsFlats', 'fn1_bathroomsWalls', 'fn1_bathroomsCeilings',
                'fn1_halfBathroomsNumber', 'fn1_halfBathroomsFlats', 'fn1_halfBathroomsWalls', 'fn1_halfBathroomsCeilings',

                // Servicios y Circulación
                'fn1_utyrFlats', 'fn1_utyrWalls', 'fn1_utyrCeilings',
                'fn1_stairsFlats', 'fn1_stairsWalls', 'fn1_stairsCeilings',

                // Patios y Exteriores
                'fn1_copaNumber', 'fn1_copaFlats', 'fn1_copaWalls', 'fn1_copaCeilings',
                'fn1_unpaNumber', 'fn1_unpaFlats', 'fn1_unpaWalls', 'fn1_unpaCeilings',
                ],
                ],

                'acabados2' => [
                'label' => 'Acabados 2',
                'fields' => [
                'fn2_furredWalls',
                'fn2_plinths',
                'fn2_paint',
                'fn2_specialCoating',
                ],
                ],

                'carpinteria' => [
                'label' => 'Carpintería',
                'fields' => [
                'car_doorsAccess',
                'car_insideDoors',
                'car_fixedFurnitureBedrooms',
                'car_fixedFurnitureInsideBedrooms',
                ],
                ],

                'hidraulicas' => [
                'label' => 'Hidráulicas y sanitarias',
                'fields' => [
                'hs_bathroomFurniture',
                'hs_hiddenApparentHydraulicBranches',
                'hs_hydraulicBranches',
                'hs_hiddenApparentSanitaryBranches',
                'hs_SanitaryBranches',
                'hs_hiddenApparentElectrics',
                'hs_electrics',
                ],
                ],

                'herreria' => [
                'label' => 'Herrería',
                'fields' => [
                'sm_serviceDoor',
                'sm_windows',
                'sm_others',
                ],
                ],

                'otros' => [
                'label' => 'Otros elementos',
                'fields' => [
                'oe_structure',
                'oe_locksmith',
                'oe_facades',
                'oe_elevator',
                ],
                ],
                ];
                    $lastKey = array_key_last($tabs);
                    @endphp

                        {{-- Navbar para pantallas grandes (≥950px) --}}
                        <flux:navbar class="hidden xl:flex bg-white border-b-2">
                            @foreach ($tabs as $key => $tab)
                            {{-- VERIFICACIÓN DE ERRORES DEL TAB: Usamos $errors->hasAny() --}}
                            @php
                            $hasErrors = $errors->hasAny($tab['fields']);
                            @endphp
                           {{--  @foreach ($tabs as $key => $label) --}}
                            <flux:navbar.item wire:click.prevent="setTab('{{ $key }}')"
                                :active="$activeTab === '{{ $key }}'" class="cursor-pointer px-4 py-2 transition-colors
                                    {{ $activeTab === $key
                                        ? 'border-b-2 border-[#43A497] text-[#3A8B88] font-semibold'
                                        : 'text-gray-600 hover:text-[#5CBEB4]' }}">
                                <span class="text-[16px] flex items-center">
                                    {{ $tab['label'] }}

                                    {{-- INDICADOR VISUAL DE ERROR --}}
                                    @if ($hasErrors)
                                    <svg class="w-4 h-4 ml-2 text-red-500 fill-current animate-pulse" viewBox="0 0 20 20"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    @endif
                                </span>
                            </flux:navbar.item>

                            @if ($key !== $lastKey)
                            <span class="text-gray-300 select-none self-center">•</span>
                            @endif
                            @endforeach
                        </flux:navbar>

                        {{-- Menú hamburguesa para pantallas pequeñas (<950px) --}} <div
                            class="xl:hidden flex justify-end p-4 bg-white border-b-2">
                            {{-- <span class="text-lg font-semibold text-[#3A8B88]">Opciones</span> --}}
                            <button type="button" @click="open = !open"
                                class="text-[#000000] focus:outline-none cursor-pointer">
                                <template x-if="!open">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M4 6h16M4 12h16M4 18h16" />
                                    </svg>
                                </template>
                                <template x-if="open">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                                        viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </template>
                            </button>
                    </div>

                    {{-- Menú desplegable en móvil --}}
                    <div x-show="open" x-transition class="xl:hidden bg-white border-b border-gray-200">
                        <ul class="flex flex-col divide-y divide-gray-100">
                            @foreach ($tabs as $key => $label)
                            {{-- VERIFICACIÓN DE ERRORES DEL TAB --}}
                            @php
                            $hasErrors = $errors->hasAny($tab['fields']);
                            @endphp
                            <li>
                                <button type="button" wire:click.prevent="setTab('{{ $key }}')" @click="open = false"
                                    class="cursor-pointer w-full text-left px-4 py-3 transition-colors
                                            {{ $activeTab === $key
                                                ? 'border-l-4 border-[#43A497] bg-[#F0FDFD] text-[#3A8B88] font-semibold'
                                                : 'text-gray-700 hover:bg-gray-100' }}">
                                    {{ $tab['label'] }}

                                    {{-- INDICADOR VISUAL DE ERROR EN MÓVIL --}}
                                    @if ($hasErrors)
                                    <svg class="w-5 h-5 text-red-500 fill-current animate-pulse" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd"
                                            d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                            clip-rule="evenodd" />
                                    </svg>
                                    @endif
                                </button>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>















                {{-- Obra negra --}}
                @if ($activeTab === 'obra_negra')
                {{-- <h2 class="text-lg font-semibold mb-4">Obra negra</h2>
                <table class="w-full table-auto border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-1 border">Ítem</th>
                            <th class="px-2 py-1 border">Cantidad</th>
                            <th class="px-2 py-1 border">Costo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="px-2 py-1 border">Ladrillo</td>
                            <td class="px-2 py-1 border">
                                <input type="number" wire:model.defer=" " class="w-24 border rounded px-1 py-0.5">
                            </td>
                            <td class="px-2 py-1 border">$</td>
                        </tr>
                        más filas
                    </tbody>
                </table> --}}
                {{-- Shell construction --}}
                <div class="form-container__content">
                    <div class="form-grid form-grid--2">
                        <flux:field class="flux_field pt2">
                            <flux:label>Estructura<span class="sup-required">*</span></flux:label>
                            <flux:textarea wire:model='sc_structure' />
                            <div class="error-container">
                                <flux:error name="sc_structure" />
                            </div>
                        </flux:field>
                        <flux:field class="flux_field pt2">
                            <flux:label>Cimentación<span class="sup-required">*</span></flux:label>
                            <flux:textarea wire:model='sc_shallowFoundation' />
                            <div class="error-container">
                                <flux:error name="sc_shallowFoundation" />
                            </div>
                        </flux:field>
                    </div>
                    <div class="form-grid form-grid--2">
                        <flux:field class="flux_field pt2">
                            <flux:label>Entrepisos<span class="sup-required">*</span></flux:label>
                            <flux:textarea wire:model='sc_intermediateFloor' />
                            <div class="error-container">
                                <flux:error name="sc_intermediateFloor" />
                            </div>
                        </flux:field>
                        <flux:field class="flux_field pt2">
                            <flux:label>Techos<span class="sup-required">*</span></flux:label>
                            <flux:textarea wire:model='sc_ceiling' />
                            <div class="error-container">
                                <flux:error name="sc_ceiling" />
                            </div>
                        </flux:field>
                    </div>
                    <div class="form-grid form-grid--2">
                        <flux:field class="flux_field pt2">
                            <flux:label>Muros<span class="sup-required">*</span></flux:label>
                            <flux:textarea wire:model='sc_walls' />
                            <div class="error-container">
                                <flux:error name="sc_walls" />
                            </div>
                        </flux:field>
                        <flux:field class="flux_field pt2">
                            <flux:label>Trabes y columnas<span class="sup-required">*</span></flux:label>
                            <flux:textarea wire:model='sc_beamsColumns' />
                            <div class="error-container">
                                <flux:error name="sc_beamsColumns" />
                            </div>
                        </flux:field>
                    </div>
                    <div class="form-grid form-grid--2">
                        <flux:field class="flux_field pt2">
                            <flux:label>Azoteas<span class="sup-required">*</span></flux:label>
                            <flux:textarea wire:model='sc_roof' />
                            <div class="error-container">
                                <flux:error name="sc_roof" />
                            </div>
                        </flux:field>
                        <flux:field class="flux_field pt2">
                            <flux:label>Bardas<span class="sup-required">*</span></flux:label>
                            <flux:textarea wire:model='sc_fences' />
                            <div class="error-container">
                                <flux:error name="sc_fences" />
                            </div>
                        </flux:field>
                    </div>
                </div>

                @endif





















                {{-- Acabados 1 --}}
                {{-- Finishes --}}
                @if ($activeTab === 'acabados1')
                {{-- <div class="form-container__content"> --}}
                    <div class="mt-8">
                        <div class="overflow-x-auto max-w-full">
                            <table class="min-w-[550px] table-fixed w-full border-2 ">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="w-[140px] px-2 py-1 border">Espacio</th>
                                        <th class="w-[90px] px-2 py-1 border">Cantidad</th>
                                        <th class="w-[28%] px-2 py-1 border">Pisos</th>
                                        <th class="w-[28%] px-2 py-1 border">Muros</th>
                                        <th class="w-[28%] px-2 py-1 border">Plafones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- hall --}}
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Sala<span class="sup-required">*</span></td>
                                        <td class="px-2 py-1 border text-sm"></td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_hallFlats' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_hallFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_hallWalls' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_hallWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_hallCeilings' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_hallCeilings" />
                                                </div>
                                            </flux:field>
                                        </td>
                                    </tr>
                                    {{-- stay-diningRoom --}}
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Estancia / comedor<span class="sup-required">*</span></td>
                                        <td class="px-2 py-1 border text-sm"></td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_stdrFlats' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_stdrFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_stdrWalls' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_stdrWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_stdrCeilings' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_stdrCeilings" />
                                                </div>
                                            </flux:field>
                                        </td>
                                    </tr>
                                    {{-- Kitchen --}}
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Cocina<span class="sup-required">*</span></td>
                                        <td class="px-2 py-1 border text-sm"></td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_kitchenFlats' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_kitchenFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_kitchenWalls' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_kitchenWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_kitchenCeilings' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_kitchenCeilings" />
                                                </div>
                                            </flux:field>
                                        </td>
                                    </tr>
                                    {{-- bedrooms --}}
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Recámaras</td>
                                        <td class="px-2 py-1 border">
                                            <flux:field>
                                                <flux:select wire:model.live.number="fn1_bedroomsNumber"
                                                    class="w-[20px] text-gray-800 [&_option]:text-gray-900">
                                                    <flux:select.option value="0">0</flux:select.option>
                                                    <flux:select.option value="1">1</flux:select.option>
                                                    <flux:select.option value="2">2</flux:select.option>
                                                    <flux:select.option value="3">3</flux:select.option>
                                                    <flux:select.option value="4">4</flux:select.option>
                                                    <flux:select.option value="5">5</flux:select.option>
                                                    <flux:select.option value="6">6</flux:select.option>
                                                    <flux:select.option value="7">7</flux:select.option>
                                                    <flux:select.option value="8">8</flux:select.option>
                                                    <flux:select.option value="9">9</flux:select.option>
                                                    <flux:select.option value="10">10</flux:select.option>
                                                </flux:select>
                                            </flux:field>
                                            {{-- <div class="error-container">
                                                <flux:error name="fn1_bedroomsNumber" />
                                            </div> --}}
                                        </td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model.live='fn1_bedroomsFlats' :disabled="$fn1_bedroomsNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_bedroomsFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_bedroomsWalls' :disabled="$fn1_bedroomsNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_bedroomsWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_bedroomsCeilings' :disabled="$fn1_bedroomsNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_bedroomsCeilings" />
                                                </div>
                                            </flux:field>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Baños</td>
                                        <td class="px-2 py-1 border">
                                            <flux:field>
                                                <flux:select wire:model.live.number="fn1_bathroomsNumber"
                                                    class="w-[20px] text-gray-800 [&_option]:text-gray-900">
                                                    <flux:select.option value="0">0</flux:select.option>
                                                    <flux:select.option value="1">1</flux:select.option>
                                                    <flux:select.option value="2">2</flux:select.option>
                                                    <flux:select.option value="3">3</flux:select.option>
                                                    <flux:select.option value="4">4</flux:select.option>
                                                    <flux:select.option value="5">5</flux:select.option>
                                                    <flux:select.option value="6">6</flux:select.option>
                                                    <flux:select.option value="7">7</flux:select.option>
                                                    <flux:select.option value="8">8</flux:select.option>
                                                    <flux:select.option value="9">9</flux:select.option>
                                                    <flux:select.option value="10">10</flux:select.option>
                                                </flux:select>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_bathroomsFlats' :disabled="$fn1_bathroomsNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_bathroomsFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_bathroomsWalls' :disabled="$fn1_bathroomsNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_bathroomsWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_bathroomsCeilings' :disabled="$fn1_bathroomsNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_bathroomsCeilings" />
                                                </div>
                                            </flux:field>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Medios baños</td>
                                        <td class="px-2 py-1 border">
                                            <flux:field>
                                                <flux:select wire:model.live.number="fn1_halfBathroomsNumber"
                                                    class="w-[20px] text-gray-800 [&_option]:text-gray-900">
                                                    <flux:select.option value="0">0</flux:select.option>
                                                    <flux:select.option value="1">1</flux:select.option>
                                                    <flux:select.option value="2">2</flux:select.option>
                                                    <flux:select.option value="3">3</flux:select.option>
                                                    <flux:select.option value="4">4</flux:select.option>
                                                    <flux:select.option value="5">5</flux:select.option>
                                                    <flux:select.option value="6">6</flux:select.option>
                                                    <flux:select.option value="7">7</flux:select.option>
                                                    <flux:select.option value="8">8</flux:select.option>
                                                    <flux:select.option value="9">9</flux:select.option>
                                                    <flux:select.option value="10">10</flux:select.option>
                                                </flux:select>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_halfBathroomsFlats' :disabled="$fn1_halfBathroomsNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_halfBathroomsFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_halfBathroomsWalls' :disabled="$fn1_halfBathroomsNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_halfBathroomsWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_halfBathroomsCeilings' :disabled="$fn1_halfBathroomsNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_halfBathroomsCeilings" />
                                                </div>
                                            </flux:field>
                                        </td>
                                    </tr>
                                    {{-- Utility yard --}}
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Patio servicio</td>
                                        <td class="px-2 py-1 border text-sm"></td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_utyrFlats' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_utyrFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_utyrWalls' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_utyrWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_utyrCeilings' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_utyrCeilings" />
                                                </div>
                                            </flux:field>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Escaleras</td>
                                        <td class="px-2 py-1 border text-sm"></td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_stairsFlats' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_stairsFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_stairsWalls' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_stairsWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_stairsCeilings' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_stairsCeilings" />
                                                </div>
                                            </flux:field>
                                        </td>
                                    </tr>
                                    {{-- covered parking --}}
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Estacionamiento cubierto</td>
                                        <td class="px-2 py-1 border">
                                            <flux:field>
                                                <flux:select wire:model.live.number="fn1_copaNumber"
                                                    class="w-[20px] text-gray-800 [&_option]:text-gray-900">
                                                    <flux:select.option value="0">0</flux:select.option>
                                                    <flux:select.option value="1">1</flux:select.option>
                                                    <flux:select.option value="2">2</flux:select.option>
                                                    <flux:select.option value="3">3</flux:select.option>
                                                    <flux:select.option value="4">4</flux:select.option>
                                                    <flux:select.option value="5">5</flux:select.option>
                                                    <flux:select.option value="6">6</flux:select.option>
                                                    <flux:select.option value="7">7</flux:select.option>
                                                    <flux:select.option value="8">8</flux:select.option>
                                                    <flux:select.option value="9">9</flux:select.option>
                                                    <flux:select.option value="10">10</flux:select.option>
                                                </flux:select>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_copaFlats' :disabled="$fn1_copaNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_copaFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_copaWalls' :disabled="$fn1_copaNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_copaWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_copaCeilings' :disabled="$fn1_copaNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_copaCeilings" />
                                                </div>
                                            </flux:field>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Estacionamiento descubierto
                                        </td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field>
                                                <flux:select wire:model.live.number="fn1_unpaNumber"
                                                    class="w-[20px] text-gray-800 [&_option]:text-gray-900">
                                                    <flux:select.option value="0">0</flux:select.option>
                                                    <flux:select.option value="1">1</flux:select.option>
                                                    <flux:select.option value="2">2</flux:select.option>
                                                    <flux:select.option value="3">3</flux:select.option>
                                                    <flux:select.option value="4">4</flux:select.option>
                                                    <flux:select.option value="5">5</flux:select.option>
                                                    <flux:select.option value="6">6</flux:select.option>
                                                    <flux:select.option value="7">7</flux:select.option>
                                                    <flux:select.option value="8">8</flux:select.option>
                                                    <flux:select.option value="9">9</flux:select.option>
                                                    <flux:select.option value="10">10</flux:select.option>
                                                </flux:select>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_unpaFlats' :disabled="$fn1_unpaNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_unpaFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_unpaWalls' :disabled="$fn1_unpaNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_unpaWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_unpaCeilings' :disabled="$fn1_unpaNumber === 0"/>
                                                <div class="error-container">
                                                    <flux:error name="fn1_unpaCeilings" />
                                                </div>
                                            </flux:field>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    {{-- TABLA PARA OTROS ACABADOS --}}

                    <div class="mt-8 mb-4">
                        <h3>Si el inmueble cuenta con más espacios no listados en la tabla anterior, por favor
                            agregarlos en la siguiente tabla:</h3>
                    </div>

                    {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                    {{-- <flux:modal.trigger name="add-item" class="flex justify-end"> --}}
                        <flux:button type="button" class="btn-primary btn-table cursor-pointer mt-2" icon="plus" wire:click='openAddElement'>
                        </flux:button>
                    {{-- </flux:modal.trigger> --}}

                    {{-- Tabla otros acabados --}}
                    <div class="mt-8">
                        <div class="overflow-x-auto max-w-full">
                            <table class="min-w-[550px] table-fixed w-full border-2 ">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-2 py-1 border whitespace-nowrap">Espacio</th>
                                        <th class="w-[16%] px-2 py-1 border whitespace-nowrap">cantidad<span
                                                class="sup-required">*</span>
                                        </th>
                                        <th class="w-[20%] px-2 py-1 border">Pisos</th>
                                        <th class="w-[20%] px-2 py-1 border">Muros</th>
                                        <th class="w-[20%] px-2 py-1 border">Plafones</th>
                                        <th class="w-[12%] py-1 border">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($finishingOthersList as $finishingOther)
                                    {{-- @foreach ($finishingOthersList as $index => $item) --}}
                                    <tr>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $finishingOther->space }}</td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $finishingOther->amount }}</td>
                                        <td class="px-2 py-1 border text-sm text-center">{{ $finishingOther->floors }}</td>
                                        <td class="px-2 py-1 border text-sm text-center">{{ $finishingOther->walls }}</td>
                                        <td class="px-2 py-1 border text-sm text-center">{{ $finishingOther->ceilings }}</td>


                                        <td class="px-2 py-1 border flex justify-evenly">

                                                <flux:button type="button" icon-leading="pencil"
                                                    class="cursor-pointer btn-intermediary btn-buildins" wire:click="openEditElement({{ $finishingOther->id }})" />

                                                    <flux:button
                                                        onclick="confirm('¿Estás seguro de que deseas eliminar esto?') || event.stopImmediatePropagation()"
                                                        wire:click="deleteItem({{ $finishingOther->id }})" type="button" icon-leading="trash"
                                                        class="cursor-pointer btn-deleted btn-buildings" />
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="text-center text-gray-500 py-2">
                                            No hay elementos registrados.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>



                    @endif


































                    {{-- Acabados 2 --}}
                    @if ($activeTab === 'acabados2')
                    <div class="form-container__content">
                    {{--     <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Aplanados<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_cementPlaster' />
                                <div class="error-container">
                                    <flux:error name="fn2_cementPlaster" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <flux:label>Plafones<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_ceilings' />
                                <div class="error-container">
                                    <flux:error name="fn2_ceilings" />
                                </div>
                            </flux:field>
                        </div> --}}
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Lambrines<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_furredWalls' />
                                <div class="error-container">
                                    <flux:error name="fn2_furredWalls" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <flux:label>Zoclos<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_plinths' />
                                <div class="error-container">
                                    <flux:error name="fn2_plinths" />
                                </div>
                            </flux:field>
                            {{-- <flux:field class="flux_field pt2">
                                <flux:label>Escaleras<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_stairs' />
                                <div class="error-container">
                                    <flux:error name="fn2_stairs" />
                                </div>
                            </flux:field> --}}
                        </div>
                        <div class="form-grid form-grid--2">
                            {{-- <flux:field class="flux_field pt2">
                                <flux:label>Pisos<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_flats' />
                                <div class="error-container">
                                    <flux:error name="fn2_flats" />
                                </div>
                            </flux:field> --}}

                        </div>
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Pintura<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_paint' />
                                <div class="error-container">
                                    <flux:error name="fn2_paint" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <flux:label>Recubrimientos especiales<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_specialCoating' />
                                <div class="error-container">
                                    <flux:error name="fn2_specialCoating" />
                                </div>
                            </flux:field>
                        </div>
                    </div>
                    @endif








































                    {{-- Carpintería --}}
                    {{-- carpentry --}}
                    @if ($activeTab === 'carpinteria')
                    <div class="form-container__content">
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Puertas de acceso a la vivienda<span class="sup-required">*</span>
                                </flux:label>
                                <flux:textarea wire:model='car_doorsAccess' />
                                <div class="error-container">
                                    <flux:error name="car_doorsAccess" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <flux:label>Puertas interiores<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='car_insideDoors' />
                                <div class="error-container">
                                    <flux:error name="car_insideDoors" />
                                </div>
                            </flux:field>
                        </div>
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Muebles empotrados o fijos fuera de recámaras<span
                                        class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='car_fixedFurnitureBedrooms' />
                                <div class="error-container">
                                    <flux:error name="car_fixedFurnitureBedrooms" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <flux:label>Muebles empotrados o fijos en recámaras<span class="sup-required">*</span>
                                </flux:label>
                                <flux:textarea wire:model='car_fixedFurnitureInsideBedrooms' />
                                <div class="error-container">
                                    <flux:error name="car_fixedFurnitureInsideBedrooms" />
                                </div>
                            </flux:field>
                        </div>

                    </div>
                    @endif






































                    {{-- Hidráulicas y sanitarias --}}
                    {{-- Hydraulic and sanitary --}}
                    @if ($activeTab === 'hidraulicas')
                    <div class="form-container__content">
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <div class="mb-3">
                                    <flux:label>Muebles de baño<span class="sup-required">*</span></flux:label>
                                </div>
                                <flux:textarea wire:model='hs_bathroomFurniture' />
                                <div class="error-container">
                                    <flux:error name="hs_bathroomFurniture" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <div class="flex justify-between mb-3">
                                    <flux:label>Ramaleos hidráulicos<span class="sup-required">*</span></flux:label>
                                <flux:radio.group wire:model="hs_hiddenApparentHydraulicBranches"
                                    class="flex items-center gap-4" size="sm">
                                    <div>
                                        <flux:radio label="Oculta" value="Oculta" />
                                    </div>
                                    <div>
                                        <flux:radio label="Aparente" value="Aparente" />
                                    </div>
                                </flux:radio.group>
                                </div>
                                <flux:textarea wire:model='hs_hydraulicBranches' />
                                <div class="error-container">
                                    <flux:error name="hs_hydraulicBranches" />
                                </div>
                            </flux:field>
                        </div>
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <div class="flex justify-between mb-3">
                                    <flux:label>Ramaleos sanitarios<span class="sup-required">*</span></flux:label>
                                        <flux:radio.group class="flex items-center gap-4"
                                            wire:model="hs_hiddenApparentSanitaryBranches" size="sm">
                                            <div>
                                                <flux:radio label="Oculta" value="Oculta" />
                                            </div>
                                            <div>
                                                <flux:radio label="Aparente" value="Aparente" />
                                            </div>
                                        </flux:radio.group>
                                </div>
                                <flux:textarea wire:model='hs_SanitaryBranches' />
                                <div class="error-container">
                                    <flux:error name="hs_SanitaryBranches" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <div class="flex justify-between mb-3">
                                    <flux:label>Eléctricas<span class="sup-required">*</span></flux:label>
                                        <flux:radio.group class="flex items-center gap-4"
                                            wire:model="hs_hiddenApparentElectrics" size="sm">
                                            <div>
                                                <flux:radio label="Oculta" value="Oculta" />
                                            </div>
                                            <div>
                                                <flux:radio label="Aparente" value="Aparente" />
                                            </div>
                                        </flux:radio.group>
                                </div>
                                <flux:textarea wire:model='hs_electrics' />
                                <div class="error-container">
                                    <flux:error name="hs_electrics" />
                                </div>
                            </flux:field>
                        </div>

                    </div>
                    @endif






















                    {{-- Herrería --}}
                    {{-- smithy --}}
                    @if ($activeTab === 'herreria')
                    <div class="form-container__content">
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Puerta de patio de servicio<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='sm_serviceDoor' />
                                <div class="error-container">
                                    <flux:error name="sm_serviceDoor" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <flux:label>Ventaneria<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='sm_windows' />
                                <div class="error-container">
                                    <flux:error name="sm_windows" />
                                </div>
                            </flux:field>
                        </div>
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Otros (especificar)<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='sm_others' />
                                <div class="error-container">
                                    <flux:error name="sm_others" />
                                </div>
                            </flux:field>
                        </div>

                    </div>
                    @endif














                    {{-- Otros elementos --}}
                    @if ($activeTab === 'otros')
                    <div class="form-container__content">
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Vidriería<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='oe_structure' />
                                <div class="error-container">
                                    <flux:error name="oe_glassworks" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <flux:label>Cerrajería<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='oe_locksmith' />
                                <div class="error-container">
                                    <flux:error name="oe_locksmith" />
                                </div>
                            </flux:field>
                        </div>
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Fachadas<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='oe_facades' />
                                <div class="error-container">
                                    <flux:error name="oe_facades" />
                                </div>
                            </flux:field>
                            <flux:field>
                                <flux:label>Cuenta con elevador<span class="sup-required">*</span></flux:label>
                                <flux:radio.group wire:model="oe_elevator" size="sm">
                                    <flux:radio label="Si cuenta" value="Si cuenta" />
                                    <flux:radio label="No cuenta" value="No cuenta" />
                                </flux:radio.group>
                            </flux:field>
                        </div>

                    </div>
                    @endif

                </div>
            </div>
        </div>





        @else
        <div class="form-container__content">
            <div class="form-grid form-grid--2">
                <flux:field class="flux-field">
                    <flux:label>Resumen<span class="sup-required">*</span></flux:label>
                    <flux:textarea class="h-64" wire:model='summary'/>
                    <div class="error-container">
                        <flux:error name="summary" />
                    </div>
                </flux:field>
            </div>

        @endunless







        {{-- MODAL PARA CREAR NUEVO ELEMENTO --}}
        <flux:modal name="add-element" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Añadir elemento</flux:heading>
                </div>

                <flux:field class="flux-field">
                    <flux:label>Espacio<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='space' />
                    <div class="error-container">
                        <flux:error name="space" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Cantidad<span class="sup-required">*</span></flux:label>
                    <flux:input type="number" wire:model='amount' />
                    <div class="error-container">
                        <flux:error name="amount" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Pisos<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='floors' />
                    <div class="error-container">
                        <flux:error name="floors" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Muros<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='walls' />
                    <div class="error-container">
                        <flux:error name="walls" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Plafones<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='ceilings' />
                    <div class="error-container">
                        <flux:error name="ceilings" />
                    </div>
                </flux:field>

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="button" wire:click='addItem' class="btn-primary btn-table cursor-pointer">Crear
                        elemento
                    </flux:button>
                </div>
            </div>
        </flux:modal>



        {{-- MODAL PARA EDITAR ELEMENTO --}}
        <flux:modal name="edit-element" class="md:w-96">
            <div class="space-y-6">
                <div>
                    <flux:heading size="lg">Editar elemento</flux:heading>
                </div>
                <flux:field class="flux-field">
                    <flux:label>Espacio<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='space' />
                    <div class="error-container">
                        <flux:error name="space" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Cantidad<span class="sup-required">*</span></flux:label>
                    <flux:input type="number" wire:model='amount' />
                    <div class="error-container">
                        <flux:error name="amount" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Pisos<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='floors' />
                    <div class="error-container">
                        <flux:error name="floors" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Muros<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='walls' />
                    <div class="error-container">
                        <flux:error name="walls" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Plafones<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='ceilings' />
                    <div class="error-container">
                        <flux:error name="ceilings" />
                    </div>
                </flux:field>

                <div class="flex">
                    <flux:spacer />

                    <flux:button type="button" wire:click='editItem' class="btn-primary btn-table cursor-pointer">Editar
                        elemento</flux:button>
                </div>
            </div>
        </flux:modal>





        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
    </form>
</div>
