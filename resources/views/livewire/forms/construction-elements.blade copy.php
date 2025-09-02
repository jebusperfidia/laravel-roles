<div>
    <div class="form-container">
        <div class="form-container__header">
            Elementos de la construcción
        </div>
        <div class="form-container__content">

            <div class="flex flex-col w-full h-full">

                {{-- Contenedor del Navbar con Alpine.js para la responsividad --}}
                {{-- CAMBIO 2: Se añade un margen inferior (mb-4) para separar la barra del contenido --}}
                <div x-data="{ open: false }" class="relative md:flex md:items-center md:justify-between mb-4">

                    {{-- Botón de "hamburguesa" para vista móvil (sin cambios) --}}
                    <div class="flex items-center justify-between w-full p-2 border-b md:hidden">
                        <span class="font-semibold text-gray-700">Menú de Secciones</span>
                        <button @click="open = !open" class="text-gray-600 hover:text-gray-800 focus:outline-none">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16m-7 6h7"></path>
                            </svg>
                        </button>
                    </div>

                    {{--
                    CAMBIO 2 (CONTINUACIÓN): El borde inferior ahora es más discreto (border-gray-200)
                    y solo se aplica a la barra principal, no a cada elemento.
                    --}}
                    <flux:navbar :class="{'hidden': !open, 'flex': open}"
                        class="flex-col w-full mt-2 md:flex md:flex-row md:items-center md:mt-0 md:border-b md:border-gray-200 absolute md:relative z-10 bg-white shadow-md md:shadow-none rounded-md p-2 md:p-0">
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
                        @endphp
                        @foreach ($tabs as $key => $label)
                        <flux:navbar.item wire:click.prevent="setTab('{{ $key }}')" @click="open = false"
                            :active="$activeTab === '{{ $key }}'" {{-- Se eliminaron los bordes de separación de aquí
                            --}}
                            class="cursor-pointer mb-4 px-4 py-3 md:py-2 transition-colors
                                {{ $activeTab === $key
                                    ? 'border-b-2 border-[#43A497] text-[#3A8B88] font-semibold bg-gray-50 md:bg-transparent'
                                    : 'text-gray-600 hover:text-[#5CBEB4] hover:bg-gray-50 md:hover:bg-transparent' }}">
                            {{ $label }}
                        </flux:navbar.item>

                        {{--
                        CAMBIO 3: Se añade un punto como separador minimalista.
                        - Se muestra solo en pantallas de escritorio ('hidden md:inline').
                        - Se usa la variable $loop->last de Blade para no añadir un punto después del último elemento.
                        --}}
                        @if (!$loop->last)
                        <span class="hidden md:inline text-gray-300 mx-2">&bull;</span>
                        @endif
                        @endforeach
                    </flux:navbar>
                </div>

                {{--
                CAMBIO 1: El contenido de aquí en adelante no fue modificado en absoluto,
                tal como lo solicitaste.
                --}}
                <div class="w-full flex-1 p-4 overflow-auto">

                    {{-- Obra negra --}}
                    @if ($activeTab === 'obra_negra')
                    <h2 class="text-lg font-semibold mb-4">Obra negra</h2>
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
                                    <input type="number" wire:model.defer="obraNegra.ladrillo"
                                        class="w-24 border rounded px-1 py-0.5">
                                </td>
                                <td class="px-2 py-1 border">$</td>
                            </tr>
                            {{-- ... más filas --}}
                        </tbody>
                    </table>
                    @endif

                    {{-- Acabados 1 --}}
                    @if ($activeTab === 'acabados1')
                    <h2 class="text-lg font-semibold mb-4">Acabados 1</h2>
                    <div class="space-y-3">
                        <label class="block">
                            Tipo de pasta:
                            <input type="text" wire:model.defer="acabados1.pasta"
                                class="border rounded w-full px-2 py-1">
                        </label>
                        <label class="block">
                            Espesor (mm):
                            <input type="number" wire:model.defer="acabados1.espesor"
                                class="border rounded w-full px-2 py-1">
                        </label>
                    </div>
                    @endif

                    {{-- El resto de tus vistas de tabs no necesita cambios --}}
                    @if ($activeTab === 'acabados2')
                    <h2 class="text-lg font-semibold mb-4">Acabados 2</h2>
                    <p>Aquí puedes poner selects, sliders, lo que necesites.</p>
                    @endif
                    @if ($activeTab === 'carpinteria')
                    <h2 class="text-lg font-semibold mb-4">Carpintería</h2>
                    <textarea wire:model.defer="carpinteria.notas" class="border rounded w-full h-32 p-2"
                        placeholder="Descripción de carpintería..."></textarea>
                    @endif
                    @if ($activeTab === 'hidraulicas')
                    <h2 class="text-lg font-semibold mb-4">Hidráulicas y sanitarias</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" wire:model.defer="hidraulicas.tuberia" placeholder="Tipo de tubería"
                            class="border rounded p-2">
                        <input type="number" wire:model.defer="hidraulicas.diametro" placeholder="Diámetro (mm)"
                            class="border rounded p-2">
                    </div>
                    @endif
                    @if ($activeTab === 'herreria')
                    <h2 class="text-lg font-semibold mb-4">Herrería</h2>
                    <p>Define aquí tus inputs, tablas o lo que requieras.</p>
                    @endif
                    @if ($activeTab === 'otros')
                    <h2 class="text-lg font-semibold mb-4">Otros elementos</h2>
                    <p>Más campos extras u observaciones.</p>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
</div>
