<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Persona extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'personas';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id', 'apellido', 'nombres', 'dni'
    ];

    public function tiposActores()
    {
        return $this->belongsToMany(TipoActor::class, 'persona_rol', 'persona_id', 'tipo_actor_id');
    }
}
