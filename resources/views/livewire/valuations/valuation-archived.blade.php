{{-- <div>
    <h2>Hola soy el módulo de archivos</h2>
</div>
 --}}

<div>
    <flux:heading size="xl" level="1">{{ __('Archivados') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Avalúos archivados durante algún proceso') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>

           <div class="overflow-x-auto mt-4">
    <table class="w-full text-sm text-left text-gray-700 rounded-lg">
        <thead class="text-xs uppercase bg-gray-50 text-gray-700">
            <tr>
                <th scope="col" class="px-6 py-3">ID Quasar</th>
                <th scope="col" class="px-6 py-3">Estatus</th>
                <th scope="col" class="px-6 py-3">Dirección</th>
                <th scope="col" class="px-6 py-3">Estado</th>
                <th scope="col" class="px-6 py-3">Municipio</th>
                <th scope="col" class="px-6 py-3">CP</th>
                <th scope="col" class="px-6 py-3">Niveles</th>
                <th scope="col" class="px-6 py-3">M Terreno</th>
                <th scope="col" class="px-6 py-3">Precio</th>
                <th scope="col" class="px-6 py-3">%</th>
                <th scope="col" class="px-6 py-3">Valuador</th>
                <th scope="col" class="px-6 py-3">Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                <td class="px-6 py-2 font-medium text-gray-900">Q2024001</td>
                <td class="px-6 py-2 text-gray-700">En proceso</td>
                <td class="px-6 py-2 text-gray-700">Av. Universidad #45</td>
                <td class="px-6 py-2 text-gray-700">Guanajuato</td>
                <td class="px-6 py-2 text-gray-700">León</td>
                <td class="px-6 py-2 text-gray-700">37150</td>
                <td class="px-6 py-2 text-gray-700">2</td>
                <td class="px-6 py-2 text-gray-700">135</td>
                <td class="px-6 py-2 text-gray-700">$1,280,000</td>
                <td class="px-6 py-2 text-gray-700">90%</td>
                <td class="px-6 py-2 text-gray-700">Ana Martínez</td>
                <td class="px-6 py-2">
                    <div class="flex items-center gap-2">
                        <button
                            class="px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                            Activar
                        </button>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

    </div>
</div>
