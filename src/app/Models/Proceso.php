<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proceso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'procesos';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'descripcion',
        'observaciones',
        'tipo_proceso_id',
        'estado_proceso_id',
        'criticidad_proceso_id',
        'codigo',
        'objetivo',
        'proceso_padre_id',
        'requiere_revision',
    ];

    // Relaciones
    public function tipoProceso()
    {
        return $this->belongsTo(TipoProceso::class, 'tipo_proceso_id');
    }

    public function estadoProceso()
    {
        return $this->belongsTo(EstadoProceso::class, 'estado_proceso_id');
    }

    public function criticidadProceso()
    {
        return $this->belongsTo(CriticidadProceso::class, 'criticidad_proceso_id');
    }

    public function procesoPadre()
    {
        return $this->belongsTo(Proceso::class, 'proceso_padre_id');
    }

    public function procesosHijos()
    {
        return $this->hasMany(Proceso::class, 'proceso_padre_id');
    }

    public function documentos()
    {
        return $this->hasMany(ProcesoDocumento::class, 'proceso_id')->with('tipoDocumento')->orderBy('created_at', 'desc');
    }

    public function unidadesResponsables()
    {
        return $this->belongsToMany(
            UnidadResponsable::class,
            'proceso_unidad_responsable',
            'proceso_id',
            'unidad_responsable_id'
        )->withTimestamps();
    }

    public function tiposActores()
    {
        return $this->belongsToMany(
            TipoActor::class,
            'proceso_tipo_actor',
            'proceso_id',
            'tipo_actor_id'
        )->withTimestamps();
    }

    // Métodos de acceso
    public function getNombreCompletoAttribute()
    {
        return $this->codigo . ' - ' . $this->descripcion;
    }
}
