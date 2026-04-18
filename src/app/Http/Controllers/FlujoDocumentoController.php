<?php

namespace App\Http\Controllers;

use App\Models\Flujo;
use App\Models\FlujoDocumento;
use App\Models\Proceso;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FlujoDocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    /**
     * Store a new document for a flujo
     */
    public function store(Request $request, Proceso $proceso, Flujo $flujo)
    {
        // Verificar que el flujo pertenece al proceso
        if ($flujo->proceso_id !== $proceso->id) {
            abort(404);
        }

        $validated = $request->validate([
            'descripcion'  => 'required|string|max:100',
            'archivo'      => 'required|file|mimes:pdf|max:20480', // max 20MB
        ]);

        $file = $request->file('archivo');
        $originalName = $file->getClientOriginalName();
        $extension    = strtolower($file->getClientOriginalExtension());
        $mimeType     = $file->getMimeType();
        $size         = $file->getSize();
        $hash         = hash_file('sha256', $file->getRealPath());

        // Store in MinIO under procesos/{proceso_id}/flujos/{flujo_id}/documentos/
        $storagePath = "procesos/{$proceso->id}/flujos/{$flujo->id}/documentos/" . Str::uuid() . '.' . $extension;

        try {
            Storage::disk('minio')->put($storagePath, file_get_contents($file->getRealPath()));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el archivo: ' . $e->getMessage(),
            ], 500);
        }

        $documento = FlujoDocumento::create([
            'id'                   => (string) Str::uuid(),
            'flujo_id'             => $flujo->id,
            'descripcion'          => $validated['descripcion'],
            'nombre_archivo'       => $originalName,
            'ruta_almacenamiento'  => $storagePath,
            'tipo_mime'            => $mimeType,
            'extension'            => $extension,
            'tamanio_bytes'        => $size,
            'hash_archivo'         => $hash,
            'storage_disk'         => 'minio',
            'bucket'               => config('filesystems.disks.minio.bucket', 'procesos'),
            'metadata'             => [
                'original_name' => $originalName,
                'uploaded_by'   => auth()->id(),
            ],
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'success'   => true,
                'message'   => 'Documento subido correctamente',
                'documento' => [
                    'id'          => $documento->id,
                    'descripcion' => $documento->descripcion,
                    'nombre'      => $documento->nombre_archivo,
                    'tamanio'     => $documento->tamanio_formateado,
                    'extension'   => $documento->extension,
                    'fecha'       => $documento->created_at->format('d/m/Y H:i'),
                ],
            ]);
        }

        return redirect()->route('internal.procesos.flujos.show', [$proceso->id, $flujo->id])
            ->with('success', 'Documento subido correctamente');
    }

    /**
     * Show the document (stream PDF)
     */
    public function show(Proceso $proceso, Flujo $flujo, FlujoDocumento $flujodocumento)
    {
        if ($flujo->proceso_id !== $proceso->id || $flujodocumento->flujo_id !== $flujo->id) {
            abort(404);
        }

        try {
            $exists = Storage::disk('minio')->exists($flujodocumento->ruta_almacenamiento);
            if (!$exists) {
                abort(404, 'Archivo no encontrado');
            }

            $stream = Storage::disk('minio')->readStream($flujodocumento->ruta_almacenamiento);

            return response()->stream(function () use ($stream) {
                fpassthru($stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }
            }, 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . rawurlencode($flujodocumento->nombre_archivo) . '"',
                'Cache-Control'       => 'private, max-age=300',
            ]);
        } catch (\Exception $e) {
            abort(404, 'Error al recuperar el archivo');
        }
    }

    /**
     * Delete a document
     */
    public function destroy(Proceso $proceso, Flujo $flujo, FlujoDocumento $flujodocumento)
    {
        if ($flujo->proceso_id !== $proceso->id || $flujodocumento->flujo_id !== $flujo->id) {
            abort(404);
        }

        try {
            Storage::disk('minio')->delete($flujodocumento->ruta_almacenamiento);
        } catch (\Exception $e) {
            // Log error pero continuar con la eliminación del registro
        }

        $flujodocumento->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Documento eliminado correctamente',
            ]);
        }

        return redirect()->route('internal.procesos.flujos.show', [$proceso->id, $flujo->id])
            ->with('success', 'Documento eliminado correctamente');
    }
}
