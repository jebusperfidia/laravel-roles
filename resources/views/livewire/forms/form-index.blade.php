<div>
    <div>
        <a wire:click="backMain"
            wire:confirm="¿Estás seguro de que deseas salir? Se borrarán los datos de la sesión actual."
            {{-- <a   onclick="if(confirm('¿Estás seguro de que quieres volver? Se perderán los datos.')){
        Livewire.dispatch('backMain');
        window.location.href = '/';}" --}}
            class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
            Regresar al menú principal
        </a>
    </div>
    <br>
    <flux:heading size="xl" level="1">{{ __('Información general') }}</flux:heading>
    {{-- <flux:subheading size="lg" class="mb-6">{{ ('Información General') }}</flux:subheading> --}}
    <flux:separator variant="subtle" />
    {{--  <h2>Valor de la valoración: {{ $valuation }}</h2> --}}
    {{-- En este div necesito renderizar el componente --}}
    <div>
        {{-- <h2>Prueba</h2>
           <h3>{{$id}}</h3> --}}
        {{--  <livewire:dynamic-component
            :component="'forms.'.$section"
            :key="$section"/> --}}


        @if (!$section)
            <h2 class="text-xl font-semibold">
                Seleccione una de las opciones del menú
            </h2>
        @elseif(in_array($section, $sections))
            <livewire:dynamic-component :component="'forms.' . $section" :key="$section" :valuation="$valuation" />
        @else
            <p class="text-red-600">
                Sección inválida: {{ $section }}
            </p>
        @endif
    </div>

</div>
