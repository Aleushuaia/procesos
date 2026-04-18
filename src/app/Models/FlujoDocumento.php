<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class FlujoDocumento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'flujo_documento';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id',
        'flujo_id',
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
        'metadata' => 'json',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    // Relaciones
    public function flujo()
    {
        return $this->belongsTo(Flujo::class, 'flujo_id');
    }

    // Accessor para tamaño formateado
    public function getTamanioFormateadoAttribute()
    {
        $bytes = $this->tamanio_bytes;
        $units = ['B', 'KB', 'MB', 'GB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }
}
