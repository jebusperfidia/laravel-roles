 <div class="flex flex-col gap-6">
    <x-auth-header :title="__('Olvidaste tu password')" :description="__('Ingrese su email para restaurar su password')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div class="relative mb-2">
        <label for="email" class="mb-2">Email</label>
        <flux:input
            wire:model="email"
            {{-- :label="__('Email')" --}}
            type="email"
            required
            autofocus
            placeholder="email@ejemplo.com"
            class="border-2 border-gray-300 text-black mt-2"
            {{-- viewable --}}
        />
        </div>
        <flux:button class="w-full btn-primary cursor-pointer" variant="primary" type="submit">{{ __('Enviar enlace de recuperación a su email') }}</flux:button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
        <span>{{ __('Regresar al') }}</span>
        <flux:link class="text-black" :href="route('login')" wire:navigate>{{ __('login') }}</flux:link>
    </div>
</div>
