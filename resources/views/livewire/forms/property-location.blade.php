{{-- Componente AlpineJS que gestiona los mapas --}}
<div x-data="mapManager()" x-init="init()" {{-- Evento personalizado que se lanza desde Livewire para actualizar mapas
    --}} @locationUpdated.window="initMaps($event.detail[0].lat, $event.detail[0].lon)">

    {{-- Estilos y hoja de Leaflet --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .map-container {
            height: 350px;
            border-radius: 12px;
            z-index: 1;
        }
    </style>

    {{-- Formulario Livewire --}}
    <form wire:submit='save'>
        <div class="form-container">
            <div class="form-container__header">Localización del inmueble</div>
            <div class="form-container__content">

                {{-- Campos para coordenadas geográficas --}}
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <flux:field>
                        <flux:label>Latitud</flux:label>
                        <flux:input type="text" inputmode="decimal" wire:model.defer='latitud' />
                        <div class="error-container">
                            <flux:error name="latitud" />
                        </div>
                    </flux:field>
                    <flux:field>
                        <flux:label>Longitud</flux:label>
                        <flux:input type="text" inputmode="decimal" wire:model.defer='longitud' />
                        <div class="error-container">
                            <flux:error name="longitud" />
                        </div>
                    </flux:field>
                    <flux:field>
                        <flux:label>Altitud</flux:label>
                        <flux:input type="text" inputmode="decimal" wire:model.defer='altitud' />
                        <div class="error-container">
                            <flux:error name="altitud" />
                        </div>
                    </flux:field>
                </div>

                {{-- Títulos para cada mapa --}}
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Croquis macro localización</h2>
                    <h2 class="border-b-2 border-gray-300">Croquis micro localización</h2>
                    <h2 class="border-b-2 border-gray-300">Polígono del inmueble</h2>
                </div>

                {{-- Contenedores de mapa con wire:ignore para que Livewire no los destruya --}}
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <div x-ref="mapMacro" class="map-container" wire:ignore></div>
                    <div x-ref="mapMicro" class="map-container" wire:ignore></div>
                    <div x-ref="mapPolygon" class="map-container" wire:ignore></div>
                </div>

                {{-- Botón que dispara el método "locate" en Livewire --}}
                <flux:button type="button" wire:click.prevent="locate" class="mt-4 cursor-pointer btn-intermediary"
                    variant="primary">
                    Localizar inmueble en mapa
                </flux:button>
            </div>
        </div>

        {{-- Segundo bloque del formulario con botón de guardar --}}
        <div class="form-container">
            <div class="form-container__header">Localización geográfica del inmueble</div>
            <div class="form-container__content">
                <flux:button class="mt-4 cursor-pointer btn-primary" variant="primary" type="submit">
                    Guardar datos
                </flux:button>
            </div>
        </div>
    </form>

    {{-- Script de Leaflet --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

    {{-- Componente AlpineJS para gestionar mapas --}}
    <script>
        function mapManager() {
            return {
                // Objeto donde se guardan las instancias de los mapas y sus marcadores
                maps: {
                    macro: { map: null, marker: null },
                    micro: { map: null, marker: null },
                    polygon: { map: null, marker: null }
                },

                // Función que crea o actualiza cada mapa
                initMaps(lat, lon) {
                    // Si no se pasan coordenadas, se usan las del componente Livewire
                    if (lat === undefined || lon === undefined) {
                        lat = @js($this->latitud);
                        lon = @js($this->longitud);
                    }

                    const tileLayerUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                    const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

                    // Esta función inicializa o actualiza un mapa específico
                    const createOrUpdateMap = (ref, mapObj, zoom) => {
                        if (!mapObj.map) {
                            // Si el mapa no existe, se crea
                            const map = L.map(ref).setView([lat, lon], zoom);
                            L.tileLayer(tileLayerUrl, { attribution }).addTo(map);
                            const marker = L.marker([lat, lon]).addTo(map);
                            mapObj.map = map;
                            mapObj.marker = marker;
                        } else {
                            // Si ya existe, se actualiza la vista y el marcador
                            mapObj.map.setView([lat, lon], zoom);
                            mapObj.marker.setLatLng([lat, lon]);
                        }
                    };

                    // Se actualizan los 3 mapas
                    createOrUpdateMap(this.$refs.mapMacro, this.maps.macro, 5);
                    createOrUpdateMap(this.$refs.mapMicro, this.maps.micro, 14);
                    createOrUpdateMap(this.$refs.mapPolygon, this.maps.polygon, 18);
                },

                // Inicializa los mapas al cargar el componente
                init() {
                    setTimeout(() => this.initMaps(), 0);
                }
            }
        }
    </script>
</div>
