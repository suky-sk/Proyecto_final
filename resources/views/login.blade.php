{{-- vista del log para iniciar sesion --}}
@extends('layouts.app')
@section('titulo', 'Iniciar Sesión')

@section('content')
<section id="login">
    <div class="login-box">
        <h2>Inicio de Sesión</h2>

        <form action="{{ route('login.submit') }}" method="POST">
            @csrf

            <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">

            <input type="password" name="password" placeholder="Contraseña" required>

            <button type="submit" class="btn-submit">ENTRAR</button>

            @error('email')
                <p style="color: red; font-size: 0.9em; margin-top: 10px;">{{ $message }}</p>
            @enderror
        </form>

        <div class="login-links">
            <a href="#">he olvidado mi contraseña</a>
            {{-- nuevos users --}}
            <a href="{{ route('register') }}">| Crear cuenta</a>
        </div>
    </div>
</section>
@endsection