<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TipoActor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_actores';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = ['id', 'descripcion', 'observaciones'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'persona_rol', 'tipo_actor_id', 'persona_id');
    }
}
