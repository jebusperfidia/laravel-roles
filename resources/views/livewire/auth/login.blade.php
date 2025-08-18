<div class="flex flex-col gap-6 text-black">
    <x-auth-header :title="('Accede a tu cuenta de usuario')" :description="('Ingrese su email y password para ingresar')" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div class="relative mb-2">
            <label for="email" class="mb-2">Email</label>
            <flux:input
                wire:model="email"
                placeholder="Ingrese su email"
                {{-- :label="('Email')" --}}
                {{-- label-class="!text-black dark:!text-black" --}}
                type="email"
                required
                autofocus
                class="border-2 border-gray-300 text-black mt-2"
                {{-- input-class="text-black placeholder-gray-400 focus:placeholder-gray-500" --}}
                {{-- viewable --}}
                {{-- placeholder="email@ejemplo.com" --}}
            />
        </div>

        <!-- Password -->
        <div class="relative mb-2">
            <label for="password" class="mb-2">Password</label>
            <flux:input
                wire:model="password"
              {{--   :label="('Password')"
                label-class="!text-black" --}}
                autofocus
                placeholder="Ingrese su password"
                type="password"
                required
                {{-- autocomplete="current-password" --}}
                class="border-2 border-gray-300 text-black mt-2"
                {{-- :placeholder="__('Password')" --}}
                {{-- viewable --}}
            />

            @if (Route::has('password.request'))
                <flux:link class="absolute end-0 top-0 text-sm text-black" :href="route('password.request')" wire:navigate>
                    {{ __('Olvidaste tu contraseña?') }}
                </flux:link>
            @endif
        </div>

        <!-- Remember Me -->
       {{--  <flux:checkbox wire:model="remember" :label="('Recordar datos')" class="border-2" /> --}}

        <div class="flex items-center justify-end mt-6">
            <flux:button variant="primary" type="submit" class="w-full btn-primary cursor-pointer">{{ ('Iniciar sesión') }}</flux:button>
        </div>
    </form>

   {{--  @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Don\'t have an account?') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif --}}
</div>
