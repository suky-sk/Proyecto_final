@extends('layouts.app')

@section('titulo', 'Bienvenido - Catálogo')

@section('content')
<style>
    .catalogo-container {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 24px;
        padding: 20px 20px;
        max-width: 1400px;
        margin: 0 auto;
    }

    .filter-toolbar {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        align-items: center;
        margin: 0 auto 16px auto;
        max-width: 1200px;
        padding: 0 14px;
    }

    .filter-pill {
        background: rgba(255,255,255,0.08);
        border: 1px solid rgba(255,255,255,0.12);
        border-radius: 999px;
        padding: 12px 18px;
        color: white;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        min-width: 165px;
        transition: border-color .2s ease, background .2s ease;
    }

    .filter-pill select,
    .filter-pill input {
        background: transparent;
        border: none;
        color: white;
        min-width: 100px;
    }

    .filter-pill select option {
        color: #111;
        background: #ffffff;
    }

    .filter-pill select:focus,
    .filter-pill input:focus {
        outline: none;
    }

    .filter-pill select {
        cursor: pointer;
    }

    .filter-search {
        flex: 1 1 320px;
        min-width: 260px;
        display: flex;
        align-items: center;
        background: #ffffff;
        border: 1px solid rgba(0,0,0,0.08);
        border-radius: 8px;
        padding: 6px 10px;
        transition: border-color .2s ease, box-shadow .2s ease;
        color: #111;
    }

    .filter-search:hover,
    .filter-search:focus-within {
        border-color: #f1c40f;
        box-shadow: 0 0 0 4px rgba(241,196,15,0.12);
    }

    .filter-search-icon {
        margin-right: 10px;
        font-size: 1rem;
        color: rgba(0,0,0,0.55);
    }

    .filter-search input {
        width: 100%;
        border: none;
        background: transparent;
        color: #111;
        padding: 10px;
        font-size: 1rem;
        border-radius: 8px;
    }

    .filter-search button {
        border: none;
        background: #f1c40f;
        color: #0d1433;
        border-radius: 999px;
        padding: 10px 22px;
        font-weight: 700;
        cursor: pointer;
        transition: transform .2s ease, background .2s ease;
    }

    .filter-search button:hover {
        transform: translateY(-1px);
        background: #d4ac0d;
    }

    .car-card {
        min-width: 0;
        max-width: none;
        width: 100%;
        margin: 0;
        display: flex;
        flex-direction: column;
        overflow: hidden;
        border-radius: 24px;
        border: 1px solid rgba(255,255,255,0.08);
        background: rgba(15,23,42,0.95);
        box-shadow: 0 18px 50px rgba(0,0,0,0.16);
        transition: transform .25s ease, box-shadow .25s ease, border-color .25s ease;
    }

    .car-card:hover {
        transform: translateY(-6px);
        border-color: rgba(241,196,15,0.25);
        box-shadow: 0 30px 70px rgba(0,0,0,0.23);
    }

    .car-card img {
        width: 100%;
        height: 240px;
        object-fit: cover;
        display: block;
        transition: transform 0.5s ease;
    }

    .car-card:hover img {
        transform: scale(1.03);
    }

    .car-card-body {
        padding: 24px;
        display: flex;
        flex-direction: column;
        gap: 14px;
    }

    .car-card-body small {
        color: rgba(255,255,255,0.6);
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 0.8rem;
    }

    .car-card-body h3 {
        margin: 0;
        font-size: 1.35rem;
    }

    .car-meta {
        color: rgba(255,255,255,0.72);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .car-price {
        margin: 0;
        font-size: 1.55rem;
        font-weight: 700;
        color: #f1c40f;
    }

    .car-actions {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        margin-top: auto;
    }

    .car-action-button {
        flex: 1 1 140px;
        padding: 12px 18px;
        border-radius: 999px;
        font-weight: 700;
        border: none;
        cursor: pointer;
        text-align: center;
        transition: transform .2s ease, box-shadow .2s ease;
    }

    .car-action-button.details {
        background: white;
        color: #0d1433;
    }

    .car-action-button.cart {
        background: rgba(255,255,255,0.08);
        color: white;
        border: 1px solid rgba(255,255,255,0.12);
    }

    .car-action-button:hover {
        transform: translateY(-1px);
    }

    .car-action-button:disabled {
        opacity: 0.55;
        cursor: not-allowed;
        transform: none;
    }
</style>


<section class="hero-section" style="background: linear-gradient(135deg, #0d1433 0%, #2d3b67 100%); color: white; padding: 30px 20px;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; text-align: left;">
        <p style="margin: 0 0 15px; text-transform: uppercase; letter-spacing: 2px; opacity: 0.85;">Tu próximo coche te espera</p>
        <h1 style="margin: 0 0 15px; font-size: 56px; line-height: 1.05;">Encuentra tu próximo vehículo</h1>
        <p style="margin: 0 0 25px; font-size: 1.1rem; max-width: 700px; opacity: 0.9;">Más de 200 coches disponibles listos para ser explorados. Filtra por marca y encuentra el modelo ideal para ti.</p>
        <a href="#catalogo" class="btn-submit" style="display: inline-block; padding: 14px 30px; background: #f1c40f; color: black; border-radius: 6px; text-decoration: none; font-weight: 700;">Explorar vehículos</a>
    </div>
</section>

<form action="{{ route('home') }}" method="GET" class="filter-toolbar">
    <label class="filter-pill">
        Marca
        <select name="marca" onchange="this.form.submit()">
            <option value="">Todas las marcas</option>
            @foreach($marcas as $marca)
                <option value="{{ $marca->id }}" {{ request('marca') == $marca->id ? 'selected' : '' }}>
                    {{ $marca->nombre }}
                </option>
            @endforeach
        </select>
    </label>

    <label class="filter-pill">
        Precio
        <select name="precio">
            <option value="">Cualquier precio</option>
            <option value="0-15000" {{ request('precio') == '0-15000' ? 'selected' : '' }}>Menos de 15.000€</option>
            <option value="15000-30000" {{ request('precio') == '15000-30000' ? 'selected' : '' }}>15.000€ - 30.000€</option>
            <option value="30000-50000" {{ request('precio') == '30000-50000' ? 'selected' : '' }}>30.000€ - 50.000€</option>
            <option value="50000+" {{ request('precio') == '50000+' ? 'selected' : '' }}>Más de 50.000€</option>
        </select>
    </label>

    <div class="filter-search">
        <span class="filter-search-icon">🔍</span>
        <input type="text" name="modelo" placeholder="Buscar marca o modelo..." value="{{ request('modelo') }}" />
        <button type="submit">Buscar</button>
    </div>
</form>

<section class="active-section" id="catalogo">
    <div class="container">
        <h2 class="section-title" style="margin-top: 12px;">Catálogo</h2>

        {{-- Mostrar mensaje si se añadió correctamente --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="catalogo-container">
            @foreach($coches as $coche)
                <div class="car-card">
                    <a href="{{ route('coches.show', $coche->id) }}">
                        <img
                            src="/storage/Fotos/{{ $coche->id }}/1.png"
                            alt="Imagen del coche"
                            car-id="{{ $coche->id }}"
                            current-img="0"
                            data-img="{{ $coche->imgs_json }}"
                            onerror="this.onerror=null; this.src='https://via.placeholder.com/800x500?text=Sin+Foto'"
                        >
                    </a>

                    <div class="car-card-body">
                        <small>{{ $coche->marca->nombre }}</small>

                        <a href="{{ route('coches.show', $coche->id) }}" style="text-decoration: none; color: inherit;">
                            <h3>{{ $coche->modelo }}</h3>
                        </a>

                        <p class="car-meta">
                            {{ $coche->fecha_fabricacion ? \Carbon\Carbon::parse($coche->fecha_fabricacion)->format('Y') : 'Año desconocido' }} ·
                            {{ $coche->potencia ? $coche->potencia . ' CV' : 'Potencia N/A' }} ·
                            Stock: {{ $coche->stock }}
                        </p>

                        <p class="car-price">{{ number_format($coche->precio, 0, ',', '.') }} €</p>

                        <div class="car-actions">
                            <a href="{{ route('coches.show', $coche->id) }}" class="car-action-button details">Ver detalles</a>

                            <form action="{{ route('carrito.add', $coche->id) }}" method="POST" style="flex: 1 1 140px; margin: 0;">
                                @csrf
                                <button type="submit" class="car-action-button cart" {{ $coche->stock <= 0 ? 'disabled' : '' }}>
                                    {{ $coche->stock <= 0 ? 'SIN STOCK' : 'Añadir al carrito' }}
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>   
</section>
@endsection
