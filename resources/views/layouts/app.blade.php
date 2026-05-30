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

    <footer class="site-footer">
        <div class="site-footer__container">
            <section class="site-footer__main" aria-label="Informacion de Vorya">
                <div class="site-footer__column site-footer__brand">
                    <h2 class="site-footer__title">Vorya</h2>
                    <p class="site-footer__description">
                        Catalogo de vehiculos seleccionados para encontrar, comparar y comprar tu proximo coche con confianza.
                    </p>
                </div>

                <address class="site-footer__column site-footer__contact">
                    <h3 class="site-footer__heading">Contacto</h3>
                    <ul class="site-footer__list">
                        <li class="site-footer__item">
                            <span class="site-footer__label">Telefono</span>
                            <a href="tel:+34900123456" class="site-footer__link">+34 900 123 456</a>
                        </li>
                        <li class="site-footer__item">
                            <span class="site-footer__label">Correo</span>
                            <a href="mailto:contacto@vorya.com" class="site-footer__link">contacto@vorya.com</a>
                        </li>
                        <li class="site-footer__item">
                            <span class="site-footer__label">Horario</span>
                            <span class="site-footer__text">Lunes a viernes, 9:00 - 18:00</span>
                        </li>
                    </ul>
                </address>

                <address class="site-footer__column site-footer__location">
                    <h3 class="site-footer__heading">Ubicacion</h3>
                    <p class="site-footer__text">Barcelona, Espana</p>
                    <p class="site-footer__text">Carrer de la Automocion 24, 08018 Barcelona</p>
                    <a href="#" class="site-footer__link">Ver ubicacion</a>
                </address>

                <nav class="site-footer__column site-footer__nav" aria-label="Enlaces rapidos">
                    <h3 class="site-footer__heading">Enlaces rapidos</h3>
                    <ul class="site-footer__list">
                        <li class="site-footer__item"><a href="{{ route('home') }}" class="site-footer__link">Inicio</a></li>
                        <li class="site-footer__item"><a href="{{ route('home') }}#catalogo" class="site-footer__link">Catalogo</a></li>
                        <li class="site-footer__item"><a href="{{ route('cart') }}" class="site-footer__link">Carrito</a></li>
                        @guest
                            <li class="site-footer__item"><a href="{{ route('login') }}" class="site-footer__link">Iniciar sesion</a></li>
                        @endguest
                        @auth
                            <li class="site-footer__item"><a href="{{ route('profile') }}" class="site-footer__link">Mi perfil</a></li>
                            @if(Auth::user()->es_admin)
                                <li class="site-footer__item"><a href="{{ route('admin.usuarios.index') }}" class="site-footer__link">Panel admin</a></li>
                            @endif
                        @endauth
                    </ul>
                </nav>
            </section>

            <section class="site-footer__trust" aria-label="Garantias de confianza">
                <ul class="site-footer__badges">
                    <li class="site-footer__badge">Compra segura</li>
                    <li class="site-footer__badge">Vehiculos revisados</li>
                    <li class="site-footer__badge">Atencion personalizada</li>
                </ul>
            </section>

            <section class="site-footer__bottom" aria-label="Informacion legal y redes sociales">
                <p class="site-footer__copyright">
                    &copy; {{ date('Y') }} Vorya. Todos los derechos reservados.
                </p>

                <nav class="site-footer__legal" aria-label="Enlaces legales">
                    <ul class="site-footer__legal-list">
                        <li class="site-footer__legal-item"><a href="#" class="site-footer__link">Aviso legal</a></li>
                        <li class="site-footer__legal-item"><a href="#" class="site-footer__link">Privacidad</a></li>
                        <li class="site-footer__legal-item"><a href="#" class="site-footer__link">Cookies</a></li>
                        <li class="site-footer__legal-item"><a href="#" class="site-footer__link">Condiciones de compra</a></li>
                    </ul>
                </nav>

                <nav class="site-footer__social" aria-label="Redes sociales">
                    <ul class="site-footer__social-list">
                        <li class="site-footer__social-item"><a href="#" class="site-footer__link">Instagram</a></li>
                        <li class="site-footer__social-item"><a href="#" class="site-footer__link">X</a></li>
                        <li class="site-footer__social-item"><a href="#" class="site-footer__link">LinkedIn</a></li>
                        <li class="site-footer__social-item"><a href="#" class="site-footer__link">YouTube</a></li>
                    </ul>
                </nav>
            </section>
        </div>
    </footer>

</body>
</html>
