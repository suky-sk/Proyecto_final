@extends('layouts.app')
@section('titulo', 'Crear Cuenta')

@section('content')
<section id="login">
    <div class="login-box" style="max-width: 500px;">
        <h2>Crear Cuenta</h2>

        <form action="{{ route('register.submit') }}" method="POST">
            @csrf

            @if ($errors->any())
                <div style="color: #fff; background: #b80d0d; padding: 14px 16px; border-radius: 8px; margin-bottom: 16px;">
                    <strong>Algo ha fallado.</strong> Revisa los datos e inténtalo de nuevo.
                    <ul style="margin: 8px 0 0 18px; padding: 0; list-style: disc; font-size: 0.95em;">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div style="display: flex; gap: 10px;">
                <input type="text" name="nombre" placeholder="Nombre" required value="{{ old('nombre') }}"> {{-- nombre --}}
                <input type="text" name="apellido" placeholder="Apellido" required value="{{ old('apellido') }}"> {{-- apellido --}}
            </div>

            <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}"> {{-- mail --}}
            <input type="text" name="telefono" placeholder="Teléfono*" value="{{ old('telefono') }}"> {{-- telefono opcional --}}

            <input type="password" name="password" placeholder="Contraseña" required> {{-- contraseña --}}
            <input type="password" name="password_confirmation" placeholder="Confirmar Contraseña" required> {{-- verifica contraseña --}}

            <button type="submit" class="btn-submit">REGISTRARSE</button>
        </form>

        <div class="login-links login-switch">
            <span>¿Ya tienes cuenta?</span>
            <span class="login-switch-separator"></span>
            <a href="{{ route('login') }}">Inicia sesión aquí</a>
        </div>
    </div>
</section>
@endsection