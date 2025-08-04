
<div>

    <div>
        <div class="p-3">
            <h1 class="text-2xl font-bold mb-4">Pendientes de revisión</h1>

            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                        <tr>
                            <th class="px-6 py-3">Dirección</th>
                            <th class="px-6 py-3">Colonia</th>
                            <th class="px-6 py-3">Ciudad</th>
                            <th class="px-6 py-3">Estado</th>
                            <th class="px-6 py-3">Municipio</th>
                            <th class="px-6 py-3">CP</th>
                            <th class="px-6 py-3">Tipo inmueble</th>
                            <th class="px-6 py-3">Año de la construcción</th>
                            <th class="px-6 py-3">Clase inmueble</th>
                            <th class="px-6 py-3 w-70">Acciones</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">Calle Álamos #45</td>
                            <td class="px-6 py-2 text-gray-700">Jardines del Moral</td>
                            <td class="px-6 py-2 text-gray-700">León</td>
                            <td class="px-6 py-2 text-gray-700">Guanajuato</td>
                            <td class="px-6 py-2 text-gray-700">León</td>
                            <td class="px-6 py-2 text-gray-700">37160</td>
                            <td class="px-6 py-2 text-gray-700">Habitacional</td>
                            <td class="px-6 py-2 text-gray-700">2012</td>
                            <td class="px-6 py-2 text-gray-700">Media</td>
                            <td class="px-6 py-2 space-x-1">
                                <div class="flex items-center gap-2 flex-wrap max-w-[500px]">

                                    <button
                                        class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        Revisar
                                    </button>
                                    <button wire:click="$dispatch('openStatusModal')"
                                        class="cursor-pointer px-4 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-300">
                                        Cambiar estatus
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">Av. Tecnológico #89</td>
                            <td class="px-6 py-2 text-gray-700">Centro</td>
                            <td class="px-6 py-2 text-gray-700">Celaya</td>
                            <td class="px-6 py-2 text-gray-700">Guanajuato</td>
                            <td class="px-6 py-2 text-gray-700">Celaya</td>
                            <td class="px-6 py-2 text-gray-700">38000</td>
                            <td class="px-6 py-2 text-gray-700">Comercial</td>
                            <td class="px-6 py-2 text-gray-700">2005</td>
                            <td class="px-6 py-2 text-gray-700">Alta</td>
                            {{-- <td class="px-6 py-2">
                            <button class="cursor-pointer px-4 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-300">
                            Cambiar estatus
                            </button>
                            </td> --}}
                            <td class="px-6 py-2 space-x-1">
                                <div class="flex items-center gap-2 flex-wrap max-w-[500px]">

                                    <button
                                        class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        Revisar
                                    </button>
                                    <button wire:click="$dispatch('openStatusModal')"
                                        class="cursor-pointer px-4 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-300">
                                        Cambiar estatus
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
    <livewire:valuations.status-modal />
</div>
