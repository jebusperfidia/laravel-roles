<div>
    {{-- AÑADIDO: Estilos CSS de Leaflet. Esencial para que el mapa se vea correctamente. --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <style>
        /* AÑADIDO: Asegura que los contenedores de los mapas tengan una altura definida */
        .map-container {
            height: 350px;
            border-radius: 12px;
            z-index: 1;
            /* Asegura que el mapa se muestre correctamente sobre otros elementos */
        }
    </style>

    <form wire:submit='save'>
        <div class="form-container">
            <div class="form-container__header">
                Localización del inmueble
            </div>
            <div class="form-container__content">

                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <flux:field>
                        <flux:label>Latitud</flux:label>
                        <flux:input type="number" wire:model.live.debounce.800ms='latitud' />
                        <div class="error-container">
                            <flux:error name="latitud" />
                        </div>
                    </flux:field>
                    <flux:field>
                        <flux:label>Longitud</flux:label>
                        <flux:input type="number" wire:model.live.debounce.800ms='longitud' />
                        <div class="error-container">
                            <flux:error name="longitud" />
                        </div>
                    </flux:field>
                    <flux:field>
                        <flux:label>Altitud</flux:label>
                        <flux:input type="number" wire:model.live.debounce.800ms='altitud' />
                        <div class="error-container">
                            <flux:error name="altitud" />
                        </div>
                    </flux:field>
                </div>

                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <h2 class="border-b-2 border-gray-300">Croquis macro localización</h2>
                    <h2 class="border-b-2 border-gray-300">Croquis micro localización</h2>
                    <h2 class="border-b-2 border-gray-300">Polígono del inmueble</h2>
                </div>

                {{-- MODIFICADO: Se reemplazan los h2 por divs que contendrán los mapas. --}}
                {{-- Cada div tiene un ID único para poder ser inicializado por JavaScript. --}}
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <div id="mapMacro" class="map-container"></div>
                    <div id="mapMicro" class="map-container"></div>
                    <div id="mapPolygon" class="map-container"></div>
                </div>
                <flux:button class="mt-4 cursor-pointer btn-intermediary" variant="primary">Localizar
                    inmueble en mapa</flux:button>
            </div>
        </div>

        <div class="form-container">
            <div class="form-container__header">
                Localización geográfica del inmueble
            </div>
            <div class="form-container__content">
                <flux:button class="mt-4 cursor-pointer btn-primary" variant="primary" type="submit">Guardar datos
                </flux:button>
            </div>
        </div>
    </form>

    {{-- AÑADIDO: Scripts de Leaflet y nuestro código personalizado para manejar los mapas. --}}
    {{-- Es importante que este script se cargue después del contenedor del mapa. --}}
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

    <script>
        // Envolvemos todo en un listener para asegurar que el DOM esté completamente cargado.
        document.addEventListener('livewire:init', () => {

            // Obtenemos las coordenadas iniciales desde el componente de Livewire.
            const initialLat = @js($latitud);
            const initialLon = @js($longitud);

            // Declaramos variables para los mapas y marcadores para que sean accesibles globalmente en este script.
            let mapMacro, mapMicro, mapPolygon;
            let markerMacro, markerMicro, markerPolygon;

            // Función para inicializar los mapas
            const initMaps = (lat, lon) => {
                // Mapa Macro (Zoom lejano)
                mapMacro = L.map('mapMacro').setView([lat, lon], 5);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(mapMacro);
                markerMacro = L.marker([lat, lon]).addTo(mapMacro);

                // Mapa Micro (Zoom intermedio)
                mapMicro = L.map('mapMicro').setView([lat, lon], 14);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(mapMicro);
                markerMicro = L.marker([lat, lon]).addTo(mapMicro);

                // Mapa Polígono (Zoom cercano)
                mapPolygon = L.map('mapPolygon').setView([lat, lon], 18);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
                }).addTo(mapPolygon);
                markerPolygon = L.marker([lat, lon]).addTo(mapPolygon);
            };

            // Función para actualizar la ubicación en los mapas
            const updateLocation = (lat, lon) => {
                // Validamos que sean números válidos
                if (isNaN(lat) || isNaN(lon)) return;

                const newLatLng = L.latLng(lat, lon);

                // Actualizamos la vista y la posición del marcador en cada mapa.
                mapMacro.setView(newLatLng, 5);
                markerMacro.setLatLng(newLatLng);

                mapMicro.setView(newLatLng, 14);
                markerMicro.setLatLng(newLatLng);

                mapPolygon.setView(newLatLng, 18);
                markerPolygon.setLatLng(newLatLng);
            };

            // Inicializamos los mapas con las coordenadas iniciales.
            initMaps(initialLat, initialLon);

            // Escuchamos el evento 'locationUpdated' que enviamos desde el controlador de Livewire.
            Livewire.on('locationUpdated', (event) => {
                // Extraemos latitud y longitud del evento.
                 const { lat, lon } = event[0];
                 updateLocation(parseFloat(lat), parseFloat(lon));
            });
        });
    </script>
</div>
