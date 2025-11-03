<div>
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
                                <th class="px-2 py-2 ">Comparables seleccionados</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="px-2 py-2 text-xs text-center">Terrenos</td>
                                <td class="px-2 py-2 text-xs text-center">$ 0.00</td>
                                <td class="px-2 py-2 text-xs text-center">$ 0.00</td>
                                <td class="px-2 py-2 text-xs text-center">$ 0.00</td>
                                <td class="px-2 py-2 text-xs text-center">
                                    <flux:button type="button" class="btn-intermediary btn-table cursor-pointer" variant="primary"
                                        wire:click='openComparablesLand'>Asignar
                                    </flux:button>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-2 py-2 text-xs text-center">Construcción en venta</td>
                                <td class="px-2 py-2 text-xs text-center">$ 0.00</td>
                                <td class="px-2 py-2 text-xs text-center">$ 0.00</td>
                                <td class="px-2 py-2 text-xs text-center">$ 0.00</td>
                                <td class="px-2 py-2 text-xs text-center">
                                    <flux:button type="button" class="btn-intermediary btn-table cursor-pointer" variant="primary"
                                      wire:click='openComparablesBuilding'>Asignar
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
                                <td class="px-2 py-4 text-xs text-center">1.00 m²</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Valor unitario del mercado</td>
                                <td class="px-2 py-4 text-xs text-center">$0.00</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Importe total del terreno</td>
                                <td class="px-2 py-4 text-xs text-center">$0.00</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Indiviso aplicable en %</td>
                                <td class="px-2 py-4 text-xs text-center">0 %</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Valor del terreno</td>
                                <td class="px-2 py-4 text-xs text-center">$0.00</td>
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
                                <td class="px-2 py-4 text-xs text-center">100.00 m²</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Valor unitario del mercado</td>
                                <td class="px-2 py-4 text-xs text-center">$0.00</td>
                            </tr>
                            <tr>
                                <td class="px-2 py-4 text-xs text-center">Valor de mercado</td>
                                <td class="px-2 py-4 text-xs text-center">$0.00</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
