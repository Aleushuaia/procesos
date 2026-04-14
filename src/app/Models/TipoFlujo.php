<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class TipoFlujo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'tipos_flujos';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = ['id', 'descripcion'];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (!$model->id) {
                $model->id = (string) Str::uuid();
            }
        });
    }

    public function flujos()
    {
        return $this->hasMany(Flujo::class, 'tipos_flujos_procesos_id');
    }
}
