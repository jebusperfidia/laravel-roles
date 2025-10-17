{{-- **CAMBIO CLAVE:** Se renombra el evento a kebab-case para seguir convenciones --}}
<div x-data="mapManager()" x-init="init()"
    @location-updated.window="createOrUpdateMaps($event.detail[0].lat, $event.detail[0].lon)">

    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <style>
        .map-container {
            height: 350px;
            border-radius: 12px;
            z-index: 1;
        }
    </style>

    <form wire:submit='save'>
        <div class="form-container">
            <div class="form-container__header">Localización del inmueble</div>
            <div class="form-container__content">
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <flux:field>
                        <flux:label>Latitud</flux:label>
                        <flux:input type="text" inputmode="decimal" wire:model.defer='latitude' />
                        <div class="error-container">
                            <flux:error name="latitude" />
                        </div>
                    </flux:field>
                    <flux:field>
                        <flux:label>Longitud</flux:label>
                        <flux:input type="text" inputmode="decimal" wire:model.defer='longitude' />
                        <div class="error-container">
                            <flux:error name="longitude" />
                        </div>
                    </flux:field>
                    <flux:field>
                        <flux:label>Altitud</flux:label>
                        <flux:input type="text" inputmode="decimal" wire:model.defer='altitude' />
                        <div class="error-container">
                            <flux:error name="altitude" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Croquis macro localización</h2>
                    <h2 class="border-b-2 border-gray-300">Croquis micro localización</h2>
     {{--                <h2 class="border-b-2 border-gray-300">Polígono del inmueble</h2> --}}
                </div>

                {{-- **CAMBIO CLAVE:** `wire:ignore` le dice a Livewire que no toque estos divs, dejando que JS los
                controle --}}
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <div x-ref="mapMacro" class="map-container" wire:ignore></div>
                    <div x-ref="mapMicro" class="map-container" wire:ignore></div>
                    {{-- <div x-ref="mapPolygon" class="map-container" wire:ignore></div> --}}
                </div>

                <flux:button type="button" wire:click.prevent="locate" class="mt-4 cursor-pointer btn-intermediary"
                    variant="primary">
                    Localizar inmueble en mapa
                </flux:button>
            </div>
        </div>

        {{-- Resto de tu formulario --}}
        <div class="form-container">
            <div class="form-container__header">Localización geográfica del inmueble</div>
            <div class="form-container__content">
                <flux:button class="mt-4 cursor-pointer btn-primary" variant="primary" type="submit">
                    Guardar datos
                </flux:button>
            </div>
        </div>
    </form>

  {{--   <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}

    <script>
        function mapManager() {
        return {
            maps: {
                macro: { map: null, marker: null },
                micro: { map: null, marker: null },
                //polygon: { map: null, marker: null }
            },

            // Función que crea o actualiza los mapas
            createOrUpdateMaps(lat, lon) {
                const latitude = parseFloat(lat);
                const longitude = parseFloat(lon);

                if (isNaN(latitude) || isNaN(longitude)) {
                    console.error('Coordenadas inválidas. No se puede actualizar el mapa.');
                    return;
                }

                const tileLayerUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
                const attribution = '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors';

                // Función interna para configurar un mapa individual
                const setupMap = (ref, mapObj, zoom) => {
                    if (!mapObj.map) { // Si el mapa NO existe, lo creamos
                        const map = L.map(ref).setView([latitude, longitude], zoom);
                        L.tileLayer(tileLayerUrl, { attribution }).addTo(map);
                        mapObj.map = map;
                        mapObj.marker = L.marker([latitude, longitude]).addTo(map);
                    } else { // Si YA existe, solo actualizamos su centro y el marcador
                        mapObj.map.setView([latitude, longitude], zoom);
                        mapObj.marker.setLatLng([latitude, longitude]);
                    }
                };

                // Ejecutamos la configuración para cada mapa
                setupMap(this.$refs.mapMacro, this.maps.macro, 7);
                setupMap(this.$refs.mapMicro, this.maps.micro, 12);
                setupMap(this.$refs.mapPolygon, this.maps.polygon, 18);
            },

            // La función init se ejecuta al cargar el componente
            init() {
                // Obtenemos los valores iniciales del componente Livewire
                const initialLat = @this.get('latitude');
                const initialLon = @this.get('longitude');

                // Inicializamos los mapas con un pequeño retraso para asegurar que el DOM esté listo
                setTimeout(() => this.createOrUpdateMaps(initialLat, initialLon), 50);
            }
        }
    }
    </script>
</div>
