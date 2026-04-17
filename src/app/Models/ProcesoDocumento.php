<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProcesoDocumento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proceso_documento';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'proceso_id',
        'tipo_proceso_documento_id',
        'descripcion',
        'nombre_archivo',
        'ruta_almacenamiento',
        'tipo_mime',
        'extension',
        'tamanio_bytes',
        'hash_archivo',
        'storage_disk',
        'bucket',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'array',
    ];

    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function tipoDocumento()
    {
        return $this->belongsTo(TipoProcesoDocumento::class, 'tipo_proceso_documento_id');
    }

    public function getTamanioFormateadoAttribute()
    {
        $bytes = $this->tamanio_bytes;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        }
        if ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        }
        return $bytes . ' B';
    }
}
