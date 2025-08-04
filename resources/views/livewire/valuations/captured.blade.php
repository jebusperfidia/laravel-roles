<div>

    @session('success')
        <div id="alerta"
            class="flex items-center p-2 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-800"
            role="alert">
            <svg class="flex-shrink-0 w-8 h-8 mr-1 text-green-700 dark:text-green-300" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
            </svg>
            <span class="font-medium"> {{ $value }} </span>
        </div>
    @endsession


    <div>
        <div class="p-3">
            <h1 class="text-2xl font-bold mb-4">Pendientes de elaboración</h1>
            {{--  <button class="mb-4 px-4 py-2 text-sm font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                  Create
              </button> --}}

            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-700">

                        <tr>
                            <th scope="col" class="px-6 py-3">Folio</th>
                            <th scope="col" class="px-6 py-3">Notas</th>
                            <th scope="col" class="px-6 py-3">Dirección</th>
                            <th scope="col" class="px-6 py-3">Ciudad</th>
                            <th scope="col" class="px-6 py-3">Estado</th>
                            <th scope="col" class="px-6 py-3">CP</th>
                            <th scope="col" class="px-6 py-3">Tipo Inmueble</th>
                            <th scope="col" class="px-6 py-3">Año terminación obra</th>
                            <th scope="col" class="px-6 py-3 w-70">Accciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">F12345</td>
                            <td class="px-6 py-2 text-gray-700">Inspección pendiente</td>
                            <td class="px-6 py-2 text-gray-700">Av. Reforma #128</td>
                            <td class="px-6 py-2 text-gray-700">León</td>
                            <td class="px-6 py-2 text-gray-700">Guanajuato</td>
                            <td class="px-6 py-2 text-gray-700">37215</td>
                            <td class="px-6 py-2 text-gray-700">Comercial</td>
                            <td class="px-6 py-2 text-gray-700">2018</td>
                            <td class="px-6 py-2 space-x-1">
                                <div class="flex items-center gap-2 flex-wrap max-w-[500px]">
                                    <button
                                        class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                        Capturar
                                    </button>
                                    <button
                                        class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                        Resumen
                                    </button>
                                    <button
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
</div>
