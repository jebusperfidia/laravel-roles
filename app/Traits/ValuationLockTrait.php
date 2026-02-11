<?php

namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait ValuationLockTrait
{
    // Variable pública que usarán tus vistas para bloquear inputs y ocultar botones
    public bool $isReadOnly = false;

    /**
     * Verifica si debemos bloquear la edición.
     * Llama a esto al final de tu método mount().
     */
    public function checkReadOnlyStatus($valuation)
    {
        // 1. Obtenemos al usuario
        $user = Auth::user();

        // 2. Definimos las condiciones
        // Ajusta 'role' o 'type' según como se llame tu columna en la BD users
        $isAdmin = $user->type === 'Administrador'; // O $user->type === 'admin', checa tu BD

        // Estatus 2 = Revisión
        $isInReview = $valuation->status === 2;

        // Lógica: Si está en revisión Y NO soy admin -> BLOQUEAR
        if ($isInReview && !$isAdmin) {
            $this->isReadOnly = true;
        }

        // Opcional: Si quieres que el Admin SIEMPRE pueda editar todo,
        // la lógica de arriba ya lo permite porque !$isAdmin sería falso.
    }

    /**
     * Protección de Backend.
     * Llama a esto al inicio de save(), add(), delete(), etc.
     */
    public function ensureNotReadOnly()
    {
        if ($this->isReadOnly) {
            // Detiene la ejecución si alguien intenta pasarse de listo
            abort(403, 'No tienes permisos para editar este avalúo en revisión.');
        }
    }
}
