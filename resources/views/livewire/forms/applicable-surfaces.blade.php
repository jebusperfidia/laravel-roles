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
    <form wire:submit='save'>
        <fieldset @disabled($isReadOnly)>
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
                                @if ( $buildingConstructionsPrivate->isEmpty())
                                <tr>
                                    <td colspan="4" class="border px-2 py-1 text-xs text-center text-gray-500">
                                        No hay construcciones privativas para mostrar.
                                    </td>
                                </tr>
                                @else
                                @foreach ($buildingConstructionsFilter as $item)
                                <tr wire:key="private-surface-{{ $item->id }}">
                                    {{-- Descripción --}}
                                    <td class="border px-2 py-1 text-xs text-center">{{ $item->description }}</td>

                                    {{-- Superficie --}}
                                    <td class="border px-2 py-1 text-xs text-center">
                                        {{ preg_replace('/(\.\d{2,}?)0+$/', '$1', number_format($item->surface, 6, '.',
                                        ',')) }}
                                    </td>

                                    {{-- Tipo --}}
                                    <td class="border px-2 py-1 text-xs text-center">
                                        {{$item->surface_vad === 'superficie accesoria' ? 'Accesoria' : 'Vendible'}}
                                    </td>

                                    {{-- Aplicar --}}
                                    <td class="border px-2 py-1 flex justify-center">
                                        <flux:checkbox wire:model.live='elementApplyState.{{ $item->id }}' />
                                    </td>
                                </tr>
                                @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-[64px] form-grid form-grid--2-center">
                    <div class="form-grid-2-variation">
                        <flux:label class="label-variation">Superficie vendible:
                        </flux:label>
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:input.group>
                                    <flux:input type="number" wire:model='totalSurfacePrivateVendible' readonly
                                        step="any" />
                                    <flux:button disabled><b>m²</b></flux:button>
                                </flux:input.group>
                            </div>
                            <div>
                                <flux:error name="totalSurfacePrivateVendible" />
                            </div>
                        </flux:field>
                    </div>
                </div>
                <div class="mt-2 form-grid form-grid--2-center">
                    <div class="form-grid-2-variation">
                        <flux:label class="label-variation">Cálculo de superficie<br>construida:</flux:label>
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:checkbox wire:model.live='calculationBuiltArea' />
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
                        <flux:label class="label-variation">Superficie construida:</flux:label>
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:input.group>
                                    @if ($calculationBuiltArea)
                                    <flux:input type="number" wire:model='builtArea' step="any" readonly />
                                    @else
                                    <flux:input type="number" wire:model='builtArea' step="any" />
                                    @endif
                                    <flux:button><b>m²</b></flux:button>
                                </flux:input.group>
                            </div>
                            <div>
                                <flux:error name="builtArea" />
                            </div>
                        </flux:field>
                    </div>
                </div>





                {{-- ESTOS VALORES SON LOS QUE SE DEBEN MOSTRAR EN EL SELECT DE HOMOLOGATION LANDS DE SUPERFICIE APLICABLE --}}
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
                                    <td class="border px-2 py-1 text-xs text-center">Total del terreno</td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field>
                                            <div class="radio-group-horizontal">
                                                <flux:input.group>
                                                    <flux:input type="number" wire:model='surfaceArea' step="any" />
                                                    <flux:button disabled><b>m²</b></flux:button>
                                                </flux:input.group>
                                            </div>

                                            {{-- *** CORRECCIÓN: Usamos ?-> y ?? 0 *** --}}
                                            <small class="suggested-text">Valor propuesto: <a
                                                    wire:click="setSurfaceAreaToSuggested">
                                                    {{ preg_replace('/(\.\d{2,}?)0+$/', '$1',
                                                    number_format($landSurfacesTotal ?? 0, 6, '.', ',')) }}
                                                </a><b> m²</b></small>

                                            <div>
                                                <flux:error name="surfaceArea" />
                                            </div>
                                        </flux:field>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field class="radio-group-horizontal">
                                            <flux:select wire:model="sourceSurfaceArea"
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
                                                <flux:error name="sourceSurfaceArea" />
                                            </div>
                                        </flux:field>
                                    </td>
                                </tr>

                                @if ($useExcessCalculation)
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Lote privativo</td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field>
                                            <div class="radio-group-horizontal">
                                                <flux:input.group>
                                                    <flux:input type="number" wire:model='privateLot' step="any" />
                                                    <flux:button disabled><b>m²</b></flux:button>
                                                </flux:input.group>
                                            </div>

                                            {{-- *** CORRECCIÓN: Usamos ?-> y ?? 0 *** --}}
                                            <small class="suggested-text">Valor propuesto: <a
                                                    wire:click="setPrivateLotToSuggested">{{
                                                    preg_replace('/(\.\d{2,}?)0+$/', '$1',
                                                    number_format($landDetail?->surface_private_lot ?? 0, 6, '.', ','))
                                                    }}</a><b>
                                                    m²</b></small>

                                            <div>
                                                <flux:error name="privateLot" />
                                            </div>
                                        </flux:field>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field class="radio-group-horizontal">
                                            <flux:select wire:model="sourcePrivateLot"
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
                                                <flux:error name="sourcePrivateLot" />
                                            </div>
                                        </flux:field>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Lote privativo tipo</td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field>
                                            <div class="radio-group-horizontal">
                                                <flux:input.group>
                                                    <flux:input type="number" wire:model='privateLotType' step="any" />
                                                    <flux:button disabled><b>m²</b></flux:button>
                                                </flux:input.group>
                                            </div>

                                            {{-- *** CORRECCIÓN: Usamos ?-> y ?? 0 *** --}}
                                            <small class="suggested-text">Valor propuesto: <a
                                                    wire:click="setPrivateLotTypeToSuggested">{{
                                                    preg_replace('/(\.\d{2,}?)0+$/', '$1',
                                                    number_format($landDetail?->surface_private_lot_type ?? 0, 6, '.',
                                                    ','))
                                                    }}</a><b> m²</b></small>

                                            <div>
                                                <flux:error name="privateLotType" />
                                            </div>
                                        </flux:field>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field class="radio-group-horizontal">
                                            <flux:select wire:model="sourcePrivateLotType"
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
                                                <flux:error name="sourcePrivateLotType" />
                                            </div>
                                        </flux:field>
                                    </td>
                                </tr>
                                @endif







                                @if (stripos($propertyType, 'condominio') !== false)
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Indiviso aplicable</td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field>
                                            <div class="radio-group-horizontal">
                                                <flux:input.group>
                                                    <flux:input type="number" wire:model='applicableUndivided'
                                                        step="any" />
                                                    <flux:button disabled><b>%</b></flux:button>
                                                </flux:input.group>
                                            </div>

                                            {{-- *** CORRECCIÓN: Usamos ?-> y ?? 0 *** --}}
                                            <small class="suggested-text">Valor propuesto: <a
                                                    wire:click="setApplicableUndividedToSuggested">{{
                                                    preg_replace('/(\.\d{2,}?)0+$/', '$1',
                                                    number_format($landDetail?->undivided_only_condominium ?? 0, 6, '.',
                                                    ','))
                                                    }}</a><b> %</b></small>

                                            <div>
                                                <flux:error name="applicableUndivided" />
                                            </div>
                                        </flux:field>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field class="radio-group-horizontal">
                                            <flux:select wire:model="sourceApplicableUndivided"
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
                                                <flux:error name="sourceApplicableUndivided" />
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
                                                    <flux:input type="number" wire:model='proporcionalLand'
                                                        step="any" />
                                                    <flux:button disabled><b>m²</b></flux:button>
                                                </flux:input.group>
                                            </div>

                                            {{-- *** CORRECCIÓN: Usamos ?-> y ?? 0 *** --}}
                                            <small class="suggested-text">Valor propuesto: <a
                                                    wire:click="setProporcionalLandToSuggested">{{
                                                    preg_replace('/(\.\d{2,}?)0+$/', '$1',
                                                    number_format($landDetail?->undivided_surface_land ?? 0, 6, '.',
                                                    ','))
                                                    }}</a><b> m²</b></small>

                                            <div>
                                                <flux:error name="proporcionalLand" />
                                            </div>
                                        </flux:field>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field class="radio-group-horizontal">
                                            <flux:select wire:model="sourceProporcionalLand"
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
                                                <flux:error name="sourceProporcionalLand" />
                                            </div>
                                        </flux:field>
                                    </td>
                                </tr>
                                @endif

                                @if ($useExcessCalculation)
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Sup. terreno excedente</td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                        <flux:field>
                                            <div class="radio-group-horizontal">
                                                <flux:input.group>
                                                    <flux:input type="number" wire:model='surplusLandArea' step="any" />
                                                    <flux:button disabled><b>m²</b></flux:button>
                                                </flux:input.group>
                                            </div>

                                            {{-- *** CORRECCIÓN: Usamos ?-> y ?? 0 *** --}}
                                            <small class="suggested-text">Valor propuesto: <a
                                                    wire:click="setSurplusLandAreaToSuggested">{{
                                                    preg_replace('/(\.\d{2,}?)0+$/', '$1',
                                                    number_format($landDetail?->surplus_land_area ?? 0, 6, '.', ','))
                                                    }}</a><b> m²</b></small>

                                            <div>
                                                <flux:error name="surplusLandArea" />
                                            </div>
                                        </flux:field>
                                    </td>
                                    <td class="border px-2 py-1 text-xs text-center">
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-2 form-grid form-grid--3">
                    <div class="overflow-x-auto">
                        <table class="border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-2 py-1 "></th>
                                    <th class="border px-2 py-1 ">Privativas</th>
                                    <th class="border px-2 py-1 ">Comunes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Superficie total de
                                        construcciones:
                                    </td>
                                    <td class="border px-2 py-1 text-sm text-center">
                                        {{ preg_replace('/(\.\d{2,}?)0+$/', '$1', number_format($totalSurfacePrivate, 6,
                                        '.', ',')) }}
                                    </td>
                                    <td class="border px-2 py-1 text-sm text-center">
                                        {{ preg_replace('/(\.\d{2,}?)0+$/', '$1', number_format($totalSurfaceCommon, 6,
                                        '.', ',')) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="mt-2 form-grid form-grid--3">
                    <div class="overflow-x-auto">
                        <table class="border-2 ">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="border px-2 py-1 "></th>
                                    <th class="border px-2 py-1 ">Vendible</th>
                                    <th class="border px-2 py-1 ">Acessoria</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="border px-2 py-1 text-xs text-center">Superficie total de
                                        construcciones:
                                    </td>
                                    <td class="border px-2 py-1 text-sm text-center">
                                        {{ preg_replace('/(\.\d{2,}?)0+$/', '$1',
                                        number_format($totalSurfacePrivateVendible, 6, '.', ',')) }}
                                    </td>
                                    <td class="border px-2 py-1 text-sm text-center">
                                        {{ preg_replace('/(\.\d{2,}?)0+$/', '$1',
                                        number_format($totalSurfacePrivateAccesoria, 6, '.', ',')) }}
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        @if(!$isReadOnly)
        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
        @endif
    </fieldset>
    </form>
</div>
