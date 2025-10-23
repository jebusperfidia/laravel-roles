<div>
{{--     <form wire:submit=''> --}}


        <div class="form-container">
            <div class="form-container__header">
                Instalaciones especiales
            </div>
            <div class="form-container__content">

                {{-- Navbar responsivo con hamburguesa --}}
                <div x-data="{ open: false }" class="w-full">
                    @php
                    $tabs = [
                    'privativas' => 'Privativas',
                    /* 'comunes' => 'Comunes', */
                    ];

                    if(stripos($valuation->property_type, 'condominio')){
                    $tabs = array_merge($tabs, ['comunes' => 'Comunes']);
                    }

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
                            <span class="text-[16px]">{{ $label }}</span>
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





                @if ($activeTab === 'privativas')




                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Instalaciones especiales</h2>
                </div>

                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                {{-- <flux:modal.trigger name="add-construction" class="flex justify-end"> --}}
                    <div class="flex justify-end">
                        <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"
                            wire:click="openAddElement('private','installations')"></flux:button>
                    </div>
                    {{--
                </flux:modal.trigger> --}}

                {{-- TABLA DE ELEMENTOS --}}
                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 border">Clave</th>
                                    <th class="px-2 py-1 border">Descripcion</th>
                                    <th class="px-2 py-1 border">Unidad</th>
                                    <th class="px-2 py-1 border">Cantidad</th>
                                    <th class="px-2 py-1 border">Edad</th>
                                    <th class="px-2 py-1 border">Vida útil</th>
                                    <th class="px-2 py-1 border">Costo unit rep nuevo</th>
                                    <th class="px-2 py-1 border">Factor de edad</th>
                                    <th class="px-2 py-1 border">Factor de conservación</th>
                                    <th class="px-2 py-1 border">Costo unit neto rep</th>
                                    <th class="px-2 py-1 border">%indiviso</th>
                                    <th class="px-2 py-1 border">Importe</th>
                                    <th class="w-[100px] py-1 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                @if ($privateInstallations->isEmpty())
                                <tr>
                                    <td colspan="18" class="px-2 py-4 text-center text-gray-500">
                                        No hay elementos registrados
                                    </td>
                                </tr>
                                @else
                                @foreach ($privateInstallations as $item)
                                <tr>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->key}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">

                                        {{ $item->key . ' - ' . ($item->description ?: $item->description_other) }}
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->unit}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{number_format($item->quantity)}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->age}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->useful_life}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">${{number_format($item->new_rep_unit_cost, 4)}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->age_factor}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->conservation_factor}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">${{number_format($item->net_rep_unit_cost, 4)}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">N/A</td>
                                    <td class="px-2 py-1 border text-sm text-center">${{number_format($item->amount, 4)}}</td>
                                    <td class="my-2 flex justify-evenly">
                                        {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins"
                                                wire:click="openEditElement('private','installations',{{$item->id}})" />
                                            {{-- </flux:modal-trigger> --}}
                                            {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end">
                                                --}}
                                                <flux:button
                                                    onclick="confirm('¿Estás seguro de que deseas eliminar este elemento?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteElement('private','installations',{{$item->id}})" icon-leading="trash"
                                                    class="cursor-pointer btn-deleted btn-buildings" />
                                                {{-- </flux:modal-trigger> --}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Elementos accesorios</h2>
                </div>
                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                <div class="flex justify-end">
                    <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"
                        wire:click="openAddElement('private','accessories')">
                    </flux:button>
                </div>


                {{-- TABLA DE ELEMENTOS --}}
                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 border">Clave</th>
                                    <th class="px-2 py-1 border">Descripcion</th>
                                    <th class="px-2 py-1 border">Unidad</th>
                                    <th class="px-2 py-1 border">Cantidad</th>
                                    <th class="px-2 py-1 border">Edad</th>
                                    <th class="px-2 py-1 border">Vida útil</th>
                                    <th class="px-2 py-1 border">Costo unit rep nuevo</th>
                                    <th class="px-2 py-1 border">Factor de edad</th>
                                    <th class="px-2 py-1 border">Factor de conservación</th>
                                    <th class="px-2 py-1 border">Costo unit neto rep</th>
                                    <th class="px-2 py-1 border">%indiviso</th>
                                    <th class="px-2 py-1 border">Importe</th>
                                    <th class="w-[100px] py-1 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                @if ($privateAccessories->isEmpty())
                                <tr>
                                    <td colspan="18" class="px-2 py-4 text-center text-gray-500">
                                        No hay elementos registrados
                                    </td>
                                </tr>
                                @else
                                @foreach ($privateAccessories as $item)
                                <tr>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->key}}</td>
                                   <td class="px-2 py-1 border text-sm text-center">

                                    {{ $item->key . ' - ' . ($item->description ?: $item->description_other) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->unit}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{number_format($item->quantity)}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->age}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->useful_life}}</td>
                                <td class="px-2 py-1 border text-sm text-center">${{number_format($item->new_rep_unit_cost, 4)}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->age_factor}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->conservation_factor}}</td>
                                <td class="px-2 py-1 border text-sm text-center">${{number_format($item->net_rep_unit_cost, 4)}}</td>
                                <td class="px-2 py-1 border text-sm text-center">N/A</td>
                                <td class="px-2 py-1 border text-sm text-center">${{number_format($item->amount, 4)}}</td>
                                    <td class="my-2 flex justify-evenly">
                                        {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins"
                                                wire:click="openEditElement('private','accessories',{{$item->id}})" />
                                            {{-- </flux:modal-trigger> --}}
                                            {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end">
                                                --}}
                                                <flux:button
                                                    onclick="confirm('¿Estás seguro de que deseas eliminar este elemento?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteElement('private','accessories',{{$item->id}})" icon-leading="trash"
                                                    class="cursor-pointer btn-deleted btn-buildings" />
                                                {{-- </flux:modal-trigger> --}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Obras complementarias</h2>
                </div>

                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                {{-- <flux:modal.trigger name="add-construction" class="flex justify-end"> --}}
                    <div class="flex justify-end">
                        <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"
                            wire:click="openAddElement('private','works')">
                        </flux:button>
                    </div>
                    {{--
                </flux:modal.trigger> --}}

                {{-- TABLA DE ELEMENTOS --}}
                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 border">Clave</th>
                                    <th class="px-2 py-1 border">Descripcion</th>
                                    <th class="px-2 py-1 border">Unidad</th>
                                    <th class="px-2 py-1 border">Cantidad</th>
                                    <th class="px-2 py-1 border">Edad</th>
                                    <th class="px-2 py-1 border">Vida útil</th>
                                    <th class="px-2 py-1 border">Costo unit rep nuevo</th>
                                    <th class="px-2 py-1 border">Factor de edad</th>
                                    <th class="px-2 py-1 border">Factor de conservación</th>
                                    <th class="px-2 py-1 border">Costo unit neto rep</th>
                                    <th class="px-2 py-1 border">%indiviso</th>
                                    <th class="px-2 py-1 border">Importe</th>
                                    <th class="w-[100px] py-1 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                @if ($privateWorks->isEmpty())
                                <tr>
                                    <td colspan="18" class="px-2 py-4 text-center text-gray-500">
                                        No hay elementos registrados
                                    </td>
                                </tr>
                                @else
                                @foreach ($privateWorks as $item)
                                <tr>
                                  <td class="px-2 py-1 border text-sm text-center">{{$item->key}}</td>
                               <td class="px-2 py-1 border text-sm text-center">

                                {{ $item->key . ' - ' . ($item->description ?: $item->description_other) }}
                            </td>
                            <td class="px-2 py-1 border text-sm text-center">{{$item->unit}}</td>
                            <td class="px-2 py-1 border text-sm text-center">{{number_format($item->quantity)}}</td>
                            <td class="px-2 py-1 border text-sm text-center">{{$item->age}}</td>
                            <td class="px-2 py-1 border text-sm text-center">{{$item->useful_life}}</td>
                            <td class="px-2 py-1 border text-sm text-center">${{number_format($item->new_rep_unit_cost, 4)}}</td>
                            <td class="px-2 py-1 border text-sm text-center">{{$item->age_factor}}</td>
                            <td class="px-2 py-1 border text-sm text-center">{{$item->conservation_factor}}</td>
                            <td class="px-2 py-1 border text-sm text-center">${{number_format($item->net_rep_unit_cost, 4)}}</td>
                            <td class="px-2 py-1 border text-sm text-center">N/A</td>
                            <td class="px-2 py-1 border text-sm text-center">${{number_format($item->amount, 4)}}</td>
                                    <td class="my-2 flex justify-evenly">
                                        {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins"
                                                wire:click="openEditElement('private','works',{{$item->id}})" />
                                            {{-- </flux:modal-trigger> --}}
                                            {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end">
                                                --}}
                                                <flux:button
                                                    onclick="confirm('¿Estás seguro de que deseas eliminar este elemento?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteElement('private','works',{{$item->id}})" type="button" icon-leading="trash"
                                                    class="cursor-pointer btn-deleted btn-buildings" />
                                                {{-- </flux:modal-trigger> --}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>



                @endif



                @if ($activeTab === 'comunes')

                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Instalaciones especiales</h2>
                </div>

                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                <div class="flex justify-end">
                    <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"
                        wire:click="openAddElement('common','installations')">
                    </flux:button>
                </div>

                {{-- TABLA DE ELEMENTOS --}}
                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 border">Clave</th>
                                    <th class="px-2 py-1 border">Descripcion</th>
                                    <th class="px-2 py-1 border">Unidad</th>
                                    <th class="px-2 py-1 border">Cantidad</th>
                                    <th class="px-2 py-1 border">Edad</th>
                                    <th class="px-2 py-1 border">Vida útil</th>
                                    <th class="px-2 py-1 border">Costo unit rep nuevo</th>
                                    <th class="px-2 py-1 border">Factor de edad</th>
                                    <th class="px-2 py-1 border">Factor de conservación</th>
                                    <th class="px-2 py-1 border">Costo unit neto rep</th>
                                    <th class="px-2 py-1 border">%indiviso</th>
                                    <th class="px-2 py-1 border">Importe</th>
                                    <th class="w-[100px] py-1 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                @if ($commonInstallations->isEmpty())
                                <tr>
                                    <td colspan="18" class="px-2 py-4 text-center text-gray-500">
                                        No hay elementos registrados
                                    </td>
                                </tr>
                                @else
                                @foreach ($commonInstallations as $item)
                                <tr>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->key}}</td>
                                <td class="px-2 py-1 border text-sm text-center">

                                    {{ $item->key . ' - ' . ($item->description ?: $item->description_other) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->unit}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{number_format($item->quantity)}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->age}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->useful_life}}</td>
                                <td class="px-2 py-1 border text-sm text-center">${{number_format($item->new_rep_unit_cost, 4)}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->age_factor}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->conservation_factor}}</td>
                                <td class="px-2 py-1 border text-sm text-center">${{number_format($item->net_rep_unit_cost, 4)}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->undivided}} %</td>
                                <td class="px-2 py-1 border text-sm text-center">${{number_format($item->amount, 4)}}</td>
                                    <td class="my-2 flex justify-evenly">
                                        {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins"
                                                wire:click="openEditElement('common','installations',{{$item->id}})" />
                                            {{-- </flux:modal-trigger> --}}
                                            {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end">
                                                --}}
                                                <flux:button
                                                    onclick="confirm('¿Estás seguro de que deseas eliminar este elemento?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteElement('common','installations',{{$item->id}})" type="button" icon-leading="trash"
                                                    class="cursor-pointer btn-deleted btn-buildings" />
                                                {{-- </flux:modal-trigger> --}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Elementos accesorios</h2>
                </div>


                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                <div class="flex justify-end">
                    <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"
                        wire:click="openAddElement('common','accessories')">
                    </flux:button>
                </div>

                {{-- TABLA DE ELEMENTOS --}}
                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 border">Clave</th>
                                    <th class="px-2 py-1 border">Descripcion</th>
                                    <th class="px-2 py-1 border">Unidad</th>
                                    <th class="px-2 py-1 border">Cantidad</th>
                                    <th class="px-2 py-1 border">Edad</th>
                                    <th class="px-2 py-1 border">Vida útil</th>
                                    <th class="px-2 py-1 border">Costo unit rep nuevo</th>
                                    <th class="px-2 py-1 border">Factor de edad</th>
                                    <th class="px-2 py-1 border">Factor de conservación</th>
                                    <th class="px-2 py-1 border">Costo unit neto rep</th>
                                    <th class="px-2 py-1 border">%indiviso</th>
                                    <th class="px-2 py-1 border">Importe</th>
                                    <th class="w-[100px] py-1 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                @if ($commonAccessories->isEmpty())
                                <tr>
                                    <td colspan="18" class="px-2 py-4 text-center text-gray-500">
                                        No hay elementos registrados
                                    </td>
                                </tr>
                                @else
                                @foreach ($commonAccessories as $item)
                                <tr>
                                   <td class="px-2 py-1 border text-sm text-center">{{$item->key}}</td>
                                <td class="px-2 py-1 border text-sm text-center">

                                    {{ $item->key . ' - ' . ($item->description ?: $item->description_other) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->unit}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{number_format($item->quantity)}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->age}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->useful_life}}</td>
                                <td class="px-2 py-1 border text-sm text-center">${{number_format($item->new_rep_unit_cost, 4)}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->age_factor}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->conservation_factor}}</td>
                                <td class="px-2 py-1 border text-sm text-center">${{number_format($item->net_rep_unit_cost, 4)}}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{$item->undivided}} %</td>
                                <td class="px-2 py-1 border text-sm text-center">${{number_format($item->amount, 4)}}</td>
                                    <td class="my-2 flex justify-evenly">
                                        {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins"
                                                wire:click="openEditElement('common','accessories',{{$item->id}})" />
                                            {{-- </flux:modal-trigger> --}}
                                            {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end">
                                                --}}
                                                <flux:button
                                                    onclick="confirm('¿Estás seguro de que deseas eliminar este elemento?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteElement('common','accessories',{{$item->id}})" type="button" icon-leading="trash"
                                                    class="cursor-pointer btn-deleted btn-buildings" />
                                                {{-- </flux:modal-trigger> --}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Obras complementarias</h2>
                </div>

                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                <div class="flex justify-end">
                    <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"
                        wire:click="openAddElement('common','works')">
                    </flux:button>
                </div>
                {{-- TABLA DE ELEMENTOS --}}
                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 border">Clave</th>
                                    <th class="px-2 py-1 border">Descripcion</th>
                                    <th class="px-2 py-1 border">Unidad</th>
                                    <th class="px-2 py-1 border">Cantidad</th>
                                    <th class="px-2 py-1 border">Edad</th>
                                    <th class="px-2 py-1 border">Vida útil</th>
                                    <th class="px-2 py-1 border">Costo unit rep nuevo</th>
                                    <th class="px-2 py-1 border">Factor de edad</th>
                                    <th class="px-2 py-1 border">Factor de conservación</th>
                                    <th class="px-2 py-1 border">Costo unit neto rep</th>
                                    <th class="px-2 py-1 border">%indiviso</th>
                                    <th class="px-2 py-1 border">Importe</th>
                                    <th class="w-[100px] py-1 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                @if ($commonWorks->isEmpty())
                                <tr>
                                    <td colspan="18" class="px-2 py-4 text-center text-gray-500">
                                        No hay elementos registrados
                                    </td>
                                </tr>
                                @else
                                @foreach ($commonWorks as $item)
                                <tr>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->key}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">

                                        {{ $item->key . ' - ' . ($item->description ?: $item->description_other) }}
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->unit}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{number_format($item->quantity)}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->age}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->useful_life}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">${{number_format($item->new_rep_unit_cost, 4)}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->age_factor}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->conservation_factor}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">${{number_format($item->net_rep_unit_cost, 4)}}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{$item->undivided}} %</td>
                                    <td class="px-2 py-1 border text-sm text-center">${{number_format($item->amount, 4)}}</td>
                                    <td class="my-2 flex justify-evenly">
                                        {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins"
                                                wire:click="openEditElement('common','works',{{$item->id}})" />
                                            {{-- </flux:modal-trigger> --}}
                                            {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end">
                                                --}}
                                                <flux:button
                                                    onclick="confirm('¿Estás seguro de que deseas eliminar este elemento?') || event.stopImmediatePropagation()"
                                                    wire:click="deleteElement('common','works',{{$item->id}})" type="button" icon-leading="trash"
                                                    class="cursor-pointer btn-deleted btn-buildings" />
                                                {{-- </flux:modal-trigger> --}}
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif



                <div class="mt-[64px] form-grid form-grid--2-center">
                    <div class="overflow-x-auto">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-2 "></th>
                                    <th class="px-2 py-2 ">Privativas</th>
                                    <th class="px-2 py-2 ">Comunes</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                <tr>
                                    <td class="px-2 py-2 text-xs text-center">Importe total instalaciones especiales:
                                    </td>
                                    <td class="px-2 py-2 text-xs text-center">{{number_format($subTotalPrivateInstallations,4)}}</td>
                                    <td class="px-2 py-2 text-xs text-center">{{number_format($subTotalCommonInstallations,4)}}</td>
                                </tr>

                                <tr>
                                    <td class="px-2 py-2 text-xs text-center">Importe total elementos accesorios:</td>
                                    <td class="px-2 py-2 text-xs text-center">{{number_format($subTotalPrivateAccessories,4)}}</td>
                                    <td class="px-2 py-2 text-xs text-center">{{number_format($subTotalCommonAccessories,4)}}</td>
                                </tr>

                                <tr>
                                    <td class="px-2 py-2 text-xs text-center">Importe total obras complementarias:</td>
                                    <td class="px-2 py-2 text-xs text-center">{{number_format($subTotalPrivateWorks,4)}}</td>
                                    <td class="px-2 py-2 text-xs text-center">{{number_format($subTotalCommonWorks,4)}}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



               <div class="mt-[64px] form-grid form-grid--2-center">
                    <div class="overflow-x-auto">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-2 "></th>
                                    <th class="px-2 py-2 ">Privativas</th>
                                    <th class="px-2 py-2 ">Comunes</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                <tr>
                                    <td class="px-2 py-2 text-xs text-center">Importe Total:
                                        (Inst. Especiales, Obras Comp. y Elem. Accesorios)</td>
                                    <td class="px-2 py-2 text-xs text-center">{{number_format($totalPrivateInstallations,4)}}</td>
                                    <td class="px-2 py-2 text-xs text-center">{{number_format($totalCommonInstallations, 4)}}</td>
                                </tr>

                                <tr>
                                    <td class="px-2 py-2 text-xs text-center">Importe PRO INDIVISO:
                                        (Inst. Especiales, Obras Comp. y Elem. Accesorios)</td>
                                    <td class="px-2 py-2 text-xs text-center">No aplica</td>
                                    <td class="px-2 py-2 text-xs text-center">{{number_format($totalCommonProportional,4)}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>


            </div>
        </div>
</div>



<flux:button class="mt-4 cursor-pointer btn-primary" variant="primary" wire:click='nextComponent'>Continuar
</flux:button>


{{-- MODALES PARA INSTALACIONES ESPECIALES --}}

{{-- AHORA SERÁ EL MODAL PRINCIPAL PARA EDITAR TODOS LOS ELEMENTOS --}}

{{-- MODAL PARA EDITAR ELEMENTO --}}
<flux:modal name="edit-element" class="md:w-96">
    <div class="space-y-6">
        <div>
            @if($elementType === 'installations')
            <flux:heading size="lg">Instalaciones especiales</flux:heading>
            @endif
            @if($elementType === 'accessories')
            <flux:heading size="lg">Elementos accesorios</flux:heading>
            @endif
            @if($elementType === 'works')
            <flux:heading size="lg">Obras complementarias</flux:heading>
            @endif
            <flux:subheading size="lg">Editar elemento</flux:subheading>
        </div>
        <flux:spacer />

        @if($elementType === 'installations')
        {{-- Inicia --}}
        <div class="relative inline-block w-full">
            <div class="pb-2">
                <flux:label>Descripción</flux:label>
            </div>
            <flux:dropdown inline position="bottom" align="start" class="w-full">

                {{-- BOTÓN --}}
                <button @click.stop.prevent
                    @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                    , 'border border-gray-300 text-gray-700 hover:border-gray-400'=> !$errors->has('descriptionSI'),
                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500' =>
                    $errors->has('descriptionSI'),
                    ])>
                    <!-- CAMBIO 1: Se agregó la clase 'truncate' para cortar el texto si es muy largo -->
                    <span class="flex-1 text-left text-gray-700 truncate">
                        @if($descriptionSI)
                        {{ $descriptionSI}} –
                        {{ collect($select_SI)->firstWhere('clave', $descriptionSI)['descripcion'] }}
                        @else
                        -- Selecciona una opción --
                        @endif
                    </span>
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w-3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- MENÚ --}}
                <!-- CAMBIO 2: Se cambió w-3/5 por w-full para que el menú ocupe todo el ancho por defecto -->
                <flux:menu
                    class="absolute left-0 top-full mt-1 md:w-96 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                    <flux:menu.item disabled>
                        <div class="w-full grid grid-cols-[30%_70%] px-2 py-1 text-gray-600 font-medium">
                            <span>Clave</span>
                            <span>Descripción</span>
                        </div>
                    </flux:menu.item>
                    <flux:menu.separator />

                    {{-- “Ninguno” --}}
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionSI','')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">0</span>
                            <span class="text-left">Ninguna</span>
                        </div>
                    </flux:menu.item>

                    @foreach($select_SI as $item)
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionSI','{{ $item['clave'] }}')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized {{ $descriptionSI == $item['clave'] ? 'bg-gray-100' : '' }}">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">{{ $item['clave'] }}</span>
                            <span class="text-left">{{ $item['descripcion'] }}</span>
                        </div>
                    </flux:menu.item>
                    @endforeach

                </flux:menu>
            </flux:dropdown>
            <div>
                <flux:error name="descriptionSI" />
            </div>
            {{-- {{$descriptionSI}} --}}
        </div>
        {{-- Finaliza --}}
        @endif












        @if($elementType === 'accessories')
        {{-- Inicia --}}
        <div class="relative inline-block w-full">
            <div class="pb-2">
                <flux:label>Descripción</flux:label>
            </div>
            <flux:dropdown inline position="bottom" align="start" class="w-full">

                {{-- BOTÓN --}}
                <button @click.stop.prevent
                    @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                    , 'border border-gray-300 text-gray-700 hover:border-gray-400'=> !$errors->has('descriptionSI'),
                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500' =>
                    $errors->has('descriptionSI'),
                    ])>
                    <!-- CAMBIO 1: Se agregó la clase 'truncate' para cortar el texto si es muy largo -->
                    <span class="flex-1 text-left text-gray-700 truncate">
                        @if($descriptionAE)
                        {{ $descriptionAE}} –
                        {{ collect($select_AE)->firstWhere('clave', $descriptionAE)['descripcion'] }}
                        @else
                        -- Selecciona una opción --
                        @endif
                    </span>
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w-3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- MENÚ --}}
                <!-- CAMBIO 2: Se cambió w-3/5 por w-full para que el menú ocupe todo el ancho por defecto -->
                <flux:menu
                    class="absolute left-0 top-full mt-1 md:w-96 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                    <flux:menu.item disabled>
                        <div class="w-full grid grid-cols-[30%_70%] px-2 py-1 text-gray-600 font-medium">
                            <span>Clave</span>
                            <span>Descripción</span>
                        </div>
                    </flux:menu.item>
                    <flux:menu.separator />

                    {{-- “Ninguno” --}}
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionAE','')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">0</span>
                            <span class="text-left">Ninguna</span>
                        </div>
                    </flux:menu.item>

                    @foreach($select_AE as $item)
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionAE','{{ $item['clave'] }}')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized {{ $descriptionAE == $item['clave'] ? 'bg-gray-100' : '' }}">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">{{ $item['clave'] }}</span>
                            <span class="text-left">{{ $item['descripcion'] }}</span>
                        </div>
                    </flux:menu.item>
                    @endforeach

                </flux:menu>
            </flux:dropdown>
            <div>
                <flux:error name="descriptionAE" />
            </div>
        </div>
        @endif








        @if($elementType === 'works')
        {{-- Inicia --}}
        <div class="relative inline-block w-full">
            <div class="pb-2">
                <flux:label>Descripción</flux:label>
            </div>
            <flux:dropdown inline position="bottom" align="start" class="w-full">

                {{-- BOTÓN --}}
                <button @click.stop.prevent
                    @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                    , 'border border-gray-300 text-gray-700 hover:border-gray-400'=> !$errors->has('descriptionSI'),
                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500' =>
                    $errors->has('descriptionSI'),
                    ])>
                    <!-- CAMBIO 1: Se agregó la clase 'truncate' para cortar el texto si es muy largo -->
                    <span class="flex-1 text-left text-gray-700 truncate">
                        @if($descriptionCW)
                        {{ $descriptionCW}} –
                        {{ collect($select_CW)->firstWhere('clave', $descriptionCW)['descripcion'] }}
                        @else
                        -- Selecciona una opción --
                        @endif
                    </span>
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w-3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- MENÚ --}}
                <!-- CAMBIO 2: Se cambió w-3/5 por w-full para que el menú ocupe todo el ancho por defecto -->
                <flux:menu
                    class="absolute left-0 top-full mt-1 md:w-96 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                    <flux:menu.item disabled>
                        <div class="w-full grid grid-cols-[30%_70%] px-2 py-1 text-gray-600 font-medium">
                            <span>Clave</span>
                            <span>Descripción</span>
                        </div>
                    </flux:menu.item>
                    <flux:menu.separator />

                    {{-- “Ninguno” --}}
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionCW','')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">0</span>
                            <span class="text-left">Ninguna</span>
                        </div>
                    </flux:menu.item>

                    @foreach($select_CW as $item)
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionCW','{{ $item['clave'] }}')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized {{ $descriptionCW == $item['clave'] ? 'bg-gray-100' : '' }}">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">{{ $item['clave'] }}</span>
                            <span class="text-left">{{ $item['descripcion'] }}</span>
                        </div>
                    </flux:menu.item>
                    @endforeach

                </flux:menu>
            </flux:dropdown>
            <div>
                <flux:error name="descriptionCW" />
            </div>
        </div>
        {{-- Finaliza --}}

        @endif

        @if ($descriptionSI === 'IE19' || $descriptionAE === 'EA12' || $descriptionCW === 'OC17')

        <flux:field class="flux-field pt-4 pb-[-10px]">
            <flux:label>Agregar otra descripción</flux:label>
            <flux:input type="text" wire:model='descriptionOther' />
            <div class="error-container">
                <flux:error name="descriptionOther" />
            </div>
        </flux:field>
        @endif


        <flux:field class="flux-field pt-4">
            <flux:label>Unidad</flux:label>
            <flux:select wire:model.live="unit" class="text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="a">-- Selecciona una opción --</flux:select.option>
                @foreach ($select_units as $value => $label)
                <flux:select.option value="{{ $label }}">
                    {{ $label }}
                </flux:select.option>
                @endforeach
            </flux:select>
            <div class="error-container">
                <flux:error name="unit" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Cantidad</flux:label>
            <flux:input type="number" wire:model='quantity' />
            <div class="error-container">
                <flux:error name="quantity" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Edad<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='age' />
            <div class="error-container">
                <flux:error name="age" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Vida útil<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model.live='usefulLife'
          :disabled="!($descriptionSI === 'IE19' || $descriptionAE === 'EA12' || $descriptionCW === 'OC17')"/>
            <div class="error-container">
                <flux:error name="usefulLife" />
            </div>
        </flux:field>
        <flux:field class="flux-field">
            <flux:label>Costo unit rep nuevo<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='newRepUnitCost' />
            <div class="error-container">
                <flux:error name="newRepUnitCost" />
            </div>
        </flux:field>

       {{--  <flux:field class="flux-field">
            <flux:label>Factor de edad<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='ageFactor' />
            <div class="error-container">
                <flux:error name="ageFactor" />
            </div>
        </flux:field>
 --}}

        {{-- Inicia --}}
        <div class="relative inline-block w-full">
            <div class="pb-2">
                <flux:label>Factor conservación</flux:label>
            </div>
            <flux:dropdown inline position="bottom" align="start" class="w-full">

                {{-- BOTÓN --}}
                <button @click.stop.prevent
                    @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                    , 'border border-gray-300 text-gray-700 hover:border-gray-400'=>
                    !$errors->has('conservationFactor'),
                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500' =>
                    $errors->has('conservationFactor'),
                    ])>
                    <!-- CAMBIO 1: Se agregó la clase 'truncate' para cortar el texto si es muy largo -->
                    <span class="flex-1 text-left text-gray-700 truncate">
                        @if($conservationFactor)
                        {{ $conservationFactor}} –
                        {{ collect($select_conservation_factor)->firstWhere('clave', $conservationFactor)['nombre'] }}
                        @else
                        -- Selecciona una opción --
                        @endif
                    </span>
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w-3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- MENÚ --}}
                <!-- CAMBIO 2: Se cambió w-3/5 por w-full para que el menú ocupe todo el ancho por defecto -->
                <flux:menu
                    class="absolute left-0 top-full mt-1 md:w-96 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                    <flux:menu.item disabled>
                        <div class="w-full grid grid-cols-[30%_40%_30%] px-2 py-1 text-gray-600 font-medium">
                            <span>Clave</span>
                            <span>Nombre</span>
                            <span>Factor</span>
                        </div>
                    </flux:menu.item>
                    <flux:menu.separator />

                    {{-- “Ninguno” --}}
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('conservationFactor','')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized">
                        <div class="w-full grid grid-cols-[30%_40%_30%]">
                            <span class="text-left">0</span>
                            <span class="text-left">Ninguna</span>
                            <span class="text-left">Ninguna</span>
                        </div>
                    </flux:menu.item>

                    @foreach($select_conservation_factor as $item)
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('conservationFactor','{{ $item['clave'] }}')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized {{ $conservationFactor == $item['clave'] ? 'bg-gray-100' : '' }}">
                        <div class="w-full grid grid-cols-[30%_40%_30%]">
                            <span class="text-left">{{ $item['clave'] }}</span>
                            <span class="text-left">{{ $item['nombre'] }}</span>
                            <span class="text-left">{{ $item['factor'] }}</span>
                        </div>
                    </flux:menu.item>
                    @endforeach

                </flux:menu>
            </flux:dropdown>
            <div>
                <flux:error name="conservationFactor" />
            </div>
        </div>
        {{-- Finaliza --}}

