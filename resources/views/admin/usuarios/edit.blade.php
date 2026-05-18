{{-- formulario para editar un usuario --}}
@extends('layouts.app')
@section('titulo', 'Editar Usuario')

@section('content')
<section id="login"> <div class="login-box" style="text-align: left; max-width: 500px;">
        <h2 style="text-align: center;">Edita los datos del usuario</h2> {{-- header --}}

        <form action="{{ route('admin.usuarios.update', $usuario->id) }}" method="POST">{{-- contenido del formulario y su orden --}}
            @csrf
            @method('PUT')

            <label>Nombre</label>
            <input type="text" name="nombre" value="{{ $usuario->nombre }}" required>

            <label>Apellido</label>
            <input type="text" name="apellido" value="{{ $usuario->apellido }}" required>

            <label>Email</label>
            <input type="email" name="email" value="{{ $usuario->email }}" required>

            <label>Teléfono</label>
            <input type="text" name="telefono" value="{{ $usuario->telefono }}">

            <label style="margin-top: 15px; display:block;">Nivel de poderes</label>
            <select name="es_admin" style="width: 100%; padding: 10px; margin-bottom: 20px; border: 1px solid #000000; background: #000000;">
                <option value="0" {{ !$usuario->es_admin ? 'selected' : '' }}>Usuario Normal</option>
                <option value="1" {{ $usuario->es_admin ? 'selected' : '' }}>Admin</option>
            </select>

            <button type="submit" class="btn-submit">Actualizar user</button>
            <a href="{{ route('admin.usuarios.index') }}" style="display:block; text-align:center; margin-top:15px; color:#777;">Mejor no</a>
        </form>
    </div>
</section>
@endsection