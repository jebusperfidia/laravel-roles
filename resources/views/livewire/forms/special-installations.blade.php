<div>
    <form wire:submit=''>


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

                            <flux:button type="submit" class="btn-primary btn-table" variant="primary">Guardar
                            </flux:button>
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

                            <flux:button type="submit" class="btn-primary btn-table" variant="primary">Guardar
                            </flux:button>
                        </div>
                    </div>
                </flux:modal>


                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                                <h2 class="border-b-2 border-gray-300">Instalaciones especiales</h2>
                            </div>

                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                {{-- <flux:modal.trigger name="add-construction" class="flex justify-end"> --}}
                    <div class="flex justify-end">
                        <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus" wire:click='openAddElement'></flux:button>
                    </div>
                {{-- </flux:modal.trigger> --}}

                {{-- TABLA DE ELEMENTOS --}}
                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 border whitespace-nowrap">Descripcion</th>
                                    <th class="w-[120px] px-2 py-1 border whitespace-nowrap">Clasificación<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[32px] px-2 py-1 border">Uso<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Niveles edificio<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Niveles por tipo de construcción<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Rango niveles TGDF<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Edad<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Superficie<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Fuente de información<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Costo unit reposición nuevo<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Avance obra<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Estado de conservación<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">RA<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Vend<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Acc<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Desc<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[100px] py-1 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                <tr>
                                    <td class="px-2 py-1 border text-xs text-center">Casa habitación
                                    </td>
                                    <td class="px-2 py-1 border text-xs text-left">
                                        <span>7. Residencial plus</span><br>
                                        <span>6. Lujo</span>
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">H</td>
                                    <td class="px-2 py-1 border text-sm text-center">1</td>
                                    <td class="px-2 py-1 border text-sm text-center">1</td>
                                    <td class="px-2 py-1 border text-sm text-center">02</td>
                                    <td class="px-2 py-1 border text-sm text-center">1</td>
                                    <td class="px-2 py-1 border text-sm text-center">100.00</td>
                                    <td class="px-2 py-1 border text-sm text-center">Escrituras</td>
                                    <td class="px-2 py-1 border text-sm text-center">$1,000</td>
                                    <td class="px-2 py-1 border text-sm text-center">100%</td>
                                    <td class="px-2 py-1 border text-sm text-center">1.0 Bueno</td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <flux:checkbox wire:model='data' />
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <input type="radio" wire:model="respuesta" name="opcion_unica" value="A"
                                            class="w-4 h-4 text-blue-500">
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <input type="radio" wire:model="respuesta" name="opcion_unica" value="B"
                                            class="w-4 h-4 text-blue-500">
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <input type="radio" wire:model="respuesta" name="opcion_unica" value="C"
                                            class="w-4 h-4 text-blue-500">
                                    </td>
                                    <td class="my-2 flex justify-evenly">
                                       {{--  <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins" wire:click='openEditElement'/>
                                            {{-- </flux:modal-trigger> --}}
                                           {{--  <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                                <flux:button
                                                onclick="confirm('¿Estás seguro de que deseas eliminar esto?') || event.stopImmediatePropagation()" wire:click="deleteElement"
                                                icon-leading="trash" class="cursor-pointer btn-deleted btn-buildings" />
                                               {{--  </flux:modal-trigger> --}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Elementos accesorios</h2>
                </div>
                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                <div class="flex justify-end">
                        <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus" wire:click='openAddElement'>
                        </flux:button>
                    </div>


                {{-- TABLA DE ELEMENTOS --}}
                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 border whitespace-nowrap">Descripcion</th>
                                    <th class="w-[120px] px-2 py-1 border whitespace-nowrap">Clasificación<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[32px] px-2 py-1 border">Uso<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Niveles edificio<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Niveles por tipo de construcción<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Rango niveles TGDF<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Edad<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Superficie<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Fuente de información<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Costo unit reposición nuevo<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Avance obra<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Estado de conservación<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">RA<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Vend<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Acc<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Desc<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[100px] py-1 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                <tr>
                                    <td class="px-2 py-1 border text-xs text-center">Casa habitación
                                    </td>
                                    <td class="px-2 py-1 border text-xs text-left">
                                        <span>7. Residencial plus</span><br>
                                        <span>6. Lujo</span>
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">H</td>
                                    <td class="px-2 py-1 border text-sm text-center">1</td>
                                    <td class="px-2 py-1 border text-sm text-center">1</td>
                                    <td class="px-2 py-1 border text-sm text-center">02</td>
                                    <td class="px-2 py-1 border text-sm text-center">1</td>
                                    <td class="px-2 py-1 border text-sm text-center">100.00</td>
                                    <td class="px-2 py-1 border text-sm text-center">Escrituras</td>
                                    <td class="px-2 py-1 border text-sm text-center">$1,000</td>
                                    <td class="px-2 py-1 border text-sm text-center">100%</td>
                                    <td class="px-2 py-1 border text-sm text-center">1.0 Bueno</td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <flux:checkbox wire:model='data' />
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <input type="radio" wire:model="respuesta" name="opcion_unica" value="A"
                                            class="w-4 h-4 text-blue-500">
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <input type="radio" wire:model="respuesta" name="opcion_unica" value="B"
                                            class="w-4 h-4 text-blue-500">
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <input type="radio" wire:model="respuesta" name="opcion_unica" value="C"
                                            class="w-4 h-4 text-blue-500">
                                    </td>
                                    <td class="my-2 flex justify-evenly">
                                        {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins" wire:click='openEditElement'/>
                                            {{-- </flux:modal-trigger> --}}
                                            {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                                <flux:button
                                                onclick="confirm('¿Estás seguro de que deseas eliminar esto?') || event.stopImmediatePropagation()" wire:click="deleteElement"
                                                icon-leading="trash"  class="cursor-pointer btn-deleted btn-buildings" />
                                                {{-- </flux:modal-trigger> --}}
                                    </td>
                                </tr>
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
                            <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus" wire:click='openAddElement'>
                            </flux:button>
                        </div>
                {{-- </flux:modal.trigger> --}}

                {{-- TABLA DE ELEMENTOS --}}
                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 border whitespace-nowrap">Descripcion</th>
                                    <th class="w-[120px] px-2 py-1 border whitespace-nowrap">Clasificación<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[32px] px-2 py-1 border">Uso<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Niveles edificio<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Niveles por tipo de construcción<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Rango niveles TGDF<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Edad<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Superficie<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Fuente de información<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Costo unit reposición nuevo<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Avance obra<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Estado de conservación<span
                                            class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">RA<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Vend<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Acc<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[5%] px-2 py-1 border">Desc<span class="sup-required">*</span>
                                    </th>
                                    <th class="w-[100px] py-1 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                <tr>
                                    <td class="px-2 py-1 border text-xs text-center">Casa habitación
                                    </td>
                                    <td class="px-2 py-1 border text-xs text-left">
                                        <span>7. Residencial plus</span><br>
                                        <span>6. Lujo</span>
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">H</td>
                                    <td class="px-2 py-1 border text-sm text-center">1</td>
                                    <td class="px-2 py-1 border text-sm text-center">1</td>
                                    <td class="px-2 py-1 border text-sm text-center">02</td>
                                    <td class="px-2 py-1 border text-sm text-center">1</td>
                                    <td class="px-2 py-1 border text-sm text-center">100.00</td>
                                    <td class="px-2 py-1 border text-sm text-center">Escrituras</td>
                                    <td class="px-2 py-1 border text-sm text-center">$1,000</td>
                                    <td class="px-2 py-1 border text-sm text-center">100%</td>
                                    <td class="px-2 py-1 border text-sm text-center">1.0 Bueno</td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <flux:checkbox wire:model='data' />
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <input type="radio" wire:model="respuesta" name="opcion_unica" value="A"
                                            class="w-4 h-4 text-blue-500">
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <input type="radio" wire:model="respuesta" name="opcion_unica" value="B"
                                            class="w-4 h-4 text-blue-500">
                                    </td>
                                    <td class="px-2 py-1 border text-sm text-center">
                                        <input type="radio" wire:model="respuesta" name="opcion_unica" value="C"
                                            class="w-4 h-4 text-blue-500">
                                    </td>
                                    <td class="my-2 flex justify-evenly">
                                        <{{-- flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins" wire:click='openEditElement'/>
                                            {{-- </flux:modal-trigger> --}}
                                           {{--  <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                                <flux:button
                                                onclick="confirm('¿Estás seguro de que deseas eliminar esto?') || event.stopImmediatePropagation()" wire:click="deleteElement"
                                                type="button" icon-leading="trash" class="cursor-pointer btn-deleted btn-buildings" />
                                                {{-- </flux:modal-trigger> --}}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>



                @endif



                @if ($activeTab === 'comunes')
             {{-- MODAL PARA EDITAR ELEMENTO --}}
            <flux:modal name="edit-element" class="md:w-96">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Añadir elemento</flux:heading>
                    </div>

                    <flux:input label="Name" placeholder="Your name" />

                    <flux:input label="Date of birth" type="date" />

                    <div class="flex">
                        <flux:spacer />

                        <flux:button type="submit" class="btn-primary btn-table" variant="primary">Guardar
                        </flux:button>
                    </div>
                </div>
            </flux:modal>


            {{-- MODAL PARA CREAR NUEVO ELEMENTO --}}
            <flux:modal name="add-element" class="md:w-96">
                <div class="space-y-6">
                    <div>
                        <flux:heading size="lg">Añadir elemento</flux:heading>
                    </div>

                    <flux:input label="Name" placeholder="Your name" />

                    <flux:input label="Date of birth" type="date" />

                    <div class="flex">
                        <flux:spacer />

                        <flux:button type="submit" class="btn-primary btn-table" variant="primary">Guardar
                        </flux:button>
                    </div>
                </div>
            </flux:modal>


            <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Instalaciones especiales</h2>
            </div>

            {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
          <div class="flex justify-end">
                    <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus" wire:click='openAddElement'>
                    </flux:button>
                </div>

            {{-- TABLA DE ELEMENTOS --}}
            <div class="mt-2">
                <div class="overflow-x-auto max-w-full">
                    <table class="min-w-[550px] table-fixed w-full border-2 ">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1 border whitespace-nowrap">Descripcion</th>
                                <th class="w-[120px] px-2 py-1 border whitespace-nowrap">Clasificación<span
                                        class="sup-required">*</span>
                                </th>
                                <th class="w-[32px] px-2 py-1 border">Uso<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Niveles edificio<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Niveles por tipo de construcción<span
                                        class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Rango niveles TGDF<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Edad<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Superficie<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Fuente de información<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Costo unit reposición nuevo<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Avance obra<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Estado de conservación<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">RA<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Vend<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Acc<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Desc<span class="sup-required">*</span>
                                </th>
                                <th class="w-[100px] py-1 border">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- Valor de ejemplo para usar en los for --}}
                            <tr>
                                <td class="px-2 py-1 border text-xs text-center">Casa habitación
                                </td>
                                <td class="px-2 py-1 border text-xs text-left">
                                    <span>7. Residencial plus</span><br>
                                    <span>6. Lujo</span>
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">H</td>
                                <td class="px-2 py-1 border text-sm text-center">1</td>
                                <td class="px-2 py-1 border text-sm text-center">1</td>
                                <td class="px-2 py-1 border text-sm text-center">02</td>
                                <td class="px-2 py-1 border text-sm text-center">1</td>
                                <td class="px-2 py-1 border text-sm text-center">100.00</td>
                                <td class="px-2 py-1 border text-sm text-center">Escrituras</td>
                                <td class="px-2 py-1 border text-sm text-center">$1,000</td>
                                <td class="px-2 py-1 border text-sm text-center">100%</td>
                                <td class="px-2 py-1 border text-sm text-center">1.0 Bueno</td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <flux:checkbox wire:model='data' />
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <input type="radio" wire:model="respuesta" name="opcion_unica" value="A"
                                        class="w-4 h-4 text-blue-500">
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <input type="radio" wire:model="respuesta" name="opcion_unica" value="B"
                                        class="w-4 h-4 text-blue-500">
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <input type="radio" wire:model="respuesta" name="opcion_unica" value="C"
                                        class="w-4 h-4 text-blue-500">
                                </td>
                                <td class="my-2 flex justify-evenly">
                                    {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                        <flux:button type="button" icon-leading="pencil"
                                            class="cursor-pointer btn-intermediary btn-buildins" wire:click='openEditElement'/>
                                       {{--  </flux:modal-trigger> --}}
                                        {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button
                                            onclick="confirm('¿Estás seguro de que deseas eliminar esto?') || event.stopImmediatePropagation()" wire:click="deleteElement"
                                            type="button" icon-leading="trash"
                                                class="cursor-pointer btn-deleted btn-buildings" />
                                           {{--  </flux:modal-trigger> --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Elementos accesorios</h2>
            </div>


            {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
            <div class="flex justify-end">
                    <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus" wire:click='openAddElement'>
                    </flux:button>
                </div>

            {{-- TABLA DE ELEMENTOS --}}
            <div class="mt-2">
                <div class="overflow-x-auto max-w-full">
                    <table class="min-w-[550px] table-fixed w-full border-2 ">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1 border whitespace-nowrap">Descripcion</th>
                                <th class="w-[120px] px-2 py-1 border whitespace-nowrap">Clasificación<span
                                        class="sup-required">*</span>
                                </th>
                                <th class="w-[32px] px-2 py-1 border">Uso<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Niveles edificio<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Niveles por tipo de construcción<span
                                        class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Rango niveles TGDF<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Edad<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Superficie<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Fuente de información<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Costo unit reposición nuevo<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Avance obra<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Estado de conservación<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">RA<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Vend<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Acc<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Desc<span class="sup-required">*</span>
                                </th>
                                <th class="w-[100px] py-1 border">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- Valor de ejemplo para usar en los for --}}
                            <tr>
                                <td class="px-2 py-1 border text-xs text-center">Casa habitación
                                </td>
                                <td class="px-2 py-1 border text-xs text-left">
                                    <span>7. Residencial plus</span><br>
                                    <span>6. Lujo</span>
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">H</td>
                                <td class="px-2 py-1 border text-sm text-center">1</td>
                                <td class="px-2 py-1 border text-sm text-center">1</td>
                                <td class="px-2 py-1 border text-sm text-center">02</td>
                                <td class="px-2 py-1 border text-sm text-center">1</td>
                                <td class="px-2 py-1 border text-sm text-center">100.00</td>
                                <td class="px-2 py-1 border text-sm text-center">Escrituras</td>
                                <td class="px-2 py-1 border text-sm text-center">$1,000</td>
                                <td class="px-2 py-1 border text-sm text-center">100%</td>
                                <td class="px-2 py-1 border text-sm text-center">1.0 Bueno</td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <flux:checkbox wire:model='data' />
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <input type="radio" wire:model="respuesta" name="opcion_unica" value="A"
                                        class="w-4 h-4 text-blue-500">
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <input type="radio" wire:model="respuesta" name="opcion_unica" value="B"
                                        class="w-4 h-4 text-blue-500">
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <input type="radio" wire:model="respuesta" name="opcion_unica" value="C"
                                        class="w-4 h-4 text-blue-500">
                                </td>
                                <td class="my-2 flex justify-evenly">
                                    {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                        <flux:button type="button" icon-leading="pencil"
                                            class="cursor-pointer btn-intermediary btn-buildins" wire:click='openEditElement'/>
                                        {{-- </flux:modal-trigger> --}}
                                        {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button
                                            onclick="confirm('¿Estás seguro de que deseas eliminar esto?') || event.stopImmediatePropagation()" wire:click="deleteElement"
                                            type="button" icon-leading="trash"
                                                class="cursor-pointer btn-deleted btn-buildings" />
                                            {{-- </flux:modal-trigger> --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>


            <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Obras complementarias</h2>
            </div>

            {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
         <div class="flex justify-end">
                <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus" wire:click='openAddElement'>
                </flux:button>
            </div>
            {{-- TABLA DE ELEMENTOS --}}
            <div class="mt-2">
                <div class="overflow-x-auto max-w-full">
                    <table class="min-w-[550px] table-fixed w-full border-2 ">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1 border whitespace-nowrap">Descripcion</th>
                                <th class="w-[120px] px-2 py-1 border whitespace-nowrap">Clasificación<span
                                        class="sup-required">*</span>
                                </th>
                                <th class="w-[32px] px-2 py-1 border">Uso<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Niveles edificio<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Niveles por tipo de construcción<span
                                        class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Rango niveles TGDF<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Edad<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Superficie<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Fuente de información<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Costo unit reposición nuevo<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Avance obra<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Estado de conservación<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">RA<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Vend<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Acc<span class="sup-required">*</span>
                                </th>
                                <th class="w-[5%] px-2 py-1 border">Desc<span class="sup-required">*</span>
                                </th>
                                <th class="w-[100px] py-1 border">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                            {{-- Valor de ejemplo para usar en los for --}}
                            <tr>
                                <td class="px-2 py-1 border text-xs text-center">Casa habitación
                                </td>
                                <td class="px-2 py-1 border text-xs text-left">
                                    <span>7. Residencial plus</span><br>
                                    <span>6. Lujo</span>
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">H</td>
                                <td class="px-2 py-1 border text-sm text-center">1</td>
                                <td class="px-2 py-1 border text-sm text-center">1</td>
                                <td class="px-2 py-1 border text-sm text-center">02</td>
                                <td class="px-2 py-1 border text-sm text-center">1</td>
                                <td class="px-2 py-1 border text-sm text-center">100.00</td>
                                <td class="px-2 py-1 border text-sm text-center">Escrituras</td>
                                <td class="px-2 py-1 border text-sm text-center">$1,000</td>
                                <td class="px-2 py-1 border text-sm text-center">100%</td>
                                <td class="px-2 py-1 border text-sm text-center">1.0 Bueno</td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <flux:checkbox wire:model='data' />
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <input type="radio" wire:model="respuesta" name="opcion_unica" value="A"
                                        class="w-4 h-4 text-blue-500">
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <input type="radio" wire:model="respuesta" name="opcion_unica" value="B"
                                        class="w-4 h-4 text-blue-500">
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    <input type="radio" wire:model="respuesta" name="opcion_unica" value="C"
                                        class="w-4 h-4 text-blue-500">
                                </td>
                                <td class="my-2 flex justify-evenly">
                                   {{--  <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                        <flux:button type="button" icon-leading="pencil"
                                            class="cursor-pointer btn-intermediary btn-buildins" wire:click='openEditElement'/>
                                        {{-- </flux:modal-trigger> --}}
                                        {{-- <flux:modal.trigger name="edit-construction" class="flex justify-end"> --}}
                                            <flux:button
                                            onclick="confirm('¿Estás seguro de que deseas eliminar esto?') || event.stopImmediatePropagation()" wire:click="deleteElement"
                                            type="button" icon-leading="trash"
                                                class="cursor-pointer btn-deleted btn-buildings" />
                                            {{-- </flux:modal-trigger> --}}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
                @endif



                    <div class="mt-[64px]">
                        <div class="overflow-x-auto max-w-full">
                            <table class="min-w-[550px] table-fixed w-full border-2 ">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-2 py-1 "></th>
                                        <th class="px-2 py-1 ">Privativas</th>
                                        <th class="px-2 py-1 ">Comune</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- Valor de ejemplo para usar en los for --}}
                                    <tr>
                                        <td class="px-2 py-1 text-xs text-center">Importe total instalaciones especiales:</td>
                                        <td class="px-2 py-1 text-xs text-left"></td>
                                    </tr>

                                    <tr>
                                        <td class="px-2 py-1 text-xs text-center">Importe total elementos accesorios:</td>
                                        <td class="px-2 py-1 text-xs text-left"></td>
                                    </tr>

                                    <tr>
                                        <td class="px-2 py-1 text-xs text-center">Importe total obras complementarias:</td>
                                        <td class="px-2 py-1 text-xs text-left"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>



                    <div class="mt-[64px]">
                        <div class="overflow-x-auto max-w-full">
                            <table class="min-w-[550px] table-fixed w-full border-2 ">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-2 py-1 "></th>
                                        <th class="px-2 py-1 ">Privativas</th>
                                        <th class="px-2 py-1 ">Comune</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- Valor de ejemplo para usar en los for --}}
                                    <tr>
                                        <td class="px-2 py-1 text-xs text-center">Importe Total:
                                            (Inst. Especiales, Obras Comp. y Elem. Accesorios)</td>
                                        <td class="px-2 py-1 text-xs text-left"></td>
                                    </tr>

                                    <tr>
                                        <td class="px-2 py-1 text-xs text-center">Importe PRO INDIVISO:
                                            (Inst. Especiales, Obras Comp. y Elem. Accesorios)</td>
                                        <td class="px-2 py-1 text-xs text-left"></td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>
                    </div>


            </div>
        </div>
</div>





<flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos
</flux:button>
</form>
</div>
