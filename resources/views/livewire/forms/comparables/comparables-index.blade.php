<div>
    <div class="flex justify-between">
        <p>
            @if ($valuation)
            Folio de valuación: <strong>{{ $valuation->folio }}</strong>

            @else
        <p>no se encontró folio</p>
        @endif

        </p>
        <a wire:click="backForms"
            wire:confirm="¿Estás seguro de que deseas salir? Se borrarán los datos de la sesión actual."
            class="cursor-pointer btn-deleted">
            Regresar a enfoque de mercado
        </a>
    </div>
    <br>

    <flux:separator />
    <div class="pt-4">
        <flux:button variant="primary" class="cursor-pointer btn-primary" wire:click='addComparable'>Agregar
            comparable</flux:button>
    </div>
   {{--  <div class="form-container">
        <div class="form-container__header">
            Filtros de búsqueda
        </div>
        <div class="form-container__content">
            <div class="form-grid form-grid--2">

            </div>
        </div>
    </div>
 --}}
    <div class="form-container">
        <div class="form-container__header">
            Comparables disponibles
        </div>
        <div class="form-container__content">
         {{--    <div class="form-grid form-grid--2 overflow-x-auto"> --}}
                <livewire:forms.comparables.comparables-table>
           {{--  </div> --}}
        </div>
    </div>

{{--     <div class="form-container">
        <div class="form-container__header">
            Comparables asignados
        </div>
        <div class="form-container__content">
            <div class="form-grid ">
                <div class="mt-2">
                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="px-2 py-1 border">Folio</th>
                                    <th class="px-2 py-1 border">Propiedad</th>
                                    <th class="px-2 py-1 border">Estado</th>
                                    <th class="px-2 py-1 border">Ciudad</th>
                                    <th class="px-2 py-1 border">Colonia</th>
                                    <th class="px-2 py-1 border">Calle</th>
                                    <th class="px-2 py-1 border">N°</th>
                                    <th class="px-2 py-1 border">CP</th>
                                    <th class="px-2 py-1 border">Oferta</th>
                                    <th class="px-2 py-1 border">Terreno</th>
                                    <th class="px-2 py-1 border">Construida</th>
                                    <th class="px-2 py-1 border">Unitario</th>
                                    <th class="w-[100px] py-1 border">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if ($assignedComparables->isEmpty())
                                <tr>
                                    <td colspan="13" class="px-2 py-4 text-center text-gray-500">
                                        No hay comparables asignados
                                    </td>
                                </tr>
                                @else
                                @foreach ($assignedComparables as $item)
                                <tr>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_folio }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_property }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_entity_name }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_locality_name }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_colony }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_street }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_abroad_number }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_cp }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_offers }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_land_area }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_built_area }}</td>
                                    <td class="px-2 py-1 border text-sm text-center">{{ $item->comparable_unit_value }}</td>
                                    <td class="my-2 flex justify-evenly">
                                        <flux:button type="button" icon-leading="pencil"
                                            class="cursor-pointer btn-intermediary btn-buildins"
                                            wire:click="editComparable({{ $item->id }})" />
                                        <flux:button
                                            onclick="confirm('¿Estás seguro de que deseas eliminar este comparable?') || event.stopImmediatePropagation()"
                                            wire:click="deleteComparable({{ $item->id }})" icon-leading="trash"
                                            class="cursor-pointer btn-deleted btn-buildings" />
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
    </div> --}}











