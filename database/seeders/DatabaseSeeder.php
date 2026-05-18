<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Coche;
use App\Models\Marca;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $marcas = [
            'Toyota' => Marca::firstOrCreate(['nombre' => 'Toyota']),
            'BMW' => Marca::firstOrCreate(['nombre' => 'BMW']),
            'Audi' => Marca::firstOrCreate(['nombre' => 'Audi']),
            'Mercedes' => Marca::firstOrCreate(['nombre' => 'Mercedes']),
        ];

        $coches = [
            [
                'marca_id' => $marcas['Toyota']->id,
                'modelo' => 'Corolla Hybrid',
                'informacion' => 'Compacto hibrido, eficiente y comodo para uso diario.',
                'potencia' => '140',
                'fecha_fabricacion' => '2023-05-10',
                'precio' => 24500,
                'stock' => 4,
            ],
            [
                'marca_id' => $marcas['BMW']->id,
                'modelo' => 'Serie 3',
                'informacion' => 'Berlina deportiva con buen equilibrio entre confort y potencia.',
                'potencia' => '184',
                'fecha_fabricacion' => '2022-09-18',
                'precio' => 38900,
                'stock' => 2,
            ],
            [
                'marca_id' => $marcas['Audi']->id,
                'modelo' => 'A4 Avant',
                'informacion' => 'Familiar premium con gran espacio y acabado cuidado.',
                'potencia' => '204',
                'fecha_fabricacion' => '2021-11-03',
                'precio' => 36500,
                'stock' => 3,
            ],
            [
                'marca_id' => $marcas['Mercedes']->id,
                'modelo' => 'Clase A',
                'informacion' => 'Compacto premium con interior moderno y consumo contenido.',
                'potencia' => '163',
                'fecha_fabricacion' => '2023-02-22',
                'precio' => 32900,
                'stock' => 5,
            ],
        ];

        foreach ($coches as $coche) {
            Coche::updateOrCreate(
                ['modelo' => $coche['modelo'], 'marca_id' => $coche['marca_id']],
                $coche
            );
        }
    }
}
