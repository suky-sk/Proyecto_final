@extends('layouts.app')
@section('titulo', 'Gestión de Usuarios')

@section('content')
<section style="padding: 40px; max-width: 1200px; margin: 0 auto;">
    <h2>Lista de users</h2>

    @if(session('success'))
        <div style="background: #d4edda; color: #41773d; padding: 15px; margin-bottom: 20px;"> {{ session('success') }}</div>
    @endif

    @if(session('error'))
        <div style="background: #f8d7da; color: #f80019; padding: 15px; margin-bottom: 20px;"> {{ session('error') }}</div>
    @endif

    <div class="profile-container" style="max-width: 100%;">

        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom: 20px;">
            <h3>Lista de users</h3>
            {{-- puerta a la pagina donde se podran meter, eliminar y editar coches --}}
            <a href="{{ route('admin.coches.index') }}" class="btn-buy" style="width: auto; margin:0; background:#2c3e50; text-decoration:none;">Gestion del stock</a>
        </div>
        {{-- muestra como se ve la tabla de usuarios --}}
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($usuarios as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->nombre }} {{ $user->apellido }}</td>
                    <td>{{ $user->email }}</td>
                    <td>
                        @if($user->es_admin)
                            <span style="background: gold; padding: 5px 10px; border-radius: 15px; font-weight:bold; font-size:0.8em;">ADMIN</span>
                        @else
                            <span style="background: #28bbff; padding: 5px 10px; border-radius: 15px; font-size:0.8em;">Usuario</span>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.usuarios.edit', $user->id) }}">✏️</a> {{-- https://emojipedia.org/es/l%C3%A1piz --}}

                        @if(Auth::user()->id !== $user->id)
                            <form action="{{ route('admin.usuarios.destroy', $user->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="border:none; background:none; cursor:pointer;" onclick="return confirm('¿Borrar?')">🗑️</button> {{-- https://emojipedia.org/es/papelera --}}
                            </form>
                        @endif </td>
                </tr>
                @endforeach </tbody>
        </table>
    </div>
</section>
@endsection