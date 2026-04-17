<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoProcesoDocumento extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_procesos_documentos';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'descripcion'];

    public function documentos()
    {
        return $this->hasMany(ProcesoDocumento::class, 'tipo_proceso_documento_id');
    }
}
