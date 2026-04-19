<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProcesoUnidadResponsable extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proceso_unidad_responsable';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id',
        'proceso_id',
        'unidad_responsable_id',
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
    public function proceso()
    {
        return $this->belongsTo(Proceso::class, 'proceso_id');
    }

    public function unidadResponsable()
    {
        return $this->belongsTo(UnidadResponsable::class, 'unidad_responsable_id');
    }
}
