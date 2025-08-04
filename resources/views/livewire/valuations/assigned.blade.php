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
            <h1 class="text-2xl font-bold mb-4">Pendientes de asignar</h1>

            <div class="overflow-x-auto mt-4">
                <table class="w-full text-sm text-left text-gray-700">
                    <thead class="text-xs uppercase bg-gray-50 text-gray-700">

                        <tr>
                            <th class="px-6 py-3">Folio</th>
                            <th class="px-6 py-3">Tipo inmueble</th>
                            <th class="px-6 py-3">Perito</th>
                            <th class="px-6 py-3">Operador</th>
                            <th class="px-6 py-3">Status</th>
                            <th class="px-6 py-3 w-70">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                            <td class="px-6 py-2 font-medium text-gray-900">FOL001</td>
                            <td class="px-6 py-2">Casa habitación</td>

                            <td class="px-6 py-2">
                                {{-- <flux:select>
                                    <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                    <flux:select.option value="juana_lopez">Juana López</flux:select.option>
                                    <flux:select.option value="carlos_soto">Carlos Soto</flux:select.option>
                                </flux:select> --}}
                                <flux:select wire:model="appraiser">
                                    <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                                    @foreach ($users as $user)
                                        <flux:select.option value="{{ $user->id }}">
                                            {{-- {{ $user->name }} (ID: {{ $user->id }}) --}}
                                            {{ $user->name }}
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>
                                @error('type')
                                    {{--  <p class="text-sm text-red-600">El campo tipo de avalúo es obligatorio.</p> --}}
                                    <div role="alert" aria-live="polite" aria-atomic="true"
                                        class="mt-2 text-sm font-medium rounded-md flex items-center gap-2"
                                        data-flux-error="">
                                        <!-- Ícono triangular de advertencia -->
                                        <svg class="shrink-0 size-5 inline" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="#FA2C37" aria-hidden="true" data-slot="icon">
                                            <path fill-rule="evenodd"
                                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <!-- Mensaje -->
                                        <span class="text-[#FA2C37]">Debe seleccionar el avalúo padre.</span>
                                    </div>
                                @enderror
                            </td>
                            <td class="px-6 py-2">
                                <flux:select  wire:model="operator">
                                    <flux:select.option value="operator">-- Selecciona una opción --</flux:select.option>
                                    @foreach ($users as $user)
                                        <flux:select.option value="{{ $user->id }}">
                                            {{-- {{ $user->name }} (ID: {{ $user->id }}) --}}
                                            {{ $user->name }}
                                        </flux:select.option>
                                    @endforeach
                                </flux:select>
                                @error('type')
                                    {{--  <p class="text-sm text-red-600">El campo tipo de avalúo es obligatorio.</p> --}}
                                    <div role="alert" aria-live="polite" aria-atomic="true"
                                        class="mt-2 text-sm font-medium rounded-md flex items-center gap-2"
                                        data-flux-error="">
                                        <!-- Ícono triangular de advertencia -->
                                        <svg class="shrink-0 size-5 inline" xmlns="http://www.w3.org/2000/svg"
                                            viewBox="0 0 20 20" fill="#FA2C37" aria-hidden="true" data-slot="icon">
                                            <path fill-rule="evenodd"
                                                d="M8.485 2.495c.673-1.167 2.357-1.167 3.03 0l6.28 10.875c.673 1.167-.17 2.625-1.516 2.625H3.72c-1.347 0-2.189-1.458-1.515-2.625L8.485 2.495ZM10 5a.75.75 0 0 1 .75.75v3.5a.75.75 0 0 1-1.5 0v-3.5A.75.75 0 0 1 10 5Zm0 9a1 1 0 1 0 0-2 1 1 0 0 0 0 2Z"
                                                clip-rule="evenodd"></path>
                                        </svg>
                                        <!-- Mensaje -->
                                        <span class="text-[#FA2C37]">Debe seleccionar el avalúo padre.</span>
                                    </div>
                                @enderror
                            </td>

                            <td class="px-6 py-2">Pendiente</td>

                            <td class="px-6 py-2 space-x-1">
                                <button wire:click="save"
                                    class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                    Asignar
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
