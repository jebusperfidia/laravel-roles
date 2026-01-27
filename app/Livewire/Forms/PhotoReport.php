<?php

namespace App\Livewire\Forms;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Forms\PhotoReport\PhotoReportModel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Masmerise\Toaster\Toaster;
use ZipArchive;
use Flux\Flux;

class PhotoReport extends Component
{
    use WithFileUploads;

    public $valuation;
    public $newPhotos = [];
    public $photosData = [];

    // Categorías para IMÁGENES
    public $photoCategories = [
        'Sin clasificar',
        'Fachada',
        'Fachada posterior',
        'Proyecto arquitectonico / croquis',
        'Estancia comedor',
        'Cocina',
        'Baño',
        'Recámara 1',
        'Recámara 2',
        'Entorno',
        'Interior',
        'Exterior',
        'Documento anexo / evidencia',
    ];

    // NUEVO: Categorías exclusivas para PDFs (Edita estos nombres)
    public $pdfCategories = [
        'Proyecto arquitectónico / croquis',
        'Documento anexo / evidencia',
    ];

    public $previewPhoto = null;

    public function mount($valuation)
    {
        $this->valuation = $valuation;
        $this->refreshPhotosData();
    }

    public function refreshPhotosData()
    {
        $photos = PhotoReportModel::where('valuation_id', $this->valuation->id)
            ->orderBy('sort_order', 'asc')
            ->get();

        $this->photosData = [];
        foreach ($photos as $photo) {
            $this->photosData[$photo->id] = [
                'category' => $photo->category,
                'description' => $photo->description,
                'isPrintable' => (bool) $photo->is_printable,
            ];
        }
    }

    public function reorder($orderedIds)
    {
        foreach ($orderedIds as $index => $id) {
            PhotoReportModel::where('id', $id)->update(['sort_order' => $index + 1]);
        }
        $this->refreshPhotosData();
        Toaster::success('Orden actualizado correctamente');
    }

    public function updatedNewPhotos()
    {
        if (empty($this->newPhotos)) return;

        $filesToProcess = is_array($this->newPhotos) ? $this->newPhotos : [$this->newPhotos];
        $validFiles = [];

        // Validaciones (Igual que antes)
        foreach ($filesToProcess as $file) {
            $validator = Validator::make(
                ['file' => $file],
                ['file' => 'mimes:jpg,jpeg,png,pdf|max:5120'],
                [
                    'file.mimes' => "El archivo '{$file->getClientOriginalName()}' no es un formato válido.",
                    'file.max' => "El archivo '{$file->getClientOriginalName()}' supera los 5MB."
                ]
            );

            if ($validator->fails()) {
                Toaster::error($validator->errors()->first());
                continue;
            }
            $validFiles[] = $file;
        }

        if (empty($validFiles)) {
            $this->newPhotos = [];
            return;
        }

        $imagesToUpload = [];
        $pdfsToUpload = [];

        foreach ($validFiles as $file) {
            $mime = $file->getMimeType();
            if (Str::contains($mime, 'pdf')) {
                $pdfsToUpload[] = $file;
            } else {
                $imagesToUpload[] = $file;
            }
        }

        // --- LÓGICA DE ORDENAMIENTO CAMBIADA ---
        // Objetivo: "Sin clasificar" (Imágenes nuevas) deben quedar ABAJO de los PDFs.

        // 1. Obtenemos el orden máximo actual para empezar a agregar al final
        $maxOrder = PhotoReportModel::where('valuation_id', $this->valuation->id)->max('sort_order') ?? 0;

        // 2. Primero insertamos los PDFs (quedarán arriba de las nuevas imágenes)
        foreach ($pdfsToUpload as $pdf) {
            $path = $pdf->store('valuation-photos', 'public');
            $maxOrder++;
            PhotoReportModel::create([
                'valuation_id' => $this->valuation->id,
                'file_path' => $path,
                'file_name' => $pdf->getClientOriginalName(),
                'rotation_angle' => 0,
                'sort_order' => $maxOrder,
                'is_printable' => true,

            ]);
        }

        // 3. Al final insertamos las IMÁGENES (quedarán al fondo como "Sin clasificar")
        foreach ($imagesToUpload as $photo) {
            $path = $photo->store('valuation-photos', 'public');
            $maxOrder++;
            PhotoReportModel::create([
                'valuation_id' => $this->valuation->id,
                'file_path' => $path,
                'file_name' => $photo->getClientOriginalName(),
                'rotation_angle' => 0,
                'sort_order' => $maxOrder,
                'is_printable' => true,
                'category' => 'Sin clasificar'
            ]);
        }

        $this->organizePhotos();
        $this->newPhotos = [];
        $this->refreshPhotosData();

        $successCount = count($validFiles);
        Toaster::success("Se cargaron $successCount archivo(s).");
    }

