@extends('layouts.app')
@section('titulo', 'Carrito')

@section('content')
<style>
    .back-link { align-self: flex-start; display: inline-flex; align-items: center; gap: 8px; color: #f1c40f; border: 1px solid rgba(241,196,15,0.45); padding: 10px 16px; border-radius: 4px; font-weight: 700; text-decoration: none; margin-bottom: 20px; transition: background 0.2s ease, color 0.2s ease; }
    .back-link:hover { background: #f1c40f; color: #000; }
    .btn-comprar-rojo {background-color: #f1c40f;color: black;border: none;padding: 15px;font-weight: bold;
        text-transform: uppercase;transition: background-color 0.3s ease, transform 0.2; width: 100%;}
    .btn-comprar-rojo:hover {background-color: #d4ac0d;}
    .btn-eliminar {color: #ff3b30; background: none; border: 1px solid #333; padding: 5px 10px;
        font-size: 0.75rem; border-radius: 4px; cursor: pointer; transition: all 0.2s;}
    .btn-eliminar:hover {background: #ff3b30; color: white; border-color: #ff3b30;}
</style>

<section id="cart" class="active" style="display:block; padding: 20px;">
    <div class="container">
        <a href="{{ route('home') }}" class="back-link" onclick="if (document.referrer) { history.back(); return false; }">
            &larr; Volver
        </a>

        <h2 class="section-title">Tu Carrito</h2>

        @if(session('error'))
            <div class="alert alert-danger" style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 5px; margin-bottom: 20px;">{{ session('error') }}</div>
        @endif
        @if(session('success'))
            <div class="alert alert-success" style="background: #d4edda; color: #155724; padding: 15px; border-radius: 5px; margin-bottom: 20px;">{{ session('success') }}</div>
        @endif

        <div class="cart-container" style="display: grid; grid-template-columns: 1fr 350px; gap: 30px;">
            <div class="cart-items">
                <h3 style="margin-bottom: 20px;">Productos seleccionados</h3>

                @if(session('carrito') && count(session('carrito')) > 0)
                    @foreach(session('carrito') as $id => $detalles)
                        <div class="product-preview mb-3" style="background: var(--card); border: 1px solid var(--border); padding: 15px; display: flex; align-items: center; justify-content: space-between; border-radius: 8px;">
                            <div style="display: flex; align-items: center;">
                                 <img src="{{ asset('storage/Fotos/' . $id . '/1.png') }}"
                                    alt="{{ $detalles['modelo'] }}"
                                    onerror="this.onerror=null; this.src='https://via.placeholder.com/800x500?text=Sin+Foto'"
                                    style="width: 120px; height: 80px; object-fit: cover; margin-right: 15px; border-radius: 4px;">
                                <div>
                                    <h5 class="mb-0 text-uppercase" style="color: var(--text);">{{ $detalles['marca'] }} {{ $detalles['modelo'] }}</h5>
                                    <p class="text-muted small mb-0">Cantidad: {{ $detalles['cantidad'] }}</p>
                                </div>
                            </div>

                            <div class="text-end" style="display: flex; flex-direction: column; align-items: flex-end; gap: 10px;">
                                <h4 style="color: var(--yellow); margin: 0;">{{ number_format($detalles['precio'] * $detalles['cantidad'], 0, ',', '.') }} €</h4>

                                {{-- form para borrar coches ne caso de que ya no los quieras --}}
                                <form action="{{ route('carrito.remove', $id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-eliminar">
                                        Borrar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="product-preview text-center py-5" style="background: var(--card); border: 1px solid var(--border); border-radius: 8px;">
                        <p style="color: var(--muted);">No tienes ningún coche en el carrito</p>
                    </div>
                @endif
            </div>

            <div class="cart-summary">
                <div style="background: var(--card); padding: 25px; border-radius: 8px; border: 1px solid var(--border); position: sticky; top: 20px;">
                    @php
                        $total = 0;
                        if(session('carrito')) {
                            foreach(session('carrito') as $id => $detalles) {
                                $total += $detalles['precio'] * $detalles['cantidad'];
                            }
                        }
                    @endphp

                    <h4 style="margin-bottom: 20px;">Resumen</h4>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 15px;">
                        <span>Total:</span>
                        <span style="color: var(--yellow); font-size: 1.5rem; font-weight: bold;">{{ number_format($total, 0, ',', '.') }} €</span>
                    </div>

                    @if(session('carrito') && count(session('carrito')) > 0)
                        <form action="{{ route('carrito.comprar') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn-comprar-rojo">
                                Finalizar compra
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
