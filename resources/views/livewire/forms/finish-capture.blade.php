<div>
    <div class="form-container">
        {{-- Encabezado --}}
        <div class="form-container__header">
            Finalizar Revisión
        </div>

        <div class="form-container__content">
            {{-- SECCIÓN DE ALERTAS (Solo se muestra si hay problemas) --}}
            @if($landExpiredCount > 0 || $buildingExpiredCount > 0)
            <div class="flex flex-col gap-3">

                {{-- Alerta Terrenos --}}
                @if($landExpiredCount > 0)
                <div class="flex items-start gap-3 text-red-700 bg-red-50 border border-red-200 p-4 rounded-lg">
                    <flux:icon.exclamation-triangle variant="mini" class="mt-0.5 w-5 h-5 text-red-600 shrink-0" />
                    <div class="text-sm">
                        <span class="font-bold block mb-1">Advertencia de Vigencia (Terrenos)</span>
                        Este avalúo cuenta con <b>{{ $landExpiredCount }}</b> comparables de <b>terreno</b> que han
                        superado los 180 días de vigencia.
                    </div>
                </div>
                @endif

                {{-- Alerta Construcciones --}}
                @if($buildingExpiredCount > 0)
                <div class="flex items-start gap-3 text-red-700 bg-red-50 border border-red-200 p-4 rounded-lg">
                    <flux:icon.exclamation-triangle variant="mini" class="mt-0.5 w-5 h-5 text-red-600 shrink-0" />
                    <div class="text-sm">
                        <span class="font-bold block mb-1">Advertencia de Vigencia (Construcción)</span>
                        Este avalúo cuenta con <b>{{ $buildingExpiredCount }}</b> comparables de <b>construcción</b> que
                        han superado los 180 días de vigencia.
                    </div>
                </div>
                @endif
            </div>
            @endif
            {{-- Si no hay alertas, este div queda vacío (solo padding del contenedor) --}}
        </div>
    </div>

    {{-- BOTÓN FUERA DEL CONTENEDOR Y A LA IZQUIERDA --}}
    <div class="mt-4 text-left">
        <flux:button class="cursor-pointer btn-primary min-w-[200px] justify-center" variant="primary"
            wire:click="finalizeValuation"
            wire:confirm="¿Estás seguro de finalizar el avalúo? Una vez enviado a revisión, ya no podrás realizar cambios.">
            Finalizar y enviar a revisión
        </flux:button>
    </div>
</div>
