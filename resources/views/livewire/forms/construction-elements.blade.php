<div>
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
                        <button @click="open = !open" class="text-[#000000] focus:outline-none cursor-pointer">
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
                            <button wire:click.prevent="setTab('{{ $key }}')" @click="open = false" class="cursor-pointer w-full text-left px-4 py-3 transition-colors
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

            {{-- Contenedor de contenido al 100% del ancho y alto disponible --}}
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
                                <input type="number" wire:model.defer=" " class="w-24 border rounded px-1 py-0.5">
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
                        <input type="text" wire:model.live="acabados1_pasta" class="border rounded w-full px-2 py-1">
                    </label>
                    <label class="block">
                        Espesor (mm):
                        <input type="number" wire:model.live="acabados1_espesor"
                            class="border rounded w-full px-2 py-1">
                    </label>
                </div>
                @endif

                {{-- Acabados 2 --}}
                @if ($activeTab === 'acabados2')
                <h2 class="text-lg font-semibold mb-4">Acabados 2</h2>
                <p>Aquí puedes poner selects, sliders, lo que necesites.</p>
                @endif

                {{-- Carpintería --}}
                @if ($activeTab === 'carpinteria')
                <h2 class="text-lg font-semibold mb-4">Carpintería</h2>
                <textarea wire:model.live="carpinteria_notas" class="border rounded w-full h-32 p-2"
                    placeholder="Descripción de carpintería..."></textarea>
                @endif

                {{-- Hidráulicas y sanitarias --}}
                @if ($activeTab === 'hidraulicas')
                <h2 class="text-lg font-semibold mb-4">Hidráulicas y sanitarias</h2>
                <div class="grid grid-cols-2 gap-4">
                    <input type="text" wire:model.live="hidraulicas_tuberia" placeholder="Tipo de tubería"
                        class="border rounded p-2">
                    <input type="number" wire:model.defer="hidraulicas_diametro" placeholder="Diámetro (mm)"
                        class="border rounded p-2">
                </div>
                @endif

                {{-- Herrería --}}
                @if ($activeTab === 'herreria')
                <h2 class="text-lg font-semibold mb-4">Herrería</h2>
                <p>Define aquí tus inputs, tablas o lo que requieras.</p>
                @endif

                {{-- Otros elementos --}}
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
