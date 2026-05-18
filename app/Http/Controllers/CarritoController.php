<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Coche;
use Illuminate\Support\Facades\Auth;

class CarritoController extends Controller
{
    public function add(Request $request, $id)
    {
        $coche = Coche::with('marca')->findOrFail($id);
        $carrito = session()->get('carrito', []);

        // si la sesion se ha iniciado se suma al carrito
        if(isset($carrito[$id])) {
            $carrito[$id]['cantidad']++;
        } else {
            // si es nuevo se guarda los datos de la sesion
            $carrito[$id] = [
                "modelo" => $coche->modelo,
                "marca" => $coche->marca->nombre,
                "precio" => $coche->precio,
                "cantidad" => 1,
                "imagen_path" => $coche->imagen_path
            ];
        }

        session()->put('carrito', $carrito);

        // al darle al boton para meterlo en la cesta la pagina se queda igual pero el coche esta en la cesta,
        //esto permite seguir navegando por la web y ya pues cuando quieras comprarlo ves a la cesta
        return redirect()->back();
    }

    public function finalizarCompra()
    {
        $user = Auth::user();
        $carrito = session()->get('carrito');

        if (!$carrito) {
            return back()->with('error', 'El carrito está vacío.');
        }

        foreach ($carrito as $id => $detalles) { /*recorremos ids*/
            $coche = Coche::find($id);

            // valida el stock
            if ($coche->stock < $detalles['cantidad']) {
                return back()->with('error', "Lo sentimos, ya no queda stock de {$coche->modelo}.");
            }

            // restar el stock
            $coche->decrement('stock', $detalles['cantidad']);

            // guardamos en la pivot la compra
            $user->coches()->attach($id, ['cantidad' => $detalles['cantidad']]);
        }

        // limpia la pagina
        session()->forget('carrito');

        return redirect()->route('home')->with('success', '¡Compra confirmada! Los datos se han guardado en tu historial.');
    }

    public function remove($id)
    {
        $carrito = session()->get('carrito');

        if(isset($carrito[$id])) {

            unset($carrito[$id]);

            session()->put('carrito', $carrito);
        }

        return redirect()->back()->with('success', 'Vehículo quitado de la cesta.');
    }
}