<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PersonasSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $faker = Faker::create('es_ES');
        
        // Catálogo de apellidos españoles comunes
        $apellidos = [
            'García', 'Martínez', 'López', 'Hernández', 'González', 'Pérez', 'Sánchez', 'Castillo',
            'Moreno', 'Jiménez', 'Díaz', 'Rodríguez', 'Ramos', 'Navarro', 'Fernández', 'Domínguez',
            'Romero', 'Velasco', 'Ríos', 'Ruiz', 'Medina', 'Herrera', 'Castro', 'Vargas',
            'Flores', 'Carrillo', 'Guzmán', 'Murillo', 'Campos', 'Rojas', 'Aguirre', 'Molina'
        ];

        // Catálogo de nombres españoles comunes
        $nombres = [
            'Juan', 'María', 'Carlos', 'Rosa', 'José', 'Ana', 'Pedro', 'Carmen', 'Luis', 'Isabel',
            'Miguel', 'Teresa', 'Francisco', 'Francisca', 'Fernando', 'Mercedes', 'Antonio', 'Beatriz',
            'Javier', 'Patricia', 'Salvador', 'Mariana', 'Alfonso', 'Soledad', 'Enrique', 'Josefina',
            'Eduardo', 'Dolores', 'Ramón', 'Lupita', 'Alfredo', 'Magdalena', 'Vicente', 'Consuelo',
            'Sergio', 'Rocío', 'Diego', 'Gloria', 'Andrés', 'Esperanza', 'Roberto', 'Lucía'
        ];

        // Generar 24 personas
        for ($i = 0; $i < 24; $i++) {
            $apellido1 = $apellidos[array_rand($apellidos)];
            $apellido2 = $apellidos[array_rand($apellidos)];
            $nombre = $nombres[array_rand($nombres)];
            
            $apellido = $apellido1 . ' ' . $apellido2;
            
            // Generar DNI único
            $dni = str_pad(rand(10000000, 99999999), 8, '0', STR_PAD_LEFT) . chr(rand(65, 90));
            
            // Verificar si ya existe
            if (! DB::table('personas')->where('dni', $dni)->exists()) {
                DB::table('personas')->insert([
                    'id' => (string) Str::uuid(),
                    'apellido' => $apellido,
                    'nombres' => $nombre,
                    'dni' => $dni,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
