@extends('layouts.app')

@section('titulo', $coche->marca->nombre . ' ' . $coche->modelo)

@section('content')

<style>
    /* principal */
    .detail-container {max-width: 900px; margin: 40px auto; padding: 0 20px; display: flex; flex-direction: column; gap: 40px; /* Separación entre la FOTO y el TEXTO DE ABAJO */
    }

    /* ft */
    .back-link { align-self: flex-start; display: inline-flex; align-items: center; gap: 8px; color: #f1c40f; border: 1px solid rgba(241,196,15,0.45); padding: 10px 16px; border-radius: 4px; font-weight: 700; }
    .back-link:hover { background: #f1c40f; color: #000; }
    .image-gallery {position: relative; width: 100%;}
    .main-image {width: 100%; aspect-ratio: 16/9; object-fit: cover; border-radius: 8px; background: #000; box-shadow: 0 4px 15px rgba(0,0,0,0.5);}
    .btn-nav {position: absolute; top: 50%; transform: translateY(-50%); background: rgba(0,0,0,0.4); color: white; border: none; padding: 10px 15px; cursor: pointer; font-size: 2em; z-index: 10; border-radius: 4px;}
    .btn-nav:hover {background: rgba(0,0,0,0.8);} .prev {left: 10px;} .next {right: 10px;}

    /* select de la unfo*/
    .car-info {
        display: flex;
        flex-direction: column;
        gap: 30px; /* <--- ESTO SEPARA EL PRECIO, LA CAJA GRIS, LOS SPECS Y EL BOTÓN */
    }

    /* header */
    .car-header { border-bottom: 1px solid #333; padding-bottom: 20px; }
    .car-brand { text-transform: uppercase; letter-spacing: 2px; color: #aaa; font-weight: bold;}
    .car-title { font-size: 2.5em; margin: 5px 0; color: white; }
    .car-price { font-size: 2em; color: var(--yellow); font-weight: bold; margin-top: 10px; display: block; }

    /* Caja gris de descripción */
    .car-desc { background: #0f172a; padding: 25px; border-radius: 8px; line-height: 1.6; color: #ddd; white-space: pre-line; }

    /* especificaciones */
    .specs-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; text-align: center; }
    .spec-item { background: #1a1a1a; padding: 15px; border-radius: 4px; border: 1px solid #333; }
    .spec-item strong { font-size: 1.1em; color: white; display:block; }
    .spec-item small { color: #777; font-size: 0.8em; }

    /* bt */
    .btn-action { width: 100%; padding: 15px; font-size: 1.2em; font-weight: bold; cursor: pointer; }
    .admin-btn { background: transparent; border: 1px solid #f1c40f; color: #f1c40f; padding: 8px 15px; cursor: pointer; border-radius: 4px; float: right; }
    .admin-btn:hover { background: #f1c40f; color: black; }

    /* modal */
    .modal-overlay {display: none; position: fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); z-index:1000; justify-content:center; align-items:center;}
    .modal-box {background: #222; padding: 30px; width: 90%; max-width: 500px; border-radius: 8px; border: 1px solid #444;}
    .modal-input {width: 100%; padding: 10px; margin: 5px 0 15px; background: #111; border: 1px solid #444; color: white; border-radius: 4px;}
    .close-btn {float: right; color: white; cursor: pointer; font-size: 20px;}
</style>

<div class="detail-container">
    <a href="{{ route('home') }}" class="back-link" onclick="if (document.referrer) { history.back(); return false; }">
        &larr; Volver
    </a>

    {{-- ft--}}
    <div class="image-gallery">
        <button class="btn-nav prev" id="btnPrev">‹</button>
        <img id="mainImage" src="/storage/Fotos/{{ $coche->id }}/1.png" class="main-image" data-photos="{{ $coche->imgs_json }}" onerror="this.src='https://via.placeholder.com/1600x900?text=Sin+Foto'">
        <button class="btn-nav next" id="btnNext">›</button>
    </div>

    {{-- inf --}}
    <div class="car-info">
        @auth @if(Auth::user()->es_admin)
            <button onclick="toggleModal('editModal')" class="admin-btn">✏️ Editar Info</button>
        @endif @endauth

        <div class="car-header">
            <small class="car-brand">{{ $coche->marca->nombre }}</small>
            <h1 class="car-title">{{ $coche->modelo }}</h1>
            <div class="car-price">{{ number_format($coche->precio, 0, ',', '.') }} €</div>
        </div>

        <div class="car-desc">
            {{ $coche->informacion ?? 'Sin descripción disponible.' }}
        </div>

        <div class="specs-grid">
            <div class="spec-item"><small>Potencia</small><strong>{{ $coche->potencia }} CV</strong></div>
            <div class="spec-item"><small>Año</small><strong>{{ \Carbon\Carbon::parse($coche->fecha_fabricacion)->format('Y') }}</strong></div>
            <div class="spec-item"><small>Stock</small><strong>{{ $coche->stock }} uds.</strong></div>
        </div>

        <form action="{{ route('carrito.add', $coche->id) }}" method="POST">
            @csrf
            <button type="submit" class="btn-submit btn-action" {{ $coche->stock <= 0 ? 'disabled style=background:#444' : '' }}>
                {{ $coche->stock > 0 ? 'AÑADIR AL CARRITO' : 'AGOTADO' }}
            </button>
        </form>
        <a href="{{ route('home') }}" style="display:block; text-align:center; margin-top:20px; color:#666;">Volver</a>
    </div>
</div>

{{-- edicion --}}
@auth @if(Auth::user()->es_admin)
<div id="editModal" class="modal-overlay">
    <div class="modal-box">
        <span class="close-btn" onclick="toggleModal('editModal')">&times;</span>
        <h3 style="color:#f1c40f; margin-bottom:15px">Editar Coche</h3>
        <form action="{{ route('admin.coches.update', $coche->id) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <label style="color:#aaa">Descripción (Informacion)</label>
            <textarea name="informacion" class="modal-input" style="height:100px">{{ $coche->informacion }}</textarea>

            <label style="color:#aaa">Modelo</label>
            <input type="text" name="modelo" value="{{ $coche->modelo }}" class="modal-input" required>

            <div style="display:flex; gap:10px">
                <input type="number" name="precio" value="{{ $coche->precio }}" class="modal-input" placeholder="Precio">
                <input type="number" name="stock" value="{{ $coche->stock }}" class="modal-input" placeholder="Stock">
                <input type="text" name="potencia" value="{{ $coche->potencia }}" class="modal-input" placeholder="CV">
            </div>

            {{-- el hidden --}}
            <input type="hidden" name="marca_id" value="{{ $coche->marca_id }}">
            <input type="hidden" name="fecha_fabricacion" value="{{ $coche->fecha_fabricacion }}">

            <button type="submit" class="btn-submit" style="width:100%; background:#f1c40f; color:black">GUARDAR</button>
        </form>
    </div>
</div>
@endif @endauth

<script>
    function toggleModal(id) {
        let el = document.getElementById(id);
        el.style.display = (el.style.display === 'flex') ? 'none' : 'flex';
    }

    document.addEventListener('DOMContentLoaded', function() {
        const img = document.getElementById('mainImage');
        const photos = JSON.parse(img.getAttribute('data-photos') || '[]');
        let idx = 0; const carId = "{{ $coche->id }}";

        if(photos.length <= 1) { document.querySelectorAll('.btn-nav').forEach(b => b.style.display='none'); }

        const update = () => img.src = `/storage/Fotos/${carId}/${photos[idx]}`;

        document.getElementById('btnNext').onclick = () => { if(photos.length){ idx = (idx+1)%photos.length; update(); }};
        document.getElementById('btnPrev').onclick = () => { if(photos.length){ idx = (idx-1+photos.length)%photos.length; update(); }};
    });
</script>
@endsection
