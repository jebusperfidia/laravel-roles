<div>
    <form wire:submit='save'>

        <div class="form-container">
            <div class="form-container__header">
                Superficies
            </div>
            <div class="form-container__content">


                <div class="mt-2 form-grid form-grid--2-center">
                    <div class="overflow-x-auto">
                        <table class="border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-2 py-1 ">Descripción</th>
                                    <th class="border px-2 py-1 ">Superficie</th>
                                    <th class="border px-2 py-1 ">Tipo</th>
                                    <th class="border px-2 py-1 ">Aplicar</th>
                                </tr>
                            </thead>
                            <tbody>

                                {{-- Valor de ejemplo para usar en los for --}}
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Casa habitacion</td>
                                    <td class="border px-2 py-1 text-xs text-center">1</td>
                                    <td class="border px-2 py-1 text-xs text-center">Vendible</td>
                                    <td class="border px-2 py-1 flex justify-center">
                                        <flux:checkbox wire:model='data' />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>





                <div class="mt-[64px] form-grid form-grid--2-center">
                    <div class="form-grid-2-variation">
                        <flux:label class="label-variation" for="sourceReplacementObtained">Superficie vendible:
                        </flux:label>
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:input.group>
                                    <flux:input type="number" wire:model='saleableArea' readonly/>
                                    <flux:button disabled><b>m²</b></flux:button>
                                </flux:input.group>
                            </div>
                            <div>
                                <flux:error name="saleableArea" />
                            </div>
                        </flux:field>
                    </div>
                </div>
                <div class="mt-2 form-grid form-grid--2-center">
                    <div class="form-grid-2-variation">
                        <flux:label class="label-variation" for="sourceReplacementObtained">Cálculo de superficie
                            <br>construida:</flux:label>
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:checkbox wire:model='calculationBuiltArea'/>
                            </div>
                            <small class="text-[12px] text-gray-500">Si la casilla está seleccionada, el valor en la
                                celda de abajo será siempre igual al la superficie vendible. Si
                                no, el
                                valor se introducirá de forma manual y el sistema respetará el valor capturado</small>
                            <div>
                                <flux:error name="calculationBuiltArea" />
                            </div>
                        </flux:field>
                    </div>
                </div>
                <div class="mt-2 form-grid form-grid--2-center">
                    <div class="form-grid-2-variation">
                        <flux:label class="label-variation" for="sourceReplacementObtained">Superficie construida:
                        </flux:label>
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:input.group>
                                    <flux:input type="number" wire:model='builtArea' />
                                    <flux:button disabled><b>m²</b></flux:button>
                                </flux:input.group>
                            </div>
                            <div>
                                <flux:error name="builtArea" />
                            </div>
                        </flux:field>
                    </div>
                </div>










                <div class="mt-[64px] form-grid form-grid--2-center">
                    <div class="overflow-x-auto">
                        <table class="border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-2 py-1 ">Concepto</th>
                                    <th class="border px-2 py-1 ">Superficie aplicable al cálculo del avalúo</th>
                                    <th class="border px-2 py-1 ">Fuente de información</th>
                                </tr>
                            </thead>
                            <tbody>

                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Casa habitacion</td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field>
                                            <div class="radio-group-horizontal">
                                                <flux:input.group>
                                                    <flux:input type="number" wire:model='hr_surfaceArea' />
                                                    <flux:button disabled><b>m²</b></flux:button>
                                                </flux:input.group>
                                            </div>
                                            <div>
                                                <flux:error name="hr_surfaceArea" />
                                            </div>
                                        </flux:field>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field class="radio-group-horizontal">
                                            <flux:select wire:model="hr_informationSource"
                                                class=" text-gray-800 [&_option]:text-gray-900">
                                                <flux:select.option value="">-- Selecciona una opción --
                                                </flux:select.option>
                                                @foreach ($construction_source_information as $value => $label)
                                                <flux:select.option value="{{ $label }}">
                                                    {{ $label }}
                                                </flux:select.option>
                                                @endforeach
                                            </flux:select>
                                            <div>
                                                <flux:error name="hr_informationSource" />
                                            </div>
                                            </flux:field>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Indiviso aplicable</td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field>
                                            <div class="radio-group-horizontal">
                                                <flux:input.group>
                                                    <flux:input type="number" wire:model='ua_surfaceArea'/>
                                                    <flux:button disabled><b>%</b></flux:button>
                                                </flux:input.group>
                                            </div>
                                            <div>
                                                <flux:error name="ua_surfaceArea"/>
                                            </div>
                                        </flux:field>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field class="radio-group-horizontal">
                                            <flux:select wire:model="ua_informationSource"
                                                class=" text-gray-800 [&_option]:text-gray-900">
                                                <flux:select.option value="">-- Selecciona una opción --
                                                </flux:select.option>
                                                @foreach ($construction_source_information as $value => $label)
                                                <flux:select.option value="{{ $label }}">
                                                    {{ $label }}
                                                </flux:select.option>
                                                @endforeach
                                            </flux:select>
                                            <div>
                                                <flux:error name="ua_informationSource" />
                                            </div>
                                        </flux:field>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Terreno proporcional</td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field>
                                            <div class="radio-group-horizontal">
                                                <flux:input.group>
                                                    <flux:input type="number" wire:model='pl_surfaceArea' />
                                                    <flux:button disabled><b>m²</b></flux:button>
                                                </flux:input.group>
                                            </div>
                                            <div>
                                                <flux:error name="pl_surfaceArea" />
                                            </div>
                                        </flux:field>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field class="radio-group-horizontal">
                                            <flux:select wire:model="pl_informationSource"
                                                class=" text-gray-800 [&_option]:text-gray-900">
                                                <flux:select.option value="">-- Selecciona una opción --
                                                </flux:select.option>
                                                @foreach ($construction_source_information as $value => $label)
                                                <flux:select.option value="{{ $label }}">
                                                    {{ $label }}
                                                </flux:select.option>
                                                @endforeach
                                            </flux:select>
                                            <div>
                                                <flux:error name="pl_informationSource" />
                                            </div>
                                        </flux:field>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>













                <div class="mt-[64px] form-grid form-grid--2-center">
                    <div class="overflow-x-auto">
                        <table class="border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-2 py-1 "></th>
                                    <th class="border px-2 py-1 ">Privatias</th>
                                    <th class="border px-2 py-1 ">Comunes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Superficie total de construcciones:
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-center">1</td>
                                    <td class="border px-2 py-1 text-sm text-center">1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-2 form-grid form-grid--2-center">
                    <div class="overflow-x-auto">
                        <table class="border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-2 py-1 "></th>
                                    <th class="border px-2 py-1 ">Vendible</th>
                                    <th class="border px-2 py-1 ">Accesoria</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Superficie</td>
                                    <td class="border px-2 py-1 text-xs text-center">1</td>
                                    <td class="border px-2 py-1 text-sm text-center">1</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
    </form>
</div>
