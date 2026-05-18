<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coche;
use App\Models\Marca;
use Illuminate\Support\Facades\File;

class AdminCocheController extends Controller
{
    public function index()
    {
        $coches = Coche::with('marca')->get();
        $marcas = Marca::all();
        return view('admin.coches.index', compact('coches', 'marcas'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'modelo' => 'required',
            'marca_id' => 'required',
            'potencia' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'fecha_fabricacion' => 'required|date',
            'fotos' => 'required',
        ]);

        $coche = Coche::create([
            'marca_id' => $request->marca_id,
            'modelo' => $request->modelo,
            'potencia' => $request->potencia,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'fecha_fabricacion' => $request->fecha_fabricacion,
            'imagen_path' => '',
        ]);

        $nombreCarpeta = $coche->id;
        $rutaDestino = storage_path('app/public/Fotos/' . $nombreCarpeta);

        if(!File::exists($rutaDestino)) {
            File::makeDirectory($rutaDestino, 0755, true);
        }

        if($request->hasFile('fotos')) {
            $files = $request->file('fotos');
            $contadorOtros = 2;

            foreach($files as $file) {
                if (stripos($file->getClientOriginalName(), 'Delantera') !== false) {
                    $nombreArchivo = "1.png";
                } else {
                    $nombreArchivo = "foto_{$contadorOtros}.jpeg";
                    $contadorOtros++;
                }
                $file->move($rutaDestino, $nombreArchivo);
            }
        }

        $coche->update([
            'imagen_path' => $nombreCarpeta,
        ]);

        return redirect()->route('admin.coches.index')
                         ->with('success', 'Coche creado correctamente.');
    }

public function update(Request $request, $id)
    {
        $request->validate([
            'modelo' => 'required',
            'marca_id' => 'required',
            'potencia' => 'required',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'fecha_fabricacion' => 'nullable|date',
            'fotos' => 'nullable',
            'informacion' => 'nullable|string',
        ]);

        $coche = Coche::findOrFail($id);

        $coche->update([
            'marca_id' => $request->marca_id,
            'modelo' => $request->modelo,
            'potencia' => $request->potencia,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'fecha_fabricacion' => $request->fecha_fabricacion,
            'informacion' => $request->informacion,
        ]);

        // ft
        if ($request->hasFile('fotos')) {
            $nombreCarpeta = $coche->id;
            $rutaDestino = storage_path('app/public/Fotos/' . $nombreCarpeta);

            if(!File::exists($rutaDestino)) {
                File::makeDirectory($rutaDestino, 0755, true);
            }

            $files = $request->file('fotos');
            $contadorOtros = 2;

            foreach($files as $file) {
                if (stripos($file->getClientOriginalName(), 'Delantera') !== false) {
                    $nombreArchivo = "1.png";
                } else {
                    $nombreArchivo = "foto_{$contadorOtros}.jpeg";
                    $contadorOtros++;
                }
                $file->move($rutaDestino, $nombreArchivo);
            }

            $coche->update(['imagen_path' => $nombreCarpeta]);
        }

        return redirect()->route('admin.coches.index')
                         ->with('success', 'Coche actualizado correctamente.');
    }

    public function destroy($id)
    {
        $coche = Coche::findOrFail($id);
        $coche->delete();
        return back()->with('success', 'Coche eliminado del catálogo.');
    }
}