{{--         <flux:field class="flux-field pt-4">
            <flux:label>Costo Unit Neto Rep<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='netRepUnitCost' />
            <div class="error-container">
                <flux:error name="netRepUnitCost" />
            </div>
        </flux:field> --}}

        @if ($classificationType === 'common')
        <flux:field class="flux-field">
            <flux:label>%Indiviso<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='undivided'/>
            <div class="error-container">
                <flux:error name="undivided" />
            </div>
        </flux:field>
        @endif



      {{--   <flux:field class="flux-field">
            <flux:label>Importe<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='amount' />
            <div class="error-container">
                <flux:error name="amount" />
            </div>
        </flux:field> --}}

        <div class="flex">
            <flux:spacer />

            <flux:button type="button" class="btn-primary btn-table cursor-pointer" variant="primary"
                wire:click='editElement'>Editar elemento
            </flux:button>
        </div>
    </div>
</flux:modal>





{{-- AHORA ESTE SERÁ EL MODAL PRINCIPAL PARA CREAR TODOS LOS ELEMENTOS --}}


{{-- MODAL PARA CREAR NUEVO ELEMENTO --}}
<flux:modal name="add-element" class="md:w-96">
    <div class="space-y-6">
        <div>
            @if($elementType === 'installations')
            <flux:heading size="lg">Instalaciones especiales</flux:heading>
            @endif
            @if($elementType === 'accessories')
            <flux:heading size="lg">Elementos accesorios</flux:heading>
            @endif
            @if($elementType === 'works')
            <flux:heading size="lg">Obras complementarias</flux:heading>
            @endif
            <flux:subheading size="lg">Añadir elemento</flux:subheading>
        </div>

        @if($elementType === 'installations')
        {{-- Inicia --}}
        <div class="relative inline-block w-full">
            <div class="pb-2">
                <flux:label>Descripción</flux:label>
            </div>
            <flux:dropdown inline position="bottom" align="start" class="w-full">

                {{-- BOTÓN --}}
                <button @click.stop.prevent
                    @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                    , 'border border-gray-300 text-gray-700 hover:border-gray-400'=> !$errors->has('descriptionSI'),
                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500' =>
                    $errors->has('descriptionSI'),
                    ])>
                    <!-- CAMBIO 1: Se agregó la clase 'truncate' para cortar el texto si es muy largo -->
                    <span class="flex-1 text-left text-gray-700 truncate">
                        @if($descriptionSI)
                        {{ $descriptionSI}} –
                        {{ collect($select_SI)->firstWhere('clave', $descriptionSI)['descripcion'] }}
                        @else
                        -- Selecciona una opción --
                        @endif
                    </span>
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w-3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- MENÚ --}}
                <!-- CAMBIO 2: Se cambió w-3/5 por w-full para que el menú ocupe todo el ancho por defecto -->
                <flux:menu
                    class="absolute left-0 top-full mt-1 md:w-96 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                    <flux:menu.item disabled>
                        <div class="w-full grid grid-cols-[30%_70%] px-2 py-1 text-gray-600 font-medium">
                            <span>Clave</span>
                            <span>Descripción</span>
                        </div>
                    </flux:menu.item>
                    <flux:menu.separator />

                    {{-- “Ninguno” --}}
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionSI','')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">0</span>
                            <span class="text-left">Ninguna</span>
                        </div>
                    </flux:menu.item>

                    @foreach($select_SI as $item)
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionSI','{{ $item['clave'] }}')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized {{ $descriptionSI == $item['clave'] ? 'bg-gray-100' : '' }}">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">{{ $item['clave'] }}</span>
                            <span class="text-left">{{ $item['descripcion'] }}</span>
                        </div>
                    </flux:menu.item>
                    @endforeach

                </flux:menu>
            </flux:dropdown>
            <div>
                <flux:error name="descriptionSI" />
            </div>
          {{--   {{$descriptionSI}} --}}
        </div>
        {{-- Finaliza --}}
        @endif












        @if($elementType === 'accessories')
        {{-- Inicia --}}
        <div class="relative inline-block w-full">
            <div class="pb-2">
                <flux:label>Descripción</flux:label>
            </div>
            <flux:dropdown inline position="bottom" align="start" class="w-full">

                {{-- BOTÓN --}}
                <button @click.stop.prevent
                    @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                    , 'border border-gray-300 text-gray-700 hover:border-gray-400'=> !$errors->has('descriptionSI'),
                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500' =>
                    $errors->has('descriptionAW'),
                    ])>
                    <!-- CAMBIO 1: Se agregó la clase 'truncate' para cortar el texto si es muy largo -->
                    <span class="flex-1 text-left text-gray-700 truncate">
                        @if($descriptionAE)
                        {{ $descriptionAE}} –
                        {{ collect($select_AE)->firstWhere('clave', $descriptionAE)['descripcion'] }}
                        @else
                        -- Selecciona una opción --
                        @endif
                    </span>
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w-3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- MENÚ --}}
                <!-- CAMBIO 2: Se cambió w-3/5 por w-full para que el menú ocupe todo el ancho por defecto -->
                <flux:menu
                    class="absolute left-0 top-full mt-1 md:w-96 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                    <flux:menu.item disabled>
                        <div class="w-full grid grid-cols-[30%_70%] px-2 py-1 text-gray-600 font-medium">
                            <span>Clave</span>
                            <span>Descripción</span>
                        </div>
                    </flux:menu.item>
                    <flux:menu.separator />

                    {{-- “Ninguno” --}}
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionAE','')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">0</span>
                            <span class="text-left">Ninguna</span>
                        </div>
                    </flux:menu.item>

                    @foreach($select_AE as $item)
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionAE','{{ $item['clave'] }}')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized {{ $descriptionAE == $item['clave'] ? 'bg-gray-100' : '' }}">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">{{ $item['clave'] }}</span>
                            <span class="text-left">{{ $item['descripcion'] }}</span>
                        </div>
                    </flux:menu.item>
                    @endforeach

                </flux:menu>
            </flux:dropdown>
            <div>
                <flux:error name="descriptionAE" />
            </div>
        </div>
        @endif








        @if($elementType === 'works')
        {{-- Inicia --}}
        <div class="relative inline-block w-full">
            <div class="pb-2">
                <flux:label>Descripción</flux:label>
            </div>
            <flux:dropdown inline position="bottom" align="start" class="w-full">

                {{-- BOTÓN --}}
                <button @click.stop.prevent
                    @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                    , 'border border-gray-300 text-gray-700 hover:border-gray-400'=> !$errors->has('descriptionSI'),
                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500' =>
                    $errors->has('descriptionCW'),
                    ])>
                    <!-- CAMBIO 1: Se agregó la clase 'truncate' para cortar el texto si es muy largo -->
                    <span class="flex-1 text-left text-gray-700 truncate">
                        @if($descriptionCW)
                        {{ $descriptionCW}} –
                        {{ collect($select_CW)->firstWhere('clave', $descriptionCW)['descripcion'] }}
                        @else
                        -- Selecciona una opción --
                        @endif
                    </span>
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w-3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- MENÚ --}}
                <!-- CAMBIO 2: Se cambió w-3/5 por w-full para que el menú ocupe todo el ancho por defecto -->
                <flux:menu
                    class="absolute left-0 top-full mt-1 md:w-96 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                    <flux:menu.item disabled>
                        <div class="w-full grid grid-cols-[30%_70%] px-2 py-1 text-gray-600 font-medium">
                            <span>Clave</span>
                            <span>Descripción</span>
                        </div>
                    </flux:menu.item>
                    <flux:menu.separator />

                    {{-- “Ninguno” --}}
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionCW','')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">0</span>
                            <span class="text-left">Ninguna</span>
                        </div>
                    </flux:menu.item>

                    @foreach($select_CW as $item)
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('descriptionCW','{{ $item['clave'] }}')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized {{ $descriptionCW == $item['clave'] ? 'bg-gray-100' : '' }}">
                        <div class="w-full grid grid-cols-[30%_70%]">
                            <span class="text-left">{{ $item['clave'] }}</span>
                            <span class="text-left">{{ $item['descripcion'] }}</span>
                        </div>
                    </flux:menu.item>
                    @endforeach

                </flux:menu>
            </flux:dropdown>
            <div>
                <flux:error name="descriptionCW" />
            </div>
        </div>
        {{-- Finaliza --}}

        @endif



        @if ($descriptionSI === 'IE19' || $descriptionAE === 'EA12' || $descriptionCW === 'OC17')

        <flux:field class="flux-field pt-4 pb-[-10px]">
            <flux:label>Agregar otra descripción</flux:label>
            <flux:input type="text" wire:model='descriptionOther' />
            <div class="error-container">
                <flux:error name="descriptionOther" />
            </div>
        </flux:field>
        @endif




        <flux:field class="flux-field pt-4">
            <flux:label>Unidad</flux:label>
            <flux:select wire:model.live="unit" class="text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="a">-- Selecciona una opción --</flux:select.option>
                @foreach ($select_units as $value => $label)
                <flux:select.option value="{{ $label }}">
                    {{ $label }}
                </flux:select.option>
                @endforeach
            </flux:select>
            <div class="error-container">
                <flux:error name="unit" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Cantidad</flux:label>
            <flux:input type="number" wire:model='quantity' />
            <div class="error-container">
                <flux:error name="quantity" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Edad<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model.lazy='age' />
            <div class="error-container">
                <flux:error name="age" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Vida útil<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='usefulLife'
            :disabled="!($descriptionSI === 'IE19' || $descriptionAE === 'EA12' || $descriptionCW === 'OC17')"/>
            <div class="error-container">
                <flux:error name="usefulLife" />
            </div>
        </flux:field>
        <flux:field class="flux-field">
            <flux:label>Costo unit rep nuevo<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='newRepUnitCost' />
            <div class="error-container">
                <flux:error name="newRepUnitCost" />
            </div>
        </flux:field>

