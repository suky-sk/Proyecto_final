@extends('layouts.app')
@section('titulo', 'Gestión de Garage')

@section('content')
<section style="padding: 40px; max-width: 1200px; margin: 0 auto;">

    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 30px;">
        <h2 class="section-title">Modo editor de coches</h2>

        <button onclick="toggleModal('createCarModal')" class="btn-sport" style="width: auto;">
            <span>añade un coche</span> {{-- boton para ir a crear un coche --}}
        </button>
    </div>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.2); border: 1px solid #2ecc71; color: #2ecc71;
        padding: 15px; margin-bottom: 20px; text-transform: uppercase; font-weight: bold; font-style: italic;">
             {{ session('success') }} {{-- color del mensaje de conbfirmacion de que se ha actualizado la informacion del coche, o que se ha creado el coche correctamente --}}
        </div>
    @endif

    <div class="profile-container" style="max-width: 100%; margin-top:0;">
        <div style="display:flex; justify-content:space-between; margin-bottom:15px;">
            <h3 style="color:#d63026;">Coches :</h3> {{-- titulo de la pag --}}
            <a href="{{ route('admin.usuarios.index') }}" style="color: var(--muted); font-size: 0.9em;"> < Ir a Usuarios</a> {{-- boton para volver a la modificacion de users --}}
        </div>
        {{-- orden de las secciones en la tabla --}}
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Foto</th>
                    <th>Marca</th>
                    <th>Modelo</th>
                    <th>Potencia</th>
                    <th>Precio</th>
                    <th>Stock</th>
                    <th>Fecha de fabricacion</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($coches as $coche)
                <tr>
                    <td>
                        <img src="{{ asset('storage/Fotos/' . $coche->id . '/1.png') }}" {{-- imagen para el coche --}}
                            alt="{{ $coche->modelo }}"
                            style="width: 100px; height: auto;">
                    </td>

                    <td style="color: #ccc;">{{ $coche->marca->nombre ?? 'N/A' }}</td>

                    <td style="font-weight: bold; color: white;">{{ $coche->modelo }}</td>

                    <td style="color: #aaa;">{{ $coche->potencia }} CV</td>

                    <td style="color: var(--yellow); font-weight:bold;">{{ number_format($coche->precio, 0, ',', '.') }} €</td>
                    <td>{{ $coche->stock }}</td>
                    <td>{{ $coche->fecha_fabricacion }}</td>
                    <td style="display: flex; gap: 10px;">

                        <button onclick="editarCoche({{ $coche->id }}, '{{ $coche->modelo }}', {{ $coche->precio }}, {{ $coche->stock }}, {{ $coche->marca_id }}, '{{ $coche->potencia }}')"
                                class="btn-buy" style="background: #868023; color: black; box-shadow:none;">
                            <span>✏️</span>
                        </button>

                        <form action="{{ route('admin.coches.destroy', $coche->id) }}" method="POST" style="display:inline ;">
                            @csrf @method('DELETE')
                            <button type="submit" style="background:none; border:none; cursor:pointer;
                            font-size:1.5em;" onclick="return confirm('SEGURO que quieres borrar el coche? No hay ctrl+z para esto -_-')">🗑️</button>
                        </form> {{-- doble boton para borrar los coches por si acaso le damos sin querer --}}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<div id="createCarModal" class="modal-overlay"> {{-- cuestionario para crear un coche nuevo en la pagina  --}}
    <div class="modal-box">
        <span class="close-btn" onclick="toggleModal('createCarModal')">&times;</span>
        <h2>Añadir un coche nuevo al concesionario</h2>

        <form action="{{ route('admin.coches.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <label>Marca del coche</label> {{-- cuadrito para seleccionar una marca que ya exista en la base de datos --}}
            <select name="marca_id" required>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                @endforeach
            </select>

            <label>Modelo</label> {{-- aqui ponemos el modelo pero sin decir la marca --}}
            <input type="text" name="modelo" required placeholder="">

            <div style="display: flex; gap: 10px;">
                <div style="flex:1;">
                    <label>Potencia (CV)</label>
                    <input type="text" name="potencia" required>
                </div>
                <div style="flex:1;">
                    <label>Precio (€)</label>
                    <input type="number" name="precio" required step="1">
                </div>
                <div style="flex:1;">
                    <label>Stock</label>
                    <input type="number" name="stock" required value="0">{{-- stcck del coche  --}}
                </div>
            </div>

            <label>Fecha de Fabricación</label>
            <input type="date" name="fecha_fabricacion" required>

            <label>Foto</label>
            <input type="file" multiple name="fotos[]" required style="padding: 5px;"> {{-- foto delantera del coche --}}

            <button type="submit" class="btn-submit" style="margin-top: 15px;">
                <span>Guardar Coche</span>
            </button>
        </form>
    </div>
</div>
{{-- cuestionario para poder editar el coche --}}
<div id="editCarModal" class="modal-overlay">
    <div class="modal-box" style="border-top: 4px solid #f1c40f;">
        <span class="close-btn" onclick="toggleModal('editCarModal')">&times;</span>
        <h2 style="color: #f1c40f;">Editar los datos del coche</h2> {{-- header formulario --}}

        <form id="formEditCoche" action="" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label>Marca</label>
            <select name="marca_id" id="edit_marca_id" required>
                @foreach($marcas as $marca)
                    <option value="{{ $marca->id }}">{{ $marca->nombre }}</option>
                @endforeach
            </select>

            <label>Modelo</label>
            <input type="text" name="modelo" id="edit_modelo" required>

            <div style="display: flex; gap: 10px;">
                <div style="flex:1;">
                    <label>Potencia (CV)</label>
                    <input type="text" name="potencia" id="edit_potencia" required>
                </div>
                <div style="flex:1;">
                    <label>Precio (€)</label>
                    <input type="number" name="precio" id="edit_precio" required step="1">
                </div>
                <div style="flex:1;">
                    <label>Stock</label>
                    <input type="number" name="stock" id="edit_stock" required>
                </div>
            </div>

            <label>Fecha de Fabricación</label>
            <input type="date" name="fecha_fabricacion" id="edit_fecha_fabricacion">

            <label>Cambiar Foto</label> {{-- cambio de imagen no obligatorio --}}
            <input type="file" name="fotos[]" multiple style="padding: 5px;">
            <p style="font-size: 0.7em; color: #f86c1b; margin-bottom: 12px;">Si no pones foto, se quedara la foto actual</p>

            <button type="submit" class="btn-submit" style="background: #f1c40f; color: black;">
                <span>Actualizar datos del coche</span>
            </button>
        </form>
    </div>
</div>

<script> /* toggle es para la ventana emergente de edicion */
    function toggleModal(modalID)   {
        var modal = document.getElementById(modalID);
        modal.style.display = (modal.style.display === "flex") ? "none" : "flex";
    }

    function editarCoche(id, modelo, precio, stock, marcaId, potencia) { /*esto copia la informacion del coche para copiarla en la tabla editar */
        document.getElementById('edit_modelo').value = modelo; /*get para coger los valores de cada apartado*/
        document.getElementById('edit_precio').value = precio;
        document.getElementById('edit_stock').value = stock;
        document.getElementById('edit_marca_id').value = marcaId;
        document.getElementById('edit_potencia').value = potencia;

        let form = document.getElementById('formEditCoche'); /*busca el form de mi html de esa id para poder editarlo*/
        let urlBase = "{{ route('admin.coches.update', ':id') }}"; /*marcador de posicion*/
        form.action = urlBase.replace(':id', id); /*reescribe la id en la url*/

        toggleModal('editCarModal');
    }
</script>
@endsection
