<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Usuario;
use Illuminate\Validation\Rule;

class AdminUsuarioController extends Controller
{
    public function index()
    {
        $usuarios = Usuario::all();
        return view('admin.usuarios.index', compact('usuarios'));
    }

    public function edit($id)
    {
        $usuario = Usuario::findOrFail($id);
        return view('admin.usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        $usuario = Usuario::findOrFail($id);

        $request->validate([
            'nombre' => 'required|string',
            'apellido' => 'required|string',
            'email' => ['required', 'email', Rule::unique('usuario')->ignore($usuario->id)],
            'es_admin' => 'required|boolean',
        ]);

        $usuario->update([
            'nombre' => $request->nombre,
            'apellido' => $request->apellido,
            'email' => $request->email,
            'telefono' => $request->telefono,
            'es_admin' => $request->es_admin,
        ]);

        return redirect()->route('admin.usuarios.index')->with('success', 'Usuario modificado correctamente');
    }

    public function destroy($id)
    {
        if(auth()->user()->id == $id){
            return back()->with('error', 'No puedes borrar tu propia cuenta.');
        }

        Usuario::destroy($id);
        return back()->with('success', 'Usuario eliminado.');
    }
}