{{--         <flux:field class="flux-field">
            <flux:label>Factor de edad<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='ageFactor' disabled/>
            <div class="error-container">
                <flux:error name="ageFactor" />
            </div>
        </flux:field>
 --}}

        {{-- Inicia --}}
        <div class="relative inline-block w-full">
            <div class="pb-2">
                <flux:label>Factor conservación</flux:label>
            </div>
            <flux:dropdown inline position="bottom" align="start" class="w-full">

                {{-- BOTÓN --}}
                <button @click.stop.prevent
                    @class([ 'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none'
                    , 'border border-gray-300 text-gray-700 hover:border-gray-400'=>
                    !$errors->has('conservationFactor'),
                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500' =>
                    $errors->has('conservationFactor'),
                    ])>
                    <!-- CAMBIO 1: Se agregó la clase 'truncate' para cortar el texto si es muy largo -->
                    <span class="flex-1 text-left text-gray-700 truncate">
                        @if($conservationFactor)
                        {{ $conservationFactor}} –
                        {{ collect($select_conservation_factor)->firstWhere('clave', $conservationFactor)['nombre'] }}
                        @else
                        -- Selecciona una opción --
                        @endif
                    </span>
                    <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w-3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                {{-- MENÚ --}}
                <!-- CAMBIO 2: Se cambió w-3/5 por w-full para que el menú ocupe todo el ancho por defecto -->
                <flux:menu
                    class="absolute left-0 top-full mt-1 md:w-96 bg-white border border-gray-200 rounded-md shadow-lg z-10">

                    <flux:menu.item disabled>
                        <div class="w-full grid grid-cols-[30%_40%_30%] px-2 py-1 text-gray-600 font-medium">
                            <span>Clave</span>
                            <span>Nombre</span>
                            <span>Factor</span>
                        </div>
                    </flux:menu.item>
                    <flux:menu.separator />

                    {{-- “Ninguno” --}}
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('conservationFactor','')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized">
                        <div class="w-full grid grid-cols-[30%_40%_30%]">
                            <span class="text-left">0</span>
                            <span class="text-left">Ninguna</span>
                            <span class="text-left">Ninguna</span>
                        </div>
                    </flux:menu.item>

                    @foreach($select_conservation_factor as $item)
                    <!-- CAMBIO 3: Se unificó la variable a 'descriptionSI' para consistencia -->
                    <flux:menu.item wire:click="$set('conservationFactor','{{ $item['clave'] }}')"
                        class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors menu-item-personalized {{ $conservationFactor == $item['clave'] ? 'bg-gray-100' : '' }}">
                        <div class="w-full grid grid-cols-[30%_40%_30%]">
                            <span class="text-left">{{ $item['clave'] }}</span>
                            <span class="text-left">{{ $item['nombre'] }}</span>
                            <span class="text-left">{{ $item['factor'] }}</span>
                        </div>
                    </flux:menu.item>
                    @endforeach

                </flux:menu>
            </flux:dropdown>
            <div>
                <flux:error name="conservationFactor" />
            </div>
        </div>
        {{-- Finaliza --}}

        {{-- <flux:field class="flux-field pt-4">
            <flux:label>Costo Unit Neto Rep<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='netRepUnitCost' />
            <div class="error-container">
                <flux:error name="netRepUnitCost" />
            </div>
        </flux:field> --}}

        @if ($classificationType === 'common')
        <flux:field class="flux-field pt-4">
            <flux:label>%Indiviso<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='undividedOnlyCondominium' readonly/>
            <div class="error-container">
                <flux:error name="undividedOnlyCondominium" />
            </div>
        </flux:field>
        @endif

        {{-- <flux:field class="flux-field">
            <flux:label>Importe<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='amount' />
            <div class="error-container">
                <flux:error name="amount" />
            </div>
        </flux:field> --}}

        <div class="flex pt-8">
            <flux:spacer/>

            <flux:button type="button" class="btn-primary btn-table cursor-pointer" variant="primary"
                wire:click='addElement'>Guardar elemento
            </flux:button>
        </div>
    </div>
</flux:modal>




















{{-- </form> --}}
</div>
