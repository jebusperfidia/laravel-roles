<div>


    <div class="flex justify-end font-semibold text-sm text-red-600 pt-2 -mb-3"><span>* Campos obligatorios</span></div>
    {{-- PRIMER CONTENEDOR --}}
    <form wire:submit='saveAll'>
        <div class="form-container">
            <div class="form-container__header">
                Configuración y fecha del avalúo
            </div>
            <div class="form-container__content">
                <div class="form-grid form-grid--2">
                    <flux:field class="flux-field">
                        <flux:label>Folio</flux:label>
                        <flux:input type="text" wire:model='gi_folio' />
                        <div class="error-container">
                            <flux:error name="gi_folio" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Fecha de creación<span class="sup-required">*</span></flux:label>
                        <flux:input type="date" wire:model='gi_date' />
                        <div class="error-container">
                            <flux:error name="gi_date" />
                        </div>
                    </flux:field>
                </div>
                <div class="form-grid form-grid--2">
                    <flux:field class="flux-field">
                        <flux:label>Tipo de avalúo</flux:label>
                        <flux:select wire:model="gi_type" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="fiscal">Físcal</flux:select.option>
                            <flux:select.option value="comercial">Comercial</flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_type" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Tipo de cálculo</flux:label>
                        <flux:select wire:model="gi_calculationType" class=" text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="calculation_active">Cálculos activados</flux:select.option>
                            <flux:select.option value="calculation_false">Este avalúo no realiza cálculos
                            </flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_calculationType" />
                        </div>
                    </flux:field>
                </div>
                <div class="form-grid form-grid--2">
                    <flux:field class="flux-field">
                        <flux:label>Valuador<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model="gi_valuator">
                            @foreach ($users as $user)
                            <flux:select.option value="{{ $user->id }}">
                                {{ $user->name }}
                            </flux:select.option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_valuator" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Es un pre-avalúo</flux:label>
                        <flux:checkbox wire:model.live="gi_preValuation" />
                    </flux:field>
                </div>
            </div>
        </div>
















        {{-- SEGUNDO CONTENEDOR CONTENEDOR --}}
        @if (!$gi_preValuation)
        <div class="form-container">
            <div class="form-container__header">
                Datos del propietario
            </div>
            <div class="form-container__content">
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Tipo de persona<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_ownerTypePerson"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Fisica">Fisica</flux:select.option>
                            <flux:select.option value="Moral">Moral</flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_ownerTypePerson" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>RFC</flux:label>
                        <flux:input type="text" wire:model='gi_ownerRfc' />
                        <div class="error-container">
                            <flux:error name="gi_ownerRfc" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>CURP</flux:label>
                        <flux:input type="text" wire:model='gi_ownerCurp' />
                        <div class="error-container">
                            <flux:error name="gi_ownerCurp" />
                        </div>
                    </flux:field>
                </div>
                {{-- Esta fila renderiza condicionalmente la fila 2 si el tipo de persona es moral y añade otra fila
                --}}
                @unless ($gi_ownerTypePerson === 'Moral')
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Nombre<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_ownerName' />
                        <div class="error-container">
                            <flux:error name="gi_ownerName" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Apellido Paterno<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_ownerFirstName' />
                        <div class="error-container">
                            <flux:error name="gi_ownerFirstName" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Apellido Materno<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_ownerSecondName' />
                        <div class="error-container">
                            <flux:error name="gi_ownerSecondName" />
                        </div>
                    </flux:field>
                </div>
                @endunless
                @if ($gi_ownerTypePerson === 'Moral')
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Nombre de la empresa<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_ownerCompanyName' />
                        <div class="error-container">
                            <flux:error name="gi_ownerCompanyName" />
                        </div>
                    </flux:field>
                </div>
                @endif

                <div class="form-grid form-grid--3 pt-4">
                    <flux:field class="flux-field">
                        <flux:label>Copiar dirección del inmueble</flux:label>
                        <flux:checkbox wire:model.live="gi_copyFromProperty" />
                    </flux:field>
                </div>
                <div class="form-grid form-grid--3 pt-4">
                    <flux:field class="flux-field">
                        <flux:label>Código postal<span class="sup-required">*</span></flux:label>
                        <flux:input.group>
                            <flux:input type="text" wire:model='gi_ownerCp' />
                            <flux:button wire:click='buscarCP1' icon="magnifying-glass" class="cursor-pointer">
                                {{-- <span wire:loading wire:target="buscarCP1">Cargando...</span>
                                <span wire:loading.remove wire:target="buscarCP1">Buscar</span> --}}
                            </flux:button>
                        </flux:input.group>
                        <div class="error-container">
                            <flux:error name="gi_ownerCp" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Entidad<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_ownerEntity" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            @foreach($states as $id => $state)
                            <flux:select.option value="{{ $id }}">{{ $state }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_ownerEntity" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Alcaldia/municipio<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_ownerLocality" class="text-gray-800 [&_option]:text-gray-900" :disabled="empty($municipalities)">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            @foreach($municipalities as $id => $nombre)
                            <option value="{{ $id }}" {{ $id===$gi_ownerLocality ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_ownerLocality" />
                        </div>
                    </flux:field>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Colonia<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_ownerColony" class="text-gray-800 [&_option]:text-gray-900"
                            :disabled="empty($colonies)">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                           {{--  @foreach($colonies as $colony)
                            <option value="{{ $colony }}">{{ $colony }}</option>
                            @endforeach --}}
                            @foreach($colonies as $colony)
                            <option value="{{ $colony }}" {{ $colony===$gi_ownerColony ? 'selected' : '' }}>
                                {{ $colony }}
                            </option>
                            @endforeach
                        <flux:select.option value="no-listada">Colonia no listada</flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_ownerColony" />
                        </div>
                    </flux:field>
                    @if ($gi_ownerColony === 'no-listada')
                    <flux:field class="flux-field">
                        <flux:label>Otra Colonia<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_ownerOtherColony' />
                    <div class="error-container">
                        <flux:error name="gi_ownerOtherColony" />
                    </div>
                    </flux:field>
                    @endif
                    <flux:field class="flux-field">
                        <flux:label>Calle<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_ownerStreet' />
                        <div class="error-container">
                            <flux:error name="gi_ownerStreet" />
                        </div>
                    </flux:field>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Número exterior<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_ownerAbroadNumber' />
                        <div class="error-container">
                            <flux:error name="gi_ownerAbroadNumber" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Número interior</flux:label>
                        <flux:input type="text" wire:model='gi_ownerInsideNumber' />
                        <div class="error-container">
                            <flux:error name="gi_ownerInsideNumber" />
                        </div>
                    </flux:field>
                </div>
            </div>
        </div>

















        {{-- TERCER CONTENEDOR --}}
        <div class="form-container">
            <div class="form-container__header">
                Datos del solicitante
            </div>
            <div class="form-container__content">
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Tipo de persona<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_applicTypePerson"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Fisica">Fisica</flux:select.option>
                            <flux:select.option value="Moral">Moral</flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_applicTypePerson" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>RFC</flux:label>
                        <flux:input type="text" wire:model='gi_applicRfc' />
                        <div class="error-container">
                            <flux:error name="gi_applicRfc" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>CURP</flux:label>
                        <flux:input type="text" wire:model='gi_applicCurp' />
                        <div class="error-container">
                            <flux:error name="gi_applicCurp" />
                        </div>
                    </flux:field>
                </div>
                {{-- Fila 2 --}}
                @unless ($gi_applicTypePerson === 'Moral')
                <div class="form-grid form-grid--3">

                    <flux:field class="flux-field">
                        <flux:label>Nombre<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_applicName' />
                        <div class="error-container">
                            <flux:error name="gi_applicName" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Apellido Paterno<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_applicFirstName' />
                        <div class="error-container">
                            <flux:error name="gi_applicFirstName" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Apellido Materno<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_applicSecondName' />
                        <div class="error-container">
                            <flux:error name="gi_applicSecondName" />
                        </div>
                    </flux:field>
                </div>
                @endunless
                @if ($gi_applicTypePerson === 'Moral')
                <div class="form-grid form-grid--3">

                    <flux:field class="flux-field">
                        <flux:label>Nombre de la empresa<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_applicCompanyName' />
                        <div class="error-container">
                            <flux:error name="gi_applicCompanyName" />
                        </div>
                    </flux:field>
                </div>
                @endif
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Número de seguridad social<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_applicNss' />
                        <div class="error-container">
                            <flux:error name="gi_applicNss" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Dirección del solicitante</h2>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Copiar dirección del inmueble</flux:label>
                        <flux:checkbox wire:model.live="gi_copyFromProperty2" />
                    </flux:field>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Código postal<span class="sup-required">*</span></flux:label>
                        <flux:input.group>
                            <flux:input type="text" wire:model='gi_applicCp' />
                            <flux:button wire:click='buscarCP2' icon="magnifying-glass" class="cursor-pointer">
                            </flux:button>
                        </flux:input.group>
                        <div class="error-container">
                            <flux:error name="gi_applicCp" />
                        </div>
                    </flux:field>
                  <flux:field class="flux-field">
                    <flux:label>Entidad<span class="sup-required">*</span></flux:label>
                    <flux:select wire:model.live="gi_applicEntity" class="text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        @foreach($states2 as $id => $state)
                        <flux:select.option value="{{ $id }}">{{ $state }}</flux:select.option>
                        @endforeach
                    </flux:select>
                    <div class="error-container">
                        <flux:error name="gi_applicEntity" />
                    </div>
                </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Alcaldia/municipio<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_applicLocality" class="text-gray-800 [&_option]:text-gray-900" :disabled="empty($municipalities2)">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            @foreach($municipalities2 as $id => $nombre)
                            <option value="{{ $id }}" {{ $id===$gi_applicLocality ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_applicLocality" />
                        </div>
                    </flux:field>
                </div>
                <div class="form-grid form-grid--3">

                    <flux:field class="flux-field">
                        <flux:label>Colonia<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_applicColony" class="text-gray-800 [&_option]:text-gray-900"
                            :disabled="empty($colonies2)">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        {{--     @foreach($colonies2 as $colony)
                            <option value="{{ $colony }}">{{ $colony }}</option>
                            @endforeach --}}
                            @foreach($colonies2 as $colony)
                            <option value="{{ $colony }}" {{ $colony===$gi_applicColony ? 'selected' : '' }}>
                            {{ $colony }}
                            </option>
                            @endforeach
                            <flux:select.option value="no-listada">Colonia no listada</flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_applicColony" />
                        </div>
                    </flux:field>
                    @if ($gi_applicColony === 'no-listada')
                    <flux:field class="flux-field">
                        <flux:label>Otra colonia<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_applicOtherColony' />
                        <div class="error-container">
                            <flux:error name="gi_applicOtherColony" />
                        </div>
                    </flux:field>
                    @endif

                    <flux:field class="flux-field">
                        <flux:label>Calle<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_applicStreet' />
                        <div class="error-container">
                            <flux:error name="gi_applicStreet" />
                        </div>
                    </flux:field>

                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Número exterior<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_applicAbroadNumber' />
                        <div class="error-container">
                            <flux:error name="gi_applicAbroadNumber" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Número interior</flux:label>
                        <flux:input type="text" wire:model='gi_applicInsideNumber' />
                        <div class="error-container">
                            <flux:error name="gi_applicInsideNumber" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Teléfono</flux:label>
                        <flux:input type="text" wire:model='gi_applicPhone' />
                        <div class="error-container">
                            <flux:error name="gi_applicPhone" />
                        </div>
                    </flux:field>
                </div>
            </div>
        </div>
        @endif


















        {{-- CUARTO CONTENEDOR --}}
        <div class="form-container">
            <div class="form-container__header">
                Datos del inmueble
            </div>
            <div class="form-container__content">
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Copiar dirección del propietario</flux:label>
                        <flux:checkbox wire:model.live="gi_copyFromOwner" />
                    </flux:field>
                </div>
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <label for="tipo" class="flux-label text-sm">Código postal<span
                                class="sup-required">*</span></label>
                        <flux:input.group>
                            <flux:input type="text" wire:model='gi_propertyCp' />
                            <flux:button wire:click='buscarCP3' icon="magnifying-glass" class="cursor-pointer"></flux:button>
                        </flux:input.group>
                        <div class="error-container">
                            <flux:error name="gi_propertyCp" />
                        </div>
                    </flux:field>

                    <flux:field class="flux-field">
                        <flux:label>Entidad<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_propertyEntity" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="a">-- Selecciona una opción --</flux:select.option>
                            @foreach($states3 as $id => $state)
                            <flux:select.option value="{{ $id }}">{{ $state }}</flux:select.option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_propertyEntity" />
                        </div>
                    </flux:field>

                    <flux:field class="flux-field">
                        <flux:label>Alcaldia/municipio<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_propertyLocality"
                            class="text-gray-800 [&_option]:text-gray-900" :disabled="empty($municipalities3)" >
                            <flux:select.option value="a">-- Selecciona una opción --</flux:select.option>
                            @foreach($municipalities3 as $id => $nombre)
                            <option value="{{ $id }}" {{ $id===$gi_propertyLocality ? 'selected' : '' }}>
                                {{ $nombre }}
                            </option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_propertyLocality" />
                        </div>
                    </flux:field>
                </div>
                {{-- Fila 7 --}}
                <div class="form-grid form-grid--3">
                    {{-- <flux:field class="flux-field">
                        <flux:label>Ciudad<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_propertyCity" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_propertyCity" />
                        </div>
                    </flux:field> --}}
                    <flux:field class="flux-field">
                        <flux:label>Ciudad<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_propertyCity' />
                        <div class="error-container">
                            <flux:error name="gi_propertyCity" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Colonia<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_propertyColony" class="text-gray-800 [&_option]:text-gray-900"
                            :disabled="empty($colonies3)">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            {{-- @foreach($colonies3 as $colony)
                            <option value="{{ $colony }}">{{ $colony }}</option>
                            @endforeach --}}
                        @foreach($colonies3 as $colony)
                        <option value="{{ $colony }}" {{ $colony===$gi_propertyColony ? 'selected' : '' }}>
                            {{ $colony }}
                        </option>
                        @endforeach
                        <flux:select.option value="no-listada">Colonia no listada</flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_propertyColony" />
                        </div>
                    </flux:field>
                    @if ($gi_propertyColony === 'no-listada')
                    <flux:field class="flux-field">
                        <flux:label>Otra colonia<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_propertyOtherColony' />
                        <div class="error-container">
                            <flux:error name="gi_propertyOtherColony" />
                        </div>
                    </flux:field>
                    @endif
                </div>

                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Calle<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_propertyStreet' />
                        <div class="error-container">
                            <flux:error name="gi_propertyStreet" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Número exterior<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_propertyAbroadNumber' />
                        <div class="error-container">
                            <flux:error name="gi_propertyAbroadNumber" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Número interior</flux:label>
                        <flux:input type="text" wire:model='gi_propertyInsideNumber' />
                        <div class="error-container">
                            <flux:error name="gi_propertyInsideNumber" />
                        </div>
                    </flux:field>

                </div>

                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Manzana</flux:label>
                        <flux:input type="text" wire:model='gi_propertyBlock' />
                        <div class="error-container">
                            <flux:error name="gi_propertyBlock" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Super manzana</flux:label>
                        <flux:input type="text" wire:model='gi_propertySuperBlock' />
                        <div class="error-container">
                            <flux:error name="gi_propertySuperBlock" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Lote</flux:label>
                        <flux:input type="text" wire:model='gi_propertyLot' />
                        <div class="error-container">
                            <flux:error name="gi_propertyLot" />
                        </div>
                    </flux:field>

                </div>

                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Edificio</flux:label>
                        <flux:input type="text" wire:model='gi_propertyBuilding' />
                        <div class="error-container">
                            <flux:error name="gi_propertyBuilding" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Departamento</flux:label>
                        <flux:input type="text" wire:model='gi_propertyDepartament' />
                        <div class="error-container">
                            <flux:error name="gi_propertyDepartament" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Entrada</flux:label>
                        <flux:input type="text" wire:model='gi_propertyAccess' />
                        <div class="error-container">
                            <flux:error name="gi_propertyAccess" />
                        </div>
                    </flux:field>

                </div>

                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Nivel</flux:label>
                        <flux:select wire:model.live="gi_propertyLevel" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="a">-- Selecciona una opción --</flux:select.option>
                            @foreach ($levels_input as $value => $label)
                            <flux:select.option value="{{ $label }}">
                                {{ $label }}
                            </flux:select.option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_propertyLevel" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Condominio</flux:label>
                        <flux:input type="text" wire:model='gi_propertyCondominium' />
                        <div class="error-container">
                            <flux:error name="gi_propertyCondominium" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Entre calle</flux:label>
                        <flux:input type="text" wire:model='gi_propertyStreetBetween' />
                        <div class="error-container">
                            <flux:error name="gi_propertyStreetBetween" />
                        </div>
                    </flux:field>

                </div>

                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Y calle</flux:label>
                        <flux:input type="text" wire:model='gi_propertyAndStreet' />
                        <div class="error-container">
                            <flux:error name="gi_propertyAndStreet" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Nombre del conjuto habitacional</flux:label>
                        <flux:input type="text" wire:model='gi_propertyHousingComplex' />
                        <div class="error-container">
                            <flux:error name="gi_propertyHousingComplex" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Número de cuenta predial<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_propertyTax' />
                        <div class="error-container">
                            <flux:error name="gi_propertyTax" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Número de cuenta de agua<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_propertyWaterAccount' />
                        <div class="error-container">
                            <flux:error name="gi_propertyWaterAccount" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Tipo de inmueble<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_propertyType" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            @foreach ($propertiesTypes_input as $value => $label)
                            <flux:select.option value="{{ $label }}">
                                {{ $label }}
                            </flux:select.option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_propertyType" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Tipo de inmueble SIGAPRED<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_propertyTypeSigapred"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            @foreach ($propertiesTypesSigapred_input as $value => $label)
                            <flux:select.option value="{{ $label }}">
                                {{ $label }}
                            </flux:select.option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_propertyTypeSigapred" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Uso de suelo<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_propertyLandUse"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            @foreach ($landUse_input as $value => $label)
                            <flux:select.option value="{{ $label }}">
                                {{ $label }}
                            </flux:select.option>
                            @endforeach
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_propertyLandUse" />
                        </div>
                    </flux:field>
                </div>


                @if (stripos($gi_propertyType, 'terreno') === false)
                <div class="form-grid form-grid--3">
                    <flux:field class="flux-field">
                        <flux:label>Tipo de vivienda<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_propertyTypeHousing"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Nueva, sin escrituración previa">Nueva, sin escrituración
                                previa
                            </flux:select.option>
                            <flux:select.option value="Usada, previamente escriturada">Usada, previamente
                                escriturada
                            </flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_propertyTypeHousing" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>Constructor (vivienda nueva)<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_propertyConstructor' />
                        <div class="error-container">
                            <flux:error name="gi_propertyConstructor" />
                        </div>
                    </flux:field>
                    <flux:field class="flux-field">
                        <flux:label>RFC constructor (vivienda nueva)<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_propertyRfcConstructor' />
                        <div class="error-container">
                            <flux:error name="gi_propertyRfcConstructor" />
                        </div>
                    </flux:field>
                </div>
                @endif

                <div class="form-grid form-grid--1">
                    <flux:field class="flux-field">
                        <flux:label>Información adicional</flux:label>
                        <flux:input type="text" wire:model='gi_propertyAdditionalData' />
                        <flux:error name="gi_propertyAdditionalData" />
                    </flux:field>
                </div>

            </div>
        </div>



















        {{-- QUINTO CONTENEDOR --}}
        <div class="form-container">
            <div class="form-container__header">
                Datos importantes
            </div>
            <div class="form-container__content">
                <div class="form-grid form-grid--1">
                    <flux:field class="flux-field">
                        <flux:label>Propósito del avalúo<span class="sup-required">*</span></flux:label>
                        <flux:select wire:model.live="gi_purpose" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Conocer el valor castral del inmueble">Conocer el valor
                                castral
                                del inmueble</flux:select.option>
                            <flux:select.option value="Conocer el valor comercial del inmueble">Conocer el valor
                                comercial del inmueble</flux:select.option>
                            <flux:select.option value="Pago del impuesto sobre traslado de dominio">Pago del
                                impuesto
                                sobre traslado de dominio</flux:select.option>
                            <flux:select.option value="Otro">Otro</flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_purpose" />
                        </div>
                    </flux:field>
                </div>

                @if ($gi_purpose === 'Otro')
                <div class="form-grid form-grid--1">
                    <flux:field class="flux-field">
                        <flux:label>Indique otro<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_purposeOther'/>
                        <div class="error-container">
                            <flux:error name="gi_purposeOther" />
                        </div>
                    </flux:field>
                </div>
                @endif

               @if (stripos($gi_propertyType, 'condominio') !== false)

                <div class="form-grid form-grid--1">
                    <div class="error-container">
                        <flux:label>Propósito del avalúo para Sigapred<span class="sup-required">*</span>
                    </flux:label>
                    <flux:select wire:model="gi_purposeSigapred" class="text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option
                        value="Establecer la base gravable para el pago de impuesto sobre adquisición del inmueble (ISAI)">
                        Establecer la base gravable para el pago de impuesto sobre adquisición del inmueble
                        (ISAI)</flux:select.option>
                        <flux:select.option value="Establecer la base gravable para el pago del impuesto predial">
                            Establecer la base gravable para el pago del impuesto predial</flux:select.option>
                            <flux:select.option
                            value="Establecer la base gravable para el pago de derechos y construcciones inmobiliarias">
                            Establecer la base gravable para el pago de derechos y construcciones inmobiliarias
                        </flux:select.option>
                    </flux:select>
                    <div class="error-container">
                        <flux:error name="gi_purposeSigapred" />
                    </div>
                </div>
            </div>
            @endif

                <div class="form-grid form-grid--1">
                    <flux:field class="flux-field">
                        <flux:label>Objeto del avalúo<span class="sup-required">*</span></flux:label>
                        <flux:input type="text" wire:model='gi_objective' />
                        <div class="error-container">
                            <flux:error name="gi_objective" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--1">
                    <flux:field class="flux-field">
                        <label for="tipo" class="flux-label text-sm">Régimen de propiedad<span
                                class="sup-required">*</span></label>
                        <flux:select wire:model="gi_ownerShipRegime" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Privada particular">Privada particular</flux:select.option>
                            <flux:select.option value="Privada condominal">Privada condominal</flux:select.option>
                            <flux:select.option value="Privada copropiedad">Privada copropiedad</flux:select.option>
                            <flux:select.option value="Publica">Pública</flux:select.option>
                        </flux:select>
                        <div class="error-container">
                            <flux:error name="gi_ownerShipRegime" />
                        </div>
                    </flux:field>
                </div>
            </div>
        </div>

        <flux:button class="mt-4 cursor-pointer btn-primary" type="submit" variant="primary">Guardar datos
        </flux:button>
    </form>

</div>
