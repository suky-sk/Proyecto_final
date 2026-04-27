{{-- pagina principal --}}
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Concesionario - @yield('titulo')</title>
    
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <script src="{{ mix('js/app.js') }}"></script>

</head>
<body> 
    {{-- header de la pagina --}}
    <header>
        <a href="{{ route('home') }}" class="home-btn" style="text-decoration: none;">
            🏠 <span>Inicio</span>
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

</body>
</html>