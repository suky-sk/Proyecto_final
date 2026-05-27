{{-- vista del log para iniciar sesion --}}
@extends('layouts.app')
@section('titulo', 'Iniciar Sesión')

@section('content')
<section id="login">
    <div class="login-box">
        <h2>Inicio de Sesión</h2>

        <form action="{{ route('login.submit') }}" method="POST">
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

            <input type="email" name="email" placeholder="Email" required value="{{ old('email') }}">

            <input type="password" name="password" placeholder="Contraseña" required>

            <button type="submit" class="btn-submit">ENTRAR</button>
        </form>

        <div class="login-links">
            <p>¿No tienes cuenta?</p>
            <a href="{{ route('register') }}">Crea una cuenta</a>
        </div>

        <div class="login-links" style="margin-top: 12px; gap: 0;">
            <a href="#" id="forgot-password-link">¿Olvidaste tu contraseña?</a>
        </div>

        <p id="forgot-password-message" style="display:none; color:red; font-size:0.95em; margin-top:10px;">
            Si no recuerdas tu contraseña, contacta con un administrador para que te ayude.
        </p>
    </div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var link = document.getElementById('forgot-password-link');
        var message = document.getElementById('forgot-password-message');

        if (link && message) {
            link.addEventListener('click', function (event) {
                event.preventDefault();
                message.style.display = 'block';
            });
        }
    });
</script>
@endsection