<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flujo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'flujos';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'proceso_id',
        'descripcion',
        'observaciones',
        'tipo_flujo_id',
        'fecha_inicio_analisis',
        'fecha_firma_version',
    ];

    protected $casts = [
        'fecha_inicio_analisis' => 'datetime',
        'fecha_firma_version' => 'datetime',
    ];

    // Relaciones
    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function tipoFlujo()
    {
        return $this->belongsTo(TipoFlujo::class, 'tipo_flujo_id');
    }

    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'flujo_persona', 'flujo_id', 'persona_id');
    }

    public function tiposActores()
    {
        return $this->belongsToMany(TipoActor::class, 'flujo_rol', 'flujo_id', 'tipo_actor_id');
    }
}
