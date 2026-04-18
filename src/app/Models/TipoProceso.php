<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TipoProceso extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_procesos';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = ['id', 'descripcion', 'color', 'icono'];

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
        return $this->hasMany(Proceso::class, 'tipos_procesos_id');
    }
}
