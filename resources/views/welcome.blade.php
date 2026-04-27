@extends('layouts.app')

@section('titulo', 'Bienvenido - Catálogo')

@section('content')
<style>
    .catalogo-container {display: grid;grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));gap: 30px;padding: 40px 20px;max-width: 1400px; margin: 0 auto;}
    .car-card {min-width: 0; max-width: none; width: 100%;margin: 0;display: flex;flex-direction: column;overflow: hidden; }
    .car-card img {width: 100%;height: 220px; object-fit: cover;border-radius: 4px;transition: transform 0.5s ease;}
    .car-info {padding-top: 15px;flex-grow: 1;}
   
    /*Botones*/
    .car-card > div:first-child { position: relative; }
    .boton-anterior, .boton-siguiente {position: absolute;top: 50%;transform: translateY(-50%);background: rgba(0,0,0,0.5);
    color: white;border: none;padding: 10px 15px;cursor: pointer;border-radius: 4px;opacity: 0.7; z-index: 10;
    }
    .boton-anterior:hover, .boton-siguiente:hover { opacity: 1; background: #000; }
    .boton-anterior { left: 5px; }
    .boton-siguiente { right: 5px; }
</style>

<div class="search-bar" style="display: flex; gap: 10px; align-items: center;"> {{-- para el filtrador por marcas --}}
    <form action="{{ route('home') }}" method="GET" style="display: flex; gap: 5px;">
        <select name="marca" onchange="this.form.submit()" style="cursor: pointer; min-width: 150px; padding: 8px;">
            <option value="">Todas las marcas</option>
            @foreach(\App\Models\Marca::all() as $marca)
                <option value="{{ $marca->id }}" {{ request('marca') == $marca->id ? 'selected' : '' }}>
                    {{ $marca->nombre }}
                </option>
            @endforeach
        </select>
    </form>

    {{-- para el buscador por teclado --}}
    <div style="flex-grow: 1; max-width: 400px;">
        <input type="text" id="simple-search" 
               placeholder="buscar" 
               value="{{ request('modelo') }}"
               style="width: 100%; padding: 8px; border-radius: 4px; border: 1px solid #444; background: #222; color: white;">
    </div>
</div>

<script>
    // para cuando le das a buscar
    document.getElementById('simple-search').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            let valor = this.value;

            // se manda a la misma página añadiendo el parámetro 
            window.location.href = `{{ route('home') }}?modelo=${valor}`;
        }
    });
</script>

<section class="active-section">
    <div class="container">
        <h2 class="section-title" style="margin-top: 30px;">Catálogo de Vehículos</h2>

        {{-- Mostrar mensaje si se añadió correctamente --}}
        @if(session('success'))
            <div class="alert-success">
                {{ session('success') }}
            </div>
        @endif
        
        <div class="catalogo-container">
            @foreach($coches as $coche)
                <div class="car-card">
                    <div>
                        <button class="boton-anterior"> < </button>

                        <button class="boton-siguiente"> > </button>

                        <a href="{{ route('coches.show', $coche->id) }}" style="display: block;">
                            <img 
                                src="/storage/Fotos/{{ $coche->id }}/1.png"  
                                alt="Imagen del coche" 
                                car-id="{{ $coche->id }}"
                                current-img="0"  
                                data-img="{{ $coche->imgs_json }}"
                            >
                        </a>
                    </div>

                    <div class="car-info">
                        <small style="color: var(--muted); text-transform: uppercase; letter-spacing: 1px;">
                            {{ $coche->marca->nombre }} {{-- Marca --}}
                        </small>
                        
                        <a href="{{ route('coches.show', $coche->id) }}" style="text-decoration: none; color: inherit;">
                            <h3 style="margin: 5px 0 5px 0; text-align: left;">{{ $coche->modelo }}</h3> {{-- Modelo del coche --}}
                        </a>
                        
                        <p style="color: #aaa; font-size: 0.9em; margin-bottom: 10px;">Potencia: {{ $coche->potencia }} CV</p> {{-- Potencia del coche --}}
                        <p style="color: #aaa; font-size: 0.9em; margin-bottom: 10px;">Fecha de fabricacion: {{ $coche->fecha_fabricacion }} </p> {{-- Fecha de fabricacion  --}}
                        
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
                            <p class="price" style="margin: 0;">{{ number_format($coche->precio, 0, ',', '.') }} €</p> {{-- Precio del coche --}}
                            <span style="font-size: 0.85em; color: var(--muted);">Stock: {{ $coche->stock }}</span> {{-- Stock disponible --}}
                        </div>
                    </div>

                    <form action="{{ route('carrito.add', $coche->id) }}" method="POST"> {{-- Llevamos los datos del boton al carrito --}}
                        @csrf
                        <button type="submit" class="btn-submit" {{ $coche->stock <= 0 ? 'disabled' : '' }} 
                                style="{{ $coche->stock <= 0 ? 'background: #444; cursor: not-allowed;' : '' }}">
                            {{ $coche->stock <= 0 ? 'SIN STOCK' : 'AÑADIR AL CARRITO' }} {{-- Anticompras sin stock --}}
                        </button>
                    </form>
                </div>
            @endforeach
        </div>
    </div>   
</section>
@endsection