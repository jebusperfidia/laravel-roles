<div>
    <form wire:submit="save">
        <div class="form-container">
            <div class="form-container__header">
                Elementos de la construcción
            </div>
            <div class="form-container__content">
                <div class="flex flex-col w-full h-full">

                    {{-- Navbar responsivo con hamburguesa --}}
                    <div x-data="{ open: false }" class="w-full">
                        @php
                        $tabs = [
                        'obra_negra' => 'Obra negra',
                        'acabados1' => 'Acabados 1',
                        'acabados2' => 'Acabados 2',
                        'carpinteria' => 'Carpintería',
                        'hidraulicas' => 'Hidráulicas y sanitarias',
                        'herreria' => 'Herrería',
                        'otros' => 'Otros elementos',
                        ];
                        $lastKey = array_key_last($tabs);
                        @endphp

                        {{-- Navbar para pantallas grandes (≥950px) --}}
                        <flux:navbar class="hidden xl:flex bg-white border-b-2">
                            @foreach ($tabs as $key => $label)
                            <flux:navbar.item wire:click.prevent="setTab('{{ $key }}')"
                                :active="$activeTab === '{{ $key }}'" class="cursor-pointer px-4 py-2 transition-colors
                                    {{ $activeTab === $key
                                        ? 'border-b-2 border-[#43A497] text-[#3A8B88] font-semibold'
                                        : 'text-gray-600 hover:text-[#5CBEB4]' }}">
                                {{ $label }}
                            </flux:navbar.item>

                            @if ($key !== $lastKey)
                            <span class="text-gray-300 select-none self-center">•</span>
                            @endif
                            @endforeach
                        </flux:navbar>

                        {{-- Menú hamburguesa para pantallas pequeñas (<950px) --}} <div
                            class="xl:hidden flex justify-end p-4 bg-white border-b-2">
                            {{-- <span class="text-lg font-semibold text-[#3A8B88]">Opciones</span> --}}
                            <button type="button" @click="open = !open" class="text-[#000000] focus:outline-none cursor-pointer">
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
                            <li>
                                <button type="button" wire:click.prevent="setTab('{{ $key }}')" @click="open = false" class="cursor-pointer w-full text-left px-4 py-3 transition-colors
                                            {{ $activeTab === $key
                                                ? 'border-l-4 border-[#43A497] bg-[#F0FDFD] text-[#3A8B88] font-semibold'
                                                : 'text-gray-700 hover:bg-gray-100' }}">
                                    {{ $label }}
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
                                        <th class="w-[90px] px-2 py-1 border">Cantidad<span
                                                class="sup-required">*</span></th>
                                        <th class="w-[28%] px-2 py-1 border">Pisos<span class="sup-required">*</span>
                                        </th>
                                        <th class="w-[28%] px-2 py-1 border">Muros<span class="sup-required">*</span>
                                        </th>
                                        <th class="w-[28%] px-2 py-1 border">Plafones<span class="sup-required">*</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- hall --}}
                                    <tr>
                                        <td class="px-2 py-1 border text-sm text-center">Sala</td>
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
                                        <td class="px-2 py-1 border text-sm text-center">Estancia / comedor</td>
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
                                        <td class="px-2 py-1 border text-sm text-center">Cocina</td>
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
                                                <flux:select wire:model="fn1_bedroomsNumber"
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
                                           {{--  <div class="error-container">
                                                <flux:error name="fn1_bedroomsNumber" />
                                            </div> --}}
                                        </td>
                                        <td class="px-2 py-1 border text-sm">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_bedroomsFlats' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_bedroomsFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_bedroomsWalls' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_bedroomsWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_bedroomsCeilings' />
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
                                                <flux:select wire:model="fn1_bathroomsNumber"
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
                                                <flux:textarea wire:model='fn1_bathroomsFlats' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_bathroomsFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_bathroomsWalls' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_bathroomsWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_bathroomsCeilings' />
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
                                                <flux:select wire:model="fn1_halfBathroomsNumber"
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
                                                <flux:textarea wire:model='fn1_halfBathroomsFlats' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_halfBathroomsFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_halfBathroomsWalls' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_halfBathroomsWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_halfBathroomsCeilings' />
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
                                                <flux:select wire:model="fn1_copaNumber"
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
                                                <flux:textarea wire:model='fn1_copaFlats' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_copaFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_copaWalls' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_copaWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_copaCeilings' />
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
                                                <flux:select wire:model="fn1_unpaNumber"
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
                                                <flux:textarea wire:model='fn1_unpaFlats' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_unpaFlats" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_unpaWalls' />
                                                <div class="error-container">
                                                    <flux:error name="fn1_unpaWalls" />
                                                </div>
                                            </flux:field>
                                        </td>
                                        <td class="px-2 py-1 border">
                                            <flux:field class="flux_field pt-8">
                                                <flux:textarea wire:model='fn1_unpaCeilings' />
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











                    {{-- MODAL PARA EDITAR ELEMENTO --}}
                    <flux:modal name="edit-construction" class="md:w-96">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Añadir elemento</flux:heading>
                            </div>

                            <flux:input label="Name" placeholder="Your name" />

                            <flux:input label="Date of birth" type="date" />

                            <div class="flex">
                                <flux:spacer />

                                <flux:button type="submit" class="btn-primary btn-table" variant="primary">Guardar</flux:button>
                            </div>
                        </div>
                    </flux:modal>


                    {{-- MODAL PARA CREAR NUEVO ELEMENTO --}}
                    <flux:modal name="add-construction" class="md:w-96">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Añadir elemento</flux:heading>
                            </div>

                            <flux:input label="Name" placeholder="Your name" />

                            <flux:input label="Date of birth" type="date" />

                            <div class="flex">
                                <flux:spacer />

                                <flux:button type="submit" class="btn-primary btn-table" variant="primary">Guardar</flux:button>
                            </div>
                        </div>
                    </flux:modal>


                    <div class="mt-8">
                        <h3>Si el inmueble cuenta con más espacios no listados en la tabla anterior, por favor agregarlos en la siguiente tabla:</h3>
                    </div>

                    {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                    <flux:modal.trigger name="add-construction" class="flex justify-end">
                        <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"></flux:button>
                    </flux:modal.trigger>

                    {{-- Tabla otros acabados  --}}
                    <div class="mt-8">
                            <div class="overflow-x-auto max-w-full">
                                <table class="min-w-[550px] table-fixed w-full border-2 ">
                                    <thead>
                                        <tr class="bg-gray-100">
                                            <th class="px-2 py-1 border whitespace-nowrap">Espacio</th>
                                            <th class="w-[16%] px-2 py-1 border whitespace-nowrap">cantidad<span
                                                    class="sup-required">*</span>
                                            </th>
                                            <th class="w-[20%] px-2 py-1 border">Pisos<span class="sup-required">*</span>
                                            </th>
                                            <th class="w-[20%] px-2 py-1 border">Muros<span class="sup-required">*</span>
                                            </th>
                                            <th class="w-[20%] px-2 py-1 border">Plafones<span
                                                    class="sup-required">*</span>
                                            </th>
                                            <th class="w-[12%] py-1 border">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        {{-- Valor de ejemplo para usar en los for --}}
                                        <tr>
                                            <td class="px-2 py-1 border text-xs text-center">Casa habitación
                                            </td>
                                            <td class="px-2 py-1 border text-xs text-center">
                                                <span>7. Residencial plus</span><br>
                                                <span>6. Lujo</span>
                                            </td>
                                            <td class="px-2 py-1 border text-sm text-center">H</td>
                                            <td class="px-2 py-1 border text-sm text-center">1</td>
                                            <td class="px-2 py-1 border text-sm text-center">1</td>


                                            <td class="my-2 flex justify-evenly">
                                                <flux:modal.trigger name="edit-construction" class="flex justify-end">
                                                    <flux:button type="button" icon-leading="pencil"
                                                        class="cursor-pointer btn-intermediary btn-buildins" />
                                                    </flux:modal-trigger>
                                                    <flux:modal.trigger name="edit-construction" class="flex justify-end">
                                                        <flux:button type="button" icon-leading="trash"
                                                            class="cursor-pointer btn-deleted btn-buildings" />
                                                </flux:modal-trigger>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif


































                    {{-- Acabados 2 --}}
                    @if ($activeTab === 'acabados2')
                    <div class="form-container__content">
                        <div class="form-grid form-grid--2">
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
                        </div>
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Lambrines<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_furredWalls' />
                                <div class="error-container">
                                    <flux:error name="fn2_furredWalls" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <flux:label>Escaleras<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_stairs' />
                                <div class="error-container">
                                    <flux:error name="fn2_stairs" />
                                </div>
                            </flux:field>
                        </div>
                        <div class="form-grid form-grid--2">
                            <flux:field class="flux_field pt2">
                                <flux:label>Pisos<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_flats' />
                                <div class="error-container">
                                    <flux:error name="fn2_flats" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <flux:label>Zoclos<span class="sup-required">*</span></flux:label>
                                <flux:textarea wire:model='fn2_plinths' />
                                <div class="error-container">
                                    <flux:error name="fn2_plinths" />
                                </div>
                            </flux:field>
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
                                    <div>
                                        <flux:radio.group class="flex justify-end items-baseline gap-2"
                                            wire:model="hs_hiddenApparentHydraulicBranches" size="sm">
                                            <flux:radio label="Oculta" value="Oculta" />
                                            <flux:radio label="Aparente" value="Aparente" />
                                        </flux:radio.group>
                                    </div>
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
                                    <div>
                                        <flux:radio.group class="flex justify-end items-baseline gap-2"
                                            wire:model="hs_hiddenApparentSanitaryBranches" size="sm">
                                            <flux:radio label="Oculta" value="Oculta" />
                                            <flux:radio label="Aparente" value="Aparente" />
                                        </flux:radio.group>
                                    </div>
                                </div>
                                <flux:textarea wire:model='hs_SanitaryBranches' />
                                <div class="error-container">
                                    <flux:error name="hs_SanitaryBranches" />
                                </div>
                            </flux:field>
                            <flux:field class="flux_field pt2">
                                <div class="flex justify-between mb-3">
                                    <flux:label>Eléctricas<span class="sup-required">*</span></flux:label>
                                    <div>
                                        <flux:radio.group class="flex justify-end items-baseline gap-2"
                                            wire:model="hs_hiddenApparentElectrics" size="sm">
                                            <flux:radio label="Oculta" value="Oculta" />
                                            <flux:radio label="Aparente" value="Aparente" />
                                        </flux:radio.group>
                                    </div>
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

        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
    </form>
</div>
