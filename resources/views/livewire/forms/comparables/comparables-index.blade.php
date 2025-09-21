<div>
    <div class="flex justify-between">
        <p>
            @if ($valuation)
            Folio de valuación: <strong>{{ $valuation->folio }}</strong>

            @else
        <p>no se encontró folio</p>
        @endif

        </p>
        <a wire:click="backForms"
            wire:confirm="¿Estás seguro de que deseas salir? Se borrarán los datos de la sesión actual."
            class="cursor-pointer btn-deleted">
            Regresar a enfoque de mercado
        </a>
    </div>
    <br>

    <flux:separator />
    <div class="pt-4">
        <flux:button variant="primary" class="cursor-pointer btn-primary" wire:click='openAddComparable'>Agregar
            comparable</flux:button>
    </div>
    <div class="form-container">
        <div class="form-container__header">
            Filtros de búsqueda
        </div>
        <div class="form-container__content">
            <div class="form-grid form-grid--2">

            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="form-container__header">
            Comparables disponibles
        </div>
        <div class="form-container__content">
            <div class="form-grid form-grid--2">

            </div>
        </div>
    </div>

    <div class="form-container">
        <div class="form-container__header">
            Comparables asignados
        </div>
        <div class="form-container__content">
            <div class="form-grid form-grid--2">

            </div>
        </div>
    </div>


















    {{-- MODAL PARA AGREGAR UN NUEVO COMPARABLE --}}
    <flux:modal name="add-comparable" class="md:w-110">
        <div class="space-y-2">
            <div>
                <flux:heading size="lg"><b>Nuevo comparable</b></flux:heading>
                <flux:text class="mt-2">Indique los valores solicitados</flux:text>
            </div>
            <flux:separator />





            {{-- Datos de asignación --}}
            <div class="form-grid form-grid--1 mt-[20px]">
                <h2>Datos de asignación:</h2>
            </div>

            <flux:field class="flux-field">
                <flux:label>Clave</flux:label>
                <flux:input type="text" wire:model='comparableKey' readonly />
                <div class="error-container">
                    <flux:error name="comparableKey" />
                </div>
            </flux:field>

            <flux:field class="flux-field">
                <flux:label>Folio:<span class="sup-required">*</span></flux:label>
                <flux:input type="text" wire:model='comparableFolio' readonly />
                <small>Servicio para el cual se captura el mercado</small>
                <div class="error-container">
                    <flux:error name="comparableFolio" />
                </div>
            </flux:field>

            <flux:field class="flux-field">
                <flux:label>Dado de alta por:<span class="sup-required">*</span></flux:label>
                <flux:input type="text" wire:model='comparableDischargedBy' readonly />
                <div class="error-container">
                    <flux:error name="comparableDischargedBy" />
                </div>
            </flux:field>






            {{-- Datos de inmueble --}}
            <div class="form-grid form-grid--1 mt-[20px]">
                <h2>Datos del inmueble:</h2>
            </div>

            <flux:field class="flux-field">
                <label for="tipo" class="flux-label text-sm">Tipo de inmueble<span class="sup-required">*</span></label>
                <flux:select wire:model="Comparableproperty" class="text-gray-800 [&_option]:text-gray-900">
                    <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                    <flux:select.option value="terreno">Terreno</flux:select.option>
                    <flux:select.option value="terrenoCondominio">terrenoCondominio</flux:select.option>
                </flux:select>
                <div class="error-container">
                    <flux:error name="Comparableproperty" />
                </div>
            </flux:field>

            <flux:field class="flux-field">
                <flux:label>Código postal<span class="sup-required">*</span></flux:label>
                <flux:input.group>
                    <flux:input type="text" wire:model='comparableCp' />
                    <flux:button wire:click='buscarCP' icon="magnifying-glass" class="cursor-pointer">
                    </flux:button>
                </flux:input.group>
                <div class="error-container">
                    <flux:error name="comparableCp" />
                </div>
            </flux:field>

            <flux:field class="flux-field">
                <flux:label>Entidad</flux:label>
                <flux:select wire:model.live="comparableEntity" class="text-gray-800 [&_option]:text-gray-900">
                    <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                    @foreach($states as $id => $state)
                    <flux:select.option value="{{ $id }}">{{ $state }}</flux:select.option>
                    @endforeach
                </flux:select>
                <div class="error-container">
                    <flux:error name="comparableEntity" />
                </div>
            </flux:field>

            <flux:field class="flux-field">
                <flux:label>Alcaldia/municipio</flux:label>
                <flux:select wire:model.live="comparableLocality" class="text-gray-800 [&_option]:text-gray-900"
                    :disabled="empty($municipalities)">
                    <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                    @foreach($municipalities as $id => $nombre)
                    <option value="{{ $id }}" {{ $id===$comparableLocality ? 'selected' : '' }}>
                        {{ $nombre }}
                    </option>
                    @endforeach
                </flux:select>
                <div class="error-container">
                    <flux:error name="comparableLocality" />
                </div>
            </flux:field>

            <div class="flux-field">
                <flux:field class="flux-field">
                    <flux:label>Colonia<span class="sup-required">*</span></flux:label>
                    <flux:select wire:model.live="comparableColony" class="text-gray-800 [&_option]:text-gray-900"
                        :disabled="empty($colonies)">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        @foreach($colonies as $colony)
                        <option value="{{ $colony }}" {{ $colony===$comparableColony ? 'selected' : '' }}>
                            {{ $colony }}
                        </option>
                        @endforeach
                        <flux:select.option value="no-listada">Colonia no listada</flux:select.option>
                    </flux:select>
                    <div class="error-container">
                        <flux:error name="comparableColony" />
                    </div>
                </flux:field>

                @if ($comparableColony === 'no-listada')
                <flux:field class="flux-field">
                    <flux:label>Otra Colonia<span class="sup-required">*</span></flux:label>
                    <flux:input type="text" wire:model='comparableOtherColony' />
                    <div class="error-container">
                        <flux:error name="comparableOtherColony" />
                    </div>
                </flux:field>
                @endif

                <flux:field class="flux-field">
                    <flux:label>Calle<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableStreet' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableStreet" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Número exterior<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableAbroadNumber' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableAbroadNumber" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Número interior</flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableInsideNumber' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableInsideNumber" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Entre calle<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableBetweenStreet' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableBetweenStreet" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Y la calle<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableAndStreet' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableAndStreet" />
                    </div>
                </flux:field>






                {{-- Localización en mapa --}}
                <div class="form-grid form-grid--1 mt-3 mb-2 text-md">
                    <h2><span class="border-b-2 border-gray-300">Localización en mapa</span></h2>
                </div>
                <p>Hay vamos xD</p>






                {{-- Datos del informante --}}
                <div class="form-grid form-grid--1 mt-3 mb-2 text-md">
                    <h2><span class="border-b-2 border-gray-300">Datos del informante</span></h2>
                </div>
                <flux:field class="flux-field">
                    <flux:label>Nombre<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableName' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableName" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Apellidos<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableLastName' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableLastName" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Teléfono<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparablePhone' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparablePhone" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Fuente de información web<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableUrl' />
                        <flux:button wire:click='' icon="scissors" class="cursor-pointer">
                        </flux:button>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableUrl" />
                    </div>
                </flux:field>








                {{-- Datos generales --}}
                <div class="form-grid form-grid--1 mt-3 mb-2 text-md">
                    <h2><span class="border-b-2 border-gray-300">Datos generales</span></h2>
                </div>

                <flux:field class="flux-field">
                    <flux:label>Uso de suelo<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparablelandUse' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparablelandUse" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Area libre requerido<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparablefreeAreaRequired' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparablefreeAreaRequired" />
                    </div>
                </flux:field>


                <flux:field class="flux-field">
                    <flux:label>Niveles permitidos<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableAllowedLevels' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableAllowedLevels" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Servicios / infraestructura<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:select wire:model.live="comparableColony" class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="completes">Completos</flux:select.option>
                            <flux:select.option value="incompletes">Incompletos</flux:select.option>
                        </flux:select>
                        {{--
                        <flux:input type="text" wire:model='comparableServicesInfraestructure' /> --}}
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableServicesInfraestructure" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Descripción servicios / infraestructura<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableDescServicesInfraestructure' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDescServicesInfraestructure" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Forma<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableShape' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableShape" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>% De pendiente<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableSlope' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableSlope" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Densidad<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableDensity' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDensity" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Frente(ML):<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableFront' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDensity" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Frente tipo</flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableFrontType' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDensity" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Descripción forma</flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableDescriptionForm' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDescriptionForm" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Topografía<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        {{--
                        <flux:input type="text" wire:model='comparableTopography' /> --}}
                        <flux:select wire:model.live="comparableTopography"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="plana">Plana</flux:select.option>
                            <flux:select.option value="PendienteAscendente">Pendiente ascendente</flux:select.option>
                            <flux:select.option value="Pendiente">Pendiente</flux:select.option>
                            <flux:select.option value="Descendente">Descendente</flux:select.option>
                            <flux:select.option value="Accidentada">Accidentada</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableTopography" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Características<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableCharacteristics' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDescriptionForm" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Características generales</flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableCharacteristicsGeneral' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableDescriptionForm" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Oferta<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableOffers' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableOffers" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Superficie del terreno<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableLandArea' />
                        <flux:button type="button" disabled>M2
                        </flux:button>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableLandArea" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Superficie construida<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableBuiltArea' />
                        <flux:button type="button" disabled>M2
                        </flux:button>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableBuiltArea" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Valor unitario<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableUnitValue' />
                        <flux:button type="button" disabled>M2
                        </flux:button>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableUnitValue" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Factor de negociación<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableBargainingFactor' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableBargainingFactor" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Ubicación en la manzana<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        {{--
                        <flux:input type="text" wire:model='comparableLocationBlock' /> --}}
                        <flux:select wire:model.live="comparableLocationBlock"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="plana">Interior</flux:select.option>
                            <flux:select.option value="twoFront">Dos frentes no continuos</flux:select.option>
                            <flux:select.option value="tresFrentes">Tres frentes</flux:select.option>
                            <flux:select.option value="unFrente">Un frente</flux:select.option>
                            <flux:select.option value="Esquina">Esquina</flux:select.option>
                            <flux:select.option value="Manzana">Manzana</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableLocationBlock" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Ubicación en la calle<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        {{--
                        <flux:input type="text" wire:model='comparableStreetLocation' /> --}}
                        <flux:select wire:model.live="comparableStreetLocation"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Superior a moda">Superior a moda</flux:select.option>
                            <flux:select.option value="Calle moda">Calle moda</flux:select.option>
                            <flux:select.option value="Inferior a moda">Inferior a moda</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableStreetLocation" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Clase general de los inmuebles en la zona<span class="sup-required">*</span>
                    </flux:label>
                    <flux:input.group>
                        {{--
                        <flux:input type="text" wire:model='comparableGeneralPropArea' /> --}}
                        <flux:select wire:model.live="comparableGeneralPropArea"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Superior a moda">Mínima</flux:select.option>
                            <flux:select.option value="Economica">Económica</flux:select.option>
                            <flux:select.option value="Interes social">Interés social</flux:select.option>
                            <flux:select.option value="Media">Media</flux:select.option>
                            <flux:select.option value="Semilujo">Semilujo</flux:select.option>
                            <flux:select.option value="Residencial">Residencial</flux:select.option>
                            <flux:select.option value="Residencial plus">Residencial plus</flux:select.option>
                            <flux:select.option value="Residencial plus +">Residencial plus +</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableGeneralPropArea" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Clase general de los inmuebles en la zona<span class="sup-required">*</span>
                    </flux:label>
                    <flux:input.group>
                        {{--
                        <flux:input type="text" wire:model='comparableGeneralProperties' /> --}}
                        <flux:select wire:model.live="comparableGeneralProperties"
                            class="text-gray-800 [&_option]:text-gray-900">
                            <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                            <flux:select.option value="Centrica">Céntrica</flux:select.option>
                            <flux:select.option value="Intermedia">Intermedia</flux:select.option>
                            <flux:select.option value="Periferica">Periférica</flux:select.option>
                            <flux:select.option value="De expansion">De expansión</flux:select.option>
                            <flux:select.option value="Rural">Rural</flux:select.option>
                        </flux:select>
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableGeneralProperties" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Referencia de proximidad urbana<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="number" wire:model='comparableUrbanProximityReference' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableUrbanProximityReference" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Número de frentes<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableNumberFronts' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableNumberFronts" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Fuente de información imágenes<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparableSourceInfImages' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableSourceInfImages" />
                    </div>
                </flux:field>

                <flux:field class="flux-field">
                    <flux:label>Fotos<span class="sup-required">*</span></flux:label>
                    <flux:input.group>
                        <flux:input type="text" wire:model='comparablePhotos' />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparablePhotos" />
                    </div>
                </flux:field>


                <flux:field class="flux-field">
                    <flux:label>Activo</flux:label>
                    <flux:input.group>
                        {{-- <flux:input type="text" wire:model='comparableActive' /> --}}
                        <flux:checkbox wire:model="comparableActive" />
                    </flux:input.group>
                    <div class="error-container">
                        <flux:error name="comparableActive" />
                    </div>
                </flux:field>





                <div class="flex">
                    <flux:spacer />
                    <flux:button class="btn-primary btn-table cursor-pointer" type="button" variant="primary"
                        wire:click='save'>Crear comparable</flux:button>
                </div>
            </div>
    </flux:modal>


</div>
