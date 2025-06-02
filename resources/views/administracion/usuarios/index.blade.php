@extends('layouts.auth')

@section('titulo')
Usuarios
@endsection

@section('contenido')

<x-alertas />

<div>
    <div class="flex flex-row justify-end ">
        <form action="{{ route('usuarios') }}" method="GET" class="mt-5 inline-block mr-5">
            <div>
                <input class="border border-black p-1 rounded" type="text" name="query" placeholder="Buscar...."
                    value="{{ old('query', request()->input('query')) }}" autocomplete="off">
                <button type="submit" class="p-2 rounded">
                    <i class="fa-solid fa-magnifying-glass icon-link"></i>
                </button>
            </div>
        </form>
        <x-link route="usuarios" text="Borrar Filtros" class="bg-sky-600 hover:bg-sky-800"/>
    </div>

    <div class="flex flex-col md:flex-row gap-5 justify-center md:justify-between items-center">

        <x-link route="usuarios.create" text="Crear Usuario" icon="fa-solid fa-plus" class="bg-sky-600 hover:bg-sky-800"/>
        
        <div class="flex flex-row gap-2 mt-5">

            <x-link route="usuarios.roles" text="Roles" class="bg-sky-600 hover:bg-sky-800"/>
            
            <x-link route="usuarios.permissions" text="Permisos" class="bg-sky-600 hover:bg-sky-800"/>
            
            <x-link route="usuarios.supervisores" text="Supervisores - Calidad" class="bg-sky-600 hover:bg-sky-800"/>

        </div>
    </div>
</div>

<div class="overflow-x-auto mt-10">
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="text-xs md:text-sm">
                <th scope="col" class="encabezado">Nombre</th>
                <th scope="col" class="encabezado">Nombre de usuario</th>
                <th scope="col" class="encabezado">Correo</th>
                <th scope="col" class="encabezado">Rol</th>
                <th scope="col" class="encabezado">Estado</th>
                <th scope="col" class="encabezado">Acciones</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($usuarios as $usuario)
            <tr>
                <td class="campo">{{ $usuario->name }}</td>
                <td class="campo">{{ $usuario->username }}</td>
                <td class="campo">{{ $usuario->email }}</td>
                <td class="campo">{{ $usuario->getRoleNames()->first(); }}
                </td>
                <td class="campo">
                    <form action="{{ route('usuarios.destroy',$usuario) }}" class="estado" method="POST">
                        @csrf
                        @method('DELETE')
                        <input data-status="{{ $usuario->status }}" id="destroy-button" type="submit"
                            value="{{ ($usuario->status == 1) ? 'ACTIVO' : 'INACTIVO' }}"
                            class="status-btn {{ ($usuario->status == 1) ? 'bg-green-500 hover:bg-green-600' : 'bg-red-500 hover:bg-red-600' }}">
                    </form>
                </td>

                <td>
                    <a class="mx-10" href="{{ route('usuarios.edit',$usuario) }}">
                        <i class="fa-solid fa-pen icon-link"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-paginacion :items="$usuarios" />

@endsection