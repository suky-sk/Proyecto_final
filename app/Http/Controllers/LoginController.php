<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Usuario;

class LoginController extends Controller
{

    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Introduce una dirección de correo válida.',
            'password.required' => 'La contraseña es obligatoria.',
        ]);

        // Intentar log
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        // Si falla
        return back()->withErrors([
            'email' => 'Las credenciales no coinciden con nuestros registros.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect(route('home'));
    }

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre'   => 'required|string|alpha|max:100',
            'apellido' => 'required|string|regex:/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/u|max:100',
            'email'    => 'required|email|unique:usuario,email',
            'password' => 'required|min:4|confirmed',
        ], [
            'nombre.required' => 'El nombre es obligatorio.',
            'nombre.alpha' => 'El nombre solo puede contener letras.',
            'nombre.max' => 'El nombre no puede tener más de 100 caracteres.',
            'apellido.required' => 'El apellido es obligatorio.',
            'apellido.regex' => 'El apellido solo puede contener letras y espacios.',
            'apellido.max' => 'El apellido no puede tener más de 100 caracteres.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'Introduce una dirección de correo válida.',
            'email.unique' => 'Este email ya está registrado.',
            'password.required' => 'La contraseña es obligatoria.',
            'password.min' => 'La contraseña debe tener al menos 4 caracteres.',
            'password.confirmed' => 'Las contraseñas no coinciden.',
            'email'      => $request->email,
            'contrasena' => Hash::make($request->password),
            'telefono'   => $request->telefono,
            'es_admin'   => false,
        ]);

        //esto es para que inicie sesion despues del registro
        Auth::login($user);

        return redirect()->route('profile');
    }
}