<div class="form-container">
    <div class="form-container__header">
        Comparables asignados
    </div>
    <div class="form-container__content">
        <div class="form-grid">
            <div class="mt-2">
                <div class="overflow-x-auto max-w-full">
                    <table class="min-w-[550px] table-fixed w-full border-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="w-[20px] py-2 border">#</th> <!-- Posición -->
                                {{-- <th class="px-2 py-2 border">Folio</th> --}}

                                <th class="px-2 py-2 border">Mover</th>
                                {{-- <th class="px-2 py-2 border">Propiedad</th> --}}
                                <th class="px-2 py-2 border">Estado</th>
                                <th class="px-2 py-2 border">Ciudad</th>
                                <th class="px-2 py-2 border">Colonia</th>
                                <th class="px-2 py-2 border">Calle</th>
                                <th class="px-2 py-2 border">N°</th>
                                <th class="px-2 py-2 border">CP</th>
                                <th class="px-2 py-2 border">Oferta</th>
                                <th class="px-2 py-2 border">Terreno</th>
                                <th class="px-2 py-2 border">Construida</th>
                                <th class="px-2 py-2 border">Unitario</th>
                                <th class="w-[320px] py-2 border">Acciones</th> <!-- Editar/Eliminar -->
                                <!-- Nueva columna para flechas -->
                            </tr>
                        </thead>
                        <tbody>
                            @if ($assignedComparables->isEmpty())
                            <tr>
                                <td colspan="15" class="px-2 py-4 text-center text-gray-500">
                                    No hay comparables asignados
                                </td>
                            </tr>
                            @else
                            @foreach ($assignedComparables as $item)
                            <tr>
                                <!-- Posición -->
                                <td class="px-2 py-2 border text-sm text-center">{{ $item->pivot->position }}</td>
                                <td class="px-2 py-2 border text-center">
                                    <div class="flex justify-center gap-2">
                                        <flux:button type="button" icon-leading="chevron-double-down" class="cursor-pointer btn-primary btn-buildings"
                                            wire:click="moveComparable({{ $item->id }}, 'down')" wire:loading.attr="disabled" :disabled="$loop->last" />

                                        <flux:button type="button" icon-leading="chevron-double-up" class="cursor-pointer btn-primary btn-buildings"
                                            wire:click="moveComparable({{ $item->id }}, 'up')" wire:loading.attr="disabled" :disabled="$loop->first" />

                                    </div>
                                </td>

                               {{--  <td class="px-2 py-2 border text-sm text-center">{{ $item->comparable_folio }}</td> --}}
                                {{-- <td class="px-2 py-2 border text-sm text-center">{{ $item->comparable_property }}</td> --}}
                                <td class="px-2 py-2 border text-sm text-center">{{ $item->comparable_entity_name }}
                                </td>
                                <td class="px-2 py-2 border text-sm text-center">{{ $item->comparable_locality_name }}
                                </td>
                                <td class="px-2 py-2 border text-sm text-center">{{ $item->comparable_colony }}</td>
                                <td class="px-2 py-2 border text-sm text-center">{{ $item->comparable_street }}</td>
                                <td class="px-2 py-2 border text-sm text-center">{{ $item->comparable_abroad_number }}
                                </td>
                                <td class="px-2 py-2 border text-sm text-center">{{ $item->comparable_cp }}</td>
                                <td class="px-2 py-2 border text-sm text-center">$ {{

                                rtrim(rtrim(number_format($item->comparable_offers, 6, '.', ','), '0'), '.')
                                }}</td>
                                <td class="px-2 py-2 border text-sm text-center">{{
                                rtrim(rtrim(number_format($item->comparable_land_area, 6, '.', ','), '0'), '.')
                                }}</td>
                                <td class="px-2 py-2 border text-sm text-center">{{
                                rtrim(rtrim(number_format($item->comparable_land_area, 6, '.', ','), '0'), '.')
                                }}</td>
                                <td class="px-2 py-2 border text-sm text-center">{{
                                rtrim(rtrim(number_format($item->comparable_built_area, 6, '.', ','), '0'), '.')
                                }}</td>

                                <!-- Resumen / Editar / Eliminar  -->
                               <td class="px-2 py-2 border text-center">
                                <div class="flex justify-center gap-4">

                                    <flux:button type="button"  class="cursor-pointer btn-change btn-table text-sm"
                                        wire:click="$dispatch('openSummary', { id: {{ $item->id }} })">Resumen</flux:button>

                                    <flux:button type="button" class="cursor-pointer btn-intermediary btn-table text-sm"
                                        wire:click="editComparable({{ $item->id }})">Editar</flux:button>

                                    <flux:button type="button"
                                        onclick="confirm('¿Estás seguro de que deseas eliminar este comparable?') || event.stopImmediatePropagation()"
                                        wire:click="deallocatedElement({{ $item->id }})" class="cursor-pointer btn-deleted btn-table text-sm">Quitar</flux:button>
                                </div>
                             {{--    <div class="flex justify-center gap-2">

                                   <flux:button type="button" icon-leading="document-text" class="cursor-pointer btn-change btn-buildins"
                                    wire:click="$dispatch('openSummary', { id: {{ $item->id }} })" />

                                    <flux:button type="button" icon-leading="pencil" class="cursor-pointer btn-intermediary btn-buildins"
                                        wire:click="editComparable({{ $item->id }})" />

                                    <flux:button type="button" icon-leading="trash"
                                        onclick="confirm('¿Estás seguro de que deseas eliminar este comparable?') || event.stopImmediatePropagation()"
                                        wire:click="deleteComparable({{ $item->id }})" class="cursor-pointer btn-deleted btn-buildings" />
                                </div> --}}
                            </td>

                                <!-- Flechas para mover -->
                              <!-- Flechas para mover -->


                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>










