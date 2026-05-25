@extends('layouts.app')
@section('titulo', 'Mi Perfil')

@section('content')
<section id="profile" class="active-section" style="padding: 40px 20px; max-width: 1200px; margin: 0 auto;">

    @if(session('success'))
        <div style="margin: 0 auto 20px; background: rgba(46, 204, 113, 0.2); border: 1px solid #2ecc71; color: #2ecc71; padding: 15px; border-radius: 4px; text-align: center;">
             {{ session('success') }}
        </div>
    @endif

    <div class="profile-container" style="background: var(--card); padding: 30px; border-radius: 8px; border: 1px solid var(--border);">
        <div style="text-align: center; margin-bottom: 30px;">
            <div style="font-size: 4em; margin-bottom: 10px;">👤</div>
            <h2 style="margin: 0;">Hola, {{ Auth::user()->nombre }}</h2>
            @if(Auth::user()->es_admin)
                <span style="background: #f1c40f; color: black; padding: 2px 8px; border-radius: 4px; font-size: 0.7em; font-weight: bold; text-transform: uppercase; margin-top: 5px; display: inline-block;">Administrador</span>
            @endif
        </div>

        <hr style="border: 0; border-top: 1px solid var(--border); margin: 20px 0;">

        <div class="user-data" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 30px;">
            <div>
                <small style="color: var(--muted);">Nombre completo</small>
                <p style="font-size: 1.1em;">{{ Auth::user()->nombre }} {{ Auth::user()->apellido }}</p>
            </div>
            <div>
                <small style="color: var(--muted);">Email</small>
                <p style="font-size: 1.1em;">{{ Auth::user()->email }}</p>
            </div>
            <div>
                <small style="color: var(--muted);">Teléfono</small>
                <p style="font-size: 1.1em;">{{ Auth::user()->telefono ?? 'No especificado' }}</p>
            </div>
            <div>
                <small style="color: var(--muted);">Dirección</small>
                <p style="font-size: 1.1em;">{{ Auth::user()->direccion ?? 'No especificada' }}</p>
            </div>
        </div>

        <div style="display: flex; justify-content: center; gap: 20px;">
            <button onclick="openModal()" class="btn-buy" style="width: auto; background: #007bff; border: none;">
                ✏️ Editar mis datos
            </button>

            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="btn-logout" style="padding: 10px 20px; cursor: pointer;">Cerrar Sesión</button>
            </form>
        </div>
    </div>

    <div id="editModal" class="modal-overlay">
        <div class="modal-box">
            <span class="close-btn" onclick="closeModal()">&times;</span>
            <h3 style="margin-bottom: 20px;">Modificar mis datos</h3>

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PUT')

                <label>Nombre</label>
                <input type="text" name="nombre" value="{{ Auth::user()->nombre }}" required>

                <label>Apellido</label>
                <input type="text" name="apellido" value="{{ Auth::user()->apellido }}" required>

                <label>Email</label>
                <input type="email" name="email" value="{{ Auth::user()->email }}" required>

                <label>Teléfono</label>
                <input type="text" name="telefono" value="{{ Auth::user()->telefono }}">

                <label>Dirección</label>
                <input type="text" name="direccion" value="{{ Auth::user()->direccion }}">

                <button type="submit" class="btn-submit" style="margin-top: 15px;">GUARDAR CAMBIOS</button>
            </form>
        </div>
    </div>

    <div style="margin-top: 50px;">
        <h3 style="color: var(--red); border-bottom: 2px solid var(--red); padding-bottom: 10px; margin-bottom: 20px;">
            Historial de compras
        </h3>

        @if(Auth::user()->coches->count() > 0)
            <table class="admin-table" style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
                <thead>
                    <tr style="text-align: left; color: var(--muted);">
                        <th style="padding: 10px;">Coche</th>
                        <th style="padding: 10px;">Fecha</th>
                        <th style="padding: 10px;">Unidades</th>
                        <th style="padding: 10px;">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach(Auth::user()->coches as $coche)
                    <tr style="background: var(--card); border-radius: 8px;">
                        <td style="padding: 15px; display: flex; align-items: center; gap: 15px;">
                            <img src="{{ asset('images/Fotos/' . $coche->imagen_path . '/1.png') }}"
                                 alt="Foto coche"
                                 style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;">
                            <div>
                                <span style="display: block; font-weight: bold; color: white;">{{ $coche->marca->nombre }}</span>
                                <span style="color: #aaa;">{{ $coche->modelo }}</span>
                            </div>
                        </td>
                        <td style="padding: 15px; color: #aaa;">
                            {{ $coche->pivot->created_at->format('d/m/Y') }} <br>
                            <small>{{ $coche->pivot->created_at->format('H:i') }}h</small>
                        </td>
                        <td style="padding: 15px; font-weight: bold;">{{ $coche->pivot->cantidad }}</td>
                        <td style="padding: 15px; color: var(--red); font-weight: bold; font-size: 1.1em;">
                            {{ number_format($coche->precio * $coche->pivot->cantidad, 0, ',', '.') }} €
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @else
            <div style="text-align: center; padding: 40px; background: var(--card); border-radius: 8px; border: 1px dashed var(--border);">
                <p style="color: var(--muted); margin-bottom: 15px;">Aún no has realizado ninguna compra.</p>
                <a href="{{ route('home') }}" class="btn-submit" style="display: inline-block; width: auto; text-decoration: none;">Ir al Catálogo</a>
            </div>
        @endif
    </div>

</section>

<script>
    function openModal() {
        document.getElementById('editModal').style.display = 'flex';
    }

    function closeModal() {
        document.getElementById('editModal').style.display = 'none';
    }

    window.onclick = function(event) {
        var modal = document.getElementById('editModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }
</script>
@endsection