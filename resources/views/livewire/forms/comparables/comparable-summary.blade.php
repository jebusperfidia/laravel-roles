<div>
<flux:modal name="comparable-summary" class="max-w-[90rem]"> {{-- max-w-[90rem] garantiza que sea muy ancho en
    escritorio --}}

    <div class="space-y-6">

        {{-- CABECERA DEL MODAL --}}
        <div class="px-6 py-4 border-b">
            <flux:heading size="lg" class="font-bold text-gray-900">
                Ficha de Comparable
                @if ($comparable)
                <span class="text-sm font-normal text-gray-500 ml-2">({{ $comparable->comparable_key }})</span>
                @endif
            </flux:heading>
        </div>

        {{-- CUERPO DEL MODAL (Contenedor de datos) --}}
        <div class="p-6">
            @if ($comparable)

            {{--
            CONTENEDOR PRINCIPAL: Usamos el form-grid--2 para forzar las dos columnas principales
            en un solo nivel, haciendo que el modal se vea bien ancho y que los elementos internos
            se acomoden mejor, como en tu imagen original.
            --}}
            <div class="form-grid form-grid--2 gap-x-8 gap-y-6">

                {{-- === COLUMNA 1:  === --}}
                <div>

                    {{-- Creador y Estatus --}}
                    <div class="form-grid form-grid--2 border-b pb-4 mb-4">
                        <div class="flux-field">
                            <flux:label class="font-bold">Dado de alta por</flux:label>
                                <div class="font-medium text-gray-900">
                                    {{ $comparable->createdBy->name ?? 'Usuario Eliminado' }}
                                </div>
                        </div>
                       {{--  <div class="flux-field">
                            <flux:label class="font-bold">Estatus</flux:label>
                                <div class="font-medium">
                                    @if ($comparable->is_active)
                                    <span
                                        class="px-2 py-0.5 bg-green-100 text-green-800 rounded-full text-xs font-semibold">ACTIVO</span>
                                    @else
                                    <span
                                        class="px-2 py-0.5 bg-red-100 text-red-800 rounded-full text-xs font-semibold">INACTIVO</span>
                                    @endif
                                </div>
                        </div> --}}
                    </div>

                    {{-- Imagen y URL --}}
                    <div class="space-y-4 mb-6">
                        <div
                            class="aspect-video bg-gray-200 rounded-lg shadow-md overflow-hidden flex items-center justify-center">
                            @if ($comparable->comparable_photos)
                            <img src="{{ asset('comparables/'.$comparable->comparable_photos) }}" alt="Foto del comparable"
                                class="w-full h-full object-cover">
                            @else
                            <span class="text-gray-500 text-lg">Sin imagen disponible</span>
                            @endif
                        </div>
                        <div class="flux-field text-sm">
                            <flux:label class="font-bold">URL</flux:label>
                                <a href="{{ $comparable->comparable_url }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800 break-all underline">
                                    {{ $comparable->comparable_url }}
                                </a>
                        </div>
                    </div>

                    <h4 class="font-bold text-lg text-gray-700 mt-6 mb-4 border-b pb-1">Terreno</h4>

                    <div class="form-grid form-grid--2">
                        <div class="flux-field">
                            <flux:label>Oferta Total</flux:label>
                                <div class="font-bold">$ {{ number_format($comparable->comparable_offers,
                                    2) }}
                                </div>
                        </div>
                        <div class="flux-field">
                            <flux:label>Valor unitario</flux:label>
                                <div class="font-medium text-gray-900">$ {{
                                    number_format($comparable->comparable_unit_value, 2)
                                    }} /m²</div>
                        </div>

                        <div class="flux-field">
                            <flux:label>Área terreno (M²)</flux:label>
                                <div class="font-medium text-gray-900">{{
                                    number_format($comparable->comparable_land_area, 2) }}
                                </div>
                        </div>
                        <div class="flux-field">
                            <flux:label>Área construida (M²)</flux:label>
                                <div class="font-medium text-gray-900">{{
                                    number_format($comparable->comparable_built_area, 2)
                                    }}</div>
                        </div>

                        <div class="flux-field">
                            <flux:label>Factor negociación</flux:label>
                                <div class="font-medium text-gray-900">{{
                                    number_format($comparable->comparable_bargaining_factor, 6) }}</div>
                        </div>
                        <div class="flux-field">
                            <flux:label>Frente (ML)</flux:label>
                                <div class="font-medium text-gray-900">{{ number_format($comparable->comparable_front,
                                    2) }}
                                </div>
                        </div>
                    </div>


                    <h4 class="font-bold text-lg text-gray-700 mt-6 mb-4 border-b pb-1">Información general</h4>
                    <div class="form-grid form-grid--2">
                        <div class="flux-field lg:col-span-2">
                            <flux:label>Dirección</flux:label>
                                <div class="font-medium text-gray-900">
                                    {{ $comparable->comparable_street }} #{{ $comparable->comparable_abroad_number }}
                                    @if($comparable->comparable_inside_number) Int. {{
                                    $comparable->comparable_inside_number }}
                                    @endif
                                </div>
                        </div>

                        <div class="flux-field">
                            <flux:label>Colonia</flux:label>
                                <div class="font-medium text-gray-900">{{ $comparable->comparable_colony ??
                                    $comparable->comparable_other_colony }}</div>
                        </div>
                        <div class="flux-field">
                            <flux:label>CP</flux:label>
                                <div class="font-medium text-gray-900">{{ $comparable->comparable_cp }}</div>
                        </div>
                        <div class="flux-field">
                            <flux:label>Entidad</flux:label>
                                <div class="font-medium text-gray-900">{{ $comparable->comparable_entity_name }}</div>
                        </div>
                        <div class="flux-field">
                            <flux:label>Teléfono de contacto</flux:label>
                                <div class="font-medium text-gray-900">{{ $comparable->comparable_phone }}</div>
                        </div>
                    </div>
                </div>

                {{-- === COLUMNA 2:  --}}
                <div>


                    <h4 class="font-bold text-lg text-gray-700 mb-4 border-b pb-1">Construcción</h4>
                    <div class="form-grid form-grid--2">
                        <div class="flux-field">
                            <flux:label>Uso de suelo</flux:label>
                                <div class="font-medium text-gray-900">{{ $comparable->comparable_land_use }}</div>
                        </div>
                        <div class="flux-field">
                            <flux:label>Niveles permitidos</flux:label>
                                <div class="font-medium text-gray-900">{{ $comparable->comparable_allowed_levels }}
                                </div>
                        </div>
                        <div class="flux-field">
                            <flux:label>Topografía</flux:label>
                                <div class="font-medium text-gray-900">{{ $comparable->comparable_topography }}</div>
                        </div>
                        <div class="flux-field">
                            <flux:label>Pendiente (%)</flux:label>
                                <div class="font-medium text-gray-900">{{ number_format($comparable->comparable_slope,
                                    2) }}%
                                </div>
                        </div>

                        <div class="flux-field lg:col-span-2">
                            <flux:label>Descripción general</flux:label>
                                <p class="text-sm text-gray-700 mt-1">
                                    {{ $comparable->comparable_description_form ??
                                    $comparable->comparable_characteristics_general }}
                                </p>
                        </div>
                    </div>

                    {{-- TABLA DE SERVICIOS EN LOS QUE SE USA --}}
                    <h4 class="font-bold text-lg text-gray-700 mt-6 mb-4 border-b pb-1">Avaluos donde está asignado</h4>


                    <div class="overflow-x-auto max-w-full">
                        <table class="min-w-[550px] table-fixed w-full border-2">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th
                                        class="px-2 py-1 border whitespace-nowrap text-left text-xs font-semibold text-gray-700">
                                        Folio del avalúo</th>
                                    <th
                                        class="px-2 py-1 border whitespace-nowrap text-left text-xs font-semibold text-gray-700">
                                        Fecha alta</th>
                                    <th
                                        class="px-2 py-1 border whitespace-nowrap text-left text-xs font-semibold text-gray-700">
                                        Asignado por</th>
                                  {{--   <th
                                        class="px-2 py-1 border whitespace-nowrap text-center text-xs font-semibold text-gray-700">
                                        Estatus</th> --}}
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($ValuationComparables as $record)

                                <tr>
                                    {{-- Avalúo (del objeto Valuation anidado) --}}
                                    <td class="px-2 py-1 border text-sm text-left">{{
                                        $record['valuation']['folio'] ?? 'N/A' }}</td>

                                    {{-- Fecha Alta (del registro de asignación) --}}
                                    <td class="px-2 py-1 border text-sm text-left text-gray-600">
                                        {{ \Carbon\Carbon::parse($record['created_at'])->format('d/m/Y') }}
                                    </td>

                                    {{-- Valuador Asignó (del objeto User anidado) --}}
                                    <td class="px-2 py-1 border text-sm text-left">
                                        {{ $record['created_by']['name'] ?? 'Usuario Eliminado' }}
                                    </td>

                                    {{-- Estatus de la Asignación (del registro de asignación) --}}
                                 {{--    <td class="px-2 py-1 border text-sm text-center">
                                        @if ($record['is_active'])
                                        <span class="text-green-600 font-medium">ACTIVA</span>
                                        @else
                                        <span class="text-red-600 font-medium">INACTIVA</span>
                                        @endif
                                    </td> --}}
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="text-center py-4 text-gray-500 border">
                                        Este comparable no está asignado a ningún avalúo.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="text-center p-8">
            Cargando datos del comparable...
        </div>
        @endif
    </div>


</flux:modal>
</div>