    public function openPreview($id)
    {
        $this->previewPhoto = PhotoReportModel::find($id);

        Flux::modal('preview-modal')->show();
    }

    protected function reindexPhotos()
    {
        $allPhotos = PhotoReportModel::where('valuation_id', $this->valuation->id)
            ->orderBy('sort_order', 'asc')
            ->get();

        foreach ($allPhotos as $index => $photo) {
            $photo->update(['sort_order' => $index + 1]);
        }
    }

    public function organizePhotos()
    {
        $photos = PhotoReportModel::where('valuation_id', $this->valuation->id)->get();

        $sortedPhotos = $photos->sort(function ($a, $b) {

            // Función para calcular en qué GRUPO va la foto
            $getGroupWeight = function ($item) {
                $isPdf = Str::endsWith(Str::lower($item->file_path), '.pdf');
                $cat = $item->category ?? 'Sin clasificar';

                // REGLA 3: AL FONDO (PESO 30)
                // Es imagen Y dice "Sin clasificar"
                if (!$isPdf && ($cat === 'Sin clasificar' || empty($cat))) {
                    return 30;
                }

                // REGLA 2: EN MEDIO (PESO 20)
                // Es PDF -O- es una imagen categorizada como "Documento anexo..."
                if ($isPdf || $cat === 'Documento anexo / evidencia') {
                    return 20;
                }

                // REGLA 1: ARRIBA (PESO 10)
                // Cualquier otra imagen clasificada (Fachada, Recámara, etc.)
                // Aquí ya no importa si es Fachada o Cocina, todas valen 10.
                return 10;
            };

            $weightA = $getGroupWeight($a);
            $weightB = $getGroupWeight($b);

            // Si están en grupos diferentes, gana el grupo más ligero (10 antes que 20)
            if ($weightA !== $weightB) {
                return $weightA <=> $weightB;
            }

            // --- AQUÍ ESTÁ EL FIX ---
            // Si están en el MISMO grupo (ej: cambiaste de Cocina a Recámara, ambas son Peso 10),
            // usamos su 'sort_order' actual para NO moverlas de lugar.
            return $a->sort_order <=> $b->sort_order;
        });

        // Guardamos el nuevo orden en la BD
        foreach ($sortedPhotos->values() as $index => $photo) {
            if ($photo->sort_order !== ($index + 1)) {
                $photo->update(['sort_order' => $index + 1]);
            }
        }
    }

    public function updatePhotoField($id, $field)
    {
        $photo = PhotoReportModel::find($id);
        if (!$photo) return;

        $dbColumn = match ($field) {
            'isPrintable' => 'is_printable',
            default => $field
        };

        $photo->update([
            $dbColumn => $this->photosData[$id][$field]
        ]);

        // 2. DETECTAR CAMBIO DE CATEGORÍA
        // Si el usuario cambia la categoría, reordenamos todo para mover la foto a su lugar correcto.
        if ($field === 'category') {
            // Actualizamos el objeto en memoria para que el sort lo detecte bien
            $photo->category = $this->photosData[$id][$field];

            // Disparamos el reordenamiento
            $this->organizePhotos();

            $this->refreshPhotosData(); // Refrescamos la vista
            $this->dispatch('photos-updated'); // Avisamos al frontend

            // Opcional: Si quieres ser muy agresivo, no muestres toaster aquí,
            // porque visualmente la fila "salta" de lugar y eso ya es feedback suficiente.
            Toaster::success('Lista reordenada automáticamente');
            return;
        }

        $msg = match ($field) {
            'category' => 'Categoría actualizada',
            'description' => 'Descripción guardada',
            'isPrintable' => 'Estado de impresión actualizado',
            default => 'Dato actualizado'
        };
        Toaster::success($msg);
    }

