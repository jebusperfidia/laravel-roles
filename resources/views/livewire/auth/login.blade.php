<div class="flex flex-col gap-6 text-black">
    <x-auth-header :title="'ESTUDIO ÁLAMO'" :description="'ARQUITECTURA + VALUACIÓN'" />

    <!-- Session Status -->
    <x-auth-session-status class="text-center" :status="session('status')" />

    <form wire:submit="login" class="flex flex-col gap-6">
        <!-- Email Address -->
        <div class="relative mb-2">

            {{-- <flux:input wire:model='email' label="Email" type="email" placeholder="Ingrese su correo"
           class="border-2 border-gray-300 text-black mt-2 rounded-lg  box-border"
           /> --}}
           {{-- El label en el input flux queda vacio, sin el no se muestran los mensajes de validación --}}
            {{-- <label for="email" class="mb-2">Email</label> --}}
            <flux:input wire:model='email' label="Email" type="email" placeholder="Ingrese su correo"
                class="text-black mt-2 rounded-lg box-border border border-gray-300 label-input-custom
                {{ $errors->has('email') ? 'border-white' : '' }}" />
        </div>
        {{-- <label for="email" class="mb-2">Email</label>
        <flux:input
                wire:model="email"
                placeholder="Ingrese su email"
                type="email"
                required
                autofocus
                class="border-2 border-gray-300 text-black mt-2"/> --}}
        <!-- Password -->
        <div class="relative mb-2">
            {{-- <label for="password" class="mb-2">Password</label>
            <flux:input wire:model="password" autofocus placeholder="Ingrese su password" type="password" required
                class="border-2 border-gray-300 text-black mt-2" /> --}}
                {{-- El label en el input flux queda vacio, sin el no se muestran los mensajes de validación --}}
             {{-- <label for="password" class="mb-2">Password</label> --}}
              <flux:input wire:model='password' type="password" label="Password" placeholder="Ingrese su password"
                class="text-black mt-2 rounded-lg box-border border border-gray-300 show-icon-custom
                {{ $errors->has('password') ? 'border-white' : '' }}" viewable
                 />
                @if (Route::has('password.request'))
                    {{-- <flux:link class="end-0 top-0 -pb-2 text-sm text-black password-link-custom" --}}
                    <flux:link class="absolute end-0 top-0 -pb-2 text-sm text-black password-link-custom"
                    :href="route('password.request')" wire:navigate>
                    {{ __('¿Olvidaste tu contraseña?') }}
                </flux:link>
               @endif
        </div>

        <!-- Remember Me -->
        {{--  <flux:checkbox wire:model="remember" :label="('Recordar datos')" class="border-2" /> --}}

        <div class="flex items-center justify-end mt-6">
            <flux:button variant="primary" type="submit" class="w-full btn-primary cursor-pointer"
                onclick="this.blur();">
                {{ 'Iniciar sesión' }}</flux:button>
        </div>
    </form>

    {{--  @if (Route::has('register'))
        <div class="space-x-1 rtl:space-x-reverse text-center text-sm text-zinc-600 dark:text-zinc-400">
            <span>{{ __('Don\'t have an account?') }}</span>
            <flux:link :href="route('register')" wire:navigate>{{ __('Sign up') }}</flux:link>
        </div>
    @endif --}}
</div>
