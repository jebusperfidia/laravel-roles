<div>
    @if($isReadOnly)
        <div class="border-l-4 border-red-600 text-red-600 p-4 mb-4 rounded shadow-sm">
            <p class="font-bold">Modo Lectura</p>
            <p>El avalúo está en revisión. No puedes realizar modificaciones.</p>
        </div>
        @endif
        @if(!$isReadOnly)
        <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>
        @endif


    {{-- CONTENEDOR PRINCIPAL: ENFOQUE DE COSTOS --}}
    <div class="form-container">
        <div class="form-container__header">
            Enfoque de costos
        </div>
        <div class="form-container__content">


            {{-- 1. SECCIÓN: DEL TERRENO --}}
            <h3 class="text-xl font-semibold text-gray-800 mb-3 mt-4">Del Terreno</h3>



            <div class="mt-2">
                <div class="overflow-x-auto max-w-full">
                    {{-- Aseguramos que la tabla ocupe al menos el ancho de la suma de los TH/TD --}}
                    <table class="min-w-[650px] table-fixed w-full border-2">
                        <thead>
                            <tr class="bg-gray-100">
                                {{-- 1. Superficie: Le damos un ancho fijo moderado para que no se extienda. --}}
                                <th class="px-2 py-1 border w-[150px]">Superficie</th>

                                {{-- 2. Valor Unitario Tierra: Mantener ancho. --}}
                                <th class="px-2 py-1 border w-[120px]">Valor Unitario Tierra</th>

                                {{-- 3. Valor de la Fracción: Mantener ancho. --}}
                                <th class="px-2 py-1 border w-[120px]">Valor de la Fracción</th>

                                {{-- 4. % Indiviso: Mantener ancho. --}}
                                <th class="px-2 py-1 border w-[80px]">% Indiviso</th>

                                {{-- 5. Valor Proporcional: Mantener ancho. --}}
                                <th class="px-2 py-1 border w-[180px]">Valor Proporcional</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{-- Fila dinámica del Terreno --}}
                            <tr>
                                <td class="px-2 py-1 border text-sm text-center font-bold w-[150px]">
                                    {{ number_format($landSurface, 2) }} m²
                                </td>
                                {{-- El resto de las celdas ya tienen el ancho definido en el thead --}}
                                <td class="px-2 py-1 border text-sm text-center">
                                    ${{ number_format($landUnitValue, 2) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center font-semibold text-gray-700">
                                    ${{ number_format($landFractionValue, 2) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center text-blue-900 font-bold">
                                    {{ number_format($landIndiviso, 4) }}%
                                </td>
                                <td class="px-2 py-1 border text-sm text-center font-bold text-black bg-gray-50">
                                    ${{ number_format($landProportionalValue, 2) }}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- TOTAL TERRENO (NEGRO) --}}
            <div class="flex justify-end mt-2 items-center gap-2">
                <span class="text-sm font-semibold text-gray-700">Valor del terreno (Total):</span>
                <span class="text-lg font-bold text-gray-900">$ {{ number_format($totalLandValue, 2) }}</span>
            </div>


            {{--- --- --- SEPARADOR VISUAL --- --- ---}}


            {{-- 2. SECCIÓN: DE LAS CONSTRUCCIONES PRIVATIVAS --}}
            <h3 class="text-xl font-semibold text-gray-800 mb-3 mt-8">De las Construcciones Privativas</h3>

            <div class="mt-2">
                <div class="overflow-x-auto max-w-full">
                    <table class="min-w-[1400px] table-fixed w-full border-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1 border w-[150px]">Descripción</th>
                                <th class="px-2 py-1 border">Clase Shf</th>
                                <th class="px-2 py-1 border">Edo. Conserv</th>
                                <th class="px-2 py-1 border w-[50px]">Uso</th>
                                <th class="px-2 py-1 border w-[50px]">Niv</th>
                                <th class="px-2 py-1 border w-[50px]">Edad</th>
                                <th class="px-2 py-1 border w-[50px]">VUT</th>
                                <th class="px-2 py-1 border w-[50px]">VUR</th>
                                <th class="px-2 py-1 border">Sup</th>
                                <th class="px-2 py-1 border">Costo Unit Rep Nuevo</th>
                                <th class="px-2 py-1 border">FEdad</th>
                                <th class="px-2 py-1 border">FCons</th>
                                <th class="px-2 py-1 border">Av.Ob</th>
                                <th class="px-2 py-1 border">FRes</th>
                                <th class="px-2 py-1 border">Costo Unit Neto Rep</th>
                                <th class="px-2 py-1 border">Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (collect($privateConstructions)->isEmpty())
                            <tr>
                                <td colspan="16" class="px-2 py-4 text-center text-gray-500">
                                    No hay construcciones privativas registradas.
                                </td>
                            </tr>
                            @else
                            @foreach ($privateConstructions as $item)
                            <tr wire:key="priv-row-{{ $item->id }}">
                                <td class="px-2 py-1 border text-sm text-left">{{ $item->description }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->clasification }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->conservation_state }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->use }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->building_levels }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ number_format($item->age) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{
                                    number_format($item->calculated_life_total) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{
                                    number_format($item->calculated_life_remaining) }}</td>
                                <td class="px-2 py-1 border text-sm text-center font-bold">
                                    {{ rtrim(rtrim(number_format($item->surface, 2, '.', ''), '0'), '.') }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    ${{ number_format($item->unit_cost_replacement, 2) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">{{
                                    number_format($item->calculated_factor_age, 4) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{
                                    number_format($item->calculated_factor_conservation, 2) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ number_format($item->progress_work,
                                    0) }}%</td>
                                <td class="px-2 py-1 border text-sm text-center font-bold">{{
                                    number_format($item->calculated_factor_result, 4) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    ${{ number_format($item->calculated_net_cost, 2) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center font-semibold text-gray-900 bg-gray-50">
                                    ${{ number_format($item->total_value, 2) }}
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="8" class="px-2 py-1 border text-right">TOTAL PRIVATIVAS:</td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    {{ number_format($totalSurfacePrivate, 2) }}
                                </td>
                                <td colspan="6" class="px-2 py-1 border text-center"></td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    ${{ number_format($totalValuePrivate, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="flex justify-end mt-2 items-center gap-2">
                <span class="text-sm font-semibold text-gray-700">Valor de las Construcciones Privativas:</span>
                <span class="text-lg font-bold text-gray-900">$ {{ number_format($totalValuePrivate, 2) }}</span>
            </div>


            {{--- --- --- SEPARADOR VISUAL --- --- ---}}

            {{-- 3. SECCIÓN: DE LAS CONSTRUCCIONES COMUNES --}}
            @if (stripos($valuation->property_type, 'condominio') !== false)
            <h3 class="text-xl font-semibold text-gray-800 mb-3 mt-8">De las Construcciones Comunes</h3>

            <div class="mt-2">
                <div class="overflow-x-auto max-w-full">
                    <table class="min-w-[1400px] table-fixed w-full border-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1 border w-[150px]">Descripción</th>
                                <th class="px-2 py-1 border">Clase Shf</th>
                                <th class="px-2 py-1 border">Edo. Conserv</th>
                                <th class="px-2 py-1 border w-[50px]">Uso</th>
                                <th class="px-2 py-1 border w-[50px]">Niv</th>
                                <th class="px-2 py-1 border w-[50px]">Edad</th>
                                <th class="px-2 py-1 border w-[50px]">VUT</th>
                                <th class="px-2 py-1 border w-[50px]">VUR</th>
                                <th class="px-2 py-1 border">Sup</th>
                                <th class="px-2 py-1 border">Costo Unit Rep Nuevo</th>
                                <th class="px-2 py-1 border">FEdad</th>
                                <th class="px-2 py-1 border">FCons</th>
                                <th class="px-2 py-1 border">Av.Ob</th>
                                <th class="px-2 py-1 border">FRes</th>
                                <th class="px-2 py-1 border">Costo Unit Neto Rep</th>
                                <th class="px-2 py-1 border">Valor Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (collect($commonConstructions)->isEmpty())
                            <tr>
                                <td colspan="16" class="px-2 py-4 text-center text-gray-500">
                                    No hay construcciones comunes registradas.
                                </td>
                            </tr>
                            @else
                            @foreach ($commonConstructions as $item)
                            <tr wire:key="common-row-{{ $item->id }}">
                                <td class="px-2 py-1 border text-sm text-left">{{ $item->description }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->clasification }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->conservation_state }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->use }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->building_levels }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ number_format($item->age) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{
                                    number_format($item->calculated_life_total) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{
                                    number_format($item->calculated_life_remaining) }}</td>
                                <td class="px-2 py-1 border text-sm text-center font-bold">
                                    {{ rtrim(rtrim(number_format($item->surface, 2, '.', ''), '0'), '.') }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    ${{ number_format($item->unit_cost_replacement, 2) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">{{
                                    number_format($item->calculated_factor_age, 4) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{
                                    number_format($item->calculated_factor_conservation, 2) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ number_format($item->progress_work,
                                    0) }}%</td>
                                <td class="px-2 py-1 border text-sm text-center font-bold">{{
                                    number_format($item->calculated_factor_result, 4) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    ${{ number_format($item->calculated_net_cost, 2) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center font-semibold text-gray-900 bg-gray-50">
                                    ${{ number_format($item->total_value, 2) }}
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="8" class="px-2 py-1 border text-right">TOTAL COMUNES:</td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    {{ number_format($totalSurfaceCommon, 2) }}
                                </td>
                                <td colspan="6" class="px-2 py-1 border text-center"></td>
                                <td class="px-2 py-1 border text-sm text-center">
                                    ${{ number_format($totalValueCommon, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="flex justify-end mt-2 items-center gap-2">
                <span class="text-sm font-semibold text-gray-700">Valor de las Construcciones Comunes:</span>
                <span class="text-lg font-bold text-gray-900">$ {{ number_format($totalValueCommon, 2) }}</span>
            </div>
            @endif


            {{--- --- --- SEPARADOR VISUAL --- --- ---}}


            {{-- 4. SECCIÓN: INSTALACIONES ESPECIALES --}}
            <h3 class="text-xl font-semibold text-gray-800 mb-3 mt-8">De las Instalaciones Especiales, Obras
                Complementarias y Elementos Accesorios</h3>

            {{-- 4.1. TABLA PRIVATIVAS --}}
            <h4 class="text-md font-semibold text-gray-700 mb-2">Instalaciones Privativas</h4>
            <div class="mt-2 mb-6">
                <div class="overflow-x-auto max-w-full">
                    <table class="min-w-[1000px] table-fixed w-full border-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1 border w-[80px]">Clave</th>
                                <th class="px-2 py-1 border">Descripción</th>
                                <th class="px-2 py-1 border w-[60px]">Unidad</th>
                                <th class="px-2 py-1 border w-[80px]">Cantidad</th>
                                <th class="px-2 py-1 border w-[120px]">Costo Unit Rep Nuevo</th>
                                <th class="px-2 py-1 border w-[80px]">Factor Edad</th>
                                <th class="px-2 py-1 border w-[80px]">Factor Cons.</th>
                                <th class="px-2 py-1 border w-[120px]">Costo Unit Neto Rep</th>
                                <th class="px-2 py-1 border w-[120px]">Valor Parcial</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($privateSpecialInstallations->isEmpty())
                            <tr>
                                <td colspan="9" class="px-2 py-4 text-center text-gray-500">
                                    No hay instalaciones privativas registradas.
                                </td>
                            </tr>
                            @else
                            @foreach ($privateSpecialInstallations as $item)
                            <tr wire:key="inst-priv-{{ $item->id }}">
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->key }}</td>
                                <td class="px-2 py-1 border text-sm text-left">
                                    {{ $item->description ?: $item->description_other }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->unit }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ number_format($item->quantity, 2) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-right">${{
                                    number_format($item->new_rep_unit_cost, 2) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ number_format($item->age_factor, 4)
                                    }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{
                                    number_format($item->conservation_factor, 2) }}</td>
                                <td class="px-2 py-1 border text-sm text-right">${{
                                    number_format($item->net_rep_unit_cost, 2) }}</td>
                                <td class="px-2 py-1 border text-sm text-right font-semibold text-gray-900 bg-gray-50">
                                    ${{ number_format($item->amount, 2) }}
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="8" class="px-2 py-1 border text-right">TOTAL PRIVATIVAS:</td>
                                <td class="px-2 py-1 border text-sm text-right">
                                    ${{ number_format($totalValueInstPrivate, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="flex justify-end mt-2 items-center gap-2">
                    <span class="text-sm font-semibold text-gray-700">Valor Inst. Especiales Privativas:</span>
                    <span class="text-lg font-bold text-gray-900">$ {{ number_format($totalValueInstPrivate, 2)
                        }}</span>
                </div>
            </div>

            {{-- 4.2. TABLA COMUNES --}}
            @if (stripos($valuation->property_type, 'condominio') !== false)
            <h4 class="text-md font-semibold text-gray-700 mb-2 mt-6">Instalaciones Comunes</h4>
            <div class="mt-2 mb-6">
                <div class="overflow-x-auto max-w-full">
                    <table class="min-w-[1200px] table-fixed w-full border-2">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-1 border w-[80px]">Clave</th>
                                <th class="px-2 py-1 border">Descripción</th>
                                <th class="px-2 py-1 border w-[60px]">Unidad</th>
                                <th class="px-2 py-1 border w-[80px]">Cant.</th>
                                <th class="px-2 py-1 border w-[110px]">Costo Unit Rep Nuevo</th>
                                <th class="px-2 py-1 border w-[60px]">F. Edad</th>
                                <th class="px-2 py-1 border w-[60px]">F. Cons.</th>
                                <th class="px-2 py-1 border w-[80px]">% Indiviso</th>
                                <th class="px-2 py-1 border w-[110px]">Costo Unit Neto Rep</th>
                                <th class="px-2 py-1 border w-[110px]">Valor Parcial</th>
                                <th class="px-2 py-1 border w-[110px]">Valor Proporcional</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($commonSpecialInstallations->isEmpty())
                            <tr>
                                <td colspan="11" class="px-2 py-4 text-center text-gray-500">
                                    No hay instalaciones comunes registradas.
                                </td>
                            </tr>
                            @else
                            @foreach ($commonSpecialInstallations as $item)
                            <tr wire:key="inst-comm-{{ $item->id }}">
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->key }}</td>
                                <td class="px-2 py-1 border text-sm text-left">
                                    {{ $item->description ?: $item->description_other }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-center">{{ $item->unit }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ number_format($item->quantity, 2) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-right">${{
                                    number_format($item->new_rep_unit_cost, 2) }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{ number_format($item->age_factor, 4)
                                    }}</td>
                                <td class="px-2 py-1 border text-sm text-center">{{
                                    number_format($item->conservation_factor, 2) }}</td>
                                <td class="px-2 py-1 border text-sm text-center font-bold text-blue-900">{{
                                    number_format($item->undivided, 4) }}%</td>
                                <td class="px-2 py-1 border text-sm text-right">${{
                                    number_format($item->net_rep_unit_cost, 2) }}</td>
                                <td class="px-2 py-1 border text-sm text-right text-gray-600">
                                    ${{ number_format($item->amount, 2) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-right font-semibold text-gray-900 bg-gray-50">
                                    ${{ number_format($item->calculated_proportional_value, 2) }}
                                </td>
                            </tr>
                            @endforeach
                            @endif
                        </tbody>
                        <tfoot>
                            <tr class="bg-gray-100 font-bold">
                                <td colspan="9" class="px-2 py-1 border text-right">TOTALES COMUNES:</td>
                                <td class="px-2 py-1 border text-sm text-right text-gray-600">
                                    ${{ number_format($totalValueInstCommonPhysical, 2) }}
                                </td>
                                <td class="px-2 py-1 border text-sm text-right text-black">
                                    ${{ number_format($totalValueInstCommonProportional, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                <div class="flex justify-end mt-2 flex-col items-end gap-1">
                    <div class="flex items-center gap-2">
                        <span class="text-xs text-gray-500">Valor Inst. Especiales Comunes (Total Físico):</span>
                        <span class="text-sm font-semibold text-gray-500">$ {{
                            number_format($totalValueInstCommonPhysical, 2) }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="text-sm font-semibold text-gray-700">Valor Inst. Especiales Comunes
                            (Proporcional):</span>
                        <span class="text-lg font-bold text-gray-900">$ {{
                            number_format($totalValueInstCommonProportional, 2) }}</span>
                    </div>
                </div>
            </div>
            @endif

        </div>
    </div>


    {{-- CONTENEDOR FINAL: RESUMEN --}}
    <div class="form-container">
        <div class="form-container__header">
            Resumen
        </div>
        <div class="form-container__content">

            {{-- VALOR DEL TERRENO --}}
            <div class="form-grid form-grid--3 form-grid-3-variation pt-4">
                <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start text-right">
                    <flux:label class="font-bold text-gray-900">VALOR DEL TERRENO:</flux:label>
                </div>
                <div class="radio-input text-left">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            {{-- Valor calculado --}}
                            <div class="text-sm font-semibold text-gray-900">$ {{ number_format($totalLandValue, 4) }}
                            </div>
                        </div>
                    </flux:field>
                </div>
            </div>

            {{-- VALOR CONSTRUCCIONES PRIVATIVAS --}}
            <div class="form-grid form-grid--3 form-grid-3-variation pt-4">
                <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start text-right">
                    <flux:label class="font-bold text-gray-900">VALOR CONSTRUCCIONES PRIVATIVAS:</flux:label>
                </div>
                <div class="radio-input text-left">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <div class="text-sm font-semibold text-gray-900">$ {{ number_format($totalValuePrivate, 4)
                                }}</div>
                        </div>
                    </flux:field>
                </div>
            </div>

            {{-- VALOR CONSTRUCCIONES COMUNES --}}
            <div class="form-grid form-grid--3 form-grid-3-variation pt-4">
                <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start text-right">
                    <flux:label class="font-bold text-gray-900">VALOR CONSTRUCCIONES COMUNES:</flux:label>
                </div>
                <div class="radio-input text-left">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <div class="text-sm font-semibold text-gray-900">$ {{ number_format($totalValueCommon, 4) }}
                            </div>
                        </div>
                    </flux:field>
                </div>
            </div>

            {{-- SUBTOTAL CONSTRUCCIONES --}}
            <div class="form-grid form-grid--3 form-grid-3-variation pt-4">
                <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start text-right">
                    <flux:label class="font-bold text-gray-900">SUBTOTAL CONSTRUCCIONES:</flux:label>
                </div>
                <div class="radio-input text-left">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <div class="text-sm font-bold text-gray-900">
                                $ {{ number_format($totalValuePrivate + $totalValueCommon, 4) }}
                                <span class="text-xs font-normal ml-2">(@if(stripos($valuation->property_type,
                                    'condominio') !== false) privativas + comunes @else privativas @endif )</span>
                            </div>
                        </div>
                    </flux:field>
                </div>
            </div>

            {{-- IMPORTE INSTALACIONES ESPECIALES --}}
            <div class="form-grid form-grid--3 form-grid-3-variation pt-4">
                <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start text-right">
                    <flux:label class="font-bold text-gray-900">IMPORTE INSTALACIONES ESPECIALES:</flux:label>
                </div>
                <div class="radio-input text-left">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <div class="text-sm font-bold text-gray-900">
                                {{-- Aquí sumamos Privativas + Comunes Proporcionales --}}
                                $ {{ number_format($totalValueInstPrivate + $totalValueInstCommonProportional, 4) }}
                                <span class="text-xs font-normal ml-2">
                                    (@if(stripos($valuation->property_type, 'condominio') !== false) privativas +
                                    comunes proporcionales @else privativas @endif )
                                </span>
                            </div>
                        </div>
                    </flux:field>
                </div>
            </div>

            {{-- IMPORTE TOTAL DEL ENFOQUE DE COSTOS --}}
            <div class="form-grid form-grid--3 form-grid-3-variation pt-4">
                <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start text-right">
                    <flux:label class="font-bold text-gray-900">IMPORTE TOTAL DEL ENFOQUE DE COSTOS:</flux:label>
                </div>
                <div class="radio-input text-left">
                    <flux:field>
                        <div class="radio-group-horizontal">
                            <div class="text-base font-bold text-gray-900">
                                {{-- Suma total: Terreno (calculado) + Construcciones + Instalaciones --}}
                                $ {{ number_format($totalLandValue + ($totalValuePrivate + $totalValueCommon) +
                                ($totalValueInstPrivate + $totalValueInstCommonProportional), 4) }}
                                <div class="text-xs font-normal mt-1">($ Terreno + construcciones + instalaciones)</div>
                            </div>
                        </div>
                    </flux:field>
                </div>
            </div>

        </div>
    </div>
    @if(!$isReadOnly)
    {{-- Botón Continuar --}}
    <flux:button class="mt-4 cursor-pointer btn-primary" variant="primary" type="button" wire:click="nextComponent">
        Continuar
    </flux:button>
    @endif
</div>
