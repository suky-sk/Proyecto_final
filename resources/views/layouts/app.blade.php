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
        .nav-icons { display: flex; gap: 14px; align-items: center; }
        .nav-icons a { display: inline-flex; align-items: center; gap: 6px; text-decoration: none; color: inherit; padding: 6px 8px; border-radius: 8px; }
        .nav-icons a:hover { background: rgba(0,0,0,0.04); }
        @media (max-width: 720px) { header { padding: 10px 12px; } }
    </style>

</head>
<body> 
    {{-- header de la pagina --}}
    <header>
        <a href="{{ route('home') }}" class="site-brand">Vorya</a>



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
                    <h2 class="site-footer__title site-brand">Vorya</h2>
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
                    <p class="site-footer__text">Carrer Arcadi García i Sanz, 1, 12600 La Vall d'Uixó, Castelló</p>
                    <a href="https://maps.app.goo.gl/3XK48khtGnuStdDP9" class="site-footer__link" target="_blank" rel="noopener noreferrer">Ver ubicacion</a>
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
                        <li class="site-footer__social-item">
                            <a href="#" class="site-footer__social-link" aria-label="Instagram" target="_blank" rel="noopener noreferrer">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M7 2h10a5 5 0 0 1 5 5v10a5 5 0 0 1-5 5H7a5 5 0 0 1-5-5V7a5 5 0 0 1 5-5zm10 2H7a3 3 0 0 0-3 3v10a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V7a3 3 0 0 0-3-3zm-5 3.5A5.5 5.5 0 1 1 6.5 13 5.5 5.5 0 0 1 12 7.5zm0 2A3.5 3.5 0 1 0 15.5 13 3.5 3.5 0 0 0 12 9.5zM18 6.2a1.2 1.2 0 1 1-1.2 1.2A1.2 1.2 0 0 1 18 6.2z"/></svg>
                            </a>
                        </li>
                        <li class="site-footer__social-item">
                            <a href="#" class="site-footer__social-link" aria-label="X" target="_blank" rel="noopener noreferrer">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M18.9 2H22l-6.8 7.8L23 22h-6.7l-5.2-6.8L5.4 22H2.3l7.3-8.4L1 2h6.9l4.7 6.2L18.9 2zm-1.2 18h1.7L7.1 3.9H5.3L17.7 20z"/></svg>
                            </a>
                        </li>
                        <li class="site-footer__social-item">
                            <a href="#" class="site-footer__social-link" aria-label="LinkedIn" target="_blank" rel="noopener noreferrer">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4.98 3.5a2.25 2.25 0 1 1 0 4.5 2.25 2.25 0 0 1 0-4.5zM3.5 9h3v12h-3V9zm7 0h2.9v1.6h.04c.4-.8 1.4-1.6 2.9-1.6 3.1 0 3.7 2 3.7 4.7V21h-3v-6.2c0-1.5 0-3.4-2.1-3.4s-2.4 1.6-2.4 3.3V21h-3V9z"/></svg>
                            </a>
                        </li>
                        <li class="site-footer__social-item">
                            <a href="#" class="site-footer__social-link" aria-label="YouTube" target="_blank" rel="noopener noreferrer">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M21.6 7.2a2.8 2.8 0 0 0-2-2C17.8 4.6 12 4.6 12 4.6s-5.8 0-7.6.6a2.8 2.8 0 0 0-2 2A29.4 29.4 0 0 0 2 12a29.4 29.4 0 0 0 .4 4.8 2.8 2.8 0 0 0 2 2c1.8.6 7.6.6 7.6.6s5.8 0 7.6-.6a2.8 2.8 0 0 0 2-2 29.4 29.4 0 0 0 .4-4.8 29.4 29.4 0 0 0-.4-4.8zM10 15.5v-7l6 3.5-6 3.5z"/></svg>
                            </a>
                        </li>
                    </ul>
                </nav>
            </section>
        </div>
    </footer>

</body>
</html>
