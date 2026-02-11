{{-- **CAMBIO CLAVE:** Se renombra el evento a kebab-case para seguir convenciones --}}
<div x-data="mapManager()" x-init="init()"
    @location-updated.window="createOrUpdateMaps($event.detail.lat, $event.detail.lon, $event.detail.alt)">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/leaflet.css') }}" />
    <style>
        .map-container {
            height: 350px;
            border-radius: 12px;
            z-index: 1;
            background-color: #e5e7eb;
            /* Fondo gris para ver si carga el canvas */
            overflow: hidden;
        }

        /* Ocultar controles al capturar */
        .leaflet-control-container .leaflet-control {
            display: none;
        }
    </style>
    @if($isReadOnly)
    <div class="border-l-4 border-red-600 text-red-600 p-4 mb-4 rounded shadow-sm">
        <p class="font-bold">Modo Lectura</p>
        <p>El avalúo está en revisión. No puedes realizar modificaciones.</p>
    </div>
    @endif

    <form wire:submit='save'>
        <fieldset @disabled($isReadOnly)>
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
                    {{-- <h2 class="border-b-2 border-gray-300">Polígono del inmueble</h2> --}}
                </div>

                {{-- **CAMBIO CLAVE:** `wire:ignore` le dice a Livewire que no toque estos divs, dejando que JS los
                controle --}}
                <div class="form-grid form-grid--3 mt-3 mb-2 text-lg">
                    <div x-ref="mapMacro" class="map-container" wire:ignore></div>
                    <div x-ref="mapMicro" class="map-container" wire:ignore></div>
                    {{-- <div x-ref="mapPolygon" class="map-container" wire:ignore></div> --}}
                </div>
                @if(!$isReadOnly)
                <flux:button type="button" wire:click.prevent="locate" class="mt-4 cursor-pointer btn-intermediary"
                    variant="primary">
                    Localizar inmueble en mapa
                </flux:button>
                @endif
            </div>
        </div>
        </fieldset>
        @if(!$isReadOnly)
        {{-- Resto de tu formulario --}}
    <div class="form-container__content">
        {{-- Botón con Loader "Overlay" --}}
        <flux:button class="mt-4 cursor-pointer btn-primary w-full sm:w-auto relative transition-all" variant="primary"
            type="button" x-on:click="captureAndSave" x-bind:disabled="isCapturing">

            {{-- 1. EL TEXTO (Se vuelve invisible pero MANTIENE el ancho del botón) --}}

            <span :class="isCapturing ? 'opacity-0' : 'opacity-100'" class="transition-opacity duration-200">
                Guardar datos
            </span>

            {{-- 2. EL LOADER (Aparece flotando justo en el centro) --}}
            <div x-show="isCapturing" class="absolute inset-0 flex items-center justify-center" style="display: none;">
                {{-- Spinner limpio sin texto --}}
                <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
            </div>

        </flux:button>
        @endif
    </div>
    </form>

    {{-- <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script> --}}

