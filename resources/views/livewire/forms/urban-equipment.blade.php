<div>


    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>
    <form wire:submit='save'>
        <div class="form-container">
            <div class="form-container__header">
                Equipamiento urbano
            </div>
            <div class="form-container__content">


                <div class="form-grid form-grid--1">



                    {{-- INICIA ACORDEÓN --}}
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                        <!-- Header del acordeón -->
                        <div @click="open = !open"
                            class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                            <div class="flex items-center gap-2 flex-grow">
                                <flux:field>
                                    <flux:checkbox wire:model='templeCheckbox' class="pointer-events-none" disabled />
                                </flux:field>
                                <span class="text-gray-800 font-medium">Templos</span>
                            </div>
                            <svg :class="{ 'rotate-180': open }"
                                class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Contenido del acordeón con transición suave -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition duration-75"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                            <div class="flex justify-end w-full">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Iglesia<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='church' />
                                        <flux:error name="church" />
                                    </flux:field>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TERMINA ACORDEÓN --}}



                    {{-- INICIA ACORDEÓN --}}
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                        <!-- Header del acordeón -->
                        <div @click="open = !open"
                            class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                            <div class="flex items-center gap-2 flex-grow">
                                <flux:field>
                                    <flux:checkbox wire:model='marketCheckbox' class="pointer-events-none" disabled/>
                                </flux:field>
                                <span class="text-gray-800 font-medium">Mercados</span>
                            </div>
                            <svg :class="{ 'rotate-180': open }"
                                class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Contenido del acordeón con transición suave -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition duration-75"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Mercado<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='market' />
                                        <flux:error name="market" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full">
                                <div class="form-group-horizontal-right mb-4">
                                    <flux:label>Supermercado<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='superMarket' />
                                        <flux:error name="superMarket" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="form-group-horizontal-right mb-4">
                                <flux:label>Locales comerciales<span class="sup-required">*</span>
                                </flux:label>
                                <flux:field class="w-80">
                                    <flux:input type="number" wire:model.lazy='commercialSpaces' />
                                    <flux:error name="commercialSpaces" />
                                </flux:field>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Cantidad locales comerciales<span class="sup-required">*</span>
                                    </flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='numberCommercialSpaces' />
                                        <flux:error name="numberCommercialSpaces" />
                                    </flux:field>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TERMINA ACORDEÓN --}}



                    {{-- INICIA ACORDEÓN --}}
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                        <!-- Header del acordeón -->
                        <div @click="open = !open"
                            class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                            <div class="flex items-center gap-2 flex-grow">
                                <flux:field>
                                    <flux:checkbox wire:model='publicSquareCheckbox' class="pointer-events-none" disabled/>
                                </flux:field>
                                <span class="text-gray-800 font-medium">Plaza pública</span>
                            </div>
                            <svg :class="{ 'rotate-180': open }"
                                class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Contenido del acordeón con transición suave -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition duration-75"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Plaza pública<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='publicSquare' />
                                        <flux:error name="publicSquare" />
                                    </flux:field>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TERMINA ACORDEÓN --}}



                    {{-- INICIA ACORDEÓN --}}
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                        <!-- Header del acordeón -->
                        <div @click="open = !open"
                            class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                            <div class="flex items-center gap-2 flex-grow">
                                <flux:field>
                                    <flux:checkbox wire:model='parkGardensCheckbox' class="pointer-events-none" disabled/>
                                </flux:field>
                                <span class="text-gray-800 font-medium">Parques o jardines</span>
                            </div>
                            <svg :class="{ 'rotate-180': open }"
                                class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Contenido del acordeón con transición suave -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition duration-75"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Parques<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='parks' />
                                        <flux:error name="parks" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Jardines<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='gardens' />
                                        <flux:error name="gardens" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Canchas deportivas<span class="sup-required">*</span>
                                    </flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='sportsCourts' />
                                        <flux:error name="sportsCourts" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Centro deportivo<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='sportsCenter' />
                                        <flux:error name="sportsCenter" />
                                    </flux:field>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TERMINA ACORDEÓN --}}




                    {{-- INICIA ACORDEÓN --}}
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                        <!-- Header del acordeón -->
                        <div @click="open = !open"
                            class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                            <div class="flex items-center gap-2 flex-grow">
                                <flux:field>
                                    <flux:checkbox wire:model='schoolsCheckbox' class="pointer-events-none" disabled/>
                                </flux:field>
                                <span class="text-gray-800 font-medium">Escuelas</span>
                            </div>
                            <svg :class="{ 'rotate-180': open }"
                                class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Contenido del acordeón con transición suave -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition duration-75"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Primaria<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='primarySchool' />
                                        <flux:error name="primarySchool" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right mb-4">
                                    <flux:label>Secundaria<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='middleSchool' />
                                        <flux:error name="middleSchool" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right mb-4">
                                    <flux:label>Preparatoria<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='highSchool' />
                                        <flux:error name="highSchool" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right mb-4">
                                    <flux:label>Universidad<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='university' />
                                        <flux:error name="university" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right mb-4">
                                    <flux:label>Otras escuelas cercanas<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='otherNearbySchools' />
                                        <flux:error name="otherNearbySchools" />
                                    </flux:field>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TERMINA ACORDEÓN --}}







                    {{-- INICIA ACORDEÓN --}}
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                        <!-- Header del acordeón -->
                        <div @click="open = !open"
                            class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                            <div class="flex items-center gap-2 flex-grow">
                                <flux:field>
                                    <flux:checkbox wire:model='hospitalsCheckbox' class="pointer-events-none" disabled/>
                                </flux:field>
                                <span class="text-gray-800 font-medium">Hospitales</span>
                            </div>
                            <svg :class="{ 'rotate-180': open }"
                                class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Contenido del acordeón con transición suave -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition duration-75"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Primer nivel<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='firstLevel' />
                                        <flux:error name="firstLevel" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Segundo nivel<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='secondLevel' />
                                        <flux:error name="firstLevel" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Tercer nivel<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='thirdLevel' />
                                        <flux:error name="firstLevel" />
                                    </flux:field>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TERMINA ACORDEÓN --}}




                    {{-- INICIA ACORDEÓN --}}
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                        <!-- Header del acordeón -->
                        <div @click="open = !open"
                            class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                            <div class="flex items-center gap-2 flex-grow">
                                <flux:field>
                                    <flux:checkbox wire:model='banksCheckbox' class="pointer-events-none" disabled/>
                                </flux:field>
                                <span class="text-gray-800 font-medium">Bancos</span>
                            </div>
                            <svg :class="{ 'rotate-180': open }"
                                class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Contenido del acordeón con transición suave -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition duration-75"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Banco<span class="sup-required">*</span></flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='bank' />
                                        <flux:error name="bank" />
                                    </flux:field>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TERMINA ACORDEÓN --}}





                    {{-- INICIA ACORDEÓN --}}
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                        <!-- Header del acordeón -->
                        <div @click="open = !open"
                            class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                            <div class="flex items-center gap-2 flex-grow">
                                <flux:field>
                                    <flux:checkbox wire:model='communityCenterCheckbox' class="pointer-events-none" disabled/>
                                </flux:field>
                                <span class="text-gray-800 font-medium">Centro comunitario</span>
                            </div>
                            <svg :class="{ 'rotate-180': open }"
                                class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Contenido del acordeón con transición suave -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition duration-75"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Centro comunitario<span class="sup-required">*</span>
                                    </flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='communityCenter' />
                                        <flux:error name="communityCenter" />
                                    </flux:field>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TERMINA ACORDEÓN --}}




                    {{-- INICIA ACORDEÓN --}}
                    <div x-data="{ open: false }" class="border border-gray-200 rounded-lg mb-4">
                        <!-- Header del acordeón -->
                        <div @click="open = !open"
                            class="flex justify-between items-center px-4 py-3 cursor-pointer border-b">
                            <div class="flex items-center gap-2 flex-grow">
                                <flux:field>
                                    <flux:checkbox wire:model='transportCheckbox' class="pointer-events-none" disabled/>
                                </flux:field>
                                <span class="text-gray-800 font-medium">Transporte</span>
                            </div>
                            <svg :class="{ 'rotate-180': open }"
                                class="w-5 h-5 text-gray-500 transform transition-transform duration-300" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                            </svg>
                        </div>

                        <!-- Contenido del acordeón con transición suave -->
                        <div x-show="open" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 max-h-0"
                            x-transition:enter-end="opacity-100 max-h-screen"
                            x-transition:leave="transition duration-75"
                            x-transition:leave-start="opacity-100 max-h-screen"
                            x-transition:leave-end="opacity-0 max-h-0" class="overflow-hidden px-4 py-3 text-gray-700">
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Distancia urbano<span class="sup-required">*</span>
                                    </flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='urbanDistance' />
                                        <flux:error name="urbanDistance" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Frecuencia urbano<span class="sup-required">*</span>
                                    </flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='urbanFrequency' />
                                        <flux:error name="urbanFrequency" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Distancia urbano<span class="sup-required">*</span>
                                    </flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='suburbanDistance' />
                                        <flux:error name="urbanDistance" />
                                    </flux:field>
                                </div>
                            </div>
                            <div class="flex justify-end w-full mb-4">
                                <div class="form-group-horizontal-right">
                                    <flux:label>Frecuencia suburnano<span class="sup-required">*</span>
                                    </flux:label>
                                    <flux:field class="w-80">
                                        <flux:input type="number" wire:model.lazy='suburbanFrequency' />
                                        <div>
                                            <flux:error name="suburbanFrequency" />
                                        </div>
                                    </flux:field>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- TERMINA ACORDEÓN --}}

                </div>
            </div>
        </div>
        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos
        </flux:button>
    </form>

</div>
