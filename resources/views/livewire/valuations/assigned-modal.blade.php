<div>
    @if ($showModalAssign)
    <div x-data="{ show: true }" x-show="show" x-transition.opacity.duration.200ms
        class="fixed inset-0 z-50 bg-slate-900/30 flex justify-center items-center p-4">
        <div x-show="show" x-transition:enter="ease-out duration-200" x-transition:enter-start="opacity-0 scale-90"
            x-transition:enter-end="opacity-100 scale-100" x-transition:leave="ease-in duration-150"
            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-90"
            class="bg-white rounded-lg shadow-2xl p-6 w-full max-w-sm">
            <h2 class="text-xl font-bold text-gray-800 mb-4">Asignar
                {{ $type === 'massive' ? 'Masivamente' : 'Individualmente' }}
            </h2>

            <flux:select wire:model="appraiser">
                <flux:select.option value="">-- Selecciona un perito --</flux:select.option>
                @foreach ($users as $user)
                <flux:select.option value="{{ $user->id }}">
                    {{ $user->name }}
                </flux:select.option>
                @endforeach
            </flux:select>
            @error('appraiser')
            <div role="alert" class="text-sm text-red-600 mt-2">
                {{ $message }}
            </div>
            @enderror

            <br>

            <flux:select wire:model="operator">
                <flux:select.option value="operator">-- Selecciona un operador --</flux:select.option>
                @foreach ($users as $user)
                <flux:select.option value="{{ $user->id }}">
                    {{ $user->name }}
                </flux:select.option>
                @endforeach
            </flux:select>
            @error('operator')
            <div role="alert" class="text-sm text-red-600 mt-2">
                {{ $message }}
            </div>
            @enderror

            <br>

            <div class="flex justify-end gap-2 mt-6">
                <button wire:click="saveAssign" class="cursor-pointer btn-primary btn-table">
                    Guardar
                </button>
                <button wire:click="closeModalAssign" class="cursor-pointer btn-deleted btn-table">
                    Cancelar
                </button>
            </div>
        </div>
    </div>
    @endif
</div>
