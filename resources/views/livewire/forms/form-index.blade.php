<div>
    <div class="flex justify-between items-start">
        <div class="flex flex-col">
            @if ($valuation)
            <p class="text-base text-gray-800">
                Folio de valuación: <strong>{{ $valuation->folio }}</strong>
            </p>
            <p class="text-xs text-gray-500 mt-1">
                <span class="font-semibold text-gray-400">Ubicación:</span>
                @if($valuation->full_address)
                {{ $valuation->full_address }}
                @else
                <span class="italic text-amber-500">Pendiente de capturar en Información General</span>
                @endif
            </p>
            @else
            <p class="text-red-500">No se encontró folio</p>
            @endif
        </div>

        <a wire:click="backMain"
            wire:confirm="¿Estás seguro de que deseas salir? Se borrarán los datos de la sesión actual."
            class="cursor-pointer btn-deleted mt-1">
            Regresar al menú principal
        </a>
    </div>
    <br>
    <flux:separator />
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
