<!-- wire:poll.10s refresca los datos (conteos y cálculos) cada 10 segundos -->
<div wire:poll.10s="loadData">
    <div class="form-container">
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
                                <td class="px-2 py-2 text-xs text-center">Terrenos</td>
                                <!-- Valores dinámicos con formato -->
                                <td class="px-2 py-2 text-xs text-center">$ {{ number_format($landAvgUnitValue, 2) }}
                                </td>
                                <td class="px-2 py-2 text-xs text-center">$ {{ number_format($landHomologatedValue, 2)
                                    }}</td>
                                <td class="px-2 py-2 text-xs text-center">$ {{ number_format($landProbableValue, 2) }}
                                </td>
                                <td class="px-2 py-2 text-xs text-center">
                                    <flux:button type="button"
                                        class="btn-primary btn-table cursor-pointer w-36 justify-center"
                                        variant="primary" wire:click='openComparablesLand'>
                                        {{ $landCount > 0 ? "Editar ($landCount)" : "Agregar" }}
                                    </flux:button>
                                </td>

                                <td class="px-2 py-2 text-xs text-center">
                                   <flux:button class="btn-primary btn-table cursor-pointer w-30 justify-center" wire:click="toHomologationLand" :disabled="$landCount < 4">
                                    Homologar
                                </flux:button>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-xs text-center">Construcción en venta</td>
                                <!-- Valores dinámicos con formato -->
                                <td class="px-2 py-2 text-xs text-center">$ {{ number_format($buildingAvgUnitValue, 2)
                                    }}</td>
                                <td class="px-2 py-2 text-xs text-center">$ {{ number_format($buildingHomologatedValue,
                                    2) }}</td>
                                <td class="px-2 py-2 text-xs text-center">$ {{ number_format($buildingProbableValue, 2)
                                    }}</td>
                                <td class="px-2 py-2 text-xs text-center">
                                    <flux:button type="button"
                                        class="btn-primary btn-table cursor-pointer w-36 justify-center"
                                        variant="primary" wire:click='openComparablesBuilding'>
                                        {{ $buildingCount > 0 ? "Editar ($buildingCount)" : "Agregar" }}
                                    </flux:button>
                                </td>

                                <td class="px-2 py-2 text-xs text-center">
                                     <flux:button class="btn-primary btn-table cursor-pointer w-30 justify-center" wire:click="toHomologationBuilding" :disabled="$buildingCount < 4">
                                        Homologar
                                    </flux:button>
                                    </td>
                            </tr>

                        </tbody>
                    </table>
                </div>
            </div>
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
                                <td class="px-2 py-4 text-xs text-center">Superficie del terreno</td>
                                <!-- Valores dinámicos con formato -->
                                <td class="px-2 py-4 text-xs text-center">{{ number_format($terrainSurface, 2) }} m²
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Valor unitario del mercado</td>
                                <td class="px-2 py-4 text-xs text-center">$ {{ number_format($marketUnitValue, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Importe total del terreno</td>
                                <td class="px-2 py-4 text-xs text-center">$ {{ number_format($totalTerrainAmount, 2) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Indiviso aplicable en %</td>
                                <td class="px-2 py-4 text-xs text-center">{{ number_format($applicableUndividedPercent,
                                    0) }} %</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Valor del terreno</td>
                                <td class="px-2 py-4 text-xs text-center">$ {{ number_format($terrainValue, 2) }}</td>
                            </tr>

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
                                <td class="px-2 py-4 text-xs text-center">Superficie construida vendible</td>
                                <td class="px-2 py-4 text-xs text-center">{{ number_format($saleableBuiltArea, 2) }} m²
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Valor unitario del mercado</td>
                                <td class="px-2 py-4 text-xs text-center">$ {{
                                    number_format($constructionMarketUnitValue, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Valor de mercado</td>
                                <td class="px-2 py-4 text-xs text-center">$ {{ number_format($marketValue, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
