<button wire:click="downloadPdf({{ $id }})" wire:loading.attr="disabled" wire:target="downloadPdf({{ $id }})"
    class="relative cursor-pointer px-3 py-2 btn-primary btn-table transition-all flex items-center justify-center gap-2 disabled:opacity-50"
    >
    {{-- 1. EL TEXTO (Nunca se va, solo se hace invisible) --}}
    {{-- wire:loading.class="opacity-0" agrega la clase cuando carga --}}
    <span wire:target="downloadPdf({{ $id }})" wire:loading.class="opacity-0" class="transition-opacity duration-200">
        Descargar PDF
    </span>

    {{-- 2. EL LOADER (Absoluto y centrado) --}}
    {{-- wire:loading.flex lo hace visible --}}
    <span wire:target="downloadPdf({{ $id }})" wire:loading.flex
        class="absolute inset-0 items-center justify-center hidden">
        <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
            </path>
        </svg>
    </span>
</button>
