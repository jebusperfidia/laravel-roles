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

    <form wire:submit="save">
        <fieldset @disabled($isReadOnly)>
        <div class="form-container">
            <div class="form-container__header">
                Descripción del inmueble
            </div>
            <div class="form-container__content">

                {{-- 1. REFERENCIA DE PROXIMIDAD URBANA --}}
                <div class="form-grid form-grid-3-variation">
                    <div class="label-variation">
                        <flux:label>Referencia de <br>proximidad urbana<span class="sup-required">*</span></flux:label>
                    </div>

                    <div class="w-full flex flex-col"> {{-- Cambiamos radio-input por esto --}}
                        <flux:dropdown position="bottom" align="start" class="w-full">
                            <button @click.stop.prevent @class([
                                'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none' ,
                                'border border-gray-300 text-gray-700 hover:border-gray-400'=> !$errors->has('urbanProximity'),
                                'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500' => $errors->has('urbanProximity'),
                            ])>
                                <span class="flex-1 text-left text-gray-700 truncate">
                                    @if($urbanProximity)
                                        {{ $urbanProximity }} – {{ collect($usages)->firstWhere('clave', $urbanProximity)['nombre'] }}
                                    @else
                                        -- Selecciona una opción --
                                    @endif
                                </span>
                                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <flux:menu class="absolute left-0 top-full mt-1 w-full bg-white border border-gray-200 rounded-md shadow-lg z-10">
                                <flux:menu.item disabled>
                                    <div class="w-full grid grid-cols-[20%_30%_50%] px-2 py-1 text-gray-600 font-medium text-xs">
                                        <span>Clave</span><span>Nombre</span><span>Descripción</span>
                                    </div>
                                </flux:menu.item>
                                <flux:menu.separator />
                                @foreach($usages as $item)
                                    <flux:menu.item wire:click="$set('urbanProximity','{{ $item['clave'] }}')" class="block w-full px-2 py-2 cursor-pointer hover:bg-gray-100 transition-colors">
                                        <div class="w-full grid grid-cols-[20%_30%_50%] gap-2 text-xs">
                                            <span>{{ $item['clave'] }}</span>
                                            <span>{{ $item['nombre'] }}</span>
                                            <span class="truncate">{{ $item['descripcion'] }}</span>
                                        </div>
                                    </flux:menu.item>
                                @endforeach
                            </flux:menu>
                        </flux:dropdown>
                        <small class="text-gray-500 mt-1">Depende de la infraestructura de la zona</small>
                        <flux:error name="urbanProximity" />
                    </div>
                </div>

                {{-- 2. USO ACTUAL --}}
                <div class="form-grid form-grid-3-variation">
                        <div class="label-variation">
                        <flux:label>Uso actual<span class="sup-required">*</span></flux:label>
                    </div>
                    <div class="w-full flex flex-col">
                        <flux:textarea class="h-40 w-full" wire:model='actualUse' />
                        <flux:error name="actualUse" />
                    </div>
                </div>

                {{-- 3. NIVEL DE EDIFICIO (Solo si aplica) --}}
                @if (stripos($propertyType, 'condominio') !== false)
                <div class="form-grid form-grid-3-variation">
                    <div class="label-variation">
                        <flux:label>Nivel de edificio <br>(condominio)<span class="sup-required">*</span></flux:label>
                    </div>
                    <div class="w-full flex flex-col">
                        <flux:input type="text" class="w-full" wire:model.lazy='levelBuilding' />
                        <small class="text-gray-500 mt-1">Nivel en el que se encuentra el departamento dentro del edificio</small>
                        <flux:error name="levelBuilding" />
                    </div>
                </div>
                @endif

                {{-- 4. ESPACIO DE USO MÚLTIPLE --}}
                <div class="form-grid form-grid-3-variation">
                    <div class="label-variation">
                        <flux:label>Espacio de uso múltiple<span class="sup-required">*</span></flux:label>
                    </div>
                    <div class="w-full flex flex-col">
                        <flux:select wire:model="multipleUseSpace" class="w-full">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="1. Existe">1. Existe</flux:select.option>
                            <flux:select.option value="2. No existe">2. No existe</flux:select.option>
                        </flux:select>
                        <small class="text-gray-500 mt-1">Se refiere a si el inmueble a valuar es un pie de casa donde todas las actividades se desarrollan en un solo espacio.</small>
                        <flux:error name="multipleUseSpace" />
                    </div>
                </div>

                {{-- 5. CALIDAD DEL PROYECTO --}}
                <div class="form-grid form-grid-3-variation">
                    <div class="label-variation">
                        <flux:label>Calidad del proyecto<span class="sup-required">*</span></flux:label>
                    </div>
                    <div class="w-full flex flex-col">
                        <flux:select wire:model="projectQuality" class="w-full">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Funcional">Funcional</flux:select.option>
                            <flux:select.option value="No funcional">No funcional</flux:select.option>
                            <flux:select.option value="Adecuado a su epoca">Adecuado a su epoca</flux:select.option>
                        </flux:select>
                        <flux:error name="projectQuality" />
                    </div>
                </div>

            </div>
        </div>
        </fieldset>

        @if(!$isReadOnly)
        <div class="flex justify-start mt-4">
            <flux:button class="cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
        </div>
        @endif
    </form>
</div>
