{{-- <div>
    <h2>Hola soy los completados</h2>
</div>
 --}}

<div>
    {{-- <flux:heading size="xl" level="1">{{ __('Usuarios') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Administra tus usuarios') }}</flux:subheading>
    <flux:separator variant="subtle" /> --}}

    <div class="p-3">
        <h1 class="text-2xl font-bold mb-4">Avalúos finalizados</h1>

        <!-- Guanajuato -->
        {{-- <div class="border border-gray-200 rounded-lg mb-4">
    <button type="button" class="w-full flex justify-between items-center px-6 py-4 text-left bg-gray-100 hover:bg-gray-200 focus:outline-none"
      onclick="document.getElementById('accordion-guanajuato').classList.toggle('hidden')">
      <span class="text-lg font-semibold text-gray-800">Guanajuato</span>
      <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <path d="M19 9l-7 7-7-7" />
      </svg>
    </button>
    <div id="accordion-guanajuato" class="hidden">
      <div class="overflow-x-auto p-4">
        <table class="w-full text-sm text-left text-gray-700">
          <thead class="text-xs uppercase bg-gray-50 text-gray-700">
            <tr>
              <th class="px-6 py-3">Folio</th>
              <th class="px-6 py-3">ID Quasar</th>
              <th class="px-6 py-3">Estatus</th>
              <th class="px-6 py-3">Dirección</th>
              <th class="px-6 py-3">Estado</th>
              <th class="px-6 py-3">Municipio</th>
              <th class="px-6 py-3">CP</th>
              <th class="px-6 py-3">Niveles</th>
              <th class="px-6 py-3">M² Terreno</th>
              <th class="px-6 py-3">Precio</th>
              <th class="px-6 py-3">Valuador</th>
              <th class="px-6 py-3 w-70">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
              <td class="px-6 py-2 font-medium text-gray-900">F014</td>
              <td class="px-6 py-2">QZ1022</td>
              <td class="px-6 py-2">En revisión</td>
              <td class="px-6 py-2">Calle Lomas #12</td>
              <td class="px-6 py-2">Guanajuato</td>
              <td class="px-6 py-2">León</td>
              <td class="px-6 py-2">37060</td>
              <td class="px-6 py-2">2</td>
              <td class="px-6 py-2">180</td>
              <td class="px-6 py-2">$1,800,000</td>
              <td class="px-6 py-2">Juana López</td>
              <td class="px-6 py-2 flex gap-2 flex-wrap">
                <button class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Resumen</button>
                <button class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-300">PDF</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Jalisco -->
  <div class="border border-gray-200 rounded-lg mb-4">
    <button type="button" class="w-full flex justify-between items-center px-6 py-4 text-left bg-gray-100 hover:bg-gray-200 focus:outline-none"
      onclick="document.getElementById('accordion-jalisco').classList.toggle('hidden')">
      <span class="text-lg font-semibold text-gray-800">Jalisco</span>
      <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor" stroke-width="2"
        viewBox="0 0 24 24">
        <path d="M19 9l-7 7-7-7" />
      </svg>
    </button>
    <div id="accordion-jalisco" class="hidden">
      <div class="overflow-x-auto p-4">
        <table class="w-full text-sm text-left text-gray-700">
          <thead class="text-xs uppercase bg-gray-50 text-gray-700">
            <tr>
              <th class="px-6 py-3">Folio</th>
              <th class="px-6 py-3">ID Quasar</th>
              <th class="px-6 py-3">Estatus</th>
              <th class="px-6 py-3">Dirección</th>
              <th class="px-6 py-3">Estado</th>
              <th class="px-6 py-3">Municipio</th>
              <th class="px-6 py-3">CP</th>
              <th class="px-6 py-3">Niveles</th>
              <th class="px-6 py-3">M² Terreno</th>
              <th class="px-6 py-3">Precio</th>
              <th class="px-6 py-3">Valuador</th>
              <th class="px-6 py-3 w-70">Acciones</th>
            </tr>
          </thead>
          <tbody>
            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
              <td class="px-6 py-2 font-medium text-gray-900">F029</td>
              <td class="px-6 py-2">QZ2033</td>
              <td class="px-6 py-2">Finalizado</td>
              <td class="px-6 py-2">Av. Chapultepec #88</td>
              <td class="px-6 py-2">Jalisco</td>
              <td class="px-6 py-2">Guadalajara</td>
              <td class="px-6 py-2">44100</td>
              <td class="px-6 py-2">1</td>
              <td class="px-6 py-2">120</td>
              <td class="px-6 py-2">$1,200,000</td>
              <td class="px-6 py-2">Carlos Soto</td>
              <td class="px-6 py-2 flex gap-2 flex-wrap">
                <button class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Resumen</button>
                <button class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-300">PDF</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div> --}}



        {{--
        <div class="overflow-x-auto mb-2">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Folio</th>
                        <th class="px-6 py-3">ID Quasar</th>
                        <th class="px-6 py-3">Estatus</th>
                        <th class="px-6 py-3">Dirección</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Municipio</th>
                        <th class="px-6 py-3">CP</th>
                        <th class="px-6 py-3">Niveles</th>
                        <th class="px-6 py-3">M² Terreno</th>
                        <th class="px-6 py-3">Precio</th>
                        <th class="px-6 py-3">Valuador</th>
                        <th class="px-6 py-3 w-70">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>


        <div class="border border-gray-200 rounded-lg mb-4">
            <button type="button"
                class="w-full flex justify-between items-center px-6 py-4 text-left bg-gray-100 hover:bg-gray-200 focus:outline-none"
                onclick="document.getElementById('accordion-guanajuato').classList.toggle('hidden')">
                <span class="text-lg font-semibold text-gray-800">Guanajuato</span>
                <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="accordion-guanajuato" class="hidden">
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-sm text-left text-gray-700">
                        <tbody>
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900">F014</td>
                                <td class="px-6 py-2">QZ1022</td>
                                <td class="px-6 py-2">En revisión</td>
                                <td class="px-6 py-2">Calle Lomas #12</td>
                                <td class="px-6 py-2">Guanajuato</td>
                                <td class="px-6 py-2">León</td>
                                <td class="px-6 py-2">37060</td>
                                <td class="px-6 py-2">2</td>
                                <td class="px-6 py-2">180</td>
                                <td class="px-6 py-2">$1,800,000</td>
                                <td class="px-6 py-2">Juana López</td>

                                <td class="px-6 py-2">
                                    <div class="flex flex-col items-center w-full">

                                        <div class="flex justify-center gap-2 mb-2 w-full">
                                            <button
                                                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">Capturar</button>
                                            <button
                                                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Resumen</button>
                                        </div>


                                        <div class="w-full text-center">
                                            <button
                                                class="cursor-pointer px-4 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-300">PDF</button>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="border border-gray-200 rounded-lg mb-4">
            <button type="button"
                class="w-full flex justify-between items-center px-6 py-4 text-left bg-gray-100 hover:bg-gray-200 focus:outline-none"
                onclick="document.getElementById('accordion-jalisco').classList.toggle('hidden')">
                <span class="text-lg font-semibold text-gray-800">Jalisco</span>
                <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="accordion-jalisco" class="hidden">
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-sm text-left text-gray-700">
                        <tbody>
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900">F029</td>
                                <td class="px-6 py-2">QZ2033</td>
                                <td class="px-6 py-2">Finalizado</td>
                                <td class="px-6 py-2">Av. Chapultepec #88</td>
                                <td class="px-6 py-2">Jalisco</td>
                                <td class="px-6 py-2">Guadalajara</td>
                                <td class="px-6 py-2">44100</td>
                                <td class="px-6 py-2">1</td>
                                <td class="px-6 py-2">120</td>
                                <td class="px-6 py-2">$1,200,000</td>
                                <td class="px-6 py-2">Carlos Soto</td>

                                <td class="px-6 py-2">
                                    <div class="flex flex-col items-center w-full">

                                        <div class="flex justify-center gap-2 mb-2 w-full">
                                            <button
                                                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">Capturar</button>
                                            <button
                                                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Resumen</button>
                                        </div>


                                        <div class="w-full text-center">
                                            <button
                                                class="cursor-pointer px-4 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-300">PDF</button>
                                        </div>
                                    </div>
                                </td>

                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div> --}}



        {{--   <!-- Títulos generales de la tabla -->
        <div class="overflow-x-auto mb-2">
            <table class="w-full text-sm text-left text-gray-700">
                <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                    <tr>
                        <th class="px-6 py-3">Folio</th>
                        <th class="px-6 py-3">ID Quasar</th>
                        <th class="px-6 py-3">Estatus</th>
                        <th class="px-6 py-3">Dirección</th>
                        <th class="px-6 py-3">Estado</th>
                        <th class="px-6 py-3">Municipio</th>
                        <th class="px-6 py-3">CP</th>
                        <th class="px-6 py-3">Niveles</th>
                        <th class="px-6 py-3">M² Terreno</th>
                        <th class="px-6 py-3">Precio</th>
                        <th class="px-6 py-3">Valuador</th>
                        <th class="px-6 py-3 w-70">Acciones</th>
                    </tr>
                </thead>
            </table>
        </div>

        <!-- Guanajuato Accordion -->
        <div class="border border-gray-200 rounded-lg mb-4">
            <button type="button"
                class="w-full flex justify-between items-center px-6 py-4 text-left bg-gray-100 hover:bg-gray-200 focus:outline-none"
                onclick="document.getElementById('accordion-guanajuato').classList.toggle('hidden')">
                <span class="text-lg font-semibold text-gray-800">Guanajuato</span>
                <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="accordion-guanajuato" class="hidden">
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-sm text-left text-gray-700">
                        <tbody>
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900">F014</td>
                                <td class="px-6 py-2">QZ1022</td>
                                <td class="px-6 py-2">En revisión</td>
                                <td class="px-6 py-2 max-w-[160px] truncate whitespace-nowrap overflow-hidden"
                                    title="Calle Lomas #12">Calle Lomas #12</td>
                                <td class="px-6 py-2 max-w-[120px] truncate whitespace-nowrap overflow-hidden"
                                    title="Guanajuato">Guanajuato</td>
                                <td class="px-6 py-2 max-w-[120px] truncate whitespace-nowrap overflow-hidden"
                                    title="León">León</td>
                                <td class="px-6 py-2 max-w-[100px] truncate whitespace-nowrap overflow-hidden"
                                    title="37060">37060</td>
                                <td class="px-6 py-2">2</td>
                                <td class="px-6 py-2">180</td>
                                <td class="px-6 py-2 max-w-[100px] truncate whitespace-nowrap overflow-hidden"
                                    title="$1,800,000">$1,800,000</td>
                                <td class="px-6 py-2 max-w-[140px] truncate whitespace-nowrap overflow-hidden"
                                    title="Juana López">Juana López</td>
                                <td class="px-6 py-2">
                                    <div class="flex flex-col items-center w-full">
                                        <div class="flex justify-center gap-2 mb-2 w-full">
                                            <button
                                                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">Capturar</button>
                                            <button
                                                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Resumen</button>
                                        </div>
                                        <div class="w-full text-center">
                                            <button
                                                class="cursor-pointer px-4 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-300">PDF</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Jalisco Accordion -->
        <div class="border border-gray-200 rounded-lg mb-4">
            <button type="button"
                class="w-full flex justify-between items-center px-6 py-4 text-left bg-gray-100 hover:bg-gray-200 focus:outline-none"
                onclick="document.getElementById('accordion-jalisco').classList.toggle('hidden')">
                <span class="text-lg font-semibold text-gray-800">Jalisco</span>
                <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="accordion-jalisco" class="hidden">
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-sm text-left text-gray-700">
                        <tbody>
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900">F029</td>
                                <td class="px-6 py-2">QZ2033</td>
                                <td class="px-6 py-2">Finalizado</td>
                                <td class="px-6 py-2 max-w-[160px] truncate whitespace-nowrap overflow-hidden"
                                    title="Av. Chapultepec #88">Av. Chapultepec #88</td>
                                <td class="px-6 py-2 max-w-[120px] truncate whitespace-nowrap overflow-hidden"
                                    title="Jalisco">Jalisco</td>
                                <td class="px-6 py-2 max-w-[120px] truncate whitespace-nowrap overflow-hidden"
                                    title="Guadalajara">Guadalajara</td>
                                <td class="px-6 py-2 max-w-[100px] truncate whitespace-nowrap overflow-hidden"
                                    title="44100">44100</td>
                                <td class="px-6 py-2">1</td>
                                <td class="px-6 py-2">120</td>
                                <td class="px-6 py-2 max-w-[100px] truncate whitespace-nowrap overflow-hidden"
                                    title="$1,200,000">$1,200,000</td>
                                <td class="px-6 py-2 max-w-[140px] truncate whitespace-nowrap overflow-hidden"
                                    title="Carlos Soto">Carlos Soto</td>
                                <td class="px-6 py-2">
                                    <div class="flex flex-col items-center w-full">
                                        <div class="flex justify-center gap-2 mb-2 w-full">
                                            <button
                                                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">Capturar</button>
                                            <button
                                                class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Resumen</button>
                                        </div>
                                        <div class="w-full text-center">
                                            <button
                                                class="cursor-pointer px-4 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-300">PDF</button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
 --}}


        <!-- Acordeón: Guanajuato -->
        {{--        <div class="border border-gray-200 rounded-lg mb-4">
            <button type="button"
                class="w-full flex justify-between items-center px-6 py-4 text-left bg-gray-100 hover:bg-gray-200 focus:outline-none"
                onclick="document.getElementById('accordion-guanajuato').classList.toggle('hidden')">
                <span class="text-lg font-semibold text-gray-800">Guanajuato</span>
                <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="accordion-guanajuato" class="hidden">
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Folio</th>
                                <th class="px-6 py-3">ID Quasar</th>
                                <th class="px-6 py-3">Estatus</th>
                                <th class="px-6 py-3">Dirección</th>
                                <th class="px-6 py-3">Estado</th>
                                <th class="px-6 py-3">Municipio</th>
                                <th class="px-6 py-3">CP</th>
                                <th class="px-6 py-3">Niveles</th>
                                <th class="px-6 py-3">M² Terreno</th>
                                <th class="px-6 py-3">Precio</th>
                                <th class="px-6 py-3">Valuador</th>
                                <th class="px-6 py-3 w-70">Acciones</th>
                            </tr>
                        </thead> --}}


        <!-- Acordeón: Estado de México -->
        <div class="border border-gray-200 rounded-lg mb-4">
            <button type="button"
                class="group w-full flex justify-between items-center px-6 py-4 bg-white hover:bg-gray-50 border-b border-gray-200 focus:outline-none transition-colors cursor-pointer"
                onclick="document.getElementById('accordion-cuernavaca').classList.toggle('hidden')">
                <span class="text-lg font-semibold text-gray-800">Cuernavaca</span>
                <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="accordion-cuernavaca" class="hidden">
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Folio</th>
                                <th class="px-6 py-3">ID Quasar</th>
                                <th class="px-6 py-3">Estatus</th>
                                <th class="px-6 py-3">Dirección</th>
                                <th class="px-6 py-3">Estado</th>
                                <th class="px-6 py-3">Municipio</th>
                                <th class="px-6 py-3">CP</th>
                                <th class="px-6 py-3">Niveles</th>
                                <th class="px-6 py-3">M² Terreno</th>
                                <th class="px-6 py-3">Precio</th>
                                <th class="px-6 py-3">Valuador</th>
                                <th class="px-6 py-3 w-70">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900">F085</td>
                                <td class="px-6 py-2">QZ3089</td>
                                <td class="px-6 py-2">Pendiente</td>
                                <td class="px-6 py-2 max-w-[160px] truncate whitespace-nowrap overflow-hidden"
                                    title="Av. Central #45, Col. San Miguel">Av. Central #45</td>
                                <td class="px-6 py-2 max-w-[120px] truncate whitespace-nowrap overflow-hidden"
                                    title="Estado de México">Estado de México</td>
                                <td class="px-6 py-2 max-w-[120px] truncate whitespace-nowrap overflow-hidden"
                                    title="Ecatepec">Ecatepec</td>
                                <td class="px-6 py-2 max-w-[100px] truncate whitespace-nowrap overflow-hidden"
                                    title="55320">55320</td>
                                <td class="px-6 py-2">3</td>
                                <td class="px-6 py-2">240</td>
                                <td class="px-6 py-2 max-w-[100px] truncate whitespace-nowrap overflow-hidden"
                                    title="$2,200,000">$2,200,000</td>
                                <td class="px-6 py-2 max-w-[140px] truncate whitespace-nowrap overflow-hidden"
                                    title="Rocío Hernández">Rocío Hernández</td>
                                {{-- <td class="px-6 py-2">
                            <div class="flex flex-col items-center w-full">
                                <div class="flex justify-center gap-2 mb-2 w-full">
                                <button class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">Capturar</button>
                                <button class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">Resumen</button>
                                </div>
                                <div class="w-full text-center">
                                <button class="cursor-pointer px-4 py-2 text-xs font-medium text-white bg-slate-600 rounded-lg hover:bg-slate-700 focus:ring-4 focus:outline-none focus:ring-slate-300">PDF</button>
                                </div>
                            </div>
                            </td> --}}
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-2 flex-wrap max-w-[500px]">
                                        <button
                                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                            PDF
                                        </button>
                                        <button
                                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                            Resumen
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

        <!-- Acordeón: Estado de México -->
        <div class="border border-gray-200 rounded-lg mb-4">
            <button type="button"
                class="group w-full flex justify-between items-center px-6 py-4 bg-white hover:bg-gray-50 border-b border-gray-200 focus:outline-none transition-colors cursor-pointer"
                onclick="document.getElementById('accordion-ciudadmexico').classList.toggle('hidden')">
                <span class="text-lg font-semibold text-gray-800">Ciudad de mexico</span>
                <svg class="w-5 h-5 transform transition-transform duration-200" fill="none" stroke="currentColor"
                    stroke-width="2" viewBox="0 0 24 24">
                    <path d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="accordion-ciudadmexico" class="hidden">
                <div class="overflow-x-auto p-4">
                    <table class="w-full text-sm text-left text-gray-700">
                        <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                            <tr>
                                <th class="px-6 py-3">Folio</th>
                                <th class="px-6 py-3">ID Quasar</th>
                                <th class="px-6 py-3">Estatus</th>
                                <th class="px-6 py-3">Dirección</th>
                                <th class="px-6 py-3">Estado</th>
                                <th class="px-6 py-3">Municipio</th>
                                <th class="px-6 py-3">CP</th>
                                <th class="px-6 py-3">Niveles</th>
                                <th class="px-6 py-3">M² Terreno</th>
                                <th class="px-6 py-3">Precio</th>
                                <th class="px-6 py-3">Valuador</th>
                                <th class="px-6 py-3 w-70">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                                <td class="px-6 py-2 font-medium text-gray-900">F085</td>
                                <td class="px-6 py-2">QZ3089</td>
                                <td class="px-6 py-2">Pendiente</td>
                                <td class="px-6 py-2 max-w-[160px] truncate whitespace-nowrap overflow-hidden"
                                    title="Av. Central #45, Col. San Miguel">Av. Central #45</td>
                                <td class="px-6 py-2 max-w-[120px] truncate whitespace-nowrap overflow-hidden"
                                    title="Estado de México">Estado de México</td>
                                <td class="px-6 py-2 max-w-[120px] truncate whitespace-nowrap overflow-hidden"
                                    title="Ecatepec">Ecatepec</td>
                                <td class="px-6 py-2 max-w-[100px] truncate whitespace-nowrap overflow-hidden"
                                    title="55320">55320</td>
                                <td class="px-6 py-2">3</td>
                                <td class="px-6 py-2">240</td>
                                <td class="px-6 py-2 max-w-[100px] truncate whitespace-nowrap overflow-hidden"
                                    title="$2,200,000">$2,200,000</td>
                                <td class="px-6 py-2 max-w-[140px] truncate whitespace-nowrap overflow-hidden"
                                    title="Rocío Hernández">Rocío Hernández</td>
                                <td class="px-6 py-2">
                                    <div class="flex items-center gap-2 flex-wrap max-w-[500px]">
                                        <button
                                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                            PDF
                                        </button>
                                        <button
                                            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                            Resumen
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


    </div>
    <livewire:valuations.status-modal />
</div>
