<?php

namespace App\Http\Controllers;

use App\Models\Proceso;
use App\Models\ProcesoDocumento;
use App\Models\TipoProcesoDocumento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcesoDocumentoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:Administrador|administrador|admin']);
    }

    /**
     * Upload and store a new document for a proceso
     */
    public function store(Request $request, Proceso $proceso)
    {
        $validated = $request->validate([
            'descripcion'              => 'required|string|max:100',
            'tipo_proceso_documento_id' => 'required|exists:tipos_procesos_documentos,id',
            'archivo'                  => 'required|file|mimes:pdf|max:20480', // max 20MB
        ]);

        $file = $request->file('archivo');
        $originalName = $file->getClientOriginalName();
        $extension    = strtolower($file->getClientOriginalExtension());
        $mimeType     = $file->getMimeType();
        $size         = $file->getSize();
        $hash         = hash_file('sha256', $file->getRealPath());

        // Store in MinIO under procesos/{proceso_id}/documentos/
        $storagePath = "procesos/{$proceso->id}/documentos/" . Str::uuid() . '.' . $extension;

        try {
            Storage::disk('minio')->put($storagePath, file_get_contents($file->getRealPath()));
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al subir el archivo al almacenamiento: ' . $e->getMessage(),
            ], 500);
        }

        $documento = ProcesoDocumento::create([
            'id'                        => (string) Str::uuid(),
            'proceso_id'                => $proceso->id,
            'tipo_proceso_documento_id' => $validated['tipo_proceso_documento_id'],
            'descripcion'               => $validated['descripcion'],
            'nombre_archivo'            => $originalName,
            'ruta_almacenamiento'       => $storagePath,
            'tipo_mime'                 => $mimeType,
            'extension'                 => $extension,
            'tamanio_bytes'             => $size,
            'hash_archivo'              => $hash,
            'storage_disk'              => 'minio',
            'bucket'                    => config('filesystems.disks.minio.bucket', 'procesos'),
            'metadata'                  => [
                'original_name' => $originalName,
                'uploaded_by'   => auth()->id(),
            ],
        ]);

        $documento->load('tipoDocumento');

        return response()->json([
            'success'  => true,
            'message'  => 'Documento subido correctamente',
            'documento' => [
                'id'           => $documento->id,
                'descripcion'  => $documento->descripcion,
                'tipo'         => $documento->tipoDocumento->descripcion ?? '-',
                'nombre'       => $documento->nombre_archivo,
                'tamanio'      => $documento->tamanio_formateado,
                'extension'    => $documento->extension,
                'fecha'        => $documento->created_at->format('d/m/Y H:i'),
            ],
        ]);
    }

    /**
     * Stream the PDF document directly to the browser
     */
    public function show(Proceso $proceso, ProcesoDocumento $documento)
    {
        if ($documento->proceso_id !== $proceso->id) {
            abort(404);
        }

        try {
            $exists = \Illuminate\Support\Facades\Storage::disk('minio')->exists($documento->ruta_almacenamiento);
            if (!$exists) {
                abort(404, 'Archivo no encontrado en el almacenamiento');
            }

            $stream = \Illuminate\Support\Facades\Storage::disk('minio')
                ->readStream($documento->ruta_almacenamiento);

            return response()->stream(function () use ($stream) {
                fpassthru($stream);
                if (is_resource($stream)) {
                    fclose($stream);
                }
            }, 200, [
                'Content-Type'        => 'application/pdf',
                'Content-Disposition' => 'inline; filename="' . rawurlencode($documento->nombre_archivo) . '"',
                'Cache-Control'       => 'private, max-age=300',
                'X-Content-Type-Options' => 'nosniff',
            ]);
        } catch (\Exception $e) {
            abort(404, 'Error al recuperar el archivo: ' . $e->getMessage());
        }
    }

    /**
     * Delete a document from storage and DB
     */
    public function destroy(Proceso $proceso, ProcesoDocumento $documento)
    {
        if ($documento->proceso_id !== $proceso->id) {
            abort(404);
        }

        // Remove from MinIO
        try {
            Storage::disk('minio')->delete($documento->ruta_almacenamiento);
        } catch (\Exception $e) {
            // Log but don't block deletion
        }

        $documento->delete();

        return response()->json([
            'success' => true,
            'message' => 'Documento eliminado correctamente',
        ]);
    }
}
