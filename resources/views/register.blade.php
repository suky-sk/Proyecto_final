@extends('layouts.app')
@section('titulo', 'Crear Cuenta')

@section('content')
<section id="login">
    <div class="login-box" style="max-width: 500px;">
        <h2>Crear Cuenta</h2>

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            <div style="display: flex; gap: 10px;">
                <input type="text" name="nombre" placeholder="Nombre" required value="{{ old('nombre') }}"> {{-- nombre --}}
                <input type="text" name="apellido" placeholder="Apellido" required value="{{ old('apellido') }}"> {{-- apellido --}}
            </div>

            <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}"> {{-- mail --}}
            <input type="text" name="telefono" placeholder="Teléfono*" value="{{ old('telefono') }}"> {{-- telefono opcional --}}

            <input type="password" name="password" placeholder="Contraseña" required> {{-- contraseña --}}
            <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required> {{-- verifica contraseña --}}

            <button type="submit" class="btn-submit">REGISTRARSE</button>

            @if ($errors->any())
                <div style="color: red; margin-top: 15px; font-size: 0.9em; text-align: left; background: #ffe6e6; padding: 10px; border-radius: 5px;">
                    <ul style="list-style: none; padding: 0;">
                        @foreach ($errors->all() as $error)
                            <li> {{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
        </form>

        <div class="login-links">
            <p>¿Tienes cuenta?</p>
            <a href="{{ route('login') }}">Inicia Sesión aquí</a>
        </div>
    </div>
</section>
@endsection