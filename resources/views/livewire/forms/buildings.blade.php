<div>
    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>
    <form wire:submit='save'>


        <div class="form-container">
            <div class="form-container__header">
                De las construcciones
            </div>
            <div class="form-container__content">
                {{-- {{$valuation->property_type}} --}}


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
                                                            ? ' border-b-2 border-[#43A497] text-[#3A8B88] font-semibold'
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

                {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                {{-- <flux:modal.trigger name="add-element" class="flex justify-end pt-8"> --}}
                    <div class="flex justify-end pt-4">
                        <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"
                            wire:click="openAddElement('private')"></flux:button>
                    </div>



                    <div class="mt-2">
                        <div class="overflow-x-auto max-w-full">
                            <table class="min-w-[550px] table-fixed w-full border-2 ">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="px-2 py-1 border whitespace-nowrap">Descripcion</th>
                                        <th class="w-[120px] px-2 py-1 border whitespace-nowrap">Clasificación</th>
                                        <th class="w-[32px] px-2 py-1 border">Uso</th>
                                        <th class="w-[5%] px-2 py-1 border">Niveles edificio</th>
                                        <th class="w-[5%] px-2 py-1 border">Niveles por tipo de construcción</th>
                                        <th class="w-[5%] px-2 py-1 border">Rango niveles TGDF</th>
                                        <th class="w-[5%] px-2 py-1 border">Edad</th>
                                        <th class="w-[5%] px-2 py-1 border">Superficie</th>
                                        <th class="w-[5%] px-2 py-1 border">Fuente de información</th>
                                        <th class="w-[5%] px-2 py-1 border">Costo unit reposición nuevo</th>
                                        <th class="w-[5%] px-2 py-1 border">Avance obra</th>
                                        <th class="w-[5%] px-2 py-1 border">Estado de conservación</th>
                                        <th class="w-[5%] px-2 py-1 border">RA</th>
                                        <th class="w-[5%] px-2 py-1 border">Vend</th>
                                        <th class="w-[5%] px-2 py-1 border">Acc</th>
                                        <th class="w-[5%] px-2 py-1 border">Desc</th>
                                        <th class="w-[100px] py-1 border">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($buildingConstructionsPrivate->isEmpty())
                                    <tr>
                                        <td colspan="18" class="px-2 py-4 text-center text-gray-500">
                                            No hay elementos registrados
                                        </td>
                                    </tr>
                                    @else
                                    @foreach ($buildingConstructionsPrivate as $item)
                                    <tr wire:key="private-{{ $item->id }}">
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->description }}</td>
                                        <td class="px-2 py-1 border text-xs text-left">
                                            @if ($item->clasification === 'Minima')
                                            <span></span>1. Mínima</span><br>
                                            <span>1. Precaria</span><br>
                                            @elseif ($item->clasification === 'Economica')
                                            <span></span>2. Económica</span><br>
                                            <span>2. Económica</span><br>
                                            @elseif ($item->clasification === 'Interes social')
                                            <span></span>3. Interés social</span><br>
                                            <span>3. Eco-interés social</span><br>
                                            @elseif ($item->clasification === 'Media')
                                            <span></span>4. Media</span><br>
                                            <span>3. Media</span><br>
                                            @elseif ($item->clasification === 'Semilujo')
                                            <span></span>5. Semilujo</span><br>
                                            <span>4. Buena</span><br>
                                            @elseif ($item->clasification === 'Residencial')
                                            <span></span>6. Residencial</span><br>
                                            <span>5. Muy buena</span><br>
                                            @elseif ($item->clasification === 'Residencial plus')
                                            <span></span>7. Residencial plus</span><br>
                                            <span>6. Lujo</span><br>
                                            @elseif ($item->clasification === 'Residencial plus +')
                                            <span></span>7. Residencial plus +</span><br>
                                            <span>7. Especial</span><br>
                                            @elseif ($item->clasification === 'Unica')
                                            <span></span>0. Única</span><br>
                                            <span>U. Unica</span><br>
                                            @endif
                                        </td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->use }}</td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->building_levels }}
                                        </td>
                                        <td class="px-2 py-1 border text-xs text-center">{{
                                            $item->levels_construction_type
                                            }}</td>

                                        {{-- Rango niveles TGDF: Asumo que esto es un campo, si no lo es, usa N/A --}}
                                        <td class="px-2 py-1 border text-xs text-center">{{ 'N/A' }}</td>

                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->age }}</td>
                                        <td class="px-2 py-1 border text-xs text-center">{{
                                            number_format($item->surface, 2)
                                            }}</td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->source_information }}
                                        </td>
                                        <td class="px-2 py-1 border text-xs text-center">${{
                                            number_format($item->unit_cost_replacement, 2)
                                            }}</td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->progress_work }}%
                                        </td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->conservation_state }}
                                        </td>

                                        {{-- RA (Range Based Height) --}}
                                        <td class="px-2 py-1 border">
                                            {{--
                                            <flux:checkbox :checked="(bool) $item->range_based_height" disabled /> --}}
                                            {{-- <input type="checkbox" disabled {{ $item->range_based_height ?
                                            'checked' :
                                            '' }}> --}}
                                            <!-- Componente Flux UI para mostrar un checkbox de solo lectura -->
                                            <div class="flex justify-center">
                                                <flux:checkbox :checked="(bool) $item->range_based_height" {{--
                                                    Establece si el checkbox debe estar marcado. Convertimos el valor a
                                                    booleano explícito para asegurar compatibilidad con Flux UI. Si
                                                    $item->
                                                    range_based_height es true, el checkbox aparece marcado.
                                                    --}}

                                                    disabled
                                                    {{--
                                                    Evita que el usuario interactúe con el checkbox.
                                                    Es útil cuando solo quieres mostrar el estado, sin permitir cambios.
                                                    --}}

                                                    wire:key="checkbox-{{ $item->id }}-{{ (int)
                                                    $item->range_based_height
                                                    }}"
                                                    {{--
                                                    Esta es la parte más importante.

                                                    Livewire usa wire:key para identificar elementos únicos en el DOM.

                                                    Aquí generamos una clave única combinando:
                                                    - El ID del elemento ($item->id)
                                                    - El valor actual del campo ($item->range_based_height convertido a
                                                    entero)

                                                    Ejemplo:
                                                    Si el ID es 12 y el valor es true, la clave será: "checkbox-12-1"
                                                    Si luego cambia a false, será: "checkbox-12-0"

                                                    Como cambia el valor de wire:key, Livewire forzará el re-render del
                                                    checkbox
                                                    en lugar de intentar "reutilizar" el anterior, asegurando que se
                                                    actualice visualmente.
                                                    --}}
                                                    />
                                            </div>
                                        </td>

                                        {{-- Vend, Acc, Desc: Asumo que estos son campos de lógica/radio específicos.
                                        Aquí
                                        están los
                                        placeholders --}}
                                        {{-- Columna VEND --}}
                                        <td class="px-2 py-1 border text-sm text-center">
                                            <input type="radio" name="surface_vad_group_{{ $item->id }}" {{-- NOMBRE
                                                UNIFICADO --}} value="superficie vendible" class="w-4 h-4 text-blue-500"
                                                disabled {{ $item->surface_vad === 'superficie vendible' ? 'checked' :
                                            '' }}
                                            >
                                        </td>

                                        {{-- Columna ACC --}}
                                        <td class="px-2 py-1 border text-sm text-center">
                                            <input type="radio" name="surface_vad_group_{{ $item->id }}" {{-- NOMBRE
                                                UNIFICADO --}} value="superficie accesoria"
                                                class="w-4 h-4 text-blue-500" disabled {{ $item->surface_vad ===
                                            'superficie accesoria' ? 'checked' : '' }}
                                            >
                                        </td>

                                        {{-- Columna DESC --}}
                                        <td class="px-2 py-1 border text-sm text-center">
                                            <input type="radio" name="surface_vad_group_{{ $item->id }}" {{-- NOMBRE
                                                UNIFICADO --}} value="construccion superficie descubierta"
                                                class="w-4 h-4 text-blue-500" disabled {{ $item->surface_vad ===
                                            'construccion superficie descubierta' ? 'checked' : '' }}
                                            >
                                        </td>
                                        <td class="my-2 flex justify-evenly border">
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins"
                                                wire:click="openEditElement({{ $item->id }})" />
                                            <flux:button
                                                onclick="confirm('¿Estás seguro de que deseas eliminar este elemento?') || event.stopImmediatePropagation()"
                                                wire:click="deleteElement({{ $item->id }})" type="button"
                                                icon-leading="trash" class="cursor-pointer btn-deleted btn-buildings" />
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="font-bold">

                                        {{-- Celdas vacías (Columna 1 a 4: Descripcion, Edad, VUT, VUR) --}}
                                        <td colspan="7" class="px-2 py-1"></td>

                                        {{-- Total Superficie (Columna 5) --}}
                                        <td class="px-2 py-1 text-xs text-center">
                                            {{ number_format($totalSurfacePrivate, 2) }}
                                        </td>

                                        {{-- Celdas vacías (Columna 6 a 12: Resto de la tabla) --}}
                                        <td colspan="9" class="px-2 py-1"></td>
                                    </tr>
                                </tfoot>
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
                                        <th class="w-[20%] px-2 py-1 border">Descripcion</th>
                                        <th class="w-[5%] px-2 py-1 border">Edad</th>
                                        <th class="w-[5%] py-1 border">Vida útil</th>
                                        <th class="w-[5%] px-2 py-1 border">Vida útil remanente</th>
                                        <th class="w-[5%] px-2 py-1 border">Superficie</th>
                                        <th class="w-[5%] px-2 py-1 border">Costo unitario reposición nuevo</th>
                                        <th class="w-[5%] px-2 py-1 border">Factor edad</th>
                                        <th class="w-[5%] px-2 py-1 border">Factor conservación</th>
                                        <th class="w-[5%] px-2 py-1 border">Avance obra</th>
                                        <th class="w-[5%] px-2 py-1 border">Factor resultante</th>
                                        <th class="w-[5%] px-2 py-1 border">Costo unitario neto de reposición</th>
                                        <th class="w-[5%] px-2 py-1 border">Valor total</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    @if ($buildingConstructionsPrivate->isEmpty())
                                    <tr>
                                        <td colspan="12" class="px-2 py-4 text-center text-gray-500">
                                            No hay elementos registrados para calcular resultados
                                        </td>
                                    </tr>
                                    @else
                                    @foreach ($buildingConstructionsPrivate as $item)

                                    {{-- AQUI GENERAMOS LOS CÁLCULOS NECESARIOS PARA ASIGNAR A LOS VALORES SEGÚN SE
                                    NECESITE --}}
                                    @php
                                    // --- 1. CÁLCULO DE VIDA ÚTIL TOTAL ---
                                    $vidaUtilTotal = match ($item->clasification) {
                                    'Minima' => 30,
                                    'Economica' => 40,
                                    'Interes social' => 40,
                                    'Media' => 50,
                                    'Semilujo' => 70,
                                    'Residencial' => 90,
                                    'Residencial plus' => 90,
                                    'Residencial plus +' => 90,
                                    'Unica' => 0,
                                    };


                                    $factorConservacion = match ($item->conservation_state) {
                                    '0. Ruidoso' => 0.0, // <-- EJEMPLO: Reemplazar por tus valores '2. Bueno'=> 1.00,
                                        // <-- EJEMPLO: Reemplazar por tusvalores '0.8 Malo'=> 0.8,
                                            '1. Normal' => 1.0,
                                            '1. Bueno' => 1.0,
                                            '1.1 Muy bueno' => 1.1,
                                            '1. Nuevo' => 1.0,
                                            '1.1 Recientemente remodelado' => 1.1,

                                            };

                                            // --- DATOS DE ENTRADA DIRECTOS (Mantenemos para el renderizado) ---
                                            $edad = (float) $item->age;
                                            /* $superficie = (float) $item->surface;
                                            $costoUnitarioNuevo = (float) $item->unit_cost_replacement; */

                                            // Las demás variables de cálculo quedan sin definir por ahora.


                                            //CALCULOS DE VALORES

                                            // Vida útil remanente
                                            if ($vidaUtilTotal === 0) {
                                            $vidaUtilRemanente = 0;
                                            } else {
                                            $vidaUtilRemanente = $vidaUtilTotal - $edad;
                                            }



                                            @endphp


                                            <tr wire:key="result-private-{{ $item->id }}">
                                                {{-- 1. Descripción (Directo) --}}
                                                <td class="px-2 py-1 border text-xs text-center">{{ $item->description
                                                    }}</td>

                                                {{-- 2. Edad (Directo) --}}
                                                <td class="px-2 py-1 border text-xs text-center">{{
                                                    number_format($item->age, 0) }}</td>

                                                {{-- 3. Vida útil (CALCULADO O CONSTANTE - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">
                                                    {{number_format($vidaUtilTotal, 0)}}</td>

                                                {{-- 4. Vida útil remanente (CALCULADO - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">
                                                    {{number_format($vidaUtilRemanente, 0)}}</td>

                                                {{-- 5. Superficie (Directo) --}}
                                                <td class="px-2 py-1 border text-xs text-center">{{
                                                    number_format($item->surface, 2) }}</td>

                                                {{-- 6. Costo unitario reposición nuevo (Directo) --}}
                                                <td class="px-2 py-1 border text-xs text-center">${{
                                                    number_format($item->unit_cost_replacement, 2) }}</td>

                                                {{-- 7. Factor edad (CALCULADO - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">[N/A O CÁLCULO]</td>

                                                {{-- 8. Factor conservación (CALCULADO O DIRECTO - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">{{$factorConservacion}}
                                                </td>

                                                {{-- 9. Avance obra (Directo, con símbolo %) --}}
                                                <td class="px-2 py-1 border text-xs text-center">{{
                                                    number_format($item->progress_work, 2) }}%</td>

                                                {{-- 10. Factor resultante (CALCULADO - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">[N/A O CÁLCULO]</td>

                                                {{-- 11. Costo unitario neto de reposición (CALCULADO - Placeholder)
                                                --}}
                                                <td class="px-2 py-1 border text-xs text-center">${{ '[N/A O CÁLCULO]'
                                                    }}</td>

                                                {{-- 12. Valor total (CALCULADO - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">${{ '[N/A O CÁLCULO]'
                                                    }}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                </tbody>
                                <tfoot>
                                    <tr class="font-bold">

                                        {{-- Celdas vacías (Columna 1 a 4: Descripcion, Edad, VUT, VUR) --}}
                                        <td colspan="4" class="px-2 py-1"></td>

                                        {{-- Total Superficie (Columna 5) --}}
                                        <td class="px-2 py-1 text-xs text-center">
                                            {{ number_format($totalSurfacePrivate, 2) }}
                                        </td>

                                        {{-- Celdas vacías (Columna 6 a 12: Resto de la tabla) --}}
                                        <td colspan="7" class="px-2 py-1"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    @endif



                    @if ($activeTab === 'comunes')

                    {{-- BOTÓN MODAL PARA NUEVO ELEMENTO --}}
                    {{-- <flux:modal.trigger name="add-element" class="flex justify-end pt-8"> --}}
                        <div class="flex justify-end pt-4">
                            <flux:button class="btn-primary btn-table cursor-pointer mr-2" icon="plus"
                                wire:click="openAddElement('common')">
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
                                        <th class="px-2 py-1 border whitespace-nowrap">Descripcion</th>
                                        <th class="w-[120px] px-2 py-1 border whitespace-nowrap">Clasificación</th>
                                        <th class="w-[32px] px-2 py-1 border">Uso</th>
                                        <th class="w-[5%] px-2 py-1 border">Niveles edificio</th>
                                        <th class="w-[5%] px-2 py-1 border">Niveles por tipo de construcción</th>
                                        <th class="w-[5%] px-2 py-1 border">Rango niveles TGDF</th>
                                        <th class="w-[5%] px-2 py-1 border">Edad</th>
                                        <th class="w-[5%] px-2 py-1 border">Superficie</th>
                                        <th class="w-[5%] px-2 py-1 border">Fuente de información</th>
                                        <th class="w-[5%] px-2 py-1 border">Costo unit reposición nuevo</th>
                                        <th class="w-[5%] px-2 py-1 border">Avance obra</th>
                                        <th class="w-[5%] px-2 py-1 border">Estado de conservación</th>
                                        <th class="w-[5%] px-2 py-1 border">RA</th>
                                        <th class="w-[5%] px-2 py-1 border">Vend</th>
                                        <th class="w-[5%] px-2 py-1 border">Acc</th>
                                        <th class="w-[5%] px-2 py-1 border">Desc</th>
                                        <th class="w-[100px] py-1 border">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($buildingConstructionsCommon->isEmpty())
                                    <tr>
                                        <td colspan="18" class="px-2 py-4 text-center text-gray-500">
                                            No hay elementos registrados
                                        </td>
                                    </tr>
                                    @else
                                    @foreach ($buildingConstructionsCommon as $item)
                                    <tr wire:key="common-{{ $item->id }}">
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->description }}</td>
                                        <td class="px-2 py-1 border text-xs text-left">
                                            @if ($item->clasification === 'Minima')
                                            <span></span>1. Mínima</span><br>
                                            <span>1. Precaria</span><br>
                                            @elseif ($item->clasification === 'Economica')
                                            <span></span>2. Económica</span><br>
                                            <span>2. Económica</span><br>
                                            @elseif ($item->clasification === 'Interes social')
                                            <span></span>3. Interés social</span><br>
                                            <span>3. Eco-interés social</span><br>
                                            @elseif ($item->clasification === 'Media')
                                            <span></span>4. Media</span><br>
                                            <span>3. Media</span><br>
                                            @elseif ($item->clasification === 'Semilujo')
                                            <span></span>5. Semilujo</span><br>
                                            <span>4. Buena</span><br>
                                            @elseif ($item->clasification === 'Residencial')
                                            <span></span>6. Residencial</span><br>
                                            <span>5. Muy buena</span><br>
                                            @elseif ($item->clasification === 'Residencial plus')
                                            <span></span>7. Residencial plus</span><br>
                                            <span>6. Lujo</span><br>
                                            @elseif ($item->clasification === 'Residencial plus +')
                                            <span></span>7. Residencial plus +</span><br>
                                            <span>7. Especial</span><br>
                                            @elseif ($item->clasification === 'Unica')
                                            <span></span>0. Única</span><br>
                                            <span>U. Unica</span><br>
                                            @endif
                                        </td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->use }}</td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->building_levels }}
                                        </td>
                                        <td class="px-2 py-1 border text-xs text-center">{{
                                            $item->levels_construction_type
                                            }}</td>

                                        {{-- Rango niveles TGDF: Asumo que esto es un campo, si no lo es, usa N/A --}}
                                        <td class="px-2 py-1 border text-xs text-center">{{ 'N/A' }}</td>

                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->age }}</td>
                                        <td class="px-2 py-1 border text-xs text-center">{{
                                            number_format($item->surface, 2)
                                            }}</td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->source_information }}
                                        </td>
                                        <td class="px-2 py-1 border text-xs text-center">${{
                                            number_format($item->unit_cost_replacement, 2)
                                            }}</td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->progress_work }}%
                                        </td>
                                        <td class="px-2 py-1 border text-xs text-center">{{ $item->conservation_state }}
                                        </td>

                                        {{-- RA (Range Based Height) --}}
                                        <td class="px-2 py-1 border">
                                            {{--
                                            <flux:checkbox :checked="(bool) $item->range_based_height" disabled /> --}}
                                            {{-- <input type="checkbox" disabled {{ $item->range_based_height ?
                                            'checked' :
                                            '' }}> --}}
                                            <!-- Componente Flux UI para mostrar un checkbox de solo lectura -->
                                            <div class="flex justify-center">
                                                <flux:checkbox :checked="(bool) $item->range_based_height" {{--
                                                    Establece si el checkbox debe estar marcado. Convertimos el valor a
                                                    booleano explícito para asegurar compatibilidad con Flux UI. Si
                                                    $item->
                                                    range_based_height es true, el checkbox aparece marcado.
                                                    --}}

                                                    disabled
                                                    {{--
                                                    Evita que el usuario interactúe con el checkbox.
                                                    Es útil cuando solo quieres mostrar el estado, sin permitir cambios.
                                                    --}}

                                                    wire:key="checkbox-{{ $item->id }}-{{ (int)
                                                    $item->range_based_height
                                                    }}"
                                                    {{--
                                                    Esta es la parte más importante.

                                                    Livewire usa wire:key para identificar elementos únicos en el DOM.

                                                    Aquí generamos una clave única combinando:
                                                    - El ID del elemento ($item->id)
                                                    - El valor actual del campo ($item->range_based_height convertido a
                                                    entero)

                                                    Ejemplo:
                                                    Si el ID es 12 y el valor es true, la clave será: "checkbox-12-1"
                                                    Si luego cambia a false, será: "checkbox-12-0"

                                                    Como cambia el valor de wire:key, Livewire forzará el re-render del
                                                    checkbox
                                                    en lugar de intentar "reutilizar" el anterior, asegurando que se
                                                    actualice visualmente.
                                                    --}}
                                                    />
                                            </div>
                                        </td>

                                        {{-- Vend, Acc, Desc: Asumo que estos son campos de lógica/radio específicos.
                                        Aquí
                                        están los
                                        placeholders --}}
                                        {{-- Columna VEND --}}
                                        <td class="px-2 py-1 border text-sm text-center">
                                            <input type="radio" name="surface_vad_group_{{ $item->id }}" {{-- NOMBRE
                                                UNIFICADO --}} value="superficie vendible" class="w-4 h-4 text-blue-500"
                                                disabled {{ $item->surface_vad === 'superficie vendible' ? 'checked' :
                                            '' }}
                                            >
                                        </td>

                                        {{-- Columna ACC --}}
                                        <td class="px-2 py-1 border text-sm text-center">
                                            <input type="radio" name="surface_vad_group_{{ $item->id }}" {{-- NOMBRE
                                                UNIFICADO --}} value="superficie accesoria"
                                                class="w-4 h-4 text-blue-500" disabled {{ $item->surface_vad ===
                                            'superficie accesoria' ? 'checked' : '' }}
                                            >
                                        </td>

                                        {{-- Columna DESC --}}
                                        <td class="px-2 py-1 border text-sm text-center">
                                            <input type="radio" name="surface_vad_group_{{ $item->id }}" {{-- NOMBRE
                                                UNIFICADO --}} value="construccion superficie descubierta"
                                                class="w-4 h-4 text-blue-500" disabled {{ $item->surface_vad ===
                                            'construccion superficie descubierta' ? 'checked' : '' }}
                                            >
                                        </td>
                                        <td class="my-2 flex justify-evenly border">
                                            <flux:button type="button" icon-leading="pencil"
                                                class="cursor-pointer btn-intermediary btn-buildins"
                                                wire:click="openEditElement({{ $item->id }})" />
                                            <flux:button
                                                onclick="confirm('¿Estás seguro de que deseas eliminar este elemento?') || event.stopImmediatePropagation()"
                                                wire:click="deleteElement({{ $item->id }})" type="button"
                                                icon-leading="trash" class="cursor-pointer btn-deleted btn-buildings" />
                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="font-bold">

                                        {{-- Celdas vacías (Columna 1 a 4: Descripcion, Edad, VUT, VUR) --}}
                                        <td colspan="7" class="px-2 py-1"></td>

                                        {{-- Total Superficie (Columna 5) --}}
                                        <td class="px-2 py-1 text-xs text-center">
                                            {{ number_format($totalSurfaceCommon, 2) }}
                                        </td>

                                        {{-- Celdas vacías (Columna 6 a 12: Resto de la tabla) --}}
                                        <td colspan="9" class="px-2 py-1"></td>
                                    </tr>
                                </tfoot>
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
                                        <th class="w-[20%] px-2 py-1 border">Descripcion</th>
                                        <th class="w-[5%] px-2 py-1 border">Edad</th>
                                        <th class="w-[5%] py-1 border">Vida útil</th>
                                        <th class="w-[5%] px-2 py-1 border">Vida útil remanente</th>
                                        <th class="w-[5%] px-2 py-1 border">Superficie</th>
                                        <th class="w-[5%] px-2 py-1 border">Costo unitario reposición nuevo</th>
                                        <th class="w-[5%] px-2 py-1 border">Factor edad</th>
                                        <th class="w-[5%] px-2 py-1 border">Factor conservación</th>
                                        <th class="w-[5%] px-2 py-1 border">Avance obra</th>
                                        <th class="w-[5%] px-2 py-1 border">Factor resultante</th>
                                        <th class="w-[5%] px-2 py-1 border">Costo unitario neto de reposición</th>
                                        <th class="w-[5%] px-2 py-1 border">Valor total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($buildingConstructionsCommon->isEmpty())
                                    <tr>
                                        <td colspan="12" class="px-2 py-4 text-center text-gray-500">
                                            No hay elementos registrados para calcular resultados
                                        </td>
                                    </tr>
                                    @else
                                    @foreach ($buildingConstructionsCommon as $item)

                                    {{-- AQUI GENERAMOS LOS CÁLCULOS NECESARIOS PARA ASIGNAR A LOS VALORES SEGÚN SE
                                    NECESITE --}}
                                    @php
                                    // --- 1. CÁLCULO DE VIDA ÚTIL TOTAL ---
                                    $vidaUtilTotal = match ($item->clasification) {
                                    'Minima' => 30,
                                    'Economica' => 40,
                                    'Interes social' => 40,
                                    'Media' => 50,
                                    'Semilujo' => 70,
                                    'Residencial' => 90,
                                    'Residencial plus' => 90,
                                    'Residencial plus +' => 90,
                                    'Unica' => 0,
                                    };


                                    $factorConservacion = match ($item->conservation_state) {
                                    '0. Ruidoso' => 0.0, // <-- EJEMPLO: Reemplazar por tus valores '2. Bueno'=> 1.00,
                                        // <-- EJEMPLO: Reemplazar portusvalores '0.8 Malo'=> 0.8,
                                            '1. Normal' => 1.0,
                                            '1. Bueno' => 1.0,
                                            '1.1 Muy bueno' => 1.1,
                                            '1. Nuevo' => 1.0,
                                            '1.1 Recientemente remodelado' => 1.1,

                                            };

                                            // --- DATOS DE ENTRADA DIRECTOS (Mantenemos para el renderizado) ---
                                            $edad = (float) $item->age;
                                            /* $superficie = (float) $item->surface;
                                            $costoUnitarioNuevo = (float) $item->unit_cost_replacement; */

                                            // Las demás variables de cálculo quedan sin definir por ahora.


                                            //CALCULOS DE VALORES

                                            // Vida útil remanente
                                            if ($vidaUtilTotal === 0) {
                                            $vidaUtilRemanente = 0;
                                            } else {
                                            $vidaUtilRemanente = $vidaUtilTotal - $edad;
                                            }



                                            @endphp


                                            <tr wire:key="result-private-{{ $item->id }}">
                                                {{-- 1. Descripción (Directo) --}}
                                                <td class="px-2 py-1 border text-xs text-center">{{ $item->description
                                                    }}</td>

                                                {{-- 2. Edad (Directo) --}}
                                                <td class="px-2 py-1 border text-xs text-center">{{
                                                    number_format($item->age, 0) }}</td>

                                                {{-- 3. Vida útil (CALCULADO O CONSTANTE - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">
                                                    {{number_format($vidaUtilTotal, 0)}}</td>

                                                {{-- 4. Vida útil remanente (CALCULADO - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">
                                                    {{number_format($vidaUtilRemanente, 0)}}</td>

                                                {{-- 5. Superficie (Directo) --}}
                                                <td class="px-2 py-1 border text-xs text-center">{{
                                                    number_format($item->surface, 2) }}</td>

                                                {{-- 6. Costo unitario reposición nuevo (Directo) --}}
                                                <td class="px-2 py-1 border text-xs text-center">${{
                                                    number_format($item->unit_cost_replacement, 2) }}</td>

                                                {{-- 7. Factor edad (CALCULADO - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">[N/A O CÁLCULO]</td>

                                                {{-- 8. Factor conservación (CALCULADO O DIRECTO - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">{{$factorConservacion}}
                                                </td>

                                                {{-- 9. Avance obra (Directo, con símbolo %) --}}
                                                <td class="px-2 py-1 border text-xs text-center">{{
                                                    number_format($item->progress_work, 2) }}%</td>

                                                {{-- 10. Factor resultante (CALCULADO - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">[N/A O CÁLCULO]</td>

                                                {{-- 11. Costo unitario neto de reposición (CALCULADO - Placeholder)
                                                --}}
                                                <td class="px-2 py-1 border text-xs text-center">${{ '[N/A O CÁLCULO]'
                                                    }}</td>

                                                {{-- 12. Valor total (CALCULADO - Placeholder) --}}
                                                <td class="px-2 py-1 border text-xs text-center">${{ '[N/A O CÁLCULO]'
                                                    }}</td>
                                            </tr>
                                            @endforeach
                                            @endif
                                </tbody>
                                <tfoot>
                                    <tr class="font-bold">

                                        {{-- Celdas vacías (Columna 1 a 4: Descripcion, Edad, VUT, VUR) --}}
                                        <td colspan="4" class="px-2 py-1"></td>

                                        {{-- Total Superficie (Columna 5) --}}
                                        <td class="px-2 py-1 text-xs text-center">
                                            {{ number_format($totalSurfaceCommon, 2) }}
                                        </td>

                                        {{-- Celdas vacías (Columna 6 a 12: Resto de la tabla) --}}
                                        <td colspan="7" class="px-2 py-1"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>
                    @endif


                    <div class="form-grid form-grid--3 mt-[64px] mb-2 text-lg">
                        <h2 class="border-b-2 border-gray-300">Resumen de superficies y valores </h2>
                    </div>


                    <div class="mt-2 form-grid form-grid--3">
                        <div class="overflow-x-auto">
                            <table class="border-2 ">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border px-2 py-1 "></th>
                                        <th class="border px-2 py-1 ">Privativas</th>
                                        <th class="border px-2 py-1 ">Comunes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="border px-2 py-1 text-xs text-center">Superficie total de
                                            construcciones:
                                        </td>
                                        <td class="border px-2 py-1 text-sm text-center">
                                            {{number_format($totalSurfacePrivate, 2)}}
                                        </td>
                                        <td class="border px-2 py-1 text-sm text-center">
                                            {{number_format($totalSurfaceCommon, 2)}}
                                        </td>
                                    </tr>
                                    <tr>
                                        <td class="border px-2 py-1 text-xs text-center">Valor total de construcciones:
                                        </td>
                                        <td class="border px-2 py-1 text-xs text-center">1</td>
                                        <td class="border px-2 py-1 text-sm text-center">1</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>


                    <div class="mt-2 form-grid form-grid--3">
                        <div class="overflow-x-auto">
                            <table class="border-2 ">
                                <thead>
                                    <tr class="bg-gray-100">
                                        <th class="border px-2 py-1 "></th>
                                        <th class="border px-2 py-1 ">Vendible</th>
                                        <th class="border px-2 py-1 ">Acessoria</th>
                                    </tr>
                                </thead>
                                <tbody>

                                    {{-- Valor de ejemplo para usar en los for --}}
                                    <tr>
                                        <td class="border px-2 py-1 text-xs text-center">Superficie total de
                                            construcciones:
                                        </td>
                                        <td class="border px-2 py-1 text-sm text-center">{{number_format($totalSurfacePrivateVendible, 2)}}</td>
                                        <td class="border px-2 py-1 text-sm text-center">{{number_format($totalSurfacePrivateAccesoria, 2)}}</td>
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


        <div class="mt-2 form-grid form-grid--3">
            <div class="overflow-x-auto">
                <table class="border-2 ">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border px-2 py-1 "></th>
                            <th class="border px-2 py-1 ">Ponderada</th>
                        </tr>
                    </thead>
                    <tbody>

                        {{-- Valor de ejemplo para usar en los for --}}
                        <tr>
                            <td class="border px-2 py-1 text-xs text-center">Vida útil total del inmueble:</td>
                            <td class="border px-2 py-1 text-xs text-center">90 años</td>
                        </tr>

                        <tr>
                            <td class="border px-2 py-1 text-xs text-center">Edad del inmueble del inmueble:</td>
                            <td class="border px-2 py-1 text-xs text-center">1 año</td>
                        </tr>

                        <tr>
                            <td class="border px-2 py-1 text-xs text-center">Vida útil remanente del inmueble:</td>
                            <td class="border px-2 py-1 text-xs text-center">89 años</td>
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
                <flux:label>Fuente de donde se obtuvo el valor de reposición<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="text" wire:model='sourceReplacementObtained' />
                    </div>
                    <div>
                        <flux:error name="sourceReplacementObtained" />
                    </div>
                </flux:field>
            </div>
        </div>

        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Estado de conservación<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:select wire:model="conservationStatus" class=" text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Ruidoso">Ruidoso</flux:select.option>
                            <flux:select.option value="Malo">Malo</flux:select.option>
                            <flux:select.option value="Normal">Normal</flux:select.option>
                            <flux:select.option value="Bueno">Bueno</flux:select.option>
                            <flux:select.option value="Muy bueno">Muy bueno</flux:select.option>
                            <flux:select.option value="Nuevo">Nuevo</flux:select.option>
                            <flux:select.option value="Recientemente remodelado">Recientemente remodelado
                            </flux:select.option>
                        </flux:select>
                    </div>
                    <div>
                        <flux:error name="conservationStatus" />
                    </div>
                </flux:field>
            </div>
        </div>



        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Observaciones al estado de conservación<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:textarea wire:model='observationsStateConservation' />
                    </div>
                    <div>
                        <flux:error name="observationsStateConservation" />
                    </div>
                </flux:field>
            </div>
        </div>

        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Clase general de los inmuebles en la zona<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:select wire:model="generalTypePropertiesZone"
                            class=" text-gray-800 [&_option]:text-gray-900">
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
                        <flux:error name="generalTypePropertiesZone" />
                    </div>
                </flux:field>
            </div>
        </div>

        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Clase general del inmueble<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:select wire:model="generalClassProperty" class=" text-gray-800 [&_option]:text-gray-900"
                            :disabled="$isClassificationAssigned">
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
                        <flux:error name="generalClassProperty" />
                    </div>
                </flux:field>
            </div>
        </div>

        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Año de terminación de la obra<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" wire:model='yearCompletedWork' readonly />
                    </div>
                    <div>
                        <flux:error name="yearCompletedWork" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Unidades rentables (sujeto)<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" wire:model.lazy='profitableUnitsSubject' />
                    </div>
                    <div>
                        <flux:error name="profitableUnitsSubject" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Unidades rentables (generales)<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" wire:model.lazy='profitableUnitsGeneral' />
                    </div>
                    <div>
                        <flux:error name="profitableUnitsGeneral" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Unidades rentables del conjunto (en condominios)<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" wire:model.lazy='profitableUnitsCondominiums' />
                    </div>
                    <div>
                        <flux:error name="profitableUnitsCondominiums" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Número de niveles del sujeto<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" wire:model.lazy='numberSubjectLevels' />
                    </div>
                    <small>Se refiere al número de niveles total del inmueble valuado</small>
                    <div>
                        <flux:error name="numberSubjectLevels" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>% Avance de obra general<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" wire:model.lazy='progressGeneralWorks' readonly/>
                    </div>
                    <div>
                        <flux:error name="progressGeneralWorks" />
                    </div>
                </flux:field>
            </div>
        </div>
        <div class="form-grid form-grid--3 form-grid-3-variation">
            <div class="label-variation">
                <flux:label>Grado de % avance de áreas comunes<span class="sup-required">*</span>
                </flux:label>
            </div>
            <div class="radio-input">
                <flux:field>
                    <div class="radio-group-horizontal">
                        <flux:input type="number" wire:model.lazy='degreeProgressCommonAreas' />
                    </div>
                    <div>
                        <flux:error name="degreeProgressCommonAreas" />
                    </div>
                </flux:field>
            </div>
        </div>


    </div>
</div>










{{-- MODAL PARA CREAR NUEVO ELEMENTO --}}
<flux:modal name="add-element" class="md:w-96">
    <div class="space-y-2">
        <div class="mb-4">
            <flux:heading size="lg">Añadir elemento</flux:heading>
        </div>

        <flux:field class="flux-field">
            <flux:label>Descripción<span class="sup-required">*</span></flux:label>
            <flux:input type="text" wire:model='description' />
            <div class="error-container">
                <flux:error name="description" />
            </div>
        </flux:field>
        <flux:field class="flux-field">
            <label for="tipo" class="flux-label text-sm">Clasificación<span class="sup-required">*</span></label>
            <flux:select wire:model="clasification" class="text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                @foreach ($construction_classification as $value => $label)
                <flux:select.option value="{{ $label }}">
                    {{ $label }}
                </flux:select.option>
                @endforeach
            </flux:select>
            <div class="error-container">
                <flux:error name="clasification" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <label for="tipo" class="flux-label text-sm">Uso<span class="sup-required">*</span></label>
            <flux:select wire:model="use" class="text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                @foreach ($construction_use as $value => $label)
                <flux:select.option value="{{ $value }}">
                    {{ $value }} - {{$label}}
                </flux:select.option>
                @endforeach
            </flux:select>
            <div class="error-container">
                <flux:error name="use" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Niveles edificio<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='buildingLevels' />
            <div class="error-container">
                <flux:error name="buildingLevels" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Niveles por tipo de construcción<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='levelsConstructionType' />
            <div class="error-container">
                <flux:error name="levelsConstructionType" />
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
            <flux:label>Superficie<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='surface' />
            <div class="error-container">
                <flux:error name="surface" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <label for="tipo" class="flux-label text-sm">Fuente de información<span
                    class="sup-required">*</span></label>
            <flux:select wire:model="sourceInformation" class="text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                @foreach ($construction_source_information as $value => $label)
                <flux:select.option value="{{ $label }}">
                    {{$label}}
                </flux:select.option>
                @endforeach
            </flux:select>
            <div class="error-container">
                <flux:error name="sourceInformation" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Costo unit reposición nuevo<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='unitCostReplacement' />
            <div class="error-container">
                <flux:error name="unitCostReplacement" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Avance obra<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='progressWork' />
            <div class="error-container">
                <flux:error name="progressWork" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <label for="tipo" class="flux-label text-sm">Estado de conservación<span
                    class="sup-required">*</span></label>
            <flux:select wire:model="conservationState" class="text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                @foreach ($construction_conservation_state as $value => $label)
                <flux:select.option value="{{ $label }}">
                    {{$label}}
                </flux:select.option>
                @endforeach
            </flux:select>
            <div class="error-container">
                <flux:error name="conservationState" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Rango con base en la altura<span class="sup-required">*</span></flux:label>
            <flux:checkbox wire:model='rangeBasedHeight' class="cursor-pointer" />
            <div class="error-container">
                <flux:error name="adjacent" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Avance obra<span class="sup-required">*</span></flux:label>
            <flux:radio.group wire:model="surfaceVAD">
                <flux:radio value="superficie vendible" label="Superficie vendible" checked />
                <flux:radio value="superficie accesoria" label="Superficie accesoria" />
                <flux:radio value="construccion superficie descubierta" label="Construcción superficie descubierta" />
            </flux:radio.group>
            <div class="error-container">
                <flux:error name="surfaceVAD" />
            </div>
        </flux:field>

        <div class="flex">
            <flux:spacer />

            <flux:button type="button" wire:click='addElement' class="btn-primary btn-table cursor-pointer"
                variant="primary">Guardar
            </flux:button>
        </div>
    </div>
</flux:modal>
















{{-- MODAL PARA EDITAR ELEMENTO --}}
<flux:modal name="edit-element" class="md:w-96">
    <div class="space-y-2">
        <div>
            <flux:heading size="lg">Editar elemento</flux:heading>
        </div>

        <flux:field class="flux-field">
            <flux:label>Descripción<span class="sup-required">*</span></flux:label>
            <flux:input type="text" wire:model='description' />
            <div class="error-container">
                <flux:error name="description" />
            </div>
        </flux:field>
        <flux:field class="flux-field">
            <label for="tipo" class="flux-label text-sm">Clasificación<span class="sup-required">*</span></label>
            <flux:select wire:model="clasification" class="text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                @foreach ($construction_classification as $value => $label)
                <flux:select.option value="{{ $label }}">
                    {{ $label }}
                </flux:select.option>
                @endforeach
            </flux:select>
            <div class="error-container">
                <flux:error name="clasification" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <label for="tipo" class="flux-label text-sm">Uso<span class="sup-required">*</span></label>
            <flux:select wire:model="use" class="text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                @foreach ($construction_use as $value => $label)
                <flux:select.option value="{{ $value }}">
                    {{ $value }} - {{$label}}
                </flux:select.option>
                @endforeach
            </flux:select>
            <div class="error-container">
                <flux:error name="use" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Niveles edificio<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='buildingLevels' />
            <div class="error-container">
                <flux:error name="buildingLevels" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Niveles por tipo de construcción<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='levelsConstructionType' />
            <div class="error-container">
                <flux:error name="levelsConstructionType" />
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
            <flux:label>Superficie<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='surface' />
            <div class="error-container">
                <flux:error name="surface" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <label for="tipo" class="flux-label text-sm">Fuente de información<span
                    class="sup-required">*</span></label>
            <flux:select wire:model="sourceInformation" class="text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                @foreach ($construction_source_information as $value => $label)
                <flux:select.option value="{{ $label }}">
                    {{$label}}
                </flux:select.option>
                @endforeach
            </flux:select>
            <div class="error-container">
                <flux:error name="sourceInformation" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Costo unit reposición nuevo<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='unitCostReplacement' />
            <div class="error-container">
                <flux:error name="unitCostReplacement" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Avance obra<span class="sup-required">*</span></flux:label>
            <flux:input type="number" wire:model='progressWork' />
            <div class="error-container">
                <flux:error name="progressWork" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <label for="tipo" class="flux-label text-sm">Estado de conservación<span
                    class="sup-required">*</span></label>
            <flux:select wire:model="conservationState" class="text-gray-800 [&_option]:text-gray-900">
                <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                @foreach ($construction_conservation_state as $value => $label)
                <flux:select.option value="{{ $label }}">
                    {{$label}}
                </flux:select.option>
                @endforeach
            </flux:select>
            <div class="error-container">
                <flux:error name="conservationState" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Rango con base en la altura<span class="sup-required">*</span></flux:label>
            <flux:checkbox wire:model='rangeBasedHeight' class="cursor-pointer" />
            <div class="error-container">
                <flux:error name="adjacent" />
            </div>
        </flux:field>

        <flux:field class="flux-field">
            <flux:label>Superficie<span class="sup-required">*</span></flux:label>
            <flux:radio.group wire:model="surfaceVAD">
                <flux:radio value="superficie vendible" label="Superficie vendible" checked />
                <flux:radio value="superficie accesoria" label="Superficie accesoria" />
                <flux:radio value="construccion superficie descubierta" label="Construcción superficie descubierta" />
            </flux:radio.group>
            <div class="error-container">
                <flux:error name="surfaceVAD" />
            </div>
        </flux:field>
        <div class="flex">
            <flux:spacer />

            <flux:button type="button" class="btn-primary btn-table cursor-pointer" variant="primary"
                wire:click='editElement'>Editar elemento
            </flux:button>
        </div>
    </div>
</flux:modal>








































<flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos
</flux:button>
</form>
</div>
