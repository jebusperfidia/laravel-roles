<div>

    {{-- ============================================================== --}}
    {{-- ÁREA FUNCIONAL (EL BOTÓN QUE DA LA ORDEN) --}}
    {{-- ============================================================== --}}

    <div class="form-container" x-data="{
        async captureChartAndDownload() {
            console.log('🔍 Buscando la gráfica en la pantalla...');

            // 1. Buscamos el canvas.
            // NOTA: Busca el primer <canvas> que encuentre en toda la página.
            // Si tienes varios, capturará el primero.
            const canvas = document.querySelector('canvas');

            if (canvas) {
                console.log('✅ Canvas encontrado. Tomando foto...');

                // Convertimos la gráfica a texto (Base64)
                const chartBase64 = canvas.toDataURL('image/jpeg', 0.6);

                // 2. Se lo pasamos a Livewire ($wire es el puente mágico de Alpine)

                $wire.generatePdf(chartBase64);

                console.log('📤 Imagen enviada al backend. Generando PDF...');

                // 3. Ordenamos generar el PDF
                $wire.generatePdf();

            } else {
                console.error('❌ NO SE ENCONTRÓ NINGÚN CANVAS');
                alert('No encuentro la gráfica en la pantalla. Se generará el PDF sin ella.');

                // Generamos el PDF aunque no haya gráfica
                $wire.generatePdf();
            }
        }
    }">
        <div class="form-container__header">
            Impresión PDF
        </div>
        <div class="form-container__content">

            <div class="flex flex-col items-center justify-center space-y-4">
                <h3 class="text-lg font-bold text-gray-700">Exportar Documento</h3>
                <p class="text-sm text-gray-500">Generar el PDF con la configuración actual.</p>

                {{-- El botón dispara la función de arriba --}}
                <flux:button @click="captureChartAndDownload" variant="primary" icon="printer"
                    class="btn-primary cursor-pointer">
                    GENERAR PDF
                </flux:button>
            </div>
        </div>

    </div>

    {{-- ============================================================== --}}
    {{-- ÁREA MAQUETADA (REFERENCIA DE LA IMAGEN) - ESTÁ COMENTADA --}}
    {{-- ============================================================== --}}

    {{--
    <div class="mt-8 border border-gray-300 rounded shadow-lg overflow-hidden max-w-4xl mx-auto font-sans">

        <div class="bg-[#3AB0E2] text-white px-4 py-2 flex items-center font-bold text-sm">
            <span class="mr-2">&lt;/&gt;</span> LOS CAMPOS EN ROJO SON OBLIGATORIOS
        </div>

        <div class="p-6 bg-white space-y-6">

            <div class="grid grid-cols-12 gap-4 items-center">
                <label class="col-span-3 text-right text-xs font-bold text-gray-600 uppercase">Membrete:</label>
                <div class="col-span-9">
                    <select
                        class="w-full border border-red-400 rounded px-2 py-1 text-sm focus:outline-none focus:border-blue-500">
                        <option>ESTUDIO ÁLAMO: ARQUITECTURA + VALUACIÓN</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4 items-start">
                <label class="col-span-3 text-right text-xs font-bold text-gray-600 uppercase mt-2">Formatos a
                    imprimir:</label>

                <div class="col-span-9 flex gap-2">
                    <div class="flex-1 border border-gray-300 rounded">
                        <div class="bg-[#3AB0E2] text-white text-xs font-bold px-2 py-1">FORMATOS DISPONIBLES</div>
                        <ul class="p-2 text-sm text-gray-600 space-y-1 h-32 overflow-y-auto">
                            <li class="flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                <div class="w-8 h-4 bg-gray-200 rounded-full relative">
                                    <div class="w-4 h-4 bg-white rounded-full border shadow absolute left-0"></div>
                                </div>
                                <span>Portada del avalúo</span>
                            </li>
                            <li class="flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                <div class="w-8 h-4 bg-gray-200 rounded-full relative">
                                    <div class="w-4 h-4 bg-white rounded-full border shadow absolute left-0"></div>
                                </div>
                                <span>Anexo Comparables Ventas</span>
                            </li>
                            <li class="flex items-center gap-2 cursor-pointer hover:bg-gray-50">
                                <div class="w-8 h-4 bg-gray-200 rounded-full relative">
                                    <div class="w-4 h-4 bg-white rounded-full border shadow absolute left-0"></div>
                                </div>
                                <span>Mapa Comparables</span>
                            </li>
                        </ul>
                    </div>

                    <div class="flex flex-col justify-center text-gray-400">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                        </svg>
                    </div>

                    <div class="flex-1 border border-gray-300 rounded">
                        <div class="bg-[#3AB0E2] text-white text-xs font-bold px-2 py-1">FORMATOS QUE SE IMPRIMIRÁN
                        </div>
                        <ul class="p-2 text-sm text-gray-600 space-y-1 h-32 overflow-y-auto">
                            <li class="flex items-center gap-2 cursor-pointer">
                                <div class="w-8 h-4 bg-[#3AB0E2] rounded-full relative">
                                    <div class="w-4 h-4 bg-white rounded-full border shadow absolute right-0"></div>
                                </div>
                                <span>Formato de Avalúo GYS Ind</span>
                            </li>
                            <li class="flex items-center gap-2 cursor-pointer">
                                <div class="w-8 h-4 bg-[#3AB0E2] rounded-full relative">
                                    <div class="w-4 h-4 bg-white rounded-full border shadow absolute right-0"></div>
                                </div>
                                <span>Documentos anexos</span>
                            </li>
                            <li class="flex items-center gap-2 cursor-pointer">
                                <div class="w-8 h-4 bg-[#3AB0E2] rounded-full relative">
                                    <div class="w-4 h-4 bg-white rounded-full border shadow absolute right-0"></div>
                                </div>
                                <span>Reporte fotográfico</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4 items-center">
                <label class="col-span-3 text-right text-xs font-bold text-gray-600 uppercase">Marca de agua:</label>
                <div class="col-span-9">
                    <select class="w-1/2 border border-gray-300 rounded px-2 py-1 text-sm text-gray-500">
                        <option>[Sin marca de agua]</option>
                        <option>Borrador</option>
                        <option>Confidencial</option>
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-12 gap-4 items-center">
                <label class="col-span-3 text-right text-xs font-bold text-gray-600 uppercase">Folio de avalúo en pie de
                    página:</label>
                <div class="col-span-9">
                    <input type="checkbox" checked class="text-blue-500 rounded focus:ring-blue-500">
                </div>
            </div>
            <div class="grid grid-cols-12 gap-4 items-center -mt-4">
                <label class="col-span-3 text-right text-xs font-bold text-gray-600 uppercase">Numeración de página
                    consecutiva:</label>
                <div class="col-span-9">
                    <input type="checkbox" checked class="text-blue-500 rounded focus:ring-blue-500">
                </div>
            </div>

        </div>

        <div class="bg-gray-100 px-6 py-4 flex items-center gap-2 border-t border-gray-200">
            <button
                class="bg-[#5CB85C] hover:bg-green-600 text-white font-bold py-2 px-6 rounded text-sm shadow uppercase">
                IMPRIMIR
            </button>
            <button
                class="bg-white hover:bg-gray-50 text-gray-600 font-bold py-2 px-6 rounded text-sm shadow border border-gray-300 uppercase">
                CERRAR VENTANA
            </button>
        </div>
    </div>
    --}}

</div>
