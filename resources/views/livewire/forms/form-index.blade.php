<div>
    <div>
        <a wire:click="backMain" class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                   Regresar al menú principal
       </a>
    </div>
    <br>
    <flux:heading size="xl" level="1">{{ __('Información general') }}</flux:heading>
    {{-- <flux:subheading size="lg" class="mb-6">{{ ('Información General') }}</flux:subheading> --}}
    <flux:separator variant="subtle" />
   {{--  <h2>Valor de la valoración: {{ $valuation }}</h2> --}}
    <div>
           <h2>Prueba</h2>
           <h3>{{$id}}</h3>
    </div>

</div>
