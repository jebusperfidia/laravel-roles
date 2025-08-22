{{-- resources/views/livewire/containers-demo.blade.php --}}
<div>
    <div class="form-container">
        <div class="form-container__header">
            Configuración y fecha del avalúo
        </div>
        <div class="form-container__content">
            {{-- Fila 1 --}}
            <div class="form-grid form-grid--2">
                <flux:input label="Folio" type="text" wire:model="gi_folio" placeholder="" />
                <flux:input label="Fecha de creación" type="date" wire:model="gi_date" placeholder="" />
            </div>
            {{-- Fila 2 --}}
            <div class="form-grid form-grid--2">
                <div>
                    <label for="tipo" class="flux-label text-sm">Tipo de avalúo</label>
                    <flux:select wire:model="gi_type" class="mt-2  text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="fiscal">Fiscal</flux:select.option>
                        <flux:select.option value="comercial">Comercial</flux:select.option>
                    </flux:select>
                </div>
                <div>
                    <label for="tipo" class="flux-label text-sm">Tipo de cálculo</label>
                    <flux:select wire:model="gi_calculationType" class="mt-2 text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="Administrador">Cálculos activados</flux:select.option>
                        <flux:select.option value="Operador">Operador</flux:select.option>
                    </flux:select>
                </div>
            </div>
            {{-- Fila 3 --}}
            <div class="form-grid form-grid--2">
                <div>
                    <label for="tipo" class="flux-label text-sm">Valuador</label>
                    <flux:select wire:model="gi_valuator">
                        <flux:select.option value=""></flux:select.option>
                        @foreach ($users as $user)
                            <flux:select.option value="{{ $user->id }}">
                                {{ $user->name }}
                            </flux:select.option>
                        @endforeach
                    </flux:select>
                </div>
                <flux:checkbox.group wire:model="gi_preValuation" label="Es un pre-avalúo">
                    <flux:checkbox value="" />
                </flux:checkbox.group>
            </div>
        </div>
    </div>

    {{-- <p>{{$gi_typePerson}}</p> --}}
    <div class="form-container">
        <div class="form-container__header">
            Datos del propietario
        </div>
        <div class="form-container__content">
            {{-- Fila 1 --}}
            <div class="form-grid form-grid--3">
                <div>
                    <label for="tipo" class="flux-label text-sm">Tipo de persona</label>
                    <flux:select wire:model.live="gi_typePerson"
                        class="mt-[8px] text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="Fisica">Fisica</flux:select.option>
                        <flux:select.option value="Moral">Moral</flux:select.option>
                    </flux:select>
                </div>
                <flux:input label="RFC" type="text" wire:model="gi_rfc" placeholder="" />
                <flux:input label="CURP" type="text" wire:model="gi_curp" placeholder="" />
            </div>
            {{-- Fila 2 --}}
            <div class="form-grid form-grid--3">
                <flux:input label="Nombre" type="text" wire:model="gi_name" placeholder="" />
                <flux:input label="Apellido Paterno" type="text" wire:model="gi_firtsName" placeholder="" />
                <flux:input label="Apellido Materno" type="text" wire:model="gi_secondName" placeholder="" />
            </div>
            {{-- Fila 3 --}}
            <div class="form-grid form-grid--3">
                <flux:input label="Código postal" type="text" wire:model="gi_cp" placeholder="" />
                <flux:input label="Entidad" type="text" wire:model="gi_entity" placeholder="" />
                <flux:input label="Alcaldia/Municipio" type="text" wire:model="gi_locality" placeholder="" />
            </div>
            {{-- Fila 4 --}}
            <div class="form-grid form-grid--3">
                <flux:input label="Colonia" type="text" wire:model="gi_colony" placeholder="" />
                <flux:input label="Calle" type="text" wire:model="gi_street" placeholder="" />
            </div>
            {{-- Fila 5 --}}
            <div class="form-grid form-grid--3">
                <flux:input label="Número exterior" type="text" wire:model="gi_abroadNumber" placeholder="" />
                <flux:input label="Número interior" type="text" wire:model="gi_insideNumber" placeholder="" />
            </div>
        </div>
    </div>


    <div class="form-container">
        <div class="form-container__header">
            Datos del solicitante
        </div>
        <div class="form-container__content">
            {{-- Fila 1 --}}
            <div class="form-grid form-grid--3">
                <flux:input label="Tipo de persona" type="text" wire:model="gi_typeApplicant" placeholder="" />
                <flux:input label="RFC" type="text" wire:model="gi_rfcApplicant" placeholder="" />
                <flux:input label="CURP" type="text" wire:model="gi_curpApplicant" placeholder="" />
            </div>
            {{-- Fila 2 --}}
            <div class="form-grid form-grid--3">
                <flux:input label="Nombre" type="text" wire:model="gi_name" placeholder="" />
                <flux:input label="Apellido Paterno" type="text" wire:model="gi_firtsNameApplicant"
                    placeholder="" />
                <flux:input label="Apellido Materno" type="text" wire:model="gi_secondNameApplicant"
                    placeholder="" />
            </div>
            {{-- Fila 3 --}}
            <div class="form-grid form-grid--3">
                <flux:input label="Número de seguridad social" type="text" wire:model="gi_NssApplicant"
                    placeholder="" />
            </div>

            <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                <h2 class="border-b-2 border-gray-300">Dirección del solicitante</h2>
            </div>
            {{-- Fila 5 --}}
            <div class="form-grid form-grid--3">
                <flux:checkbox.group wire:model="gi_copyDirToApplicant" label="Copiar direccion del inmueble">
                    <flux:checkbox value="push" />
                </flux:checkbox.group>
            </div>

            {{-- Fila 6 --}}
            <div class="form-grid form-grid--3">
                <flux:input label="Código postal" type="text" wire:model="gi_cpApplicant" placeholder="" />
                <flux:input label="Entidad" type="text" wire:model="gi_entityApplicant" placeholder="" />
                <flux:input label="Alcaldia/Municipio" type="text" wire:model="gi_localityApplicant"
                    placeholder="" />
            </div>
            {{-- Fila 7 --}}
            <div class="form-grid form-grid--3">
                <flux:input label="Colonia" type="text" wire:model="gi_colonyApplicant" placeholder="" />
                <flux:input label="Calle" type="text" wire:model="gi_streetApplicant" placeholder="" />
                <flux:input label="Número exterior" type="text" wire:model="gi_streetAbroadApplicant"
                    placeholder="" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Número interior" type="text" wire:model="gi_streetInsideApplicant"
                    placeholder="" />
                <flux:input label="Telefóno" type="text" wire:model="gi_phoneApplicant" placeholder="" />
            </div>

        </div>
    </div>

    <div class="form-container">
        <div class="form-container__header">
            Datos del inmueble
        </div>
        <div class="form-container__content">

            <div class="form-grid form-grid--3">
                <flux:checkbox.group wire:model="gi_copyDirToProperty" label="Copiar direccion del propietario">
                    <flux:checkbox value="push" />
                </flux:checkbox.group>
            </div>


            <div class="form-grid form-grid--3">
                <flux:input label="Código postal" type="text" wire:model="gi_cpProperty" placeholder="" />
                <flux:input label="Entidad" type="text" wire:model="gi_entityProperty" placeholder="" />
                <flux:input label="Alcaldia/Municipio" type="text" wire:model="gi_localityProperty"
                    placeholder="" />
            </div>
            {{-- Fila 7 --}}
            <div class="form-grid form-grid--3">
                <flux:input label="Ciudad" type="text" wire:model="gi_municipalityProperty" placeholder="" />
                <flux:input label="Colonia" type="text" wire:model="gi_colonyProperty" placeholder="" />
                <flux:input label="Calle" type="text" wire:model="gi_streetProperty" placeholder="" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Número exterior" type="text" wire:model="gi_streetAbroadtProperty"
                    placeholder="" />
                <flux:input label="Número interior" type="text" wire:model="gi_streetInsidetProperty"
                    placeholder="" />
                <flux:input label="Manzana" type="text" wire:model="gi_blockProperty" placeholder="" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Super manzana" type="text" wire:model="gi_superBlockProperty"
                    placeholder="" />
                <flux:input label="Lote" type="text" wire:model="gi_lotProperty" placeholder="" />
                <flux:input label="Edificio" type="text" wire:model="gi_buildingProperty" placeholder="" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Departamento" type="text" wire:model="gi_departamentProperty"
                    placeholder="" />
                <flux:input label="Entrada" type="text" wire:model="gi_accessProperty" placeholder="" />
                <flux:input label="Nivel" type="text" wire:model="gi_levelProperty" placeholder="" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Condominio" type="text" wire:model="gi_condominiumProperty" placeholder="" />
                <flux:input label="Entre calle" type="text" wire:model="gi_streetBetweenProperty"
                    placeholder="" />
                <flux:input label="Y calle" type="text" wire:model="gi_andStreetProperty" placeholder="" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Condominio" type="text" wire:model="gi_housingComplexProperty"
                    placeholder="" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Número de cuenta predial" type="text" wire:model="gi_taxProperty"
                    placeholder="" />
                <flux:input label="Cuenta de agua" type="text" wire:model="gi_waterAccountProperty"
                    placeholder="" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Tipo de inmueble" type="text" wire:model="gi_typeProperty" placeholder="" />
                <flux:input label="Uso de suelo" type="text" wire:model="gi_landUseProperty" placeholder="" />
                <flux:input label="Tipo de vivienda" type="text" wire:model="gi_typeHousingProperty"
                    placeholder="" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Constructor (vivienda nueva)" type="text" wire:model="gi_constructorProperty"
                    placeholder="" />
                <flux:input label="RFC constructor (vivienda nueva)" type="text"
                    wire:model="gi_rfcConstructorProperty" placeholder="" />
            </div>

            <div class="form-grid form-grid--3">
                <flux:input label="Información adicional" type="text" wire:model="gi_aditionalDataProperty"
                    placeholder="" />
            </div>
        </div>
    </div>


    <div class="form-container">
        <div class="form-container__header">
            Datos importantes
        </div>
        <div class="form-container__content">


            <div class="form-grid form-grid--1">
                <flux:input label="Proposito del avalúo" type="text" wire:model="gi_purpose"
                    placeholder="Escribe aquí" />
            </div>

            <div class="form-grid form-grid--1">
                <flux:input label="Objetivo del avalúo" type="text" wire:model="gi_objetive"
                    placeholder="Escribe aquí" />
            </div>

            <div class="form-grid form-grid--1">
                <flux:input label="Régimen de propiedad" type="text" wire:model="gi_ownershipRegime"
                    placeholder="Escribe aquí" />
            </div>


        </div>
    </div>

    <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos</flux:button>

