<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    @include('partials.head')
</head>
@php
    $formSections = [
        ['key' => 'general-info', 'icon' => 'book-open', 'label' => __('Información general')],
        ['key' => 'property-location', 'icon' => 'map-pin', 'label' => __('Localización del inmueble')],
        ['key' => 'nerby-valuations', 'icon' => 'map', 'label' => __('Avalúos cercanos')],
        [
            'key' => 'declarations-warnings',
            'icon' => 'clipboard-document-check',
            'label' => __('Decl, adv y justificaciones'),
        ],
        ['key' => 'urban-features', 'icon' => 'pencil-square', 'label' => __('Características urbanas')],
        ['key' => 'urban-equipment', 'icon' => 'squares-2x2', 'label' => __('Equipamento urbano')],
        ['key' => 'land-details', 'icon' => 'building-office-2', 'label' => __('Terreno')],
        ['key' => 'property-description', 'icon' => 'document-text', 'label' => __('Descripción inmueble')],
        ['key' => 'construction-elements', 'icon' => 'rectangle-stack', 'label' => __('Elementos de construcción')],
        ['key' => 'buildings', 'icon' => 'building-office', 'label' => __('Construcciones')],
        ['key' => 'applicable-surfaces', 'icon' => 'rectangle-group', 'label' => __('Superficies aplicables')],
        ['key' => 'special-installations', 'icon' => 'sparkles', 'label' => __('Instalaciones especiales')],
        ['key' => 'echo-technologies', 'icon' => 'wifi', 'label' => __('Ecotecnologías vivienda')],
        ['key' => 'd-t-c-infonavit', 'icon' => 'banknotes', 'label' => __('D.T.C. Infonavit')],
         [
            'key' => 'pre-conclusion-considerations',
            'icon' => 'printer',
            'label' => __('Cons previas conclusión'),
        ],
        ['key' => 'pre-appraisal-considerations', 'icon' => 'printer', 'label' => __('Cons previas avalúo')],
        ['key' => 'photo-report', 'icon' => 'camera', 'label' => __('Reporte fotográfico')],
        ['key' => 'conclusion', 'icon' => 'document-check', 'label' => __('Conclusión')],
        ['key' => 'finish-capture', 'icon' => 'check-badge', 'label' => __('Finalizar captura')],
      /*   ['key' => 'valuation-report', 'icon' => 'document-text', 'label' => __('Reporte de avalúo')], */
        ['key' => 'pdf-export', 'icon' => 'printer', 'label' => __('Impresión PDF')],

    ];
@endphp

<body class="min-h-screen bg-white dark:bg-zinc-800">
    <x-toaster-hub class="z-50 top-0 right-0 p-8" />
    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            @unless (session()->has('valuation-active-form'))
                <flux:navlist.group :heading="__('Menu')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                        wire:navigate>{{ __('Inicio') }}</flux:navlist.item>
                    @if (auth()->user()->type === 'Administrador')
                        <flux:navlist.item icon="users" :href="route('user.index')"
                            :current="request()->routeIs('user.index')" wire:navigate>{{ __('Usuarios') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="plus" :href="route('valuation.create')"
                            :current="request()->routeIs('valuation.create')" wire:navigate>{{ __('Nuevo avalúo') }}
                        </flux:navlist.item>
                        <flux:navlist.item icon="document-duplicate" :href="route('valuation.duplicate')"
                            :current="request()->routeIs('valuation.duplicate')" wire:navigate>{{ __('Duplicar avalúo') }}
                        </flux:navlist.item>
                    @endif
                    {{-- <flux:navlist.item icon="archive-box" :href="route('valuation.archived')" :current="request()->routeIs('valuation.archived')" wire:navigate>{{ __('Avalúos archivados') }}</flux:navlist.item> --}}
                    <flux:navlist.item icon="chart-bar-square" :href="route('market.data')"
                        :current="request()->routeIs('market.data')" wire:navigate>{{ __('Fichas de mercado') }}
                    </flux:navlist.item>
                </flux:navlist.group>
            @endunless

            @if (session()->has('valuation-active-form'))
                <flux:navlist.group class="grid">
                    @foreach ($formSections as $item)
                        <flux:navlist.item icon="{{ $item['icon'] }}"
                            :href="route('form.index', ['section' => $item['key']])"
                            :current="request()->routeIs('form.index') && request()->get('section') === $item['key']"
                            wire:navigate>
                            {{ $item['label'] }}
                        </flux:navlist.item>
                    @endforeach
                </flux:navlist.group>
            @endif
        </flux:navlist>

        <flux:spacer />



        <!-- Desktop User Menu -->
        <flux:dropdown class="hidden lg:block" position="bottom" align="start">
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />


            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
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
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>{{ 'Ajustes' }}
                    </flux:menu.item>
                </flux:menu.radio.group>

                <flux:menu.separator />

                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                        {{ 'Cerrar sesión' }}
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
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
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
                    <flux:menu.item :href="route('settings.profile')" icon="cog" wire:navigate>
                        {{ __('Settings') }}</flux:menu.item>
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
    <script>
        window.addEventListener('clear-powergrid', () => {
            // Ajusta esta clave al namespace real que usa PowerGrid
            localStorage.removeItem('powergrid-selected-rows');
        });
    </script>
</body>

</html>
