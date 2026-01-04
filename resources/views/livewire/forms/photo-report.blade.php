<div>
    {{-- Script de SortableJS --}}
{{--     <script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.0/Sortable.min.js"></script> --}}

    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3">
        <span>* Campos obligatorios</span>
    </div>

  {{--   <form wire:submit.prevent='save'> --}}

        <div class="form-container">
            <div class="form-container__header">
                Reporte fotográfico
            </div>

            <div class="form-container__content">

                {{-- AREA DE CARGA (DROPZONE) --}}
                <div x-data="{ isDropping: false }"
                    class="relative w-full border-2 border-dashed rounded-lg h-32 text-center transition-all duration-200 ease-in-out bg-gray-50 hover:bg-gray-100 mb-6 group"
                    :class="{ 'border-[#43A497] bg-[#F0FDFD]': isDropping, 'border-gray-300': !isDropping }">

                    {{-- AQUI ESTÁ EL TRUCO: Agregamos el 'onchange' a tu input original --}}
                    <input type="file" multiple accept="image/png, image/jpeg, application/pdf"
                        class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-50" wire:model="newPhotos"
                        x-on:dragenter="isDropping = true" x-on:dragleave="isDropping = false"
                        x-on:drop="isDropping = false" onchange="
                            for(let i=0; i < this.files.length; i++){
                                if(this.files[i].size > 5242880){ // 5MB en bytes
                                    /* alert('El archivo «' + this.files[i].name + '» pesa más de 5MB. No se puede subir.'); */
                                    alert('Uno o más archivos tienen un tamaño mayor al permitido, verifica e intenta de nuevo.');
                                    this.value = ''; // ESTO CORTA LA SUBIDA DE GOLPE
                                    return false;
                                }
                            }
                        ">

                    <div wire:loading.remove wire:target="newPhotos"
                        class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none z-10">
                        <div
                            class="p-2 bg-white rounded-full shadow-sm mb-2 group-hover:scale-110 transition-transform">
                            <flux:icon name="cloud-arrow-up" class="w-8 h-8 text-gray-400 group-hover:text-[#3A8B88]" />
                        </div>
                        <div class="text-gray-600 text-sm">
                            <span class="font-bold text-[#3A8B88]">Arrastra aquí</span> o haz clic
                        </div>
                        {{-- TEXTO RECUPERADO --}}
                        <div class="text-[10px] text-gray-400 mt-1">
                            Imágenes o PDF (Máx. 5MB)
                        </div>
                    </div>

                    <div wire:loading.flex wire:target="newPhotos"
                        class="absolute inset-0 z-50 bg-white/90 flex flex-col items-center justify-center rounded-lg">
                        <div class="flex items-center space-x-2 text-[#3A8B88] font-semibold animate-pulse">
                            <flux:icon name="arrow-path" class="w-6 h-6 animate-spin" />
                            <span>Procesando archivos...</span>
                        </div>
                    </div>
                </div>

                {{-- BOTONES DE DESCARGA --}}
                <div class="flex justify-end items-center mb-4 gap-2">

                    @if(count($photosData) > 0)
                    <flux:button type="button"
                        onclick="confirm('¿Estás seguro?\n\nSe eliminarán TODOS los archivos de forma permanente.\n\nEsta acción no se puede deshacer.') || event.stopImmediatePropagation()"
                        wire:click="deleteAllPhotos" icon="trash" size="sm"
                        class="cursor-pointer btn-deleted btn-table">
                        Eliminar todo
                    </flux:button>
                    @endif
                    <flux:button type="button" wire:click="downloadSelected" icon="document-arrow-down" size="sm"
                        class="cursor-pointer btn-primary btn-table">
                        Descargar seleccionados
                    </flux:button>

                    <flux:button type="button" wire:click="downloadAll" icon="archive-box-arrow-down" size="sm"
                        class="cursor-pointer btn-primary btn-table">
                        Descargar todos
                    </flux:button>
                </div>

                {{-- TABLA --}}
               <div class="mt-2">
                <div class="overflow-x-auto max-w-full">
                    <table class="table-fixed w-full min-w-[950px] border-2 border-gray-300 bg-white">
                        <thead>
                            <tr class="bg-gray-100 text-xs font-bold text-gray-700">
                                {{-- AJUSTE DE PORCENTAJES AQUÍ --}}
                                <th class="w-[5%] px-2 py-1 border border-gray-300 text-center">No.</th>
                                <th class="w-[8%] px-2 py-1 border border-gray-300 text-center">Vista</th>
                                <th class="w-[25%] px-2 py-1 border border-gray-300 text-center">Categoría</th>
                                <th class="w-[42%] px-2 py-1 border border-gray-300 text-center">Descripción</th>
                                <th class="w-[10%] px-2 py-1 border border-gray-300 text-center">Impresión PDF</th>
                                <th class="w-[10%] px-2 py-1 border border-gray-300 text-center">Acciones</th>
                            </tr>
                        </thead>

                    <tbody x-data x-init="
                            const initSortable = () => {
                                if (typeof Sortable !== 'undefined') {
                                    new Sortable($el, {
                                        handle: '.drag-handle',
                                        animation: 150,
                                        ghostClass: 'bg-teal-100',
                                        onEnd: function (evt) {
                                            let orderedIds = Array.from(evt.to.children)
                                                .map(el => el.dataset.id)
                                                .filter(id => id !== undefined);
                                            $wire.reorder(orderedIds);
                                        }
                                    });
                                }
                            };

                            {{-- Lo ejecutamos al cargar --}}
                            initSortable();

                            {{-- Y lo relanzamos si Livewire refresca el componente --}}
                            document.addEventListener('livewire:navigated', () => initSortable());
                            $wire.on('photos-updated', () => initSortable());
                        ">
                            @if ($photos->isEmpty())
                            <tr>
                                <td colspan="6" class="px-2 py-8 text-center text-gray-500 text-sm italic border border-gray-300">
                                    No hay elementos registrados
                                </td>
                            </tr>
                            @else
                            @foreach ($photos as $photo)
                            @php
                            $isPdf = Str::endsWith(Str::lower($photo->file_path), '.pdf');
                            @endphp

                            <tr wire:key="photo-{{ $photo->id }}" data-id="{{ $photo->id }}"
                                class="hover:bg-gray-50 group border-b border-gray-300">

                                {{-- 1. No. + Ícono Drag --}}
                                <td class="px-2 py-1 border border-gray-300 text-center">
                                    <div class="drag-handle flex flex-col items-center justify-center h-full cursor-grab active:cursor-grabbing p-2 hover:bg-gray-100 rounded transition-colors"
                                        >
                                        <flux:icon name="bars-3" class="w-6 h-6 text-gray-500 mb-1" />
                                        <span class="text-xs font-bold text-gray-700">{{ $photo->sort_order }}</span>
                                    </div>
                                </td>

                                {{-- 2. Vista Previa --}}
                          <td class="px-2 py-1 border border-gray-300">
                            <div class="flex items-center justify-center py-2">
                                {{--
                                CAMBIO: Quitamos el botón absoluto invisible.
                                Ahora el div contenedor tiene el wire:click directo.
                                Esto elimina el "ruido" del cursor.
                                --}}
                                <div @if(!$isPdf) wire:click="openPreview({{ $photo->id }})"
                                    class="w-32 h-32 bg-gray-50 border border-gray-200 rounded flex items-center justify-center overflow-hidden shadow-sm hover:scale-105 hover:shadow-md transition-all cursor-pointer"
                                    @else
                                    class="w-32 h-32 bg-gray-50 border border-gray-200 rounded flex items-center justify-center overflow-hidden shadow-sm"
                                    @endif>

                                    @if($isPdf)
                                    <div class="flex flex-col items-center text-red-600">
                                        <flux:icon name="document-text" class="w-12 h-12" />
                                        <span class="text-[10px] font-bold mt-1 text-gray-600">PDF</span>
                                    </div>
                                    @else
                                    {{-- Eliminamos el button invisible intermedio --}}
                                    <img src="{{ asset('storage/' . $photo->file_path) }}"
                                        class="object-contain w-full h-full pointer-events-none"
                                        style="transform: rotate({{ $photo->rotation_angle }}deg);">
                                    @endif
                                </div>
                            </div>
                        </td>

                                {{-- 3. Categoría (AHORA MÁS ANCHA) --}}
                                <td class="px-2 py-1 border border-gray-300">
                                    <div class="flex items-center gap-1.5 h-full">
                                        @if(empty($photosData[$photo->id]['category']))
                                        <div class="flex-shrink-0 cursor-help" title="Campo pendiente">
                                            <flux:icon name="exclamation-circle" class="w-5 h-5 dark-red-500 stroke-2" />
                                        </div>
                                        @endif
                                        <div class="flex-grow">
                                            <flux:select wire:model="photosData.{{ $photo->id }}.category"
                                                wire:change="updatePhotoField({{ $photo->id }}, 'category')" size="sm"
                                                class="w-full text-xs">
                                                <flux:select.option value="">-- Selecciona --</flux:select.option>
                                                @if($isPdf)
                                                @foreach($pdfCategories as $cat)
                                                <flux:select.option value="{{ $cat }}">{{ $cat }}</flux:select.option>
                                                @endforeach
                                                @else
                                                @foreach($photoCategories as $cat)
                                                <flux:select.option value="{{ $cat }}">{{ $cat }}</flux:select.option>
                                                @endforeach
                                                @endif
                                            </flux:select>
                                        </div>
                                    </div>
                                </td>

                                {{-- 4. Descripción --}}
                                <td class="px-2 py-1 border border-gray-300">
                                    <div class="flex items-center h-full">
                                        <flux:input type="text" wire:model.blur="photosData.{{ $photo->id }}.description"
                                            wire:blur="updatePhotoField({{ $photo->id }}, 'description')" size="sm"
                                            class="w-full text-xs" placeholder="Descripción..." />
                                    </div>
                                </td>

                                {{-- 5. Impresión PDF (MÁS GRANDE) --}}
                                <td class="px-2 py-1 border border-gray-300 text-center">
                                    <div class="flex items-center justify-center h-full">
                                        <flux:checkbox wire:model="photosData.{{ $photo->id }}.isPrintable"
                                            wire:change="updatePhotoField({{ $photo->id }}, 'isPrintable')" />
                                    </div>
                                </td>

                            {{-- 6. Acciones --}}
                            <td class="px-2 py-1 border border-gray-300">
                                {{-- Usamos justify-around como pediste, pero ahora funcionará bien --}}
                                <div class="flex items-center justify-around w-full">

                                    @if(!$isPdf)
                                    {{-- Botón Girar (Visible) --}}
                                    <flux:button wire:click="rotatePhoto({{ $photo->id }})" icon="arrow-path" size="sm"
                                        class="cursor-pointer btn-intermediary" />
                                        {{-- class="cursor-pointer !bg-blue-600 hover:!bg-blue-700 !text-white !border-0" title="Girar" /> --}}
                                    @else
                                    {{-- EL TRUCO: Elemento invisible del mismo tamaño (Ghost) --}}
                                    {{-- Esto ocupa el espacio pero no se ve, manteniendo la alineación --}}
                                    <div class="w-8 h-8 invisible"></div>
                                    @endif

                                    {{-- Botón Ver --}}
                                    <a href="{{ asset('storage/' . $photo->file_path) }}" target="_blank">
                                        <flux:button icon="eye" size="sm"
                                            class="cursor-pointer btn-intermediary" />
                                    </a>

                                    {{-- Botón Eliminar --}}
                                    <flux:button onclick="confirm('¿Eliminar archivo?') || event.stopImmediatePropagation()"
                                        wire:click="deletePhoto({{ $photo->id }})" icon="trash" size="sm"
                                        class="cursor-pointer btn-deleted" />
                                       {{--  class="cursor-pointer !bg-red-500 hover:!bg-red-600 !text-white !border-0" /> --}}

                                </div>
                            </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

            </div>
        </div>

        <div class="flex justify-start mt-4">
            <flux:button class="btn-primary cursor-pointer" type="button" variant="primary" wire:click='nextComponent'>
                Continuar
            </flux:button>
        </div>
{{-- <div x-data="{ openPdfModal: false }">

    <flux:button @click="openPdfModal = true">IMPRIMIR AVALÚO</flux:button>

    <div x-show="openPdfModal" class="fixed inset-0 z-50 overflow-y-auto" style="display: none;">
        <div class="fixed inset-0 bg-black opacity-50" @click="openPdfModal = false"></div>

        <div class="relative min-h-screen flex items-center justify-center p-4">
            <livewire:forms.pdf-export />
        </div>
    </div>
</div>
 --}}

{{-- MODAL VISTA PREVIA: Simple, Fondo Blanco, GIGANTE --}}
<flux:modal name="preview-modal" {{-- !max-w-[90vw] permite que crezca a lo ancho. w-auto se ajusta a la foto. --}}
    class="bg-white p-2 rounded-xl shadow-2xl !max-w-[90vw] !w-auto h-auto outline-none">

    <div class="relative flex items-center justify-center outline-none">
        @if($previewPhoto)
        <img src="{{ asset('storage/' . $previewPhoto->file_path) }}" {{-- max-h-[90vh] es la clave: fuerza la altura al
            90% de tu pantalla --}} class="max-h-[90vh] object-contain rounded"
            style="transform: rotate({{ $previewPhoto->rotation_angle }}deg);">
        @endif
    </div>
</flux:modal>
    {{-- </form> --}}
</div>