    public function rotatePhoto($id)
    {
        $photo = PhotoReportModel::find($id);
        // Doble validación: no rotar PDFs
        if (!$photo || Str::endsWith(Str::lower($photo->file_path), '.pdf')) {
            return;
        }

        $newAngle = ($photo->rotation_angle + 90);
        if ($newAngle >= 360) $newAngle = 0;

        $photo->update(['rotation_angle' => $newAngle]);
        Toaster::success('Imagen girada correctamente');
    }

    public function deletePhoto($id)
    {
        $photo = PhotoReportModel::find($id);
        if ($photo) {
            if (Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }
            $photo->delete();
            unset($this->photosData[$id]);
            $this->reindexPhotos();
            Toaster::error('Archivo eliminado');
        } else {
            Toaster::error('Error al eliminar');
        }
    }



    public function downloadSelected()
    {
        $photos = PhotoReportModel::where('valuation_id', $this->valuation->id)
            ->where('is_printable', true)
            ->get();

        if ($photos->isEmpty()) {
            Toaster::error('No hay archivos marcados para descargar');
            return;
        }

        return $this->generateZip($photos, 'selected_photos');
    }

    public function downloadAll()
    {
        $photos = PhotoReportModel::where('valuation_id', $this->valuation->id)->get();

        if ($photos->isEmpty()) {
            Toaster::error('No hay archivos para descargar');
            return;
        }

        return $this->generateZip($photos, 'all_photos');
    }

    protected function generateZip($photos, $filenamePrefix)
    {
        $zip = new ZipArchive;
        $zipFileName = $filenamePrefix . '_' . $this->valuation->id . '.zip';
        $zipFilePath = storage_path('app/public/' . $zipFileName);

        if ($zip->open($zipFilePath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
            foreach ($photos as $photo) {
                $fullPath = Storage::disk('public')->path($photo->file_path);

                if (file_exists($fullPath)) {
                    // Agregamos al ZIP con su nombre original
                    $zip->addFile($fullPath, $photo->file_name);
                }
            }
            $zip->close();
        }

        Toaster::success('Iniciando descarga del ZIP');
        return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }


    public function nextComponent()
    {
        /* Toaster::success('Formulario guardado con éxito'); */
        return redirect()->route('form.index', ['section' => 'pre-appraisal-considerations']);
    }


    public function deleteAllPhotos()
    {
        // 1. Obtenemos todas las fotos de este avalúo
        $photos = PhotoReportModel::where('valuation_id', $this->valuation->id)->get();

        if ($photos->isEmpty()) {
            Toaster::error('No hay archivos para eliminar');
            return;
        }

        // 2. Borramos los archivos físicos del disco
        foreach ($photos as $photo) {
            if (Storage::disk('public')->exists($photo->file_path)) {
                Storage::disk('public')->delete($photo->file_path);
            }
        }

        // 3. Borramos los registros de la base de datos de un jalón
        PhotoReportModel::where('valuation_id', $this->valuation->id)->delete();

        // 4. Limpiamos las variables locales y re-indexamos (aunque quede vacío)
        $this->photosData = [];
        $this->refreshPhotosData();

        Toaster::error('Archivos eliminados con éxito');
    }




    public function render()
    {
        return view('livewire.forms.photo-report', [
            'photos' => PhotoReportModel::where('valuation_id', $this->valuation->id)
                ->orderBy('sort_order', 'asc')
                ->get()
        ]);
    }
}
