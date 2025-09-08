<div>
    <form wire:submit=''>


        <div class="form-container">
            <div class="form-container__header">
                De las contrucciones
            </div>
            <div class="form-container__content">



                {{-- Navbar responsivo con hamburguesa --}}
                <div x-data="{ open: false }" class="w-full">
                    @php
                    $tabs = [
                    'privativas' => 'Privativas',
                    'comunes' => 'Comunes',
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

                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                <flux:modal.trigger name="add-construction" class="flex justify-end">
                    <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"></flux:button>
                </flux:modal.trigger>

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


                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Resultados de las construcciones</h2>
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



                @if ($activeTab === 'comunes')
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

                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                <flux:modal.trigger name="add-construction" class="flex justify-end">
                    <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"></flux:button>
                </flux:modal.trigger>

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


                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Resultados de las construcciones</h2>
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


                <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Resumen de superficies y valores </h2>
                </div>


                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 "></th>
                                    <th class="px-2 py-1 ">Privatias</th>
                                    <th class="px-2 py-1 ">Comunes</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                <tr>
                                    <td class="px-2 py-1 text-xs text-center">Superficie total de construcciones:</td>
                                    <td class="px-2 py-1 text-xs text-left"></td>
                                    <td class="px-2 py-1 text-sm text-center">H</td>
                                </tr>
                                <tr>
                                    <td class="px-2 py-1 text-xs text-center">Valor total de construcciones:</td>
                                    <td class="px-2 py-1 text-xs text-left"></td>
                                    <td class="px-2 py-1 text-sm text-center">H</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>


                <div class="mt-8">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 "></th>
                                    <th class="px-2 py-1 ">Vendible</th>
                                    <th class="px-2 py-1 ">Acessoria</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                <tr>
                                    <td class="px-2 py-1 text-xs text-center">Superficie total de construcciones:</td>
                                    <td class="px-2 py-1 text-xs text-left"></td>
                                    <td class="px-2 py-1 text-sm text-center">H</td>
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
        Promedios y ponderaciones
    </div>
    <div class="form-container__content">


        <div class="mt-8">
            <div class="overflow-x-auto max-w-full">
                <table class="min-w-[550px] table-fixed w-full border-2 ">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="px-2 py-1 "></th>
                            <th class="px-2 py-1 ">Ponderada</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- Valor de ejemplo para usar en los for --}}
                        <tr>
                            <td class="px-2 py-1 text-xs text-center">Vida útil total del inmueble:</td>
                            <td class="px-2 py-1 text-xs text-left"></td>
                        </tr>

                        <tr>
                            <td class="px-2 py-1 text-xs text-center">Edad del inmueble del inmueble:</td>
                            <td class="px-2 py-1 text-xs text-left"></td>
                        </tr>

                        <tr>
                            <td class="px-2 py-1 text-xs text-center">Vida útil remanente del inmueble:</td>
                            <td class="px-2 py-1 text-xs text-left"></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



<div class="form-container">
    <div class="form-container__header">
        Datos adicionales
    </div>
    <div class="form-container__content">


        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Fuente de donde se obtuvo el valor de reposición</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="text" />
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>

        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Estado de conservación</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:select wire:model="multipleUseSpace" class=" text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Ruidoso">Ruidoso</flux:select.option>
                            <flux:select.option value="Malo">Mali</flux:select.option>
                            <flux:select.option value="Normal">Normal</flux:select.option>
                            <flux:select.option value="Bueno">Bueno</flux:select.option>
                            <flux:select.option value="Muy bueno">Muy bueno</flux:select.option>
                            <flux:select.option value="Nuevo">Nuevo</flux:select.option>
                            <flux:select.option value="Recientemente remodelado">Recientemente remodelado</flux:select.option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>



        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Observaciones al estado de conseración</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:textarea/>
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>

        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Clase general de los inmuebles en la zona</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:select wire:model="multipleUseSpace" class=" text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Minima">Mínima</flux:select.option>
                            <flux:select.option value="Economica">Económica</flux:select.option>
                            <flux:select.option value="Interes social">Interes social</flux:select.option>
                            <flux:select.option value="Media">Media</flux:select.option>
                            <flux:select.option value="Semilujo">Semilujo</flux:select.option>
                            <flux:select.option value="Residencial">Residencial</flux:select.option>
                            <flux:select.option value="Residencial plus">Residencial plus </flux:select.option>
                            <flux:select.option value="Residencial plus +">Residencial plus +</flux:select.option>
                            <flux:select.option value="Unica">Unica</flux:select.option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>

        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Clase general del inmueble</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:select wire:model="multipleUseSpace" class=" text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Ruidoso">Ruidoso</flux:select.option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>

        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Año de terminación de la obra</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" />
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Unidades rentables (sujeto)</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" />
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Unidades rentables generales</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" />
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Unidadesrentables del conjunto (en condominios)</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" />
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Número de niveles del sujeto</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" /><br>
                        <small>Se refiere al número de niveles total del inmueble valuado</small>
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>% Avance de obra general</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" />
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Gradp de % avance de áreas comune</flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" />
                    </div>
                    <div>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </flux:field>
            </div>
        </div>


    </div>
</div>
<flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos
</flux:button>
</form>
</div>
