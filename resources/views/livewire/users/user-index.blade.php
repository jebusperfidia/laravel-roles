<div>
    <flux:heading size="xl" level="1">{{ __('Usuarios') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Administra tus usuarios') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>
            @session('success')
                <div id="alerta" class="flex items-center p-2 mb-4 text-sm text-green-800 border border-green-300 rounded-lg bg-green-50 dark:bg-green-900 dark:text-green-300 dark:border-green-800" role="alert">
                    <svg class="flex-shrink-0 w-8 h-8 mr-1 text-green-700 dark:text-green-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4"></path>
                    </svg>
                    <span class="font-medium"> {{ $value }} </span>
                </div>
            @endsession
            <a href={{route('user.create')}} class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                Crear usuario
            </a>
            <div class="overflow-x-auto mt-4">
                    <flux:input class="p-4" placeholder="Buscar elemento" wire:model.live="search"/>
                @if ($users->count())
                <table class="w-full text-sm text-left text-gray-700">
                   {{--  @if (!$users)
                        <h4>No se encontraron datos que mostrar</h4>
                     @else --}}
                    <thead class="text-xs uppercase bg-gray-50 text-gray-700">
                    <tr>
                        <th scope="col" class="px-6 py-3">#</th>
                        <th scope="col" class="px-6 py-3">Nombre</th>
                        <th scope="col" class="px-6 py-3">Email</th>
                        <th scope="col" class="px-6 py-3 w-70">Accciones</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                    <tr class="odd:bg-white even:bg-gray-50 border-b border-gray-200">
                        <td class="px-6 py-2 font-medium text-gray-900">{{$user -> id}}</td>
                        <td class="px-6 py-2 text-gray-700">{{$user -> name}}</td>
                        <td class="px-6 py-2 text-gray-700">{{$user -> email}}</td>
                        <td class="px-6 py-2 space-x-1">
                            <a href="{{route('user.edit', $user->id)}}" class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300">
                                Editar
                            </a>
                           {{--  <button class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                                Show
                            </button> --}}
                            <button wire:click='delete({{$user->id}})' wire:confirm='Está seguro de eliminar al usuario?' class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300">
                                Eliminar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
                <div class="mt-4">
                {{ $users->links() }}
                </div>
                @else
                <div class="flex items-center justify-center h-40">
                    <h2>No se encontraron elementos</h2>
                </div>
                @endif
            </div>
        </div>
</div>
