<div>
    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>
    <form wire:submit="save">
        <div class="form-container">
            <div class="form-container__header">
                Descripción del inmueble
            </div>
            <div class="form-container__content">


                <div class="form-grid form-grid--3 form-grid-3-variation">
                    <div class="label-variation">
                        <flux:label>Referencia de <br>proximidad urbana<span class="sup-required">*</span></flux:label>
                    </div>


                    {{-- Inicia --}}
                    <div class="relative inline-block w-full">
                        <flux:dropdown inline position="bottom" align="start" class="w-full">

                            {{-- BOTÓN --}}
                          {{--   <flux:button class="w-full flex items-center px-3 py-2 bg-white border border-gray-300
                     rounded-md shadow-sm hover:border-gray-400 focus:outline-none cursor-pointer"> --}}
                 <button @click.stop.prevent @class([ // Clases comunes
                    'w-full flex items-center px-3 py-2 bg-white rounded-md shadow-sm cursor-pointer focus:outline-none' , //
                    //Borde y color cuando NO hay error
                    'border border-gray-300 text-gray-700 hover:border-gray-400'=> !
                    $errors->has('urbanProximity'),

                    // Borde y color cuando SÍ hay error
                    'border border-red-500 text-red-700 focus:ring-1 focus:ring-red-500 focus:border-red-500' =>
                    $errors->has('urbanProximity'),
                    ])
                    >
                                <span class="flex-1 text-left text-gray-700">
                                    @if($urbanProximity)
                                    {{ $urbanProximity }} –
                                    {{ collect($usages)->firstWhere('clave', $urbanProximity)['nombre'] }}
                                    @else
                                    -- Selecciona una opción --
                                    @endif
                                </span>
                                <svg class="w-5 h-5 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <small>Depende de la infraestructura de la zona</small>
                            {{-- MENÚ --}}
                            <flux:menu class="absolute left-0 top-full mt-1 w-3/5 bg-white
                               border border-gray-200 rounded-md shadow-lg z-10">

                                <flux:menu.item disabled>
                                    <div class="w-full grid grid-cols-[20%_30%_50%] px-2 py-1
                            text-gray-600 font-medium">
                                        <span>Clave</span>
                                        <span>Nombre</span>
                                        <span>Descripción</span>
                                    </div>
                                </flux:menu.item>
                                <flux:menu.separator />

                                {{-- “Ninguno” --}}
                                <flux:menu.item wire:click="$set('urbanProximity','')" class="block w-full px-2 py-2 cursor-pointer
                       hover:bg-gray-100 transition-colors menu-item-personalized ">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span class="text-left">0</span>
                                        <span class="text-left">Ninguna </span>
                                        <span class="text-left">.</span>
                                    </div>
                                </flux:menu.item>

                                @foreach($usages as $item)
                                <flux:menu.item wire:click="$set('urbanProximity','{{ $item['clave'] }}')" class="block w-full px-2 py-2 cursor-pointer
                         hover:bg-gray-100 transition-colors menu-item-personalized
                         {{ $urbanProximity == $item['clave'] ? 'bg-gray-100' : '' }}">
                                    <div class="w-full grid grid-cols-[20%_30%_50%]">
                                        <span class="text-left">{{ $item['clave'] }}</span>
                                        <span class="text-left">{{ $item['nombre'] }}</span>
                                        <span class="text-left">{{ $item['descripcion'] }}</span>
                                    </div>
                                </flux:menu.item>
                                @endforeach

                            </flux:menu>
                        </flux:dropdown>
                        <div>
                            <flux:error name="urbanProximity"/>
                        </div>
                    </div>
                    {{-- Finaliza --}}
                    {{-- {{$urbanProximity}} --}}
                </div>


                <div class="form-grid form-grid--3 form-grid-3-variation">
                    <div class="flex xl:justify-end lg:justify-end md:justify-end sm:justify-start">
                        <flux:label>Uso actual<span class="sup-required">*</span></flux:label>
                    </div>
                    <div class="radio-input">
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:textarea class="h-64  " wire:model='actualUse' />
                            </div>
                            <div>
                                <flux:error name="actualUse"/>
                            </div>
                        </flux:field>
                    </div>
                </div>

                @if (stripos($propertyType, 'condominio') !== false)
                <div class="form-grid form-grid--3 form-grid-3-variation">
                    <div class="label-variation">
                        <flux:label>Espacio de uso múltiple<span class="sup-required">*</span></flux:label>
                    </div>
                    <div class="radio-input">
                        <flux:field>
                            <div class="radio-group-horizontal">
                               <flux:select wire:model="multipleUseSpace" class=" text-gray-800 [&_option]:text-gray-900">
                                    <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                    <flux:select.option value="1. Existe">1. Existe</flux:select.option>
                                    <flux:select.option value="2. No existe">2. No existe</flux:select.option>
                                </flux:select>
                            </div>
                            <div>
                                <flux:error name="multipleUseSpace"/>
                            </div>
                        </flux:field>
                        <small>Se refiere a si el inmueble a valuar es un pie de casa donde todas las actividades se desarrollan en un solo espacio.
                        Sólo hay muros divisorios para el baño</small>
                    </div>
                </div>

                <div class="form-grid form-grid--3 form-grid-3-variation">
                    <div class="label-variation">
                        <flux:label>Nivel de edicificio <br>(condominio)<span class="sup-required">*</span></flux:label>
                    </div>
                    <div class="radio-input">
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:input type="text" wire:model.lazy='levelBuilding' />
                            </div>
                            <div>
                                <flux:error name="levelBuilding"/>
                            </div>
                        </flux:field>
                        <small>Nivel en el que se encuentra el departamento dentro del edificio</small>
                    </div>
                </div>
                <div class="form-grid form-grid--3 form-grid-3-variation">
                    <div class="label-variation">
                        <flux:label>Calidad del proyecto<span class="sup-required">*</span></flux:label>
                    </div>
                    <div class="radio-input">
                        <flux:field>
                            <div class="radio-group-horizontal">
                                <flux:select wire:model="projectQuality" class=" text-gray-800 [&_option]:text-gray-900">
                                    <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                    <flux:select.option value="Funcional">Funcional</flux:select.option>
                                    <flux:select.option value="No funcional">No funcional</flux:select.option>
                                    <flux:select.option value="Adecuado a su epoca">Adecuado a su epoca</flux:select.option>
                                </flux:select>
                            </div>
                            <div>
                                <flux:error name="projectQuality"/>
                            </div>
                        </flux:field>
                    </div>
                </div>
                @endif
            </div>
        </div>
        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>
    </form>
</div>
