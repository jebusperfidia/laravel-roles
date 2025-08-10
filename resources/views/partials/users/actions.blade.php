<div class="flex space-x-1">
    <a
        href="{{ route('user.edit', $user->id) }}"
        class="px-3 py-2 text-xs font-medium text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300"
    >
        Editar
    </a>

    <button
        wire:click="delete({{ $user->id }})"
        wire:confirm="'¿Está seguro de eliminar al usuario?'"
        class="px-3 py-2 text-xs font-medium text-white bg-red-700 rounded-lg hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300"
    >
        Eliminar
    </button>
</div>
