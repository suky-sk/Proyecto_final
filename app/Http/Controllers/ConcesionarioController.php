<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coche;
use App\Models\Marca;
class ConcesionarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Coche::query()->with('marca');

        // desplegable del inicio para filtrar por las marcas
        if ($request->filled('marca')) {
            $query->where('marca_id', $request->marca);
        }

        // filtro por rango de precio
        if ($request->filled('precio')) {
            switch ($request->precio) {
                case '0-15000':
                    $query->whereBetween('precio', [0, 15000]);
                    break;
                case '15000-30000':
                    $query->whereBetween('precio', [15000, 30000]);
                    break;
                case '30000-50000':
                    $query->whereBetween('precio', [30000, 50000]);
                    break;
                case '50000+':
                    $query->where('precio', '>=', 50000);
                    break;
            }
        }

        // buscador de texto (buscar por modelo o por nombre de marca)
        if ($request->filled('modelo')) {
            $term = $request->modelo;
            $query->where(function($q) use ($term) {
                $q->where('modelo', 'LIKE', '%' . $term . '%')
                  ->orWhereHas('marca', function($q2) use ($term) {
                      $q2->where('nombre', 'LIKE', '%' . $term . '%');
                  });
            });
        }

        $coches = $query->get();
        $marcas = Marca::all();


        foreach ($coches as $coche) {
            $coche->imgs_json = json_encode($this->imagenesDelCoche($coche));
        }

        // forzar la pagian en ester caso el welcome.blade
        return view('welcome', compact('coches', 'marcas'));
    }

    public function show($id)
    {
        $coche = Coche::with('marca')->findOrFail($id);
        $coche->imgs_json = json_encode($this->imagenesDelCoche($coche));

        return view('coches.show', compact('coche'));
    }

    private function imagenesDelCoche(Coche $coche): array
    {
        $carpeta = public_path("images/Fotos/{$coche->id}");

        if (! file_exists($carpeta) || ! is_dir($carpeta)) {
            return [];
        }

        $archivos = scandir($carpeta);
        $imagenes = array_filter($archivos, function ($archivo) use ($carpeta) {
            return $archivo !== '.' && $archivo !== '..' && is_file($carpeta . DIRECTORY_SEPARATOR . $archivo);
        });

        sort($imagenes, SORT_NATURAL);

        return array_values($imagenes);
    }
}
