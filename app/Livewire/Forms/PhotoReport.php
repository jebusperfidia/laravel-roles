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
        'Proyecto arquitectónico / croquis',
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
        // 1. Verificamos si realmente hay archivos
        if (empty($this->newPhotos)) return;

        $filesToProcess = is_array($this->newPhotos) ? $this->newPhotos : [$this->newPhotos];
        $validFiles = [];
        $errorsCount = 0;

        foreach ($filesToProcess as $file) {
            // 2. Validar archivo individualmente
            $validator = Validator::make(
                ['file' => $file],
                ['file' => 'mimes:jpg,jpeg,png,pdf|max:5120'], // 5MB
                [
                    'file.mimes' => "El archivo '{$file->getClientOriginalName()}' no es un formato válido.",
                    'file.max' => "El archivo '{$file->getClientOriginalName()}' supera los 5MB."
                ]
            );

            if ($validator->fails()) {
                // Si falla, avisamos con Toaster y pasamos al siguiente
                Toaster::error($validator->errors()->first());
                $errorsCount++;
                continue;
            }

            $validFiles[] = $file;
        }

        // 3. Procesar solo los archivos que pasaron la prueba
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

        // --- Lógica de inserción en DB (Misma que ya tenías) ---
        $currentPhotos = PhotoReportModel::where('valuation_id', $this->valuation->id)
            ->orderBy('sort_order', 'asc')
            ->get();

        // Insertar IMÁGENES
        $startingIndex = -count($imagesToUpload);
        foreach ($imagesToUpload as $index => $photo) {
            $path = $photo->store('valuation-photos', 'public');
            PhotoReportModel::create([
                'valuation_id' => $this->valuation->id,
                'file_path' => $path,
                'file_name' => $photo->getClientOriginalName(),
                'rotation_angle' => 0,
                'sort_order' => $startingIndex + $index,
                'is_printable' => true,
            ]);
        }

        // Insertar PDFs
        $maxOrder = $currentPhotos->max('sort_order') ?? 0;
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

        $this->reindexPhotos();
        $this->newPhotos = []; // Limpiamos el input
        $this->refreshPhotosData();

        // Mensaje final de éxito
        $successCount = count($validFiles);
        Toaster::success("Se cargaron $successCount archivo(s) correctamente.");
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

    public function render()
    {
        return view('livewire.forms.photo-report', [
            'photos' => PhotoReportModel::where('valuation_id', $this->valuation->id)
                ->orderBy('sort_order', 'asc')
                ->get()
        ]);
    }
}