<!-- Loader -->
{{-- <div wire:loading wire:target="assignedElement, moveComparable, deleteComparable, editComparable"
    class="fixed inset-0 z-50 bg-black bg-opacity-40 backdrop-blur-sm items-center justify-center">
    <div class="bg-white rounded-xl p-6 flex flex-col items-center">
        <svg class="animate-spin h-10 w-10 text-blue-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 018 8h-4l3 3 3-3h-4a8 8 0 01-8 8v-4l-3 3 3 3v-4a8 8 0 01-8-8z" />
        </svg>
        <span class="text-gray-700 font-medium">Actualizando comparables...</span>
    </div>
</div>

 --}}

{{-- <div x-data="{ open: @entangle('isLoading') }" x-show="open"
    class="fixed inset-0 z-50 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center">
    <div class="bg-white rounded-xl p-6 flex flex-col items-center">
        <svg class="animate-spin h-10 w-10 text-blue-600 mb-2" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8v4l3-3-3-3v4a8 8 0 018 8h-4l3 3 3-3h-4a8 8 0 01-8 8v-4l-3 3 3 3v-4a8 8 0 01-8-8z" />
        </svg>
        <span class="text-gray-700 font-medium">Actualizando comparables...</span>
    </div>
</div>
 --}}





    {{-- MODAL PARA AGREGAR UN NUEVO COMPARABLE --}}
    <flux:modal :dismissible="false" name="modal-comparable" class="md:w-110">
        <div class="space-y-4">
            <div>
                <flux:heading size="lg"><b class="text-lg">Nuevo comparable</b></flux:heading>
                <flux:text class="mt-2 font-bold">Indique los valores solicitados</flux:text>
            </div>
            <flux:separator />





            {{-- Datos de asignación --}}
            {{-- <div class="form-grid form-grid--1 mt-[20px]">
                <h2>Datos de asignación:</h2>
            </div> --}}

            <div class="form-grid form-grid--1 mt-3 mb-2 text-md">
                <h2><span class="border-b-2 border-gray-300 font-semibold">Datos de asignación</span></h2>
            </div>

            <flux:field class="flux-field">
                <flux:label>Clave</flux:label>
                <flux:input type="text" wire:model='comparableKey' readonly />
                <div class="error-container">
                    <flux:error name="comparableKey" />
                </div>
            </flux:field>

            <flux:field class="flux-field">
                <flux:label>Folio:<span class="sup-required">*</span></flux:label>
                <flux:input type="text" wire:model='comparableFolio' readonly />
                <small>Servicio para el cual se captura el mercado</small>
                <div class="error-container">
                    <flux:error name="comparableFolio" />
                </div>
            </flux:field>

            <flux:field class="flux-field">
                <flux:label>Dado de alta por:<span class="sup-required">*</span></flux:label>
                <flux:input type="text" wire:model='comparableDischargedBy' readonly />
                <div class="error-container">
                    <flux:error name="comparableDischargedBy" />
                </div>
            </flux:field>






            {{-- Datos de inmueble --}}
           <div class="form-grid form-grid--1 mt-3 mb-2 text-md">
                <h2><span class="border-b-2 border-gray-300 font-semibold">Datos del inmueble</span></h2>
            </div>

            <flux:field class="flux-field">
                <label class="flux-label text-sm">Tipo de inmueble<span class="sup-required">*</span></label>
                <flux:select wire:model="comparableProperty" class="text-gray-800 [&_option]:text-gray-900">
                    <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                    <flux:select.option value="Terreno">Terreno</flux:select.option>
                    <flux:select.option value="Terreno en condominio">Terreno en condominio</flux:select.option>
                </flux:select>
                <div class="error-container">
                    <flux:error name="comparableProperty" />
                </div>
            </flux:field>

            <flux:field class="flux-field">
                <flux:label>Código postal<span class="sup-required">*</span></flux:label>
                <flux:input.group>
                    <flux:input type="text" wire:model='comparableCp' />
                    <flux:button wire:click='buscarCP' icon="magnifying-glass" class="cursor-pointer">
                    </flux:button>
                </flux:input.group>
                <div class="error-container">
                    <flux:error name="comparableCp" />
                </div>
            </flux:field>

            <flux:field class="flux-field">
                <flux:label>Entidad</flux:label>
                <flux:select wire:model.live="comparableEntity" class="text-gray-800 [&_option]:text-gray-900">
                    <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                    @foreach($states as $id => $state)
                    <flux:select.option value="{{ $id }}">{{ $state }}</flux:select.option>
                    @endforeach
                </flux:select>
                <div class="error-container">
                    <flux:error name="comparableEntity" />
                </div>
            </flux:field>

            <flux:field class="flux-field">
                <flux:label>Alcaldia/municipio</flux:label>
                <flux:select wire:model.live="comparableLocality" class="text-gray-800 [&_option]:text-gray-900"
                    :disabled="empty($municipalities)">
                    <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                    @foreach($municipalities as $id => $nombre)
                    <option value="{{ $id }}" {{ $id===$comparableLocality ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                    @endforeach
                </flux:select>
                <div class="error-container">
                    <flux:error name="comparableLocality" />
                </div>
            </flux:field>

            <div class="flux-field">
                <flux:field class="flux-field">
                    <flux:label>Colonia<span class="sup-required">*</span></flux:label>
                    <flux:select wire:model.live="comparableColony" class="text-gray-800 [&_option]:text-gray-900"
                        :disabled="empty($colonies)">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        @foreach($colonies as $colony)
                        <option value="{{ $colony }}" {{ $colony===$comparableColony ? 'selected' : '' }}>
                            {{ $colony }}
                        </option>
                        @endforeach
                        <flux:select.option value="no-listada">Colonia no listada</flux:select.option>
                    </flux:select>
                    <div class="error-container">
                        <flux:error name="comparableColony" />
                    </div>
                </flux:field>
            </div>

                @if ($comparableColony === 'no-listada')
                <flux:field class="flux-field">
                    <flux:label>Otra Colonia<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='comparableOtherColony' />
                    <div class="error-container">
                        <flux:error name="comparableOtherColony" />
                    </div>
                </flux:field>
                @endif

                <flux:field class="flux-field">
                    <flux:label>Calle<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableStreet' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableStreet" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Número exterior<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableAbroadNumber' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableAbroadNumber" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Número interior</flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableInsideNumber' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableInsideNumber" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Entre calle<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableBetweenStreet' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableBetweenStreet" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Y la calle<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableAndStreet' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableAndStreet" />
                    </div>
                </flux:field>






                {{-- Localización en mapa --}}
                {{-- <div class="form-grid form-grid--1 mt-3 mb-2 text-md">
                    <h2><span class="border-b-2 border-gray-300">Localización en mapa</span></h2>
                </div>
                <p>Hay vamos xD</p>


 --}}



                {{-- Datos del informante --}}
                <div class="form-grid form-grid--1 mt-3 mb-2 text-md">
                    <h2><span class="border-b-2 border-gray-300 font-semibold">Datos del informante</span></h2>
                </div>

                <flux:field class="flux-field">
                    <flux:label>Nombre<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableName' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableName" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Apellidos<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableLastName' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableLastName" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Teléfono<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparablePhone' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparablePhone" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Fuente de información web<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableUrl' />
                        <flux:button wire:click='shortUrl' icon="scissors" class="cursor-pointer">
                        </flux:button>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableUrl" />
                    </div>
                </flux:field>








                {{-- Datos generales --}}
               <div class="form-grid form-grid--1 mt-3 mb-2 text-md">
                    <h2><span class="border-b-2 border-gray-300 font-semibold">Datos generales</span></h2>
                </div>

                <flux:field class="flux-field">
                    <flux:label>Uso de suelo<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableLandUse' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableLandUse" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Área libre requerido<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="number" wire:model='comparableFreeAreaRequired' />
                        <flux:button type="button" class="font-bold" disabled>%
                        </flux:button>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableFreeAreaRequired" />
                    </div>
                </flux:field>


                <flux:field class="flux-field">
                    <flux:label>Niveles permitidos<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableAllowedLevels' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableAllowedLevels" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Servicios / infraestructura<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:select wire:model.live="comparableServicesInfraestructure" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="completes">Completos</flux:select.option>
                            <flux:select.option value="incompletes">Incompletos</flux:select.option>
                        </flux:select>
                        {{--
                        <flux:input type="text" wire:model='comparableServicesInfraestructure' /> --}}
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableServicesInfraestructure" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Descripción servicios / infraestructura<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableDescServicesInfraestructure' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDescServicesInfraestructure" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Forma<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableShape' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableShape" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>De pendiente<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="number" wire:model='comparableSlope' step="any" />
                        <flux:button type="button" class="font-bold" disabled><b>%</b>
                        </flux:button>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableSlope" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Densidad<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableDensity' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDensity" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Frente(ML):<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableFront' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDensity" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Frente tipo</flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableFrontType' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableFrontType" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Descripción forma</flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableDescriptionForm' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDescriptionForm" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Topografía<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        {{--
                        <flux:input type="text" wire:model='comparableTopography' /> --}}
                        <flux:select wire:model.live="comparableTopography"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="plana">Plana</flux:select.option>
                            <flux:select.option value="PendienteAscendente">Pendiente ascendente</flux:select.option>
                            <flux:select.option value="Pendiente">Pendiente</flux:select.option>
                            <flux:select.option value="Descendente">Descendente</flux:select.option>
                            <flux:select.option value="Accidentada">Accidentada</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableTopography" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Características<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableCharacteristics' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDescriptionForm" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Características generales</flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableCharacteristicsGeneral' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDescriptionForm" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Oferta<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="number" wire:model.lazy='comparableOffers' step="any"/>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableOffers" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Superficie del terreno<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="number" wire:model.lazy='comparableLandArea' step="any"/>
                        <flux:button type="button" class="text-bold" disabled>m²
                        </flux:button>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableLandArea" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Superficie construida<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="number" wire:model='comparableBuiltArea' step="any"/>
                        <flux:button type="button" class="text-bold" disabled>m²
                        </flux:button>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableBuiltArea" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Valor unitario<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="number" wire:model='comparableUnitValue' step="any" disabled/>
                        <flux:button type="button" icon="calculator" disabled></flux:button>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableUnitValue" />
                    </div>
                </flux:field>





                <flux:field class="flux-field">
                    <flux:label>Factor de negociación<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="number" wire:model='comparableBargainingFactor' step="any" />
                    </flux:input.group>
                    <small>Factor entre 0.8 y 1</small>
                    <div class="error-container">
                        <flux:error name="comparableBargainingFactor" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Ubicación en la manzana<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        {{--
                        <flux:input type="text" wire:model='comparableLocationBlock' /> --}}
                        <flux:select wire:model.live="comparableLocationBlock"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="plana">Interior</flux:select.option>
                            <flux:select.option value="twoFront">Dos frentes no continuos</flux:select.option>
                            <flux:select.option value="tresFrentes">Tres frentes</flux:select.option>
                            <flux:select.option value="unFrente">Un frente</flux:select.option>
                            <flux:select.option value="Esquina">Esquina</flux:select.option>
                            <flux:select.option value="Manzana">Manzana</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableLocationBlock" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Ubicación en la calle<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        {{--
                        <flux:input type="text" wire:model='comparableStreetLocation' /> --}}
                        <flux:select wire:model.live="comparableStreetLocation"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Superior a moda">Superior a moda</flux:select.option>
                            <flux:select.option value="Calle moda">Calle moda</flux:select.option>
                            <flux:select.option value="Inferior a moda">Inferior a moda</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableStreetLocation" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Clase general de los inmuebles en la zona<span class="sup-required">*</span>
                    </flux:label>
                    <flux:input.group>
                        {{--
                        <flux:input type="text" wire:model='comparableGeneralPropArea' /> --}}
                        <flux:select wire:model.live="comparableGeneralPropArea"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Superior a moda">Mínima</flux:select.option>
                            <flux:select.option value="Economica">Económica</flux:select.option>
                            <flux:select.option value="Interes social">Interés social</flux:select.option>
                            <flux:select.option value="Media">Media</flux:select.option>
                            <flux:select.option value="Semilujo">Semilujo</flux:select.option>
                            <flux:select.option value="Residencial">Residencial</flux:select.option>
                            <flux:select.option value="Residencial plus">Residencial plus</flux:select.option>
                            <flux:select.option value="Residencial plus +">Residencial plus +</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableGeneralPropArea" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Referencia de proximidad urbana<span class="sup-required">*</span>
                    </flux:label>
                    <flux:input.group>
                        {{--
                        <flux:input type="text" wire:model='comparableGeneralProperties' /> --}}
                        <flux:select wire:model.live="comparableUrbanProximityReference"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Centrica">Céntrica</flux:select.option>
                            <flux:select.option value="Intermedia">Intermedia</flux:select.option>
                            <flux:select.option value="Periferica">Periférica</flux:select.option>
                            <flux:select.option value="De expansion">De expansión</flux:select.option>
                            <flux:select.option value="Rural">Rural</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableUrbanProximityReference" />
                    </div>
                </flux:field>


           {{--      <flux:field class="flux-field">
                    <flux:label>Número de frentes<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="number" wire:model='comparableNumberFronts' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableNumberFronts" />
                    </div>
                </flux:field>
 --}}
                <flux:field class="flux-field">
                    <flux:label>Fuente de información imágenes<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableSourceInfImages' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableSourceInfImages" />
                    </div>
                </flux:field>

        <flux:field class="flux-field">
            <flux:label>Fotos<span class="sup-required">*</span></flux:label>

            <div class="flex items-center gap-3 mt-1">
                {{-- Input de archivo oculto --}}
                <input type="file" wire:model="comparablePhotosFile" id="file-upload" class="sr-only">

                {{-- Botón estilizado un poco más pequeño --}}
                <label for="file-upload"
                    class="cursor-pointer inline-flex items-center px-3 py-1.5 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 whitespace-nowrap">
                    <svg class="h-5 w-5 text-gray-500 mr-1.5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                        fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 4-4z"
                            clip-rule="evenodd" />
                    </svg>
                    {{ __('Seleccionar archivo') }}
                </label>

                {{-- Nombre del archivo con límite de ancho --}}
                <div class="max-w-[190px] overflow-hidden text-ellipsis whitespace-nowrap">
                    @if ($comparablePhotosFile)
                    <span class="text-sm text-gray-500"
                        title="{{ is_string($comparablePhotosFile) ? $comparablePhotosFile : $comparablePhotosFile->getClientOriginalName() }}">
                        {{ is_string($comparablePhotosFile) ? $comparablePhotosFile :
                        $comparablePhotosFile->getClientOriginalName() }}
                    </span>
                    @else
                    <span class="text-sm text-gray-500">
                        {{ __('Seleccione un archivo...') }}
                    </span>
                    @endif
                </div>
            </div>

          @if ($comparablePhotosFile && is_string($comparablePhotosFile) && Storage::disk('comparables_public')->exists($comparablePhotosFile))
            <div>
                <img src="{{ asset('comparables/'.$comparablePhotosFile) }}" alt="Foto del comparable"
                    class="w-full h-full object-cover">
            </div>
             @endif
            {{-- Errores de validación --}}
            <div class="error-container mt-1">
                @error('comparablePhotosFile')
                <flux:error name="comparablePhotosFile" />
                @enderror
            </div>

            {{-- Indicador de carga (subiendo archivo) --}}
            <div class="min-h-[40px]">
                <div wire:loading wire:target="comparablePhotosFile" class="text-sm text-blue-600 flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                    </svg>
                    {{ __('Subiendo archivo...') }}
                </div>
            </div>
        </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Activo</flux:label>
                    <flux:input.group>
                        {{-- <flux:input type="text" wire:model='comparableActive' /> --}}
                        <flux:checkbox wire:model="comparableActive" />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableActive" />
                    </div>
                </flux:field>




                @if ($comparableId)
                        <div class="flex">
                            <flux:spacer />
                            <flux:button class="btn-primary btn-table cursor-pointer" type="button" variant="primary" wire:click='comparableUpdate'>Editar
                                comparable</flux:button>
                        </div>
                @endunless


                @if($comparableId === null)
                <div class="flex">
                    <flux:spacer />
                    <flux:button class="btn-primary btn-table cursor-pointer" type="button" variant="primary" wire:click='save'>Crear
                        comparable</flux:button>
                </div>
                @endif
            </div>
    </flux:modal>



{{-- Añadimos el componente del modal para el resumen del comparable --}}
<livewire:forms.comparables.comparable-summary />


</div>
