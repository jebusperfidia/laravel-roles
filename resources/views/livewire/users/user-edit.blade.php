<div>
    <flux:heading size="xl" level="1">{{ __('Editar usuario') }}</flux:heading>
    <flux:subheading size="lg" class="mb-6">{{ __('Edición de datos del usuario') }}</flux:subheading>
    <flux:separator variant="subtle" />

    <div>
        <flux:button class="btn-intermediary mb-6" href="{{ route('user.index') }}" variant="primary">Regresar</flux:button>
        <div class="w-150">
            <form wire:submit='save' class="mt-6 space-y-6">
                <flux:field class="flux-field">
                    <flux:label>Nombre</flux:label>
                    <flux:input type="text" wire:model='name' placeholder="Nombre" />
                    <div class="error-container">
                        <flux:error name="name" />
                    </div>
                </flux:field>
                <flux:field class="flux-field">
                    <flux:label>Email</flux:label>
                    <flux:input type="email" wire:model='email' placeholder="Email" />
                    <div class="error-container">
                        <flux:error name="email" />
                    </div>
                </flux:field>
                <flux:field class="flux-field">
                    <flux:label>Tipo de usuario</flux:label>
                    <flux:select wire:model="type" class=" text-gray-800 [&_option]:text-gray-900">
                        <flux:select.option value="">-- Selecciona una opción --</flux:select.option>
                        <flux:select.option value="Administrador">Administrador</flux:select.option>
                        <flux:select.option value="Operador">Operador</flux:select.option>
                    </flux:select>
                    <div class="error-container">
                        <flux:error name="type" />
                    </div>
                </flux:field>
                <flux:field class="flux-field">
                    <flux:label>Password</flux:label>
                    <flux:input type="password" wire:model='password' placeholder="Password" />
                    <div class="error-container">
                        <flux:error name="password" />
                    </div>
                </flux:field>
                <flux:field class="flux-field">
                    <flux:label>Confirmar password</flux:label>
                    <flux:input type="password" wire:model='confirm_password' placeholder="Confirmar password" />
                    <div class="error-container">
                        <flux:error name="confirm_password" />
                    </div>
                </flux:field>
                <flux:button class="mt-10 cursor-pointer btn-primary" type="submit" variant="primary">Guardar cambios</flux:button>
            </form>
        </div>
    </div>

</div>
