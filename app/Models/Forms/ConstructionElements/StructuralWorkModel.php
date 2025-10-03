<?php

namespace App\Models\Forms\ConstructionElements;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
// Asegúrate de importar la clase del modelo padre
use App\Models\Forms\ConstructionElements\ConstructionElementModel;

class StructuralWorkModel extends Model
{

    protected $table = 'structural_work';

    protected $fillable = [
        // La clave foránea DEBE ser 'construction_element_id' para que la relación funcione por convención
        'construction_element_id',

        'structure',
        'shallow_fundation',
        'intermeediate_floor',
        'ceiling',
        'walls',
        'beams_columns',
        'roof',
        'fences'
    ];

    // ... (restos de las propiedades)

    /**
     * Define la relación con el elemento de construcción padre (ConstructionElementModel).
     */
    public function constructionElement() // <-- Nombre corregido
    {
        // El método belongsTo infiere la clave foránea 'construction_element_id'
        return $this->belongsTo(ConstructionElementModel::class, 'construction_elements_id');
    }
}
