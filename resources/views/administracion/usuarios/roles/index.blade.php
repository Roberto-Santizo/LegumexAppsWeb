@extends('layouts.auth')

@section('titulo')
Roles
@endsection

@section('contenido')

<x-alertas />


<div class="flex w-full justify-between items-center mt-5">
    
    <x-link route="usuarios" text="Volver" icon="fa-solid fa-arrow-left" class=" btn bg-sky-600 hover:bg-sky-800"/>
    <x-link route="usuarios.roles-create" text="Crear Rol" icon="fa-solid fa-plus" class=" btn bg-sky-600 hover:bg-sky-800"/>
    
</div>

<div class="overflow-x-auto mt-10">
    <table class="tabla">
        <thead class="tabla-head">
            <tr class="md:text-sm text-sm font-bold uppercase text-left rtl:text-right text-gray-500">
                <th scope="col" class="encabezado">No.</th>
                <th scope="col" class="encabezado">Rol</th>
                <th scope="col" class="encabezado">Fecha de creación</th>
                <th scope="col" class="encabezado">Última fecha de actualización</th>
                <th scope="col" class="encabezado">Acciones</th>
            </tr>
        </thead>
        <tbody class="tabla-body">
            @foreach ($roles as $rol)
            <tr>
                <td class="campo">{{ $rol->id }}</td>
                <td class="campo">{{ $rol->name }}</td>
                <td class="campo">{{ $rol->created_at }}</td>
                <td class="campo">{{ $rol->updated_at }}</td>
                <td class="campo">
                    <a href="{{ route('usuarios.roles-edit', $rol) }}">
                        <i class="fa-solid fa-pen text-xl icon-link"></i>
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<x-paginacion :items="$roles" />

@endsection