<div>
    <flux:heading size="xl" level="1">{{ __('Crear usuario') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Formulario de creación de nuevos usuarios') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>
            <a href={{route('user.index')}} class="cursor-pointer px-3 py-2 text-xs font-medium text-white bg-green-700 rounded-lg hover:bg-green-800 focus:ring-4 focus:outline-none focus:ring-green-300">
                Regresar
            </a>
           <div class="w-150">
            <form wire:submit='save' class="mt-6 space-y-6">
               <flux:input wire:model='name' label="Nombre" placeholder="Nombre" />
               <flux:input wire:model='email' label="Email"  type="email" placeholder="Email" />
               <flux:input wire:model='password' label="Password"  type="password" placeholder="Password" />
               <flux:input wire:model='confirm_password' label="Confirmar password"  type="password" placeholder="Confirmar Password" />
                <flux:button type="submit" variant="primary">Guardar usuario</flux:button>
            </form>
           </div>
    </div>

</div>
