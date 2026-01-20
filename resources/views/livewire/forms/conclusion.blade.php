
<div>
    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>

    <form wire:submit='save'>

        <div class="form-container">
            <div class="form-container__header">
                Conclusión del Valor
            </div>
            <div class="form-container__content">

                {{-- TABLA ESTILO SUPERFICIES --}}
                <div class="mt-2 form-grid form-grid--2-center">

                        <table class="border-2 w-full">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-2 py-1 w-1/4">Resumen de Valores</th>
                                    <th class="border px-2 py-1 w-1/4">Monto</th>
                                    <th class="border px-2 py-1 w-16">Selección</th>
                                    <th class="border px-2 py-1">Descripción</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Fila 1: Terreno --}}
                                <tr class="h-10"> {{-- Altura fija para uniformidad --}}
                                    <td class="border px-2 py-1 text-xs text-right font-semibold text-gray-700">
                                        Valor del Terreno:
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-right text-gray-700">
                                        {{ $con_landValue }}
                                    </td>
                                    <td class="border px-2 py-1 text-center">
                                        <div class="flex justify-center items-center h-full">
                                            {{-- RADIO CON COLORES CORRECTOS (FONDO NEGRO, PUNTO BLANCO) --}}
                                            <input type="radio" wire:model.live="con_selectedValueType"
                                                name="valuation_type" value="land"
                                                class="size-4 cursor-pointer appearance-none rounded-full border border-zinc-400 bg-white checked:border-[5px] checked:border-zinc-900 transition-all">
                                        </div>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-gray-600">
                                        Valor del terreno proporcional
                                    </td>
                                </tr>

                                {{-- Fila 2: Mercado --}}
                                <tr class="h-10">
                                    <td class="border px-2 py-1 text-xs text-right font-semibold text-gray-700">
                                        Comparativo de Mercado:
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-right text-gray-700">
                                        {{ $con_marketValue }}
                                    </td>
                                    <td class="border px-2 py-1 text-center">
                                        <div class="flex justify-center items-center h-full">
                                            <input type="radio" wire:model.live="con_selectedValueType"
                                                name="valuation_type" value="market"
                                                class="size-4 cursor-pointer appearance-none rounded-full border border-zinc-400 bg-white checked:border-[5px] checked:border-zinc-900 transition-all">
                                        </div>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-gray-600">
                                        Valor de mercado en el estado actual
                                    </td>
                                </tr>

                                {{-- Fila 3: Hipotético --}}
                                <tr class="h-10">
                                    <td class="border px-2 py-1 text-xs text-right font-semibold text-gray-700">
                                        Comparativo Hipotético:
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-right text-gray-700">
                                        {{ $con_hypotheticalValue }}
                                    </td>
                                    <td class="border px-2 py-1 text-center">
                                        <div class="flex justify-center items-center h-full">
                                            <input type="radio" wire:model.live="con_selectedValueType"
                                                name="valuation_type" value="hypothetical"
                                                class="size-4 cursor-pointer appearance-none rounded-full border border-zinc-400 bg-white checked:border-[5px] checked:border-zinc-900 transition-all">
                                        </div>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-gray-600">
                                        Valor de mercado suponiendo su total terminación
                                    </td>
                                </tr>

                                {{-- Fila 4: Físico --}}
                                <tr class="h-10">
                                    <td class="border px-2 py-1 text-xs text-right font-semibold text-gray-700">
                                        Valor Físico:
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-right text-gray-700">
                                        {{ $con_physicalValue }}
                                    </td>
                                    <td class="border px-2 py-1 text-center">
                                        <div class="flex justify-center items-center h-full">
                                            <input type="radio" wire:model.live="con_selectedValueType"
                                                name="valuation_type" value="physical"
                                                class="size-4 cursor-pointer appearance-none rounded-full border border-zinc-400 bg-white checked:border-[5px] checked:border-zinc-900 transition-all">
                                        </div>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-gray-600">
                                        Valor físico o directo o costos
                                    </td>
                                </tr>

                                {{-- Fila 5: Otro Valor --}}
                                <tr class="h-10">
                                    <td
                                        class="border px-2 py-1 text-xs text-right font-semibold text-gray-700 align-middle">
                                        Otro valor:
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-right">
                                        <flux:field>
                                            <div class="radio-group-horizontal justify-end">
                                                <flux:input type="number" step="0.01" wire:model.lazy="con_otherValueAmount"
                                                    class="text-center disabled:bg-gray-200 disabled:cursor-not-allowed"
                                                    :disabled="$con_selectedValueType != 'other'" style="text-align: right;" />
                                            </div>
                                        </flux:field>
                                    </td>
                                    <td class="border px-2 py-1 text-center align-middle">
                                        <div class="flex justify-center items-center h-full">
                                            <input type="radio" wire:model.lazy="con_selectedValueType"
                                                name="valuation_type" value="other"
                                                class="size-4 cursor-pointer appearance-none rounded-full border border-zinc-400 bg-white checked:border-[5px] checked:border-zinc-900 transition-all">
                                        </div>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-gray-600 align-middle">
                                        Especifique otro valor
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                </div>

                {{-- SECCION DE CALCULOS INFERIOR --}}

                {{-- Diferencia --}}
                <div class="mt-[32px] form-grid form-grid--2-center">
                    <div class="form-grid-2-variation">
                        <flux:label class="label-variation">Diferencia Físico VS Mercado:</flux:label>
                        <div class="flex items-center">
                            <span class="font-bold text-sm text-gray-800">{{ $con_difference }}</span>
                        </div>
                    </div>
                </div>

                {{-- Rango --}}
                <div class="mt-2 form-grid form-grid--2-center">
                    <div class="form-grid-2-variation">
                        <flux:label class="label-variation">Rango entre los enfoques:</flux:label>
                        <div class="flex items-center">
                            <span class="font-bold text-sm text-gray-800">{{ $con_range }}</span>
                        </div>
                    </div>
                </div>

              {{-- Redondeo --}}
            <div class="mt-2 form-grid form-grid--2-center">
                <div class="form-grid-2-variation">
                    <flux:label class="label-variation">Redondeo<span class="sup-required">*</span></flux:label>
                    <flux:field>
                        <div class="radio-group-horizontal">
                            {{-- CAMBIO CRÍTICO: Se agregó .live --}}
                            <flux:select wire:model.live="con_rounding" class="text-gray-800 [&_option]:text-gray-900">
                                <flux:select.option value="Sin redondeo">Sin redondeo</flux:select.option>
                                <flux:select.option value="A decimales">A decimales</flux:select.option>
                                <flux:select.option value="A decenas">A decenas</flux:select.option>
                                <flux:select.option value="A centenas">A centenas</flux:select.option>
                                <flux:select.option value="A miles">A miles</flux:select.option>
                                <flux:select.option value="Personalizado">Personalizado</flux:select.option>
                            </flux:select>
                        </div>
                        <div>
                            <flux:error name="con_rounding" />
                        </div>
                    </flux:field>
                </div>
            </div>

            {{-- Valor Concluido --}}
            <div class="mt-2 form-grid form-grid--2-center">
                <div class="form-grid-2-variation">
                    <flux:label class="label-variation">Valor Concluido:</flux:label>
                    <flux:field>
                        <div class="radio-group-horizontal">
                            {{-- .live aquí también para que si es personalizado se actualice el modelo --}}
                            <flux:input type="number" wire:model.lazy='con_concludedValue'
                                :disabled="$con_rounding !== 'Personalizado'"
                                class="font-bold text-lg bg-gray-50 text-gray-800 read-only:bg-gray-100 read-only:cursor-not-allowed focus:bg-white" />
                        </div>
                    </flux:field>
                </div>
            </div>
            </div>
        </div>

        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Continuar</flux:button>
    </form>
</div>
