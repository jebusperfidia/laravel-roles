{{-- <div wire:poll.10s="loadData"> --}}
<div>
    @if($isReadOnly)
    <div class="border-l-4 border-red-600 text-red-600 p-4 mb-4 rounded shadow-sm">
        <p class="font-bold">Modo Lectura</p>
        <p>El avalúo está en revisión. No puedes realizar modificaciones.</p>
    </div>
    @endif
    <div class="form-container">
        <fieldset @disabled($isReadOnly)>
        <div class="form-container__header">
            Enfoque de mercado
        </div>
        <div class="form-container__content">
            <div class="mt-[64px] form-grid form-grid--2-center">
                <div class="overflow-x-auto">
                    <table class="min-w-[550px] table-fixed w-full border-2 ">
                        <thead>
                            <tr class="bg-gray-100">
                                <th class="px-2 py-2 "></th>
                                <th class="px-2 py-2 ">Valor unitario promedio</th>
                                <th class="px-2 py-2 ">Valor unitario homologado</th>
                                <th class="px-2 py-2 ">Valor unitario probable</th>
                                <th class="px-2 py-2 ">Comparables</th>
                                <th class="px-2 py-2 ">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-2 text-sm text-center">Terrenos</td>
                                <td class="px-2 py-2 text-sm text-center">$ {{ number_format($landAvgUnitValue, 2) }}
                                </td>
                                <td class="px-2 py-2 text-sm text-center">$ {{ number_format($landHomologatedValue, 2)
                                    }}</td>
                                <td class="px-2 py-2 text-sm text-center">$ {{ number_format($landProbableValue, 2) }}
                                </td>
                                <td class="px-2 py-2 text-sm text-center">
                                    <flux:button type="button"
                                        class="btn-primary btn-table cursor-pointer w-36 justify-center"
                                        variant="primary" wire:click='openComparablesLand'>
                                        {{ $landCount > 0 ? "Editar ($landCount)" : "Agregar" }}
                                    </flux:button>
                                </td>

                                <td class="px-2 py-2 text-sm text-center">
                                    <flux:button class="btn-primary btn-table cursor-pointer w-30 justify-center"
                                        wire:click="toHomologationLand" :disabled="$landCount < 4">
                                        Homologar
                                    </flux:button>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-sm text-center">Construcción en venta</td>
                                <td class="px-2 py-2 text-sm text-center">$ {{ number_format($buildingAvgUnitValue, 2)
                                    }}</td>
                                <td class="px-2 py-2 text-sm text-center">$ {{ number_format($buildingHomologatedValue,
                                    2) }}</td>
                                <td class="px-2 py-2 text-sm text-center">$ {{ number_format($buildingProbableValue, 2)
                                    }}</td>
                                <td class="px-2 py-2 text-sm text-center">
                                    <flux:button type="button"
                                        class="btn-primary btn-table cursor-pointer w-36 justify-center"
                                        variant="primary" wire:click='openComparablesBuilding'>
                                        {{ $buildingCount > 0 ? "Editar ($buildingCount)" : "Agregar" }}
                                    </flux:button>
                                </td>

                                <td class="px-2 py-2 text-sm text-center">
                                    <flux:button class="btn-primary btn-table cursor-pointer w-30 justify-center"
                                        wire:click="toHomologationBuilding" :disabled="$buildingCount < 4">
                                        Homologar
                                    </flux:button>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>

            {{-- Alerta de Comparables Vencidos --}}
            @if($landExpiredCount > 0 || $buildingExpiredCount > 0)
            <div class="mt-4 flex flex-col gap-2">
                @if($landExpiredCount > 0)
                <div class="flex items-center gap-2 text-red-600 bg-amber-50 border border-amber-200 p-2 rounded-lg text-xs">
                    <flux:icon.exclamation-triangle variant="mini" />
                    <span>
                        Hay <b>{{ $landExpiredCount }}</b> comparables de <b>terreno</b> que han superado los 180 días de vigencia.
                    </span>
                </div>
                @endif

                @if($buildingExpiredCount > 0)
                <div class="flex items-center gap-2 text-red-600 bg-amber-50 border border-amber-200 p-2 rounded-lg text-xs">
                    <flux:icon.exclamation-triangle variant="mini" />
                    <span>
                        Hay <b>{{ $buildingExpiredCount }}</b> comparables de <b>construcción</b> que han superado los 180 días de
                        vigencia.
                    </span>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    <div class="form-container">
        <div class="form-container__header">
            Valor del terreno por comparación
        </div>
        <div class="form-container__content">
            <div class="mt-[16px] form-grid form-grid--2-center">
                <div class="overflow-x-auto">
                    <table class="min-w-[550px] table-fixed w-full border-2 ">
                        <tbody>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Superficie del terreno</td>
                                <td class="px-2 py-4 text-sm text-center">{{ number_format($terrainSurface, 2) }} m²
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Valor unitario del mercado</td>
                                <td class="px-2 py-4 text-sm text-center">$ {{ number_format($marketUnitValue, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Importe total del terreno</td>
                                <td class="px-2 py-4 text-sm text-center">$ {{ number_format($totalTerrainAmount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Indiviso aplicable en %</td>
                                <td class="px-2 py-4 text-sm text-center">{{ number_format($applicableUndividedPercent,
                                    0) }} %</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Valor del terreno Prop</td>
                                <td class="px-2 py-4 text-sm text-center">$ {{ number_format($terrainValue, 2) }}</td>
                            </tr>

                            {{-- SECCIÓN DE EXCEDENTES (SOLO SI APLICA) --}}
                            @if($showExcessSection)
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Valor Lote Privativo</td>
                                <td class="px-2 py-4 text-sm text-center">$ {{ number_format($valLotePrivativo, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Valor Lote Privativo Tipo</td>
                                <td class="px-2 py-4 text-sm text-center">$ {{ number_format($valLoteTipo, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Diferencia Excedente de Terreno</td>
                                <td class="px-2 py-4 text-sm text-center">$ {{ number_format($valDiferenciaExcedente,
                                    2)
                                    }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">% del valor de terreno excedente a aplicar
                                </td>
                                <td class="px-2 py-4 text-sm text-center">
                                    {{-- Contenedor para centrar --}}
                                    <div class="flex justify-center w-full">
                                        {{-- Contenedor de ancho fijo para hacerlo "chiquito" --}}
                                        <div class="w-28">
                                            <flux:select wire:model.live="surplusPercentage">
                                                @foreach($percentageOptions as $opt)
                                                <flux:select.option value="{{ $opt }}">{{ $opt }} %</flux:select.option>
                                                @endforeach
                                            </flux:select>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Valor Terreno Excedente</td>
                                <td class="px-2 py-4 text-sm text-center">$ {{ number_format($valTerrenoExcedente, 2)
                                    }}
                                </td>
                            </tr>
                            @endif

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="form-container__header">
            Valor de las construcciones por comparación
        </div>
        <div class="form-container__content">
            <div class="mt-[16px] form-grid form-grid--2-center">
                <div class="overflow-x-auto">
                    <table class="min-w-[550px] table-fixed w-full border-2 ">
                        <tbody>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Superficie construida vendible</td>
                                <td class="px-2 py-4 text-sm text-center">{{ number_format($saleableBuiltArea, 2) }} m²
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Valor unitario de mercado</td>
                                <td class="px-2 py-4 text-sm text-center">$ {{
                                    number_format($constructionMarketUnitValue, 2) }}</td>
                            </tr>

                            {{-- AGREGAMOS EL EXCEDENTE AQUÍ TAMBIÉN PARA SUMAR AL TOTAL --}}
                            @if($showExcessSection)
                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Valor Terreno Excedente</td>
                                <td class="px-2 py-4 text-sm text-center">$ {{ number_format($valTerrenoExcedente, 2)
                                    }}
                                </td>
                            </tr>
                            @endif

                            <tr>
                                <td class="px-2 py-4 text-sm text-center">Valor de mercado</td>
                                <td class="px-2 py-4 text-sm text-center">$ {{ number_format($marketValue, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</fielset>
</div>
