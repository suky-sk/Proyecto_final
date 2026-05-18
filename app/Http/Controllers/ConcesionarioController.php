<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coche;
use App\Models\Marca;
use Illuminate\Support\Facades\Storage;

class ConcesionarioController extends Controller
{
    public function index(Request $request)
    {
        $query = Coche::query()->with('marca');

        // desplegable del inicio para filtrar por las marcas
        if ($request->filled('marca')) {
            $query->where('marca_id', $request->marca);
        }

        // buscador de texto
        if ($request->filled('modelo')) {
            $query->where('modelo', 'LIKE', '%' . $request->modelo . '%'); // % para filtrar da igual donde este la palabra
        }

        $coches = $query->get();


        foreach ($coches as $coche) {
            $coche->imgs_json = json_encode($this->imagenesDelCoche($coche));
        }

        // forzar la pagian en ester caso el welcome.blade
        return view('welcome', compact('coches'));
    }

    public function show($id)
    {
        $coche = Coche::with('marca')->findOrFail($id);
        $coche->imgs_json = json_encode($this->imagenesDelCoche($coche));

        return view('coches.show', compact('coche'));
    }

    private function imagenesDelCoche(Coche $coche): array
    {
        $carpeta = "Fotos/{$coche->id}";

        if (! Storage::disk('public')->exists($carpeta)) {
            return [];
        }

        $imagenes = array_map('basename', Storage::disk('public')->files($carpeta));
        sort($imagenes, SORT_NATURAL);

        return array_values($imagenes);
    }
}
