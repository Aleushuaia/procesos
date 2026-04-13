<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoActor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_actores';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = ['id', 'descripcion', 'observaciones'];

    public function personas()
    {
        return $this->belongsToMany(Persona::class, 'persona_rol', 'tipo_actor_id', 'persona_id');
    }
}