</div>




































{{--
    Ejemplo 1 columna
    <div class="form-container">
        <div class="form-container__header">
            Ejemplo 1: Una columna (fila a fila)
        </div>
        <div class="form-container__content">


            <div class="form-grid form-grid--1">
                <flux:input id="field1" label="Campo A" type="text" wire:model="fieldA" placeholder="Escribe aquí" />
            </div>


            <div class="form-grid form-grid--1">
                <flux:input id="field2" label="Campo B" type="email" wire:model="fieldB"
                    placeholder="correo@ejemplo.com" />
            </div>

        </div>
    </div>



    Ejemplo 2 dos columnas
    <div class="form-container">
        <div class="form-container__header">
            Ejemplo 2: Dos columnas (filas flexibles)
        </div>
        <div class="form-container__content">


            <div class="form-grid form-grid--2">
                <flux:input id="field3" label="Nombre(s)" type="text" wire:model="firstName"
                    placeholder="Tu nombre" />
                <flux:input id="field4" label="Apellidos" type="text" wire:model="lastName"
                    placeholder="Tus apellidos" />
            </div>


            <div class="form-grid form-grid--2">
                <flux:input id="field5" label="Correo Electrónico" type="email" wire:model="email"
                    placeholder="tu@correo.com" />
            </div>


            <div class="form-grid form-grid--2">
                <flux:input id="field6" label="Teléfono" type="tel" wire:model="phone"
                    placeholder="Ej. 477 123 4567" />

            </div>

        </div>
    </div>





    Ejemplo 3 tres columnas
    <div class="form-container">
        <div class="form-container__header">
            Ejemplo 3: Tres columnas (una sola fila)
        </div>
        <div class="form-container__content">

            <div class="form-grid form-grid--3">
                <flux:input id="field7" label="Ciudad" type="text" wire:model="city" placeholder="León" />
                <flux:input id="field8" label="Estado" type="text" wire:model="state" placeholder="Guanajuato" />
                <flux:input id="field9" label="Código Postal" type="text" wire:model="zipcode"
                    placeholder="37000" />
            </div>

        </div>
    </div>





 --}}
