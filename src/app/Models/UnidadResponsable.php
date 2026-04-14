<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class UnidadResponsable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'unidades_responsables';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = ['id', 'descripcion', 'unidad_madre_id'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function procesos()
    {
        return $this->hasMany(Proceso::class, 'unidades_responsables_id');
    }

    public function personasAsignadas()
    {
        return $this->belongsToMany(Persona::class, 'proceso_unidad_responsable', 'unidades_responsables_id', 'persona_id');
    }
}
