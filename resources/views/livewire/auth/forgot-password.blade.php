 <div class="flex flex-col gap-6">
    <x-auth-header :title="__('Olvidaste tu password')" :description="__('Ingrese su email para restaurar su password')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="sendPasswordResetLink" class="flex flex-col gap-6">
        <!-- Email Address -->
        <flux:input
            wire:model="email"
            :label="__('Email')"
            type="email"
            required
            autofocus
            placeholder="email@ejemplo.com"
        />

        <flux:button variant="primary" type="submit" class="w-full">{{ __('Enviar enlace de recuperación a su email') }}</flux:button>
    </form>

    <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-400">
        <span>{{ __('Regresar al') }}</span>
        <flux:link :href="route('login')" wire:navigate>{{ __('login') }}</flux:link>
    </div>
</div>
