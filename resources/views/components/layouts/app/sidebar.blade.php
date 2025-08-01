<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Menu')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Inicio') }}</flux:navlist.item>
                    <flux:navlist.item icon="users" :href="route('user.index')" :current="request()->routeIs('user.index')" wire:navigate>{{ __('Usuarios') }}</flux:navlist.item>
                    <flux:navlist.item icon="plus" :href="route('valuation.create')" :current="request()->routeIs('valuation.create')" wire:navigate>{{ __('Nuevo avalúo') }}</flux:navlist.item>
                    <flux:navlist.item icon="document-duplicate" :href="route('valuation.duplicate')" :current="request()->routeIs('valuation.duplicate')" wire:navigate>{{ __('Duplicar avalúo') }}</flux:navlist.item>
                    <flux:navlist.item icon="archive-box" :href="route('valuation.archived')" :current="request()->routeIs('valuation.archived')" wire:navigate>{{ __('Avalúos archivados') }}</flux:navlist.item>
                    <flux:navlist.item icon="chart-bar-square" :href="route('market.data')" :current="request()->routeIs('market.data')" wire:navigate>{{ __('Fichas de mercado') }}</flux:navlist.item>
                </flux:navlist.group>
               {{--   <flux:navlist.group heading="Avaluos" expandable :expanded="false">
                    <flux:navlist.item icon="plus" href="#">Nuevo avalúo</flux:navlist.item>
                    <flux:navlist.item icon="document-duplicate" href="#">Duplicar avalúos</flux:navlist.item>
                    <flux:navlist.item icon="archive-box" href="#">Avalúos archivados</flux:navlist.item>
                    <flux:navlist.item icon="presentation-chart-bar" href="#">Fichas de mercado</flux:navlist.item>
                </flux:navlist.group> --}}
                {{-- <flux:navlist.group class="grid">
                    <flux:navlist.item icon="book-open" :href="route('dashboard')" :current="request()->routeIs('#')" wire:navigate>{{ __('Informacion general') }}</flux:navlist.item>
                    <flux:navlist.item icon="map-pin" :href="route('dashboard')" :current="request()->routeIs('#')" wire:navigate>{{ __('Localización del inmueble') }}</flux:navlist.item>
                    <flux:navlist.item icon="map" :href="route('dashboard')" :current="request()->routeIs('#')" wire:navigate>{{ __('Avaluos cercanos') }}</flux:navlist.item>
                    <flux:navlist.item icon="clipboard-document-check" :href="route('dashboard')" :current="request()->routeIs('#')" wire:navigate>{{ __('Decl, adv y justificaciones') }}</flux:navlist.item>
                    <flux:navlist.item icon="table-cells" :href="route('dashboard')" :current="request()->routeIs('#')" wire:navigate>{{ __('Características urbanas') }}</flux:navlist.item>
                    <flux:navlist.item icon="archive-box" :href="route('dashboard')" :current="request()->routeIs('#')" wire:navigate>{{ __('Equipamento urbano') }}</flux:navlist.item>
                    <flux:navlist.item icon="building-office-2" :href="route('dashboard')" :current="request()->routeIs('#')" wire:navigate>{{ __('Terreno') }}</flux:navlist.item>
                    <flux:navlist.item icon="document-text" :href="route('dashboard')" :current="request()->routeIs('#')" wire:navigate>{{ __('Descripción inmueble') }}</flux:navlist.item>
                    <flux:navlist.item icon="camera" :href="route('dashboard')" :current="request()->routeIs('#')" wire:navigate>{{ __('Reporte fotográfico') }}</flux:navlist.item>
                    <flux:navlist.item icon="printer" :href="route('dashboard')" :current="request()->routeIs('#')" wire:navigate>{{ __('Impresión PDF') }}</flux:navlist.item>
                </flux:navlist.group> --}}
            </flux:navlist>

            <flux:spacer />

          {{--   <flux:navlist variant="outline">
                <flux:navlist.item icon="folder-git-2" href="https://github.com/laravel/livewire-starter-kit" target="_blank">
                {{ __('Repository') }}
                </flux:navlist.item>

                <flux:navlist.item icon="book-open-text" href="https://laravel.com/docs/starter-kits#livewire" target="_blank">
                {{ __('Documentation') }}
                </flux:navlist.item>
            </flux:navlist> --}}

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ ('Ajustes') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ ('Cerrar sesión') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        @fluxScripts
    </body>
</html>
