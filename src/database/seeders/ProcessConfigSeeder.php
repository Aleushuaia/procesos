<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CriticidadProceso;
use App\Models\EstadoProceso;
use App\Models\TipoFlujo;
use App\Models\TipoProceso;
use App\Models\TipoActor;
use App\Models\UnidadResponsable;
use App\Models\Persona;
use Illuminate\Support\Str;

class ProcessConfigSeeder extends Seeder
{
    public function run()
    {
        // Crear Criticidades
        CriticidadProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Crítica']);
        CriticidadProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Alta']);
        CriticidadProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Media']);
        CriticidadProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Baja']);

        // Crear Estados
        EstadoProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'En Diseño']);
        EstadoProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Activo']);
        EstadoProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Revisión']);
        EstadoProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Inactivo']);

        // Crear Tipos de Flujos
        TipoFlujo::create(['id' => (string) Str::uuid(), 'descripcion' => 'Secuencial']);
        TipoFlujo::create(['id' => (string) Str::uuid(), 'descripcion' => 'Paralelo']);
        TipoFlujo::create(['id' => (string) Str::uuid(), 'descripcion' => 'Condicional']);
        TipoFlujo::create(['id' => (string) Str::uuid(), 'descripcion' => 'Iterativo']);

        // Crear Tipos de Procesos
        TipoProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Operativo']);
        TipoProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Administrativo']);
        TipoProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Soporte']);
        TipoProceso::create(['id' => (string) Str::uuid(), 'descripcion' => 'Estratégico']);

        // Crear Tipos de Actores (si no existen)
        if (TipoActor::count() === 0) {
            TipoActor::create(['id' => (string) Str::uuid(), 'descripcion' => 'Administrador']);
            TipoActor::create(['id' => (string) Str::uuid(), 'descripcion' => 'Usuario']);
            TipoActor::create(['id' => (string) Str::uuid(), 'descripcion' => 'Supervisor']);
            TipoActor::create(['id' => (string) Str::uuid(), 'descripcion' => 'Auditor']);
        }

        // Crear Unidades Responsables
        UnidadResponsable::create(['id' => (string) Str::uuid(), 'descripcion' => 'Dirección General']);
        UnidadResponsable::create(['id' => (string) Str::uuid(), 'descripcion' => 'Recursos Humanos']);
        UnidadResponsable::create(['id' => (string) Str::uuid(), 'descripcion' => 'Finanzas']);
        UnidadResponsable::create(['id' => (string) Str::uuid(), 'descripcion' => 'Operaciones']);
        UnidadResponsable::create(['id' => (string) Str::uuid(), 'descripcion' => 'Tecnología Información']);

        // Crear Personas
        if (Persona::count() === 0) {
            Persona::create([
                'id' => (string) Str::uuid(),
                'apellido' => 'García',
                'nombres' => 'Juan',
                'dni' => '12345678'
            ]);
            Persona::create([
                'id' => (string) Str::uuid(),
                'apellido' => 'Martínez',
                'nombres' => 'María',
                'dni' => '87654321'
            ]);
            Persona::create([
                'id' => (string) Str::uuid(),
                'apellido' => 'López',
                'nombres' => 'Carlos',
                'dni' => '11111111'
            ]);
            Persona::create([
                'id' => (string) Str::uuid(),
                'apellido' => 'Rodríguez',
                'nombres' => 'Ana',
                'dni' => '22222222'
            ]);
            Persona::create([
                'id' => (string) Str::uuid(),
                'apellido' => 'Fernández',
                'nombres' => 'Roberto',
                'dni' => '33333333'
            ]);
        }
    }
}

