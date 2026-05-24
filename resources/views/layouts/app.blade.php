{{-- pagina principal --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - @yield('titulo')</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        header { display: flex; justify-content: space-between; align-items: center; padding: 12px 20px; border-bottom: 1px solid rgba(0,0,0,0.06); }
        .home-btn { display: inline-flex; align-items: center; gap: 10px; color: inherit; font-weight: 700; }
        .home-emoji { font-size: 1.05rem; line-height: 1; }
        .home-text { font-size: 1rem; letter-spacing: .6px; }
        .nav-icons { display: flex; gap: 14px; align-items: center; }
        .nav-icons a { display: inline-flex; align-items: center; gap: 6px; text-decoration: none; color: inherit; padding: 6px 8px; border-radius: 8px; }
        .nav-icons a:hover { background: rgba(0,0,0,0.04); }
        @media (max-width: 720px) { header { padding: 10px 12px; } .home-text { display: none; } }
    </style>

</head>
<body> 
    {{-- header de la pagina --}}
    <header>
        <a href="{{ route('home') }}" class="home-btn" style="text-decoration: none;">
            <span class="home-emoji">🏠</span>
            <span class="home-text">Inicio</span>
        </a>



<div class="nav-icons">
    {{-- en caso de que el user sea admin se mostrara la rueda para poder modificar usuarios y coches y tambien la opcion de poner nuevos coches --}}
    @auth
        @if(Auth::user()->es_admin)
            <a href="{{ route('admin.usuarios.index') }}" title="Panel de Administración" class="admin-icon">
                ⚙️
            </a>
        @endif
    @endauth

    @guest
        <a href="{{ route('login') }}" title="Iniciar Sesión">👤 <span style="font-size: 0.8em;">Entrar</span></a>
    @endguest
            {{-- muestra el icono de una persona que es un enlace directo para ir a ver la informacion del usuario --}}
    @auth
        <a href="{{ route('profile') }}" title="Ir a mi perfil">
            👤 
        </a>
    @endauth
        {{-- te lleva al carrito para terminar el proceso de compra y hacer -1 en el stock del coche seleccionado o de los coches --}}
    <a href="{{ route('cart') }}" title="Carrito">🛒</a>

</div>
        
    </header>

    <main>
        @yield('content')
    </main>

    <footer style="padding:12px 20px; text-align:center; color: #666; border-top:1px solid rgba(0,0,0,0.06); margin-top:40px;">
        &copy; {{ date('Y') }} Proyecto Final DAW
    </footer>

</body>
</html>