<script>
    function mapManager() {
        return {
            // 1. CONTROL DE ESTADO VISUAL (Para que el botón reaccione al instante)
            isCapturing: false,

            maps: {
                macro: { map: null, marker: null },
                micro: { map: null, marker: null },
            },

            createOrUpdateMaps(lat, lon, alt = 0) {
                const latitude = parseFloat(lat);
                const longitude = parseFloat(lon);

                if (isNaN(latitude) || isNaN(longitude)) return;

                const setupMap = (ref, mapObj, zoom) => {
                    if (!ref) return;

                    // RECUPERACIÓN ANTI-ZOMBIE
                    if (!mapObj.map && ref.savedMap) {
                        mapObj.map = ref.savedMap;
                        mapObj.marker = ref.savedMarker;
                    }
                    if (!mapObj.map && ref._leaflet_id) {
                        ref._leaflet_id = null;
                        ref.innerHTML = '';
                    }

                    if (!mapObj.map) {
                        // CREACIÓN DEL MAPA
                        const map = L.map(ref, {
                            preferCanvas: true,
                            zoomControl: false,
                            fadeAnimation: false, // OBLIGATORIO: Sin animaciones
                            zoomAnimation: false,
                            markerZoomAnimation: false
                        }).setView([latitude, longitude], zoom);

                        // OBLIGATORIO: crossOrigin anonymous
                        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                            attribution: '&copy; OpenStreetMap',
                            crossOrigin: 'anonymous',
                            maxZoom: 19
                        }).addTo(map);

                        const marker = L.marker([latitude, longitude]).addTo(map);

                        mapObj.map = map;
                        mapObj.marker = marker;
                        ref.savedMap = map;
                        ref.savedMarker = marker;

                    } else {
                        // ACTUALIZACIÓN
                        mapObj.map.setView([latitude, longitude], zoom);
                        if (mapObj.marker) {
                            mapObj.marker.setLatLng([latitude, longitude]);
                        } else {
                            const marker = L.marker([latitude, longitude]).addTo(mapObj.map);
                            mapObj.marker = marker;
                            ref.savedMarker = marker;
                        }
                        // Repintado forzoso
                        setTimeout(() => { mapObj.map.invalidateSize(); }, 200);
                    }
                };

                setupMap(this.$refs.mapMacro, this.maps.macro, 14);
                setupMap(this.$refs.mapMicro, this.maps.micro, 18);
            },

            init() {
                // Fix Iconos Leaflet
                delete L.Icon.Default.prototype._getIconUrl;
                L.Icon.Default.mergeOptions({
                    iconRetinaUrl: '/css/img/marker-icon-2x.png',
                    iconUrl: '/css/img/marker-icon.png',
                    shadowUrl: '/css/img/marker-shadow.png',
                });

                const initialLat = @this.get('latitude');
                const initialLon = @this.get('longitude');
                const initialAlt = @this.get('altitude') ?? 0;

                setTimeout(() => this.createOrUpdateMaps(initialLat, initialLon, initialAlt), 100);

                window.addEventListener('location-updated', (event) => {
                    const lat = event.detail[0]?.lat || event.detail.lat;
                    const lon = event.detail[0]?.lon || event.detail.lon;
                    this.createOrUpdateMaps(lat, lon);
                });
            },

            // --- FUNCIÓN MAESTRA DE CAPTURA ---
            async captureAndSave() {
                // 1. ACTIVAMOS LA ANIMACIÓN VISUAL (FEEDBACK INSTANTÁNEO)
                this.isCapturing = true;
                console.log('📸 Iniciando captura...');

                if (typeof html2canvas === 'undefined') {
                    alert('Error: html2canvas no cargó.');
                    this.isCapturing = false;
                    return;
                }

                try {
                    // 2. OBTENEMOS TAMAÑO EXACTO PARA EVITAR BORDES GRISES
                    const width = this.$refs.mapMacro.offsetWidth;
                    const height = this.$refs.mapMacro.offsetHeight;

                    const getOptions = () => ({
                        useCORS: true,
                        allowTaint: true,
                        logging: false,
                        scale: 2,
                        backgroundColor: '#ffffff',
                        width: width,   // Recorte exacto Ancho
                        height: height, // Recorte exacto Alto

                        onclone: (clonedDoc) => {
                            // 3. LIMPIEZA NUCLEAR DE CSS (Adiós oklch / Tailwind en el clon)
                            const links = clonedDoc.querySelectorAll('link[rel="stylesheet"]');
                            links.forEach(link => {
                                if (!link.href.includes('leaflet')) link.remove();
                            });

                            const styles = clonedDoc.querySelectorAll('style');
                            styles.forEach(style => {
                                if (style.innerHTML.includes('oklch') || style.innerHTML.includes('var(--')) {
                                    style.remove();
                                }
                            });

                            // 4. FORZAR DIMENSIONES FIJAS EN EL CLON
                            const mapContainers = clonedDoc.querySelectorAll('.map-container');
                            mapContainers.forEach(el => {
                                el.style.width = width + 'px';
                                el.style.height = height + 'px';
                                el.style.position = 'fixed';
                                el.style.top = '0';
                                el.style.left = '0';
                                el.style.margin = '0';
                                el.style.backgroundColor = '#ffffff';
                                el.style.zIndex = '9999';
                            });
                        },

                        ignoreElements: (element) => {
                            if (element.classList.contains('leaflet-control-container')) return true;
                            if (element.tagName && element.tagName.toLowerCase().startsWith('ui-')) return true;
                            return false;
                        }
                    });

                    // 5. PAUSA TÁCTICA (Aquí el usuario ya ve el spinner girando)
                    await new Promise(r => setTimeout(r, 800));

                    console.log('📸 Capturando Macro...');
                    const canvasMacro = await html2canvas(this.$refs.mapMacro, getOptions());
                    const base64Macro = canvasMacro.toDataURL('image/jpeg', 0.85);

                    console.log('📸 Capturando Micro...');
                    const canvasMicro = await html2canvas(this.$refs.mapMicro, getOptions());
                    const base64Micro = canvasMicro.toDataURL('image/jpeg', 0.85);

                    console.log('🚀 Enviando al servidor...');
                    await @this.saveMapImages(base64Macro, base64Micro);

                    console.log(' Finalizando...');
                    @this.save();

                    // Nota: Si la página no recarga, descomenta esto para quitar el spinner:
                    // this.isCapturing = false;

                } catch (error) {
                    console.error('❌ Error en captura:', error);
                    // Si falla, intentamos guardar los datos numéricos de todas formas
                    @this.save();
                    this.isCapturing = false; // Restauramos el botón
                }
            }
        };
    }
</script>
</